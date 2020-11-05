<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Tasks;
use App\Http\Livewire\Chart30days;
use App\Http\Controllers\ChartJsController;

use App\Http\Controllers\TasksController;



Route::middleware(['auth:sanctum', 'verified'])->get('/', [TasksController::class, 'index'])->name('dashboard');
// Route::middleware(['auth:sanctum', 'verified'])->get('/nedo',Chart30days::class)->name('error');
Route::get('/nedo', function () {
    return view('error');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/archive', [Tasks::class, 'index_done'])->name('archive');

Route::middleware(['auth:sanctum', 'verified'])->get('/error', Tasks::class);

Route::middleware(['auth:sanctum', 'verified'])->get('/{task}/show', [Tasks::class, 'show'])->name('task_details');

Route::get('/mail',[TasksController::class, 'sendEmail'])->name('mail');

Route::middleware(['auth:sanctum', 'verified'])->get('/duplicate', [TasksController::class, 'indexDuplicate'])->name('duplicate');

Route::get('/nedo', [ChartJsController::class, 'index'])->name('error');



