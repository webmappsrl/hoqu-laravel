<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/', function (Request $request) {
    return response([ "name" => "HOQU-API","version" => "0.1.0"]);
});


