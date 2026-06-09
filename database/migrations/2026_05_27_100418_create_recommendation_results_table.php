<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'recommendation_results',
            function (
                Blueprint $table
            ) {

                $table->id();

                $table->foreignId(
                    'user_id'
                )
                    ->constrained()
                    ->cascadeOnDelete();

                $table->foreignId(
                    'alternative_id'
                )
                    ->constrained()
                    ->cascadeOnDelete();

                $table->integer('rank');

                $table->decimal(
                    'score',
                    10,
                    5
                );

                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'recommendation_results'
        );
    }
};
