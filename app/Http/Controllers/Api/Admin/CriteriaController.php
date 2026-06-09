<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Criteria;
use Illuminate\Http\Request;

class CriteriaController extends Controller
{
    /**
     * Get all criteria
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Criteria::orderBy('id')->get()
        ]);
    }

    /**
     * Store criteria
     */
    public function store(
        Request $request
    ) {

        $validated =
            $request->validate([

                'kode' =>
                'required|string|max:10|unique:criterias,kode',

                'nama' =>
                'required|string|max:255',

                'source' =>
                'required|in:user,admin',

                'tipe' =>
                'required|in:benefit,cost',

                'deskripsi' =>
                'nullable|string'
            ]);

        $criteria =
            Criteria::create([
                ...$validated,
                'bobot' => 0
            ]);

        return response()->json([
            'success' => true,
            'message' =>
            'Kriteria berhasil dibuat',
            'data' =>
            $criteria
        ], 201);
    }

    /**
     * Show criteria
     */
    public function show($id)
    {
        $criteria =
            Criteria::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' =>
            $criteria
        ]);
    }

    /**
     * Update criteria
     */
    public function update(
        Request $request,
        $id
    ) {

        $criteria =
            Criteria::findOrFail($id);

        $validated =
            $request->validate([

                'kode' =>
                'required|string|max:10|unique:criterias,kode,' .
                    $criteria->id,

                'nama' =>
                'required|string|max:255',

                'source' =>
                'required|in:user,admin',

                'tipe' =>
                'required|in:benefit,cost',

                'deskripsi' =>
                'nullable|string'
            ]);

        $criteria->update(
            $validated
        );

        return response()->json([
            'success' => true,
            'message' =>
            'Kriteria berhasil diperbarui',
            'data' =>
            $criteria
        ]);
    }

    /**
     * Delete criteria
     */
    public function destroy($id)
    {
        try {

            $criteria =
                Criteria::findOrFail($id);

            // hapus relasi alternative criteria
            $criteria
                ->alternativeScores()
                ->delete();

            // hapus relasi questionnaire answer
            $criteria
                ->questionnaireAnswers()
                ->delete();

            // hapus criteria
            $criteria->delete();

            return response()->json([
                'success' => true,
                'message' =>
                'Kriteria berhasil dihapus'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' =>
                $e->getMessage()
            ], 500);
        }
    }
}
