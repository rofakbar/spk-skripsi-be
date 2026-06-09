<?php

namespace App\Services;

use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\QuestionnaireAnswer;
use App\Models\AlternativeCriteria;
use App\Models\RecommendationResult;
use Exception;

class WaspasService
{
    public function calculate(int $userId)
    {
        // =====================
        // LOAD DATA
        // =====================

        $criterias = Criteria::orderBy('id')->get();

        $alternatives = Alternative::orderBy('id')->get();

        // Load semua jawaban user sekali query
        $userAnswers = QuestionnaireAnswer::where(
            'user_id',
            $userId
        )->get();

        // Load semua nilai admin sekali query
        $adminValues =
            AlternativeCriteria::all();

        // Mapping biar cepat akses
        $userMap = [];

        foreach ($userAnswers as $answer) {
            $userMap[$answer->alternative_id][$answer->criteria_id] = $answer->nilai;
        }

        $adminMap = [];

        foreach ($adminValues as $value) {
            $adminMap[$value->alternative_id][$value->criteria_id] = $value->nilai;
        }

        // =====================
        // DECISION MATRIX
        // =====================

        $matrix = [];

        foreach ($alternatives as $alternative) {

            foreach ($criterias as $criteria) {

                // USER SOURCE
                if (
                    $criteria->source ===
                    'user'
                ) {

                    $value =
                        $userMap[$alternative->id][$criteria->id] ?? null;
                }

                // ADMIN SOURCE
                else {

                    $value =
                        $adminMap[$alternative->id][$criteria->id] ?? null;
                }

                // Validasi data kosong
                if (
                    is_null($value)
                ) {
                    throw new Exception(
                        "Nilai kriteria {$criteria->kode} untuk alternatif {$alternative->kode} tidak ditemukan."
                    );
                }

                $matrix[$alternative->kode][$criteria->kode] = (float) $value;
            }
        }

        // =====================
        // NORMALIZATION
        // =====================

        $normalized = [];

        foreach ($criterias as $criteria) {

            $column = [];

            foreach ($alternatives as $alternative) {

                $column[] =
                    $matrix[$alternative->kode][$criteria->kode];
            }

            $max = max($column);
            $min = min($column);

            foreach ($alternatives as $alternative) {

                $value =
                    $matrix[$alternative->kode][$criteria->kode];

                // BENEFIT
                if (
                    $criteria->tipe ===
                    'benefit'
                ) {

                    $normalized[$alternative->kode][$criteria->kode] =
                        $value / $max;
                }

                // COST
                else {

                    $normalized[$alternative->kode][$criteria->kode] =
                        $min / $value;
                }
            }
        }

        // =====================
        // WSM + WPM + WASPAS
        // =====================

        $wsmResults = [];
        $wpmResults = [];
        $waspasResults = [];

        foreach ($alternatives as $alternative) {

            $wsm = 0;
            $wpm = 1;

            foreach ($criterias as $criteria) {

                $r =
                    $normalized[$alternative->kode][$criteria->kode];

                $w =
                    (float) $criteria->bobot;

                // WSM
                $wsm +=
                    $w * $r;

                // WPM
                $wpm *=
                    pow(
                        $r,
                        $w
                    );
            }

            // Final score WASPAS
            $score =
                (
                    0.5 * $wsm
                )
                +
                (
                    0.5 * $wpm
                );

            $wsmResults[] = [
                'alternative' =>
                $alternative->kode,

                'value' =>
                round(
                    $wsm,
                    5
                )
            ];

            $wpmResults[] = [
                'alternative' =>
                $alternative->kode,

                'value' =>
                round(
                    $wpm,
                    5
                )
            ];

            $waspasResults[] = [

                'alternative_id' =>
                $alternative->id,

                'kode' =>
                $alternative->kode,

                'nama_topik' =>
                $alternative
                    ->nama_topik,

                'kompetensi_lulusan' =>
                $alternative
                    ->kompetensi_lulusan,

                'score' =>
                round(
                    $score,
                    5
                ),
            ];
        }

        // =====================
        // SORTING RANK
        // =====================

        usort(
            $waspasResults,
            fn($a, $b) =>
            $b['score']
                <=>
                $a['score']
        );

        foreach (
            $waspasResults
            as $index => &$item
        ) {

            $item['rank'] =
                $index + 1;
        }

        // =====================
        // RETURN
        // =====================

        return [

            'decision_matrix' =>
            $matrix,

            'normalized_matrix' =>
            array_map(
                fn($row) =>
                array_map(
                    fn($value) =>
                    round(
                        $value,
                        4
                    ),
                    $row
                ),
                $normalized
            ),

            'wsm' =>
            $wsmResults,

            'wpm' =>
            $wpmResults,

            'ranking' =>
            $waspasResults,

            'recommendation' =>
            $waspasResults[0] ?? null,
        ];
    }

    public function calculateFromSession(
        int $sessionId
    ) {

        $ranking =
            RecommendationResult::with(
                'alternative'
            )
            ->where(
                'recommendation_session_id',
                $sessionId
            )
            ->orderBy('rank')
            ->get();

        return [

            'recommendation' => [

                'nama_topik' =>
                $ranking
                    ->first()
                    ?->alternative
                    ?->nama_topik,

                'kompetensi_lulusan' =>
                $ranking
                    ->first()
                    ?->alternative
                    ?->kompetensi_lulusan,

                'score' =>
                $ranking
                    ->first()
                    ?->score,
            ],

            'ranking' =>
            $ranking->map(
                function ($item) {

                    return [

                        'rank' =>
                        $item->rank,

                        'kode' =>
                        $item
                            ->alternative
                            ->kode,

                        'nama_topik' =>
                        $item
                            ->alternative
                            ->nama_topik,

                        'score' =>
                        $item->score,
                    ];
                }
            )
        ];
    }
}
 