<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table(
            'recommendation_results',
            function (
                Blueprint $table
            ) {

                $table->foreignId(
                    'recommendation_session_id'
                )
                    ->after('id')
                    ->constrained(
                        'recommendation_sessions'
                    )
                    ->cascadeOnDelete();
            }
        );
    }

    public function down(): void
    {
        Schema::table(
            'recommendation_results',
            function (
                Blueprint $table
            ) {

                $table->dropForeign([
                    'recommendation_session_id'
                ]);

                $table->dropColumn(
                    'recommendation_session_id'
                );
            }
        );
    }
};
