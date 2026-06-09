<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AlternativeCriteria;

class AlternativeCriteriaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [

            /*
            Criteria ID:
            C5 = 6
            C6 = 7
            C7 = 8
            C8 = 9
            C10 = 10
            */

            // A1 Software Engineering
            [1, 6, 5],
            [1, 7, 5],
            [1, 8, 5],
            [1, 9, 3],
            [1, 10, 5],

            // A2 Web Enterprise
            [2, 6, 5],
            [2, 7, 4],
            [2, 8, 5],
            [2, 9, 2],
            [2, 10, 5],

            // A3 Database Engineering
            [3, 6, 4],
            [3, 7, 5],
            [3, 8, 4],
            [3, 9, 3],
            [3, 10, 5],

            // A4 AI
            [4, 6, 5],
            [4, 7, 5],
            [4, 8, 4],
            [4, 9, 5],
            [4, 10, 5],

            // A5 DSS / System Analyst
            [5, 6, 5],
            [5, 7, 4],
            [5, 8, 5],
            [5, 9, 3],
            [5, 10, 4],

            // A6 Data Science
            [6, 6, 5],
            [6, 7, 5],
            [6, 8, 4],
            [6, 9, 4],
            [6, 10, 5],

            // A7 Mobile
            [7, 6, 4],
            [7, 7, 4],
            [7, 8, 4],
            [7, 9, 3],
            [7, 10, 5],

            // A8 Multimedia & CV
            [8, 6, 4],
            [8, 7, 4],
            [8, 8, 3],
            [8, 9, 5],
            [8, 10, 4],
        ];

        foreach ($data as $item) {

            AlternativeCriteria::create([
                'alternative_id' => $item[0],
                'criteria_id' => $item[1],
                'nilai' => $item[2],
            ]);
        }
    }
}
