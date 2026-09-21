<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('taches')
            ->where('statut', 'À faire')
            ->update(['statut' => 'a_faire']);

        DB::table('taches')
            ->where('statut', 'En cours')
            ->update(['statut' => 'en_cours']);

        DB::table('taches')
            ->where('statut', 'Terminée')
            ->update(['statut' => 'terminee']);

        DB::table('taches')
            ->where('statut', 'Annulée')
            ->update(['statut' => 'annulee']);
    }

    public function down(): void
    {
        DB::table('taches')
            ->where('statut', 'a_faire')
            ->update(['statut' => 'À faire']);

        DB::table('taches')
            ->where('statut', 'en_cours')
            ->update(['statut' => 'En cours']);

        DB::table('taches')
            ->where('statut', 'terminee')
            ->update(['statut' => 'Terminée']);

        DB::table('taches')
            ->where('statut', 'annulee')
            ->update(['statut' => 'Annulée']);
    }
};