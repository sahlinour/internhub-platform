<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\EntrepriseController as AdminEntrepriseController;
use App\Http\Controllers\Admin\StagiaireController as AdminStagiaireController;
use App\Http\Controllers\Admin\EncadrantController as AdminEncadrantController;
use App\Http\Controllers\Admin\OffreDeStageController as AdminOffreController;
use App\Http\Controllers\Admin\CompetenceController as AdminCompetenceController;
use App\Http\Controllers\Admin\SignalementController as AdminSignalementController;
use App\Http\Controllers\Admin\CandidatureController as AdminCandidatureController;
use App\Http\Controllers\Admin\StageController as AdminStageController;
use App\Http\Controllers\Admin\EvaluationController as AdminEvaluationController;
use App\Http\Controllers\Admin\DocumentController as AdminDocumentController;
use App\Http\Controllers\Admin\TacheController as AdminTacheController;
Route::middleware(['auth', 'role:Admin'])->prefix('admin')->name('admin.')->group(function () {
    
});

Route::middleware(['auth', 'role:Admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('dashboard');


        //Admin CRUD (just update)
        Route::put('/profile/password', [AdminProfileController::class, 'updatePassword'])->name('profile.password.update');
        Route::get('/profile', [AdminProfileController::class, 'show'])->name('profile.show');
        Route::get('/profile/edit', [AdminProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');

        // Admin Notification Routes
        Route::get('/notifications', [NotificationController::class, 'indexAll'])->name('notifications.indexAll');
        Route::post('/notifications/send', [NotificationController::class, 'sendToUser'])->name('notifications.send');
        Route::post('/notifications/broadcast', [NotificationController::class, 'broadcast'])->name('notifications.broadcast');
        Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

        // Entreprise Management Routes
        Route::get('/entreprises', [AdminEntrepriseController::class, 'index'])->name('entreprises.index');
        Route::get('/entreprises/{id}', [AdminEntrepriseController::class, 'show'])->name('entreprises.show');
        Route::get('/entreprises/{id}/edit', [AdminEntrepriseController::class, 'edit'])->name('entreprises.edit');
        Route::put('/entreprises/{id}', [AdminEntrepriseController::class, 'update'])->name('entreprises.update');
        Route::patch('/entreprises/{id}/status', [AdminEntrepriseController::class, 'updateStatus'])->name('entreprises.updateStatus');
        Route::delete('/entreprises/{id}', [AdminEntrepriseController::class, 'destroy'])->name('entreprises.destroy');
        Route::put('/entreprises/{id}/reset-password', [AdminEntrepriseController::class, 'resetPassword']) ->name('entreprises.resetPassword');

        // Admin Stagiaire Management Routes
        Route::get('/stagiaires', [AdminStagiaireController::class, 'index'])->name('stagiaires.index');
        Route::get('/stagiaires/{id}', [AdminStagiaireController::class, 'show'])->name('stagiaires.show');
        Route::get('/stagiaires/{id}/edit', [AdminStagiaireController::class, 'edit'])->name('stagiaires.edit');
        Route::put('/stagiaires/{id}', [AdminStagiaireController::class, 'update'])->name('stagiaires.update');
        Route::patch('/stagiaires/{id}/status', [AdminStagiaireController::class, 'updateStatus'])->name('stagiaires.updateStatus');
        Route::delete('/stagiaires/{id}', [AdminStagiaireController::class, 'destroy'])->name('stagiaires.destroy');
        Route::put('/stagiaires/{id}/reset-password', [AdminStagiaireController::class, 'resetPassword'])->name('stagiaires.resetPassword');

        // Admin Encadrant Management Routes
        Route::get('/encadrants', [AdminEncadrantController::class, 'index'])->name('encadrants.index');
        Route::get('/encadrants/{id}', [AdminEncadrantController::class, 'show'])->name('encadrants.show');
        Route::patch('/encadrants/{id}/status', [AdminEncadrantController::class, 'updateStatus'])->name('encadrants.updateStatus');
        Route::put('/encadrants/{id}/reset-password', [AdminEncadrantController::class, 'resetPassword'])->name('encadrants.resetPassword');
        Route::delete('/encadrants/{id}', [AdminEncadrantController::class, 'destroy'])->name('encadrants.destroy');

        // Admin Offre de Stage Management Routes
        Route::get('/offres', [AdminOffreController::class, 'index'])->name('offres.index');
        Route::patch('/offres/{id}/status', [AdminOffreController::class, 'updateStatus'])->name('offres.updateStatus');
        Route::delete('/offres/{id}', [AdminOffreController::class, 'destroy'])->name('offres.destroy');

        // Admin Competence Management Routes
        Route::get('/competences', [AdminCompetenceController::class, 'index'])->name('competences.index');
        Route::post('/competences', [AdminCompetenceController::class, 'store'])->name('competences.store');
        Route::put('/competences/{id}', [AdminCompetenceController::class, 'update'])->name('competences.update');
        Route::delete('/competences/{id}', [AdminCompetenceController::class, 'destroy'])->name('competences.destroy');

        // Admin Signalement Management Routes
        Route::get('/signalements', [AdminSignalementController::class, 'index'])->name('signalements.index');
        Route::patch('/signalements/{id}/status', [AdminSignalementController::class, 'updateStatus'])->name('signalements.updateStatus');

        // Admin Candidature Management Routes
        Route::get('/candidatures', [AdminCandidatureController::class, 'index'])->name('candidatures.index');
        Route::get('/offres/{offreId}/candidatures', [AdminCandidatureController::class, 'showByOffer'])->name('candidatures.byOffer');

        // Admin Stage Management Routes
        Route::get('/stages', [AdminStageController::class, 'index'])->name('stages.index');
        Route::patch('/stages/{id}/status', [AdminStageController::class, 'updateStatus'])->name('stages.updateStatus');
        Route::delete('/stages/{id}', [AdminStageController::class, 'destroy'])->name('stages.destroy');

        // Admin Evaluation Management Routes
        Route::get('/evaluations', [AdminEvaluationController::class, 'index'])->name('evaluations.index');
        Route::delete('/evaluations/{id}', [AdminEvaluationController::class, 'destroy'])->name('evaluations.destroy');

        //Admin  Document Management Routes
        Route::get('/documents', [AdminDocumentController::class, 'index'])->name('documents.index');
        Route::delete('/documents/{id}', [AdminDocumentController::class, 'destroy'])->name('documents.destroy');

        //Admin Tache Management Routes
        Route::get('/taches', [AdminTacheController::class, 'index'])->name('taches.index');
        Route::delete('/taches/{id}', [AdminTacheController::class, 'destroy'])->name('taches.destroy');
});