<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Entreprise\EntrepriseController;
use App\Http\Controllers\Entreprise\NotificationController;
use App\Http\Controllers\Entreprise\EncadrantController as EntrepriseEncadrantController;
use App\Http\Controllers\Entreprise\OffreDeStageController as EntrepriseOffreController;
use App\Http\Controllers\Entreprise\CandidatureController as EntrepriseCandidatureController;
use App\Http\Controllers\Entreprise\StageController as EntrepriseStageController;
use App\Http\Controllers\Entreprise\DocumentController as EntrepriseDocumentController;
use App\Http\Controllers\Entreprise\TacheController as EntrepriseTacheController;


Route::middleware(['auth', 'role:Entreprise'])
    ->prefix('entreprise')
    ->name('entreprise.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Notifications
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/notifications/send-encadrant',
            [NotificationController::class, 'sendToEncadrant']
        )->name('notifications.sendToEncadrant');

        Route::post(
            '/notifications/broadcast-encadrants',
            [NotificationController::class, 'broadcastToEncadrants']
        )->name('notifications.broadcastToEncadrants');

        Route::delete(
            '/notifications/{id}',
            [NotificationController::class, 'destroy']
        )->name('notifications.destroy');


        /*
        |--------------------------------------------------------------------------
        | Entreprise Profile
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/profile',
            [EntrepriseController::class, 'show']
        )->name('profile.show');

        // Route::get(
        //     '/profile/edit',
        //     [EntrepriseController::class, 'edit']
        // )->name('profile.edit');

        Route::put(
            '/profile',
            [EntrepriseController::class, 'update']
        )->name('profile.update');

        Route::delete(
            '/profile',
            [EntrepriseController::class, 'destroy']
        )->name('profile.destroy');

        Route::put(
            '/profile/password',
            [EntrepriseController::class, 'updatePassword']
        )->name('profile.password.update');

        /*
        |--------------------------------------------------------------------------
        | Encadrants
        |--------------------------------------------------------------------------
        */

        Route::get('/encadrants',[EntrepriseEncadrantController::class, 'index'])->name('encadrants.index');

        Route::get('/encadrants/create',[EntrepriseEncadrantController::class, 'create'])->name('encadrants.create');

        Route::post('/encadrants',[EntrepriseEncadrantController::class, 'store'])->name('encadrants.store');

        Route::put('/encadrants/{id}',[EntrepriseEncadrantController::class, 'update'])->name('encadrants.update');

        Route::put('/encadrants/{id}/reset-password',[EntrepriseEncadrantController::class, 'resetPassword'])->name('encadrants.resetPassword');

        Route::delete('/encadrants/{id}',[EntrepriseEncadrantController::class, 'destroy'])->name('encadrants.destroy');


        /*
        |--------------------------------------------------------------------------
        | Internship Offers
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/offres',
            [EntrepriseOffreController::class, 'index']
        )->name('offres.index');

        Route::get(
            '/offres/create',
            [EntrepriseOffreController::class, 'create']
        )->name('offres.create');

        Route::post(
            '/offres',
            [EntrepriseOffreController::class, 'store']
        )->name('offres.store');

        Route::put(
            '/offres/{id}',
            [EntrepriseOffreController::class, 'update']
        )->name('offres.update');

        Route::delete(
            '/offres/{id}',
            [EntrepriseOffreController::class, 'destroy']
        )->name('offres.destroy');


        /*
        |--------------------------------------------------------------------------
        | Candidatures / Applicants
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/candidatures',
            [EntrepriseCandidatureController::class, 'index']
        )->name('candidatures.index');

        Route::patch(
            '/candidatures/{id}/status',
            [EntrepriseCandidatureController::class, 'updateStatus']
        )->name('candidatures.updateStatus');

      Route::get(
            '/candidatures/{id}',
            [EntrepriseCandidatureController::class, 'show']
        )->name('candidatures.show');


        /*
        |--------------------------------------------------------------------------
        | Accepted Students
        |--------------------------------------------------------------------------
        */

      Route::get(
    '/accepted-students',
    [EntrepriseCandidatureController::class, 'accepted']
     )->name('acceptedStudents.index');

    Route::get(
    '/accepted-students/{id}',
    [EntrepriseCandidatureController::class, 'showAccepted']
    )->name('acceptedStudents.show');


        /*
        |--------------------------------------------------------------------------
        | Stages / Current Interns
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/stages',
            [EntrepriseStageController::class, 'index']
        )->name('stages.index');

        Route::post(
            '/stages',
            [EntrepriseStageController::class, 'store']
        )->name('stages.store');

        Route::patch(
            '/stages/{id}/encadrant',
            [EntrepriseStageController::class, 'assignEncadrant']
        )->name('stages.assignEncadrant');

        Route::delete(
            '/stages/{id}',
            [EntrepriseStageController::class, 'destroy']
        )->name('stages.destroy');


        /*
        |--------------------------------------------------------------------------
        | Documents
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/documents',
            [EntrepriseDocumentController::class, 'index']
        )->name('documents.index');


        /*
        |--------------------------------------------------------------------------
        | Tasks
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/taches',
            [EntrepriseTacheController::class, 'index']
        )->name('taches.index');
    });
