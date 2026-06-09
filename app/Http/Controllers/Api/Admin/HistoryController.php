<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\RecommendationSession;

class HistoryController extends Controller
{
    public function index()
    {
        $histories =
            RecommendationSession::with([
                'user',
                'topAlternative'
            ])
            ->latest()
            ->get()
            ->map(function ($item) {

                return [
                    'id' => $item->id,

                    'mahasiswa' => [
                        'id' =>
                        $item->user?->id,

                        'name' =>
                        $item->user?->name,

                        'nim' =>
                        $item->user?->nim,

                        'email' =>
                        $item->user?->email,
                    ],

                    'topik' => [
                        'id' =>
                        $item->topAlternative?->id,

                        'kode' =>
                        $item->topAlternative?->kode,

                        'nama_topik' =>
                        $item->topAlternative?->nama_topik,

                        'kompetensi_lulusan' =>
                        $item->topAlternative?->kompetensi_lulusan,
                    ],

                    'score' =>
                    $item->top_score,

                    'tanggal' =>
                    $item->created_at,

                    'status' =>
                    'completed',
                ];
            });

        return response()->json([
            'success' => true,
            'message' =>
            'Riwayat berhasil diambil',
            'data' =>
            $histories
        ]);
    }
}
