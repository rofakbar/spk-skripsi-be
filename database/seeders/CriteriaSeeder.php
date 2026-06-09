<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Criteria;

class CriteriaSeeder extends Seeder
{
    public function run(): void
    {
        $criterias = [

            // USER CRITERIA

            [
                'kode' => 'C1',
                'nama' => 'Nilai Mata Kuliah Relevan',
                'source' => 'user',
                'bobot' => 0.15,
                'tipe' => 'benefit',
                'deskripsi' => 'Nilai mata kuliah yang relevan terhadap bidang topik'
            ],

            [
                'kode' => 'C2',
                'nama' => 'Minat Mahasiswa',
                'source' => 'user',
                'bobot' => 0.10,
                'tipe' => 'benefit',
                'deskripsi' => 'Tingkat ketertarikan mahasiswa terhadap bidang topik'
            ],

            [
                'kode' => 'C3',
                'nama' => 'Pengalaman Proyek',
                'source' => 'user',
                'bobot' => 0.10,
                'tipe' => 'benefit',
                'deskripsi' => 'Pengalaman membuat proyek pada bidang terkait'
            ],

            [
                'kode' => 'C4',
                'nama' => 'Penguasaan Skill',
                'source' => 'user',
                'bobot' => 0.10,
                'tipe' => 'benefit',
                'deskripsi' => 'Kemampuan teknis mahasiswa pada bidang terkait'
            ],

            [
                'kode' => 'C9',
                'nama' => 'Ketersediaan Dataset / Objek Penelitian',
                'source' => 'user',
                'bobot' => 0.05,
                'tipe' => 'benefit',
                'deskripsi' => 'Kemudahan memperoleh dataset atau objek penelitian'
            ],

            // ADMIN CRITERIA

            [
                'kode' => 'C5',
                'nama' => 'Referensi Ilmiah',
                'source' => 'admin',
                'bobot' => 0.10,
                'tipe' => 'benefit',
                'deskripsi' => 'Ketersediaan referensi ilmiah untuk topik'
            ],

            [
                'kode' => 'C6',
                'nama' => 'Kesesuaian Profil Lulusan',
                'source' => 'admin',
                'bobot' => 0.15,
                'tipe' => 'benefit',
                'deskripsi' => 'Kesesuaian topik dengan profil lulusan'
            ],

            [
                'kode' => 'C7',
                'nama' => 'Dosen Pembimbing / KBK',
                'source' => 'admin',
                'bobot' => 0.10,
                'tipe' => 'benefit',
                'deskripsi' => 'Ketersediaan dosen pembimbing pada bidang terkait'
            ],

            [
                'kode' => 'C8',
                'nama' => 'Kesulitan Implementasi',
                'source' => 'admin',
                'bobot' => 0.05,
                'tipe' => 'cost',
                'deskripsi' => 'Tingkat kesulitan implementasi topik'
            ],

            [
                'kode' => 'C10',
                'nama' => 'Implementasi Industri',
                'source' => 'admin',
                'bobot' => 0.10,
                'tipe' => 'benefit',
                'deskripsi' => 'Relevansi topik terhadap kebutuhan industri'
            ]
        ];

        foreach ($criterias as $criteria) {
            Criteria::create($criteria);
        }
    }
}
