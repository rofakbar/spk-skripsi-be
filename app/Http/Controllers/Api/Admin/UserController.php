<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')
            ->latest()
            ->get()
            ->map(function ($user) {

                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,

                    'role' =>
                    $user->roles
                        ->pluck('name')
                        ->toArray(),

                    'created_at' =>
                    $user->created_at,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $users
        ]);
    }
}
