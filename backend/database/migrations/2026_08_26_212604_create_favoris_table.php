<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('favoris', function (Blueprint $table) {
            $table->id();

            // Clé étrangère vers Stagiaire (user_id)
            $table->foreignId('idUtilisateur_Stagiaire')
                  ->constrained('stagiaires', 'user_id')
                  ->onDelete('cascade');

            // Clé étrangère vers Offredestage
            $table->foreignId('id_Offre_De_Stage')
                  ->constrained('offredestages')
                  ->onDelete('cascade');

            // Empêche un stagiaire d'ajouter 2 fois la même offre en favoris
            $table->unique(['idUtilisateur_Stagiaire', 'id_Offre_De_Stage']);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favoris');
    }
};