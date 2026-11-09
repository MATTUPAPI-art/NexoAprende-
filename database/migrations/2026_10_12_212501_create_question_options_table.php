<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'question_options',
            function (Blueprint $table) {
                $table->id();

                $table->foreignId(
                    'questionnaire_question_id'
                )
                    ->constrained()
                    ->cascadeOnDelete();

                $table->string('option_text', 255);

                $table->unsignedSmallInteger('position')
                    ->default(1);

                $table->timestamps();

                $table->index([
                    'questionnaire_question_id',
                    'position',
                ]);
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('question_options');
    }
};
