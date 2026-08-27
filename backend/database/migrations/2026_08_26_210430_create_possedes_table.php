<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('possedes', function (Blueprint $table) {
            // Foreign Keys
            $table->foreignId('id_Competence')
                  ->constrained('competences')
                  ->onDelete('cascade');

            // Référence user_id / idUtilisateur de la table stagiaires
            $table->foreignId('idUtilisateur_Stagiaire')
                  ->constrained('stagiaires', 'user_id') 
                  ->onDelete('cascade');

            // Clé primaire composée
            $table->primary(['id_Competence', 'idUtilisateur_Stagiaire']);

            // Champs spécifiques
            $table->string('niveau');
            $table->string('experience');
            $table->date('date_ajout');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('possedes');
    }
};