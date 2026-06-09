<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\WaspasService;
use App\Models\RecommendationResult;
use App\Models\RecommendationSession;

class RecommendationController
extends Controller
{
    public function calculate(
        WaspasService $waspas
    ) {

        try {

            $userId =
                Auth::id();

            $results =
                $waspas->calculate(
                    $userId
                );

            $topResult =
                $results['recommendation'];

            // SAVE SESSION
            $session =
                RecommendationSession::create([

                    'user_id' =>
                    $userId,

                    'top_alternative_id' =>
                    $topResult['alternative_id'],

                    'top_score' =>
                    $topResult['score']
                ]);

            // SAVE RANKING
            foreach (
                $results['ranking']
                as $result
            ) {

                RecommendationResult::create([

                    'recommendation_session_id' =>
                    $session->id,

                    'user_id' =>
                    $userId,

                    'alternative_id' =>
                    $result['alternative_id'],

                    'rank' =>
                    $result['rank'],

                    'score' =>
                    $result['score']
                ]);
            }

            return response()->json([
                'success' => true,
                'data' => $results
            ]);
        } catch (
            \Exception $e
        ) {

            return response()->json([
                'success' => false,
                'message' =>
                $e->getMessage()
            ], 500);
        }
    }
    public function latest()
    {
        $session =
            RecommendationSession::with(
                'topAlternative'
            )
            ->where(
                'user_id',
                Auth::id()
            )
            ->latest()
            ->first();

        if (!$session) {

            return response()->json([
                'success' => false,
                'message' =>
                'Belum ada hasil rekomendasi'
            ], 404);
        }

        $ranking =
            RecommendationResult::with(
                'alternative'
            )
            ->where(
                'recommendation_session_id',
                $session->id
            )
            ->orderBy('rank')
            ->get()
            ->map(function (
                $item
            ) {

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
            });

        return response()->json([
            'success' => true,

            'data' => [

                'recommendation' => [

                    'nama_topik' =>
                    $session
                        ->topAlternative
                        ->nama_topik,

                    'kompetensi_lulusan' =>
                    $session
                        ->topAlternative
                        ->kompetensi_lulusan,

                    'score' =>
                    $session
                        ->top_score,
                ],

                'ranking' =>
                $ranking
            ]
        ]);
    }

    public function detail(
        WaspasService $waspas
    ) {

        $result =
            $waspas->calculate(
                Auth::id()
            );

        return response()->json([
            'success' => true,
            'data' => $result
        ]);
    }
    public function history()
    {
        try {

            $history =
                RecommendationSession::with(
                    'topAlternative'
                )
                ->where(
                    'user_id',
                    Auth::id()
                )
                ->latest()
                ->get();

            return response()->json([
                'success' => true,
                'data' => $history
            ]);
        } catch (
            \Exception $e
        ) {

            return response()->json([
                'success' => false,
                'message' =>
                $e->getMessage()
            ], 500);
        }
    }

    public function historyDetail(
        $id,
        WaspasService $waspas
    ) {

        $session =
            RecommendationSession::where(
                'user_id',
                Auth::id()
            )
            ->findOrFail($id);

        // reuse WASPAS detail
        $result =
            $waspas->calculate(
                $session->user_id
            );

        return response()->json([
            'success' => true,
            'data' => $result,
            'session' => $session
        ]);
    }
}
