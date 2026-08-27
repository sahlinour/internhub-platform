<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('offredestages', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description');
            $table->string('duree');
            $table->date('date_limite');
            $table->string('statut');
            
            // Foreign key targeting user_id on entreprises table
            $table->foreignId('idUtilisateur_Entreprise')
                  ->constrained('entreprises', 'user_id')
                  ->onDelete('cascade');
                  
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('offredestages');
    }
};