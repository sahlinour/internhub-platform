<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AdminAuthenticatedSessionController;

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


/*
|--------------------------------------------------------------------------
| Admin Authentication
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/login', [AdminAuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('/login', [AdminAuthenticatedSessionController::class, 'store'])
        ->name('login.store');
});


/*
|--------------------------------------------------------------------------
| Protected Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:admin', 'role:Admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('dashboard');

        // Logout
        Route::post('/logout', [AdminAuthenticatedSessionController::class, 'destroy'])
            ->name('logout');


        /*
        |--------------------------------------------------------------------------
        | Admin Profile
        |--------------------------------------------------------------------------
        */

        Route::get('/profile', [AdminProfileController::class, 'show'])
            ->name('profile.show');

        Route::get('/profile/edit', [AdminProfileController::class, 'edit'])
            ->name('profile.edit');

        Route::put('/profile', [AdminProfileController::class, 'update'])
            ->name('profile.update');

        Route::put('/profile/password', [AdminProfileController::class, 'updatePassword'])
            ->name('profile.password.update');




        /*
        |--------------------------------------------------------------------------
        | Notifications
        |--------------------------------------------------------------------------
        */

        Route::get('/notifications', [NotificationController::class, 'indexAll'])
            ->name('notifications.indexAll');

        Route::post('/notifications/send', [NotificationController::class, 'sendToUser'])
            ->name('notifications.send');

        Route::post('/notifications/broadcast', [NotificationController::class, 'broadcast'])
            ->name('notifications.broadcast');

        Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])
            ->name('notifications.destroy');


        /*
        |--------------------------------------------------------------------------
        | Entreprises
        |--------------------------------------------------------------------------
        */

        // Company Management Routes
        Route::get('/entreprises', [AdminEntrepriseController::class, 'index'])
            ->name('entreprises.index');

        Route::get('/entreprises/create', [AdminEntrepriseController::class, 'create'])
            ->name('entreprises.create');

        Route::post('/entreprises', [AdminEntrepriseController::class, 'store'])
            ->name('entreprises.store');

        Route::get('/entreprises/{id}', [AdminEntrepriseController::class, 'show'])
            ->name('entreprises.show');

        Route::get('/entreprises/{id}/edit', [AdminEntrepriseController::class, 'edit'])
            ->name('entreprises.edit');

        Route::put('/entreprises/{id}', [AdminEntrepriseController::class, 'update'])
            ->name('entreprises.update');

        Route::patch('/entreprises/{id}/status', [AdminEntrepriseController::class, 'updateStatus'])
            ->name('entreprises.updateStatus');

        Route::delete('/entreprises/{id}', [AdminEntrepriseController::class, 'destroy'])
            ->name('entreprises.destroy');

        Route::put('/entreprises/{id}/reset-password', [AdminEntrepriseController::class, 'resetPassword'])
            ->name('entreprises.resetPassword');


        /*
|--------------------------------------------------------------------------
| Stagiaires
|--------------------------------------------------------------------------
*/


            Route::get('/stagiaires', [AdminStagiaireController::class, 'index'])
                ->name('stagiaires.index');


            Route::get('/stagiaires/create', [AdminStagiaireController::class, 'create'])
                ->name('stagiaires.create');

            Route::post('/stagiaires', [AdminStagiaireController::class, 'store'])
                ->name('stagiaires.store');


            Route::get('/stagiaires/{id}/edit', [AdminStagiaireController::class, 'edit'])
                ->name('stagiaires.edit');


            Route::put('/stagiaires/{id}', [AdminStagiaireController::class, 'update'])
                ->name('stagiaires.update');


            Route::patch('/stagiaires/{id}/status', [AdminStagiaireController::class, 'updateStatus'])
                ->name('stagiaires.updateStatus');


            Route::put('/stagiaires/{id}/reset-password', [AdminStagiaireController::class, 'resetPassword'])
                ->name('stagiaires.resetPassword');


            Route::delete('/stagiaires/{id}', [AdminStagiaireController::class, 'destroy'])
                ->name('stagiaires.destroy');


            Route::get('/stagiaires/{id}', [AdminStagiaireController::class, 'show'])
                ->name('stagiaires.show');

                            /*
        |--------------------------------------------------------------------------
        | Encadrants
        |--------------------------------------------------------------------------
        */

        Route::get('/encadrants', [AdminEncadrantController::class, 'index'])
            ->name('encadrants.index');

        Route::get('/encadrants/create', [AdminEncadrantController::class, 'create'])
            ->name('encadrants.create');

        Route::post('/encadrants', [AdminEncadrantController::class, 'store'])
            ->name('encadrants.store');

        // IMPORTANT: /edit before /{id}
        Route::get('/encadrants/{id}/edit', [AdminEncadrantController::class, 'edit'])
            ->name('encadrants.edit');

        Route::put('/encadrants/{id}', [AdminEncadrantController::class, 'update'])
            ->name('encadrants.update');

        Route::patch('/encadrants/{id}/status', [AdminEncadrantController::class, 'updateStatus'])
            ->name('encadrants.updateStatus');

        Route::put('/encadrants/{id}/reset-password', [AdminEncadrantController::class, 'resetPassword'])
            ->name('encadrants.resetPassword');

        Route::delete('/encadrants/{id}', [AdminEncadrantController::class, 'destroy'])
            ->name('encadrants.destroy');

        // Keep this after the more specific routes
        Route::get('/encadrants/{id}', [AdminEncadrantController::class, 'show'])
            ->name('encadrants.show');
        /*
        |--------------------------------------------------------------------------
        | Signalements
        |--------------------------------------------------------------------------
        */

        Route::get('/signalements', [AdminSignalementController::class, 'index'])
            ->name('signalements.index');

        Route::patch('/signalements/{id}/status', [AdminSignalementController::class, 'updateStatus'])
            ->name('signalements.updateStatus');


        /*
        |--------------------------------------------------------------------------
        | Candidatures
        |--------------------------------------------------------------------------
        */

        Route::get('/candidatures', [AdminCandidatureController::class, 'index'])
            ->name('candidatures.index');





        Route::get('/offres/{offreId}/candidatures', [AdminCandidatureController::class, 'showByOffer'])
            ->name('candidatures.byOffer');


            /*
        |--------------------------------------------------------------------------
        | Stages
        |--------------------------------------------------------------------------
        */

            Route::get(
            '/stages',
            [AdminStageController::class, 'index']
        )->name('stages.index');

        Route::get(
            '/stages/{id}',
            [AdminStageController::class, 'show']
        )->name('stages.show');
        /*
        |--------------------------------------------------------------------------
        | Evaluations
        |--------------------------------------------------------------------------
        */

        Route::get('/evaluations', [AdminEvaluationController::class, 'index'])
            ->name('evaluations.index');

        Route::delete('/evaluations/{id}', [AdminEvaluationController::class, 'destroy'])
            ->name('evaluations.destroy');


        /*
        |--------------------------------------------------------------------------
        | Documents
        |--------------------------------------------------------------------------
        */

        Route::get('/documents', [AdminDocumentController::class, 'index'])
            ->name('documents.index');

        Route::delete('/documents/{id}', [AdminDocumentController::class, 'destroy'])
            ->name('documents.destroy');


        /*
        |--------------------------------------------------------------------------
        | Taches
        |--------------------------------------------------------------------------
        */

        Route::get('/taches', [AdminTacheController::class, 'index'])
            ->name('taches.index');

        Route::delete('/taches/{id}', [AdminTacheController::class, 'destroy'])
            ->name('taches.destroy');

// offres
            Route::get('/offres', [AdminOffreController::class, 'index'])
                ->name('offres.index');

            Route::get('/offres/create', [AdminOffreController::class, 'create'])
                ->name('offres.create');

            Route::post('/offres', [AdminOffreController::class, 'store'])
                ->name('offres.store');

            Route::get('/offres/{id}/edit', [AdminOffreController::class, 'edit'])
                ->name('offres.edit');

            Route::put('/offres/{id}', [AdminOffreController::class, 'update'])
                ->name('offres.update');

            Route::patch('/offres/{id}/status', [AdminOffreController::class, 'updateStatus'])
                ->name('offres.updateStatus');

            Route::delete('/offres/{id}', [AdminOffreController::class, 'destroy'])
                ->name('offres.destroy');

            Route::get('/offres/{id}', [AdminOffreController::class, 'show'])
                ->name('offres.show');
    });
