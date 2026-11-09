<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Agregar los datos necesarios para autenticación con Google.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('google_id')
                ->nullable()
                ->unique()
                ->after('email');

            $table->string('avatar_url', 2048)
                ->nullable()
                ->after('google_id');
        });
    }

    /**
     * Revertir los campos de autenticación con Google.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['google_id']);

            $table->dropColumn([
                'google_id',
                'avatar_url',
            ]);
        });
    }
};
