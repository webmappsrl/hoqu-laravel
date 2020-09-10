<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(array('prefix' => 'queue'), function()
{
    Route::get('list','QueuesController@list');
    Route::get('item/{id}','QueuesController@item');
    Route::post('push','QueuesController@push');
    Route::put('pull','QueuesController@pull');
    Route::put('update','QueuesController@update');
});





