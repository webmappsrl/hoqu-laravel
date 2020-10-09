<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TasksController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/', function (Request $request) {
    if($request->user()->tokenCan('read'))
    {
        return response([ "name" => "HOQU-API","version" => "0.1.0"]);
    }
    else return abort(403,'Unauthorized');
});

Route::middleware('auth:sanctum')->post('/store',[TasksController::class, 'store']);
Route::middleware('auth:sanctum')->put('/pull',[TasksController::class, 'pull']);



