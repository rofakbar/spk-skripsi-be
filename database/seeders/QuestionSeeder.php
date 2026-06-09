<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $questions = [

            [
                'pertanyaan' =>
                'Saya tertarik pada Artificial Intelligence atau Machine Learning',
                'criteria_id' => 1
            ],

            [
                'pertanyaan' =>
                'Saya nyaman membuat aplikasi menggunakan coding',
                'criteria_id' => 2
            ],

            [
                'pertanyaan' =>
                'Nilai mata kuliah pemrograman saya baik',
                'criteria_id' => 3
            ],

            [
                'pertanyaan' =>
                'Saya pernah membuat project aplikasi',
                'criteria_id' => 4
            ],

            [
                'pertanyaan' =>
                'Saya ingin berkarir di bidang teknologi tertentu',
                'criteria_id' => 5
            ]
        ];

        foreach ($questions as $item) {
            Question::create($item);
        }
    }
}
