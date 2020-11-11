<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Tasks;
use App\Http\Controllers\ChartJsController;

use App\Http\Controllers\TasksController;



Route::middleware(['auth:sanctum', 'verified'])->get('/', [TasksController::class, 'index'])->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/todo', [TasksController::class, 'indexTodo'])->name('todo');

Route::middleware(['auth:sanctum', 'verified'])->get('/done', [TasksController::class, 'indexDone'])->name('archive');


Route::middleware(['auth:sanctum', 'verified'])->get('/error', [TasksController::class, 'indexError'])->name('error');

Route::middleware(['auth:sanctum', 'verified'])->get('/{task}/show', [Tasks::class, 'show'])->name('task_details');

Route::get('/mail',[TasksController::class, 'sendEmail'])->name('mail');

Route::middleware(['auth:sanctum', 'verified'])->get('/duplicate', [TasksController::class, 'indexDuplicate'])->name('duplicate');

Route::get('/nedo', [ChartJsController::class, 'index'])->name('error');

Route::middleware(['auth:sanctum', 'verified'])->get('/info', function () {
    return view('info');
});





