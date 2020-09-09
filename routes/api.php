<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/','QueuesController@index');
Route::get('/{id}','QueuesController@indexId');
Route::post('add','QueuesController@add');
Route::put('pull','QueuesController@pull');
Route::put('update','QueuesController@update');





