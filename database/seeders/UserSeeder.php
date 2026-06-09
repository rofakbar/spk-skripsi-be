<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\StudentProfile;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ==================
        // ADMIN
        // ==================
        $admin = User::firstOrCreate(
            [
                'email' =>
                'admin@gmail.com'
            ],
            [
                'name' =>
                'Admin',

                'password' =>
                Hash::make(
                    'password123'
                ),
            ]
        );

        $admin->assignRole(
            'admin'
        );

        // ==================
        // MAHASISWA
        // ==================
        $user = User::firstOrCreate(
            [
                'email' =>
                'user@gmail.com'
            ],
            [
                'name' =>
                'Mahasiswa',

                'password' =>
                Hash::make(
                    'password123'
                ),
            ]
        );

        $user->assignRole(
            'user'
        );

        // STUDENT PROFILE
        StudentProfile::firstOrCreate(
            [
                'user_id' =>
                $user->id
            ],
            [
                'nim' =>
                '201011400123',

                'semester' =>
                8,

                'ipk' =>
                3.75,

                'minat' =>
                'Artificial Intelligence'
            ]
        );
    }
}
