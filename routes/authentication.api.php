<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;



//Authentication routes
//Public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/email-confirmation/{email}/{token}', [AuthController::class, 'EmailConfirmation']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password/{email}/{token}', [AuthController::class, 'passwordReset']);

Route::middleware(['Cauth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});
