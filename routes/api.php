<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FingerprintController;


Route::post('/login', [AuthController::class, 'apiLogin']);
Route::post('/fingerprint/verify', [FingerprintController::class, 'verify']);