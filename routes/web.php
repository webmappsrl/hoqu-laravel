<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Tasks;

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

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/', [Tasks::class, 'index'])->name('dashboard');
Route::middleware(['auth:sanctum', 'verified'])->get('/archive', [Tasks::class, 'index_done'])->name('archive');
 // Route::middleware(['auth:sanctum', 'verified'])->get('/error', [Tasks::class, 'index_error'])->name('error');
// Route::get('/error', Tasks::class);
	Route::middleware(['auth:sanctum', 'verified'])->get('/error', Tasks::class);

Route::middleware(['auth:sanctum', 'verified'])->get('/{task}', [Tasks::class, 'show'])->name('task_details');
Route::middleware(['auth:sanctum', 'verified'])->put('/{task}', [Tasks::class, 'update'])->name('reschedule');

Route::middleware(['auth:sanctum', 'verified'])->get('/prova', [Tasks::class])->name('livewire.tasks');

