<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('version')->default('v1.0');
            $table->string('statut')->default('En attente');
            $table->string('fichier_url')->nullable();

            // FK referencing Encadrant: idUtilisateur_Encadrant
            $table->foreignId('idUtilisateur_Encadrant')
                  ->constrained('encadrants', 'user_id')
                  ->onDelete('cascade');

            // FK referencing Stage
            $table->foreignId('id_Stage')
                  ->constrained('stages')
                  ->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};