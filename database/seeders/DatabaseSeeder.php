<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([

            // role
            RoleSeeder::class,

            // users
            UserSeeder::class,

            // master data
            AlternativeSeeder::class,
            CriteriaSeeder::class,

            // admin scoring
            AlternativeCriteriaSeeder::class,
        ]);
    }
}
