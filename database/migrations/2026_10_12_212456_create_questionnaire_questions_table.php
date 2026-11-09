<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'questionnaire_questions',
            function (Blueprint $table) {
                $table->id();

                $table->foreignId('questionnaire_id')
                    ->constrained()
                    ->cascadeOnDelete();

                $table->text('question_text');

                $table->string('question_type', 30)
                    ->default('written');

                $table->boolean('is_required')
                    ->default(true);

                $table->unsignedSmallInteger('position')
                    ->default(1);

                $table->timestamps();

                $table->index([
                    'questionnaire_id',
                    'position',
                ]);
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('questionnaire_questions');
    }
};
