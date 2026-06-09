<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'recommendation_sessions',
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
                    'top_alternative_id'
                )
                    ->nullable()
                    ->constrained(
                        'alternatives'
                    )
                    ->nullOnDelete();

                $table->decimal(
                    'top_score',
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
            'recommendation_sessions'
        );
    }
};
