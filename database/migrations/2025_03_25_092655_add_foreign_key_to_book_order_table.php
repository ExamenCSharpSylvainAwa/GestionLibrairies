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
        DB::statement('DELETE FROM book_order WHERE book_id NOT IN (SELECT id FROM books)');
        DB::statement('DELETE FROM book_order WHERE order_id NOT IN (SELECT id FROM orders)');

        // Ajouter les clés étrangères avec suppression en cascade
        Schema::table('book_order', function (Blueprint $table) {
            $table->foreign('book_id')
                  ->references('id')
                  ->on('books')
                  ->onDelete('cascade');
            $table->foreign('order_id')
                  ->references('id')
                  ->on('orders')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('book_order', function (Blueprint $table) {
            $table->dropForeign(['book_id']);
            $table->dropForeign(['order_id']);
        });
    }
};
