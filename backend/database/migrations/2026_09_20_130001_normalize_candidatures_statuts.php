<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('candidatures')
            ->where('statut', 'Acceptée')
            ->update(['statut' => 'acceptee']);

        DB::table('candidatures')
            ->where('statut', 'Refusée')
            ->update(['statut' => 'refusee']);

        DB::table('candidatures')
            ->where('statut', 'En attente')
            ->update(['statut' => 'en_attente']);

        DB::table('candidatures')
            ->where('statut', 'En cours d\'examen')
            ->update(['statut' => 'en_cours_examen']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
