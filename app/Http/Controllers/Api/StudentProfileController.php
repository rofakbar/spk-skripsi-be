<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StudentProfile;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentProfileController extends Controller
{
    public function show(Request $request)
    {
        $profile = StudentProfile::where(
            'user_id',
            $request->user()->id
        )->first();

        return response()->json([
            'success' => true,
            'message' =>
            'Profil berhasil diambil',
            'data' => $profile
        ]);
    }

    public function store(Request $request)
    {
        $validated =
            $request->validate([

                'nim' =>
                'required|string|unique:student_profiles,nim',

                'semester' =>
                'required|integer|min:1|max:14',

                'ipk' =>
                'nullable|numeric|min:0|max:4',

                'minat' =>
                'nullable|string|max:255',
            ]);

        $profile =
            StudentProfile::create([

                'user_id' =>
                $request->user()->id,

                'nim' =>
                $validated['nim'],

                'semester' =>
                $validated['semester'],

                'ipk' =>
                $validated['ipk'] ?? null,

                'minat' =>
                $validated['minat'] ?? null,
            ]);

        return response()->json([
            'success' => true,
            'message' =>
            'Profil berhasil dibuat',
            'data' => $profile
        ], 201);
    }

    public function update(
        Request $request
    ) {
        $profile =
            StudentProfile::where(
                'user_id',
                $request->user()->id
            )->first();

        if (!$profile) {
            return response()->json([
                'success' => false,
                'message' =>
                'Profil tidak ditemukan'
            ], 404);
        }

        $validated =
            $request->validate([

                'nim' =>
                'required|string|unique:student_profiles,nim,' . $profile->id,

                'semester' =>
                'required|integer|min:1|max:14',

                'ipk' =>
                'nullable|numeric|min:0|max:4',

                'minat' =>
                'nullable|string|max:255',
            ]);

        $profile->update(
            $validated
        );

        return response()->json([
            'success' => true,
            'message' =>
            'Profil berhasil diupdate',
            'data' => $profile
        ]);
    }
    public function indexAdmin()
    {
        $students = User::with(
            'studentProfile',
            'roles'
        )
            ->role('user')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $students
        ]);
    }

    public function storeAdmin(
        Request $request
    ) {
        $validated =
            $request->validate([

                'name' =>
                'required|string|max:255',

                'email' =>
                'required|email|unique:users,email',

                'password' =>
                'required|min:6',

                'nim' =>
                'required|string|unique:student_profiles,nim',

                'semester' =>
                'required|integer|min:1|max:14',

                'ipk' =>
                'nullable|numeric|min:0|max:4',

                'minat' =>
                'nullable|string|max:255',
            ]);

        DB::beginTransaction();

        try {

            $user =
                User::create([

                    'name' =>
                    $validated['name'],

                    'email' =>
                    $validated['email'],

                    'password' =>
                    Hash::make(
                        $validated['password']
                    )
                ]);

            $user->assignRole(
                'user'
            );

            $profile =
                StudentProfile::create([

                    'user_id' =>
                    $user->id,

                    'nim' =>
                    $validated['nim'],

                    'semester' =>
                    $validated['semester'],

                    'ipk' =>
                    $validated['ipk'] ?? null,

                    'minat' =>
                    $validated['minat'] ?? null,
                ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' =>
                'Mahasiswa berhasil ditambahkan',
                'data' => [
                    'user' => $user,
                    'profile' => $profile
                ]
            ], 201);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' =>
                $e->getMessage()
            ], 500);
        }
    }

    public function updateAdmin(
        Request $request,
        $id
    ) {
        $user =
            User::with(
                'studentProfile'
            )->findOrFail($id);

        $validated =
            $request->validate([

                'name' =>
                'required|string|max:255',

                'email' =>
                'required|email|unique:users,email,' .
                    $user->id,

                'nim' =>
                'required|string|unique:student_profiles,nim,' .
                    $user->studentProfile->id,

                'semester' =>
                'required|integer|min:1|max:14',

                'ipk' =>
                'nullable|numeric|min:0|max:4',

                'minat' =>
                'nullable|string|max:255',
            ]);

        DB::beginTransaction();

        try {

            $user->update([
                'name' =>
                $validated['name'],

                'email' =>
                $validated['email']
            ]);

            $user
                ->studentProfile
                ->update([

                    'nim' =>
                    $validated['nim'],

                    'semester' =>
                    $validated['semester'],

                    'ipk' =>
                    $validated['ipk'] ?? null,

                    'minat' =>
                    $validated['minat'] ?? null,
                ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' =>
                'Mahasiswa berhasil diupdate'
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' =>
                $e->getMessage()
            ], 500);
        }
    }

    public function destroyAdmin(
        $id
    ) {
        $user =
            User::findOrFail($id);

        $user->delete();

        return response()->json([
            'success' => true,
            'message' =>
            'Mahasiswa berhasil dihapus'
        ]);
    }
}
