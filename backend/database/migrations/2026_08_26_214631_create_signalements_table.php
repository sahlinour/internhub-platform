<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('signalements', function (Blueprint $table) {
            $table->id();
            $table->text('raison');
            $table->date('date_signalement');
            $table->string('statut')->default('En attente'); // En attente, Traité, Rejeté

            // User who created the report
            $table->foreignId('idUtilisateur_emetteur')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Admin who handles the report (references admins.idUtilisateur)
            $table->foreignId('id_Utilisateur_Admin')
                  ->nullable()
                  ->constrained('admins', 'idUtilisateur')
                  ->onDelete('set null');

            // Optional targeted offer
            $table->foreignId('id_Offre_De_Stage')
                  ->constrained('offredestages')
                  ->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('signalements');
    }
};