<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('offredestages')
            ->where('statut', 'active')
            ->update(['statut' => 'ouverte']);

        DB::table('offredestages')
            ->where('statut', 'Ouverte')
            ->update(['statut' => 'ouverte']);

        DB::table('offredestages')
            ->where('statut', 'En attente')
            ->update(['statut' => 'en_attente']);

        DB::table('offredestages')
            ->where('statut', 'Fermée')
            ->update(['statut' => 'fermee']);

        DB::table('offredestages')
            ->where('statut', 'inactive')
            ->update(['statut' => 'fermee']);

        DB::table('offredestages')
            ->where('statut', 'closed')
            ->update(['statut' => 'fermee']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};