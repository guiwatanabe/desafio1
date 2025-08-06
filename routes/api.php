<?php

use App\Http\Controllers\UploadedFileController;
use App\Models\Publication;
use App\Models\PublicationMetadata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/file', [UploadedFileController::class, 'store']);