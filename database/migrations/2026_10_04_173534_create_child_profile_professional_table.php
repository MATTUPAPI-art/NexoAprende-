<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'child_profile_professional',
            function (Blueprint $table) {
                $table->id();

                $table->foreignId('child_profile_id')
                    ->constrained()
                    ->cascadeOnDelete();

                $table->foreignId('professional_profile_id')
                    ->constrained()
                    ->cascadeOnDelete();

                $table->timestamps();

                $table->unique([
                    'child_profile_id',
                    'professional_profile_id',
                ]);
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('child_profile_professional');
    }
};
