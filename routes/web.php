<?php

use Illuminate\Support\Facades\Route;

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

/*pass data directly from controller to view
 *
 *
 Route::get('/', 'QueuesController@countQueue');
 *
 */
Route::get('/', 'QueuesController@countQueue');
