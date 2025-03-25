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
            // Supprimer la colonne is_archived si elle existe
            if (Schema::hasColumn('books', 'is_archived')) {
                $table->dropColumn('is_archived');
            }

            // Ajouter la colonne deleted_at si elle n'existe pas
            if (!Schema::hasColumn('books', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            // Restaure la colonne is_archived si elle n'existe pas
            if (!Schema::hasColumn('books', 'is_archived')) {
                $table->boolean('is_archived')->default(false);
            }

            // Supprime la colonne deleted_at si elle existe
            if (Schema::hasColumn('books', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }
};
