<?php

use App\Http\Controllers\Api\FilesController;
use App\Http\Controllers\Api\PublicationsController;
use App\Http\Controllers\UploadedFileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/file', [UploadedFileController::class, 'store']);

Route::get('/files', [FilesController::class, 'index']);

Route::get('/publications', [PublicationsController::class, 'index']);

Route::get('/publications/{id}', [PublicationsController::class, 'show']);