<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(
        Request $request
    ) {

        $validatedData =
            $request->validate([
                'name' =>
                'required|string|max:255',

                'email' =>
                'required|email|unique:users,email',

                'password' =>
                'required|min:8|confirmed',

                'nim' =>
                'required|string|max:20|unique:student_profiles,nim',

                'semester' =>
                'required|integer|min:1|max:14',

                'ipk' =>
                'required|numeric|min:0|max:4',

                'minat' =>
                'required|string|max:255',
            ]);

        // ==================
        // CREATE USER
        // ==================

        $user = User::create([
            'name' =>
            $validatedData['name'],

            'email' =>
            $validatedData['email'],

            'password' =>
            Hash::make(
                $validatedData['password']
            ),
        ]);

        $user->assignRole(
            'user'
        );

        // ==================
        // CREATE STUDENT PROFILE
        // ==================

        $user->studentProfile()
            ->create([
                'nim' =>
                $validatedData['nim'],

                'semester' =>
                $validatedData['semester'],

                'ipk' =>
                $validatedData['ipk'],

                'minat' =>
                $validatedData['minat'],
            ]);

        // ==================
        // TOKEN
        // ==================

        $token = $user
            ->createToken(
                'auth_token'
            )
            ->plainTextToken;

        return response()
            ->json([
                'success' => true,

                'message' =>
                'Register berhasil',

                'data' => [
                    'token' =>
                    $token,

                    'user' => [
                        'id' =>
                        $user->id,

                        'name' =>
                        $user->name,

                        'email' =>
                        $user->email,

                        'role' =>
                        $user->getRoleNames(),
                    ]
                ]
            ], 201);
    }
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $validatedData['email'])->first();

        if (!$user || !Hash::check($validatedData['password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'data' => [
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->getRoleNames()
                ]
            ]
        ]);
    }
    public function me(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => $request->user()
        ]);
    }
    public function profile(
        Request $request
    ) {

        $user = User::with(
            'studentProfile'
        )->find(
            $request->user()->id
        );

        return response()->json([
            'success' => true,
            'data' => [
                'id' =>
                $user->id,

                'name' =>
                $user->name,

                'email' =>
                $user->email,

                'created_at' =>
                $user->created_at,

                'role' =>
                $user->getRoleNames(),

                'student_profile' => [
                    'nim' =>
                    $user
                        ->studentProfile
                        ?->nim,

                    'semester' =>
                    $user
                        ->studentProfile
                        ?->semester,

                    'ipk' =>
                    $user
                        ->studentProfile
                        ?->ipk,

                    'minat' =>
                    $user
                        ->studentProfile
                        ?->minat,
                ]
            ]
        ]);
    }
    public function logout(Request $request)
    {
        $request->user()
            ->currentAccessToken()
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil'
        ]);
    }
}
