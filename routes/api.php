<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('queues','QueuesController@index');
Route::post('queues','QueuesController@add');
Route::put('queuesPull','QueuesController@pull');




