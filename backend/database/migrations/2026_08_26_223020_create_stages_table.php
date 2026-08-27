<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stages', function (Blueprint $table) {
            $table->id();
            $table->string('sujet');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->string('statut')->default('En cours');


            $table->foreignId('idUtilisateur_Encadrant')
                  ->nullable()
                  ->constrained('encadrants', 'user_id')
                  ->onDelete('set null');

            
            $table->foreignId('id_Candidature')
                  ->unique()
                  ->constrained('candidatures')
                  ->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stages');
    }
};