<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
    Schema::create('stagiaires', function (Blueprint $table) {
    $table->foreignId('user_id')->primary()->constrained('users')->onDelete('cascade');
    $table->string('universite')->nullable();
    $table->string('filiere')->nullable();
    $table->string('niveau')->nullable();
    $table->date('date_naissance')->nullable();
    $table->string('cv_url')->nullable();
    $table->enum('statut_stage', ['recherche','en_attente','en_cours','termine','annule',])->default('recherche');
    $table->string('linkedin_url')->nullable();
    $table->string('portfolio_url')->nullable();
    $table->timestamps();
    $table->softDeletes();
    });
    }
     /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stagiaires');
    }
};
