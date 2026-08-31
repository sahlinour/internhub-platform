<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('taches', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description')->nullable();
            $table->string('priorite')->default('Moyenne'); // Basse, Moyenne, Haute, Urgente
            $table->date('date_creation');
            $table->date('date_echeance');
            $table->date('date_fin_effective')->nullable();
            $table->string('statut')->default('À faire'); 

            
            $table->foreignId('idUtilisateur')
                  ->constrained('users')
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
        Schema::dropIfExists('taches');
    }
};