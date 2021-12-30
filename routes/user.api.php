<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::middleware(['Cauth'])->group(function () {
    Route::get('/users/myprofile', [UserController::class, 'myProfile']);
    Route::post('/users/update', [UserController::class, 'update']);
    Route::delete('/users/delete', [UserController::class, 'delete']);
    Route::post('/users/search/{name}', [UserController::class, 'searchByName']);
});

Route::delete('/users/delete-user/{id}', [UserController::class, 'deleteUser']);
Route::delete('/users/delete-token/{id}', [UserController::class, 'deleteTokenById']);
