<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->string('type_evaluation');
            $table->decimal('note_technique', 5, 2);
            $table->decimal('note_relationnelle', 5, 2);
            $table->decimal('note_global', 5, 2);
            $table->text('remarque_encadrant')->nullable();
            $table->date('date_evaluation');

            
            $table->foreignId('idUtilisateur_Encadrant')
                  ->constrained('encadrants', 'user_id')
                  ->onDelete('cascade');

            
            $table->foreignId('id_Stage')
                  ->constrained('stages')
                  ->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};