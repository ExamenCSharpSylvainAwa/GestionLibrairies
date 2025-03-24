<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('is_archived'); // Supprime le champ is_archived
            $table->softDeletes(); // Ajoute la colonne deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropSoftDeletes(); // Supprime la colonne deleted_at
            $table->boolean('is_archived')->default(false); // Rétablit le champ is_archived
        });
    }
};
