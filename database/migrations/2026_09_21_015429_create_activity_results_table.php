<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_results', function (Blueprint $table) {
            $table->id();

            // Identifica la actividad realizada.
            $table->string('activity_code', 50)->index();

            // Indicadores descriptivos de la sesión.
            $table->unsignedSmallInteger('correct_answers');
            $table->unsignedSmallInteger('errors');
            $table->unsignedSmallInteger('attempts');
            $table->unsignedInteger('duration_seconds');
            $table->unsignedSmallInteger('level')->default(1);
            $table->boolean('completed')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_results');
    }
};
