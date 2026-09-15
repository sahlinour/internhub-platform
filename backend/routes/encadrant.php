<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth', 'role:Encadrant'])
    ->prefix('encadrant')
    ->name('encadrant.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return Inertia::render('Encadrant/Dashboard');
        })->name('dashboard');

    });
Route::get('/stagiaires', function () {
    return Inertia::render('Encadrant/Stagiaires/Index');
})->name('stagiaires.index');
