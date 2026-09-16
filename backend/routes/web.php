<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VilleController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SignalementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AdminAuthenticatedSessionController;
use App\Http\Controllers\OffreDeStageController as GuestOffreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // Villes
    Route::get('/villes', [VilleController::class, 'index'])
        ->name('villes.index');

    Route::get('/villes/{id}', [VilleController::class, 'show'])
        ->name('villes.show');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');

    Route::patch('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])
        ->name('notifications.read');

    Route::patch('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])
        ->name('notifications.readAll');

    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])
        ->name('notifications.destroy');

    // Signalement
    Route::post('/offres/{id}/signalement', [SignalementController::class, 'store'])
        ->name('signalements.store');

    // Dashboard
    Route::get('/dashboard', DashboardController::class)
        ->name('dashboard');
});

// Public offers
Route::get('/offres', [GuestOffreController::class, 'index'])
    ->name('offres.index');

Route::get('/offres/{id}', [GuestOffreController::class, 'show'])
    ->name('offres.show');

// Admin authentication
Route::middleware('guest')->group(function () {

    Route::get('/admin/login', [AdminAuthenticatedSessionController::class, 'create'])
        ->name('admin.login');

    Route::post('/admin/login', [AdminAuthenticatedSessionController::class, 'store'])
        ->name('admin.login.store');
});

// Admin dashboard
Route::get('/admin/dashboard', function (Request $request) {
    abort_unless($request->user()?->role === 'Admin', 403);

    return Inertia::render('Admin/Dashboard');
})
    ->middleware('auth')
    ->name('admin.dashboard');

// Admin logout
Route::post('/admin/logout', [AdminAuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('admin.logout');

require __DIR__.'/auth.php';