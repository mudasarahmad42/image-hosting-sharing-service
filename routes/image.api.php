<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;


Route::middleware(['Cauth'])->group(function () {
    Route::post('/image/upload', [ImageController::class, 'imageUpload']);
    Route::delete('/image/delete/{id}', [ImageController::class, 'deleteImageById']);
    Route::get('/images/all', [ImageController::class, 'findAll']);
    Route::get('/images', [ImageController::class, 'findAllByUser']);
    Route::get('/images/{id}', [ImageController::class, 'findById']);
    Route::post('/images/addaccess', [ImageController::class, 'addUserAccess']);
    Route::post('/images/removeaccess', [ImageController::class, 'removeUserAccess']);
    Route::get('/images/search/{query}', [ImageController::class, 'searchImages']);
    Route::post('/images/change-privacy/{id}', [ImageController::class, 'changePrivacy']);
});
