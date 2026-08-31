<?php

use Illuminate\Support\Facades\Route;
<<<<<<< Updated upstream
=======
use Inertia\Inertia;
use App\Http\Controllers\VilleController;
use App\Http\Controllers\Stagiaire\NotificationController;

>>>>>>> Stashed changes

Route::get('/', function () {
    return view('welcome');
});
<<<<<<< Updated upstream
=======

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//villes
Route::get('/villes', [VilleController::class, 'index'])->name('villes.index');
Route::get('/villes/{id}', [VilleController::class, 'show'])->name('villes.show');

//notifications
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::patch('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
Route::patch('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');



require __DIR__.'/auth.php';
>>>>>>> Stashed changes
