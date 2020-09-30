<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Tasks;



Route::middleware(['auth:sanctum', 'verified'])->get('/', [Tasks::class, 'index'])->name('dashboard');
Route::middleware(['auth:sanctum', 'verified'])->get('/archive', [Tasks::class, 'index_done'])->name('archive');

Route::middleware(['auth:sanctum', 'verified'])->get('/error', Tasks::class);

Route::middleware(['auth:sanctum', 'verified'])->get('/{task}', [Tasks::class, 'show'])->name('task_details');
Route::middleware(['auth:sanctum', 'verified'])->put('/{task}', [Tasks::class, 'update'])->name('reschedule');

