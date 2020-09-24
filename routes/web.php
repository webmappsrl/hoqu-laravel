<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TasksController;


Route::middleware(['auth:sanctum', 'verified'])->get('/', [TasksController::class, 'index'])->name('dashboard');
Route::middleware(['auth:sanctum', 'verified'])->get('/archive', [TasksController::class, 'index_done'])->name('archive');
Route::middleware(['auth:sanctum', 'verified'])->get('/error', [TasksController::class, 'index_error'])->name('error');
Route::middleware(['auth:sanctum', 'verified'])->get('/{task}', [TasksController::class, 'show'])->name('task_details');
Route::middleware(['auth:sanctum', 'verified'])->get('/{task}/reschedule', [TasksController::class, 'edit'])->name('reschedule');
Route::middleware(['auth:sanctum', 'verified'])->put('/{task}', [TasksController::class, 'update'])->name('reschedule');

