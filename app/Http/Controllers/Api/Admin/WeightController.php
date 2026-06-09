<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Criteria;
use Illuminate\Http\Request;

class WeightController extends Controller
{
    /**
     * Get all weights
     */
    public function index()
    {
        return response()->json([
            'success' => true,

            'data' =>
            Criteria::select(
                'id',
                'kode',
                'nama',
                'bobot'
            )->get(),

            'total' =>
            Criteria::sum(
                'bobot'
            ) * 100
        ]);
    }

    /**
     * Update weights
     */
    public function update(
        Request $request
    ) {
        $request->validate([
            'weights' =>
            'required|array',

            'weights.*.id' =>
            'required|exists:criterias,id',

            'weights.*.bobot' =>
            'required|numeric|min:0|max:1'
        ]);

        $total =
            collect(
                $request->weights
            )->sum(
                'bobot'
            );

        if (
            round(
                $total,
                2
            ) != 1
        ) {
            return response()->json([
                'success' =>
                false,

                'message' =>
                'Total bobot harus tepat 100%'
            ], 422);
        }

        foreach (
            $request->weights
            as $weight
        ) {

            Criteria::where(
                'id',
                $weight['id']
            )->update([
                'bobot' =>
                $weight['bobot']
            ]);
        }

        return response()->json([
            'success' =>
            true,

            'message' =>
            'Bobot berhasil diperbarui'
        ]);
    }
}
