<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alternative;

class AlternativeSeeder extends Seeder
{
    public function run(): void
    {
        $alternatives = [

            [
                'kode' => 'A1',

                'nama_topik' =>
                'Software Engineering & System Development',

                'kompetensi_lulusan' =>
                'Software Developer',

                'mata_kuliah_relevan' =>
                'Rekayasa Perangkat Lunak (RPL)',
            ],

            [
                'kode' => 'A2',

                'nama_topik' =>
                'Web & Enterprise Application',

                'kompetensi_lulusan' =>
                'Web Developer',

                'mata_kuliah_relevan' =>
                'Framework Programming',
            ],

            [
                'kode' => 'A3',

                'nama_topik' =>
                'Database & Data Engineering',

                'kompetensi_lulusan' =>
                'Database Administrator / Data Engineer',

                'mata_kuliah_relevan' =>
                'Sistem Basis Data',
            ],

            [
                'kode' => 'A4',

                'nama_topik' =>
                'Artificial Intelligence & Intelligent System',

                'kompetensi_lulusan' =>
                'AI Engineer',

                'mata_kuliah_relevan' =>
                'Kecerdasan Buatan (AI)',
            ],

            [
                'kode' => 'A5',

                'nama_topik' =>
                'System Analyst & Decision Support System',

                'kompetensi_lulusan' =>
                'System Analyst',

                'mata_kuliah_relevan' =>
                'Sistem Pendukung Keputusan (SPK)',
            ],

            [
                'kode' => 'A6',

                'nama_topik' =>
                'Data Science & Business Intelligence',

                'kompetensi_lulusan' =>
                'Data Analyst / Business Intelligence Analyst',

                'mata_kuliah_relevan' =>
                'Statistika Komputer',
            ],

            [
                'kode' => 'A7',

                'nama_topik' =>
                'Mobile & Smart Application',

                'kompetensi_lulusan' =>
                'Mobile Application Developer',

                'mata_kuliah_relevan' =>
                'Mobile Programming',
            ],

            [
                'kode' => 'A8',

                'nama_topik' =>
                'Multimedia & Computer Vision',

                'kompetensi_lulusan' =>
                'Multimedia Engineer / Computer Vision Developer',

                'mata_kuliah_relevan' =>
                'Pengolahan Citra Digital',
            ],
        ];

        foreach (
            $alternatives
            as $alternative
        ) {
            Alternative::create(
                $alternative
            );
        }
    }
}
