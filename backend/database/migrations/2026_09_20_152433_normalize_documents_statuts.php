<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('documents')
            ->where('statut', 'En attente')
            ->update(['statut' => 'en_attente']);

        DB::table('documents')
            ->where('statut', 'Validé')
            ->update(['statut' => 'valide']);

        DB::table('documents')
            ->where('statut', 'Rejeté')
            ->update(['statut' => 'rejete']);
    }

    public function down(): void
    {
        DB::table('documents')
            ->where('statut', 'en_attente')
            ->update(['statut' => 'En attente']);

        DB::table('documents')
            ->where('statut', 'valide')
            ->update(['statut' => 'Validé']);

        DB::table('documents')
            ->where('statut', 'rejete')
            ->update(['statut' => 'Rejeté']);
    }
};