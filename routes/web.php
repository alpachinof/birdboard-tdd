<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectTasksController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::get('/dashboard', [ProjectController::class, 'index'])
//     ->middleware(['auth'])
//     ->name('dashboard');

Route::middleware('auth')->prefix('projects')->group(function () {
    Route::get('/', [ProjectController::class, 'index'])->name('dashboard');
    Route::get('/create', [ProjectController::class, 'create']);
    Route::get('/{project}', [ProjectController::class, 'show']);
    Route::get('/{project}/edit', [ProjectController::class, 'edit']);
    Route::patch('/{project}', [ProjectController::class, 'update']);
    Route::post('/', [ProjectController::class, 'store']);
    Route::delete('/{project}', [ProjectController::class, 'destroy']);


    Route::prefix('/{project}/tasks')->group(function () {
        Route::post('/', [ProjectTasksController::class, 'store']);
        Route::patch('/{task}', [ProjectTasksController::class, 'update']);
    });
});

require __DIR__ . '/auth.php';
