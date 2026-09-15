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
        Schema::table('documents', function (Blueprint $table) {
            // Add these columns if they don't exist
            if (!Schema::hasColumn('documents', 'type')) {
                $table->string('type')->default('document')->comment('Type of document: cv, document, etc.');
            }
            if (!Schema::hasColumn('documents', 'id_Utilisateur_stagiaire')) {
                $table->unsignedBigInteger('id_Utilisateur_stagiaire')->nullable();
                $table->foreign('id_Utilisateur_stagiaire')->references('id')->on('users')->onDelete('cascade');
            }
            // Make id_Stage nullable since CVs don't need to be tied to a specific stage
            if (Schema::hasColumn('documents', 'id_Stage')) {
                $table->unsignedBigInteger('id_Stage')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            if (Schema::hasColumn('documents', 'id_Utilisateur_stagiaire')) {
                $table->dropForeignKeyIfExists(['id_Utilisateur_stagiaire']);
                $table->dropColumn('id_Utilisateur_stagiaire');
            }
            if (Schema::hasColumn('documents', 'type')) {
                $table->dropColumn('type');
            }
        });
    }
};
