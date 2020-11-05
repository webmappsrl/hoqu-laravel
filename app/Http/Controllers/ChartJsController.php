<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use DB;
use Carbon\Carbon;

class ChartJsController extends Controller
{
    public function index()
    {
        $hour = [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23];

        $job = [];
        foreach ($hour as $key => $value) {
            $job[] = Task::where(\DB::raw("DATE_FORMAT(created_at, '%H')"),$value)->count();
        }

    	return view('error')->with('year',json_encode($hour,JSON_NUMERIC_CHECK))->with('user',json_encode($job,JSON_NUMERIC_CHECK));
    }
}
