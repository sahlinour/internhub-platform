<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidatures', function (Blueprint $table) {
            $table->id();
            $table->string('statut')->default('En attente'); // En attente, Acceptée, Refusée
            $table->date('date_postulation');
            $table->text('lettre_de_motivation')->nullable();
            $table->string('piece_jointe')->nullable();
            $table->string('cv_url')->nullable();

            
            $table->foreignId('idUtilisateur_Stagiaire')
                  ->constrained('stagiaires', 'user_id')
                  ->onDelete('cascade');

            
            $table->foreignId('id_Offre_De_Stage')
                  ->constrained('offredestages')
                  ->onDelete('cascade');

            
            $table->unique(['idUtilisateur_Stagiaire', 'id_Offre_De_Stage']);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidatures');
    }
};