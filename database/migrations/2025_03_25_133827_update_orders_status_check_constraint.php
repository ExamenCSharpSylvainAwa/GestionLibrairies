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
        DB::statement('ALTER TABLE orders DROP CONSTRAINT orders_status_check;');

        // Mettre à jour les statuts existants pour qu'ils correspondent aux nouvelles valeurs
        DB::table('orders')
            ->where('status', 'pending')
            ->update(['status' => 'En attente']);

        DB::table('orders')
            ->where('status', 'processing')
            ->update(['status' => 'En préparation']);

        DB::table('orders')
            ->where('status', 'shipped')
            ->update(['status' => 'Expédiée']);

        DB::table('orders')
            ->where('status', 'paid')
            ->update(['status' => 'Payée']);

        DB::table('orders')
            ->where('status', 'cancelled')
            ->update(['status' => 'Annulée']);

        // Ajouter la nouvelle contrainte avec les valeurs de l'enum OrderStatus
        DB::statement("ALTER TABLE orders ADD CONSTRAINT orders_status_check CHECK (status IN ('En attente', 'En préparation', 'Expédiée', 'Payée', 'Annulée'));");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       // Supprimer la nouvelle contrainte
       DB::statement('ALTER TABLE orders DROP CONSTRAINT orders_status_check;');

       // Revenir aux anciennes valeurs
       DB::table('orders')
           ->where('status', 'En attente')
           ->update(['status' => 'pending']);

       DB::table('orders')
           ->where('status', 'En préparation')
           ->update(['status' => 'processing']);

       DB::table('orders')
           ->where('status', 'Expédiée')
           ->update(['status' => 'shipped']);

       DB::table('orders')
           ->where('status', 'Payée')
           ->update(['status' => 'paid']);

       DB::table('orders')
           ->where('status', 'Annulée')
           ->update(['status' => 'cancelled']);

       // Restaurer l'ancienne contrainte
       DB::statement("ALTER TABLE orders ADD CONSTRAINT orders_status_check CHECK (status IN ('pending', 'processing', 'shipped', 'paid', 'cancelled'));");
    }
};
