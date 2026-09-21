<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AiMatchingController;


Route::post(
    '/parse-cv',
    [AiMatchingController::class, 'parseCv']
)->name('ai.parse-cv');

Route::post(
    '/match',
    [AiMatchingController::class, 'matchCv']
)->name('ai.match');

Route::post(
    '/match-score',
    [AiMatchingController::class, 'calculateMatch']
)->name('ai.match-score');