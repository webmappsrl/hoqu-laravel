<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TasksController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::middleware(['auth:sanctum', 'verified'])->get('/', function () {

//     return view('dashboard');
// })->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/', [TasksController::class, 'index'])->name('dashboard');;

Route::middleware(['auth:sanctum', 'verified'])->get('/{task}', [TasksController::class, 'show'])->name('task_details');;



//Route::get('articles', [TasksController::class, 'index']);
