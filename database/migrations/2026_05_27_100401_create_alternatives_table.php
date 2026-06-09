<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'alternatives',
            function (
                Blueprint $table
            ) {

                $table->id();

                $table->string(
                    'kode'
                )->unique();

                $table->string(
                    'nama_topik'
                );

                $table->string(
                    'kompetensi_lulusan'
                );

                // TAMBAHAN
                $table->string(
                    'mata_kuliah_relevan'
                )->nullable();

                $table->text(
                    'deskripsi'
                )->nullable();

                $table->timestamps();
            },
        );
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'alternatives',
        );
    }
};
