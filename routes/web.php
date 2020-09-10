<?php

use Illuminate\Support\Facades\Route;

/*pass data directly from controller to view
 *
 *
 Route::get('/', 'QueuesController@countQueue');
 *
 */
Route::get('/', 'QueuesController@countQueue');


