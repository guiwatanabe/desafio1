<?php

use App\Http\Controllers\FilesController;
use App\Http\Controllers\PublicationsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/files', [FilesController::class, 'index'])->middleware(['auth', 'verified'])->middleware(['auth', 'verified']);

Route::get('/publications', [PublicationsController::class, 'index'])->middleware(['auth', 'verified'])->middleware(['auth', 'verified']);

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
