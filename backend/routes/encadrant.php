<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\Encadrant\ProgressController;
use App\Http\Controllers\Encadrant\DocumentController;
use App\Http\Controllers\Encadrant\TacheController;
use App\Http\Controllers\Encadrant\EvaluationController;
use App\Http\Controllers\Encadrant\StageController;
use App\Http\Controllers\Encadrant\ProfileController;
use App\Http\Controllers\Encadrant\NotificationController;

Route::middleware(['auth', 'role:Encadrant'])
    ->prefix('encadrant')
    ->name('encadrant.')
    ->group(function () {


        Route::get('/dashboard', function () {
            return Inertia::render('Encadrant/Dashboard');
        })->name('dashboard');



        Route::get('/stagiaires', [StageController::class, 'index'])
            ->name('stagiaires.index');

        Route::get('/stagiaires/{id}', [StageController::class, 'showIntern'])
            ->name('stagiaires.show');



        Route::get('/taches/create', [TacheController::class, 'create'])
            ->name('taches.create');

        Route::get('/taches', [TacheController::class, 'index'])
            ->name('taches.index');

        Route::post('/taches', [TacheController::class, 'store'])
            ->name('taches.store');

        Route::put('/taches/{id}', [TacheController::class, 'update'])
            ->name('taches.update');

        Route::delete('/taches/{id}', [TacheController::class, 'destroy'])
            ->name('taches.destroy');


        Route::get('/task-reviews', [DocumentController::class, 'reviews'])
            ->name('task-reviews.index');



        Route::get('/documents', [DocumentController::class, 'index'])
            ->name('documents.index');

        Route::get('/documents/{id}/review', [DocumentController::class, 'show'])
            ->name('documents.show');

        Route::get('/documents/{id}/download', [DocumentController::class, 'download'])
            ->name('documents.download');

        Route::patch('/documents/{id}/status', [DocumentController::class, 'updateStatus'])
            ->name('documents.updateStatus');

        Route::delete('/documents/{id}', [DocumentController::class, 'destroy'])
            ->name('documents.destroy');



        Route::get('/progress', [ProgressController::class, 'index'])
            ->name('progress.index');



        Route::get('/evaluations', [EvaluationController::class, 'index'])
            ->name('evaluations.index');

        Route::post('/evaluations', [EvaluationController::class, 'store'])
            ->name('evaluations.store');

        Route::put('/evaluations/{id}', [EvaluationController::class, 'update'])
            ->name('evaluations.update');



        Route::get('/stages', [StageController::class, 'index'])
            ->name('stages.index');

        Route::get('/stages/{id}', [StageController::class, 'show'])
            ->name('stages.show');

        Route::put('/stages/{id}', [StageController::class, 'update'])
            ->name('stages.update');

        Route::patch('/stages/{id}/status', [StageController::class, 'updateStatus'])
            ->name('stages.updateStatus');



        Route::get('/profile', [ProfileController::class, 'edit'])
            ->name('profile.edit');

        Route::patch('/profile', [ProfileController::class, 'update'])
            ->name('profile.update');

        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])
            ->name('profile.password');



        Route::get('/notifications', [NotificationController::class, 'index'])
           ->name('notifications.index');

        Route::patch('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])
           ->name('notifications.readAll');

        Route::patch('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])
           ->name('notifications.read');

        Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])
           ->name('notifications.destroy');
    });
