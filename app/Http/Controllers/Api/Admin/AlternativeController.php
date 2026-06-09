<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alternative;
use Illuminate\Http\Request;

class AlternativeController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' =>
            Alternative::all()
        ]);
    }

    public function store(
        Request $request
    ) {

        $validated =
            $request->validate([

                'kode' =>
                'required|string|unique:alternatives,kode',

                'nama_topik' =>
                'required|string|max:255',

                'kompetensi_lulusan' =>
                'required|string|max:255',

                'mata_kuliah_relevan' =>
                'nullable|string|max:255',

                'deskripsi' =>
                'nullable|string'
            ]);

        $alternative =
            Alternative::create(
                $validated
            );

        return response()->json([
            'success' => true,
            'message' =>
            'Topik berhasil dibuat',

            'data' =>
            $alternative
        ]);
    }

    public function show(
        Alternative $alternative
    ) {
        return response()->json([
            'success' => true,
            'data' =>
            $alternative
        ]);
    }

    public function update(
        Request $request,
        Alternative $alternative
    ) {

        $validated =
            $request->validate([

                'kode' =>
                'required|string|unique:alternatives,kode,' .
                    $alternative->id,

                'nama_topik' =>
                'required|string|max:255',

                'kompetensi_lulusan' =>
                'required|string|max:255',

                'mata_kuliah_relevan' =>
                'nullable|string|max:255',

                'deskripsi' =>
                'nullable|string'
            ]);

        $alternative->update(
            $validated
        );

        return response()->json([
            'success' => true,
            'message' =>
            'Topik berhasil diupdate',

            'data' =>
            $alternative
        ]);
    }

    public function destroy(
        Alternative $alternative
    ) {

        $alternative->delete();

        return response()->json([
            'success' => true,
            'message' =>
            'Topik berhasil dihapus'
        ]);
    }
}
