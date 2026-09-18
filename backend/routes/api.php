<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AiMatchingController;

Route::post('/parse-cv', [AiMatchingController::class, 'parseCv']);
Route::post('/match-score', [AiMatchingController::class, 'calculateMatch']);