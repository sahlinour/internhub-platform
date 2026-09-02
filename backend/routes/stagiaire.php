<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Stagiaire\StagiaireController;
use App\Http\Controllers\Stagiaire\CompetenceController as StagiaireCompetenceController;
use App\Http\Controllers\Stagiaire\FavorisController;
use App\Http\Controllers\Stagiaire\CandidatureController as StagiaireCandidatureController;
use App\Http\Controllers\Stagiaire\DocumentController as StagiaireDocumentController;
use App\Http\Controllers\Stagiaire\TacheController as StagiaireTacheController;


Route::middleware(['auth', 'role:Stagiaire'])
    ->prefix('stagiaire')
    ->name('stagiaire.')
    ->group(function () {

        Route::get('/dashboard', [StagiaireController::class, 'dashboard'])
            ->name('dashboard');

        // Stagiaire Profile CRUD
        Route::get('/profile', [StagiaireController::class, 'show'])->name('profile.show');
        Route::get('/profile/edit', [StagiaireController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [StagiaireController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [StagiaireController::class, 'destroy'])->name('profile.destroy');
        Route::put('/profile/password', [StagiaireController::class, 'updatePassword'])->name('profile.password.update');

        // Stagiaire Competence CRUD
        Route::get('/competences', [StagiaireCompetenceController::class, 'index'])->name('competences.index');
        Route::post('/competences', [StagiaireCompetenceController::class, 'store'])->name('competences.store');
        Route::put('/competences/{id}', [StagiaireCompetenceController::class, 'update'])->name('competences.update');
        Route::delete('/competences/{id}', [StagiaireCompetenceController::class, 'destroy'])->name('competences.destroy');

        // Stagiaire Favoris CRUD
        Route::get('/favoris', [FavorisController::class, 'index'])->name('favoris.index');
        Route::post('/favoris/{offreId}/toggle', [FavorisController::class, 'toggle'])->name('favoris.toggle');
        Route::delete('/favoris/{offreId}', [FavorisController::class, 'destroy'])->name('favoris.destroy');

        // Stagiaire Candidature CRUD
        Route::get('/candidatures', [StagiaireCandidatureController::class, 'index'])->name('candidatures.index');
        Route::post('/offres/{offreId}/apply', [StagiaireCandidatureController::class, 'store'])->name('candidatures.store');
        Route::delete('/candidatures/{id}', [StagiaireCandidatureController::class, 'destroy'])->name('candidatures.destroy');

        //Stagiaire Document
        Route::get('/documents', [StagiaireDocumentController::class, 'index'])->name('documents.index');
        Route::post('/documents', [StagiaireDocumentController::class, 'store'])->name('documents.store');

        // Stagiaire Tache
        Route::get('/taches', [StagiaireTacheController::class, 'index'])->name('taches.index');
        Route::patch('/taches/{id}/status', [StagiaireTacheController::class, 'updateStatus'])->name('taches.updateStatus');
});