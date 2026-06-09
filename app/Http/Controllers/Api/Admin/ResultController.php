<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\RecommendationResult;

class ResultController extends Controller
{
    public function index()
    {
        $results =
            RecommendationResult::with([
                'user',
                'alternative',
                'session'
            ])
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $results
        ]);
    }
}
