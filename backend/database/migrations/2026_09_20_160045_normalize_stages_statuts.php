<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('stages')
            ->where('statut', 'En cours')
            ->update(['statut' => 'en_cours']);

        DB::table('stages')
            ->where('statut', 'Terminé')
            ->update(['statut' => 'termine']);

        DB::table('stages')
            ->where('statut', 'Terminée')
            ->update(['statut' => 'termine']);

        DB::table('stages')
            ->where('statut', 'Annulé')
            ->update(['statut' => 'annule']);

        DB::table('stages')
            ->where('statut', 'Annulée')
            ->update(['statut' => 'annule']);
    }

    public function down(): void
    {
        DB::table('stages')
            ->where('statut', 'en_cours')
            ->update(['statut' => 'En cours']);

        DB::table('stages')
            ->where('statut', 'termine')
            ->update(['statut' => 'Terminé']);

        DB::table('stages')
            ->where('statut', 'annule')
            ->update(['statut' => 'Annulé']);
    }
};