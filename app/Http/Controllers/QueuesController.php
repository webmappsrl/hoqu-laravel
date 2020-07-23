<?php

namespace App\Http\Controllers;

use App\Queue;
use DB;

class QueuesController extends Controller
{
    public function countQueue()
    {
        $cQ= DB::table('queues')->count();
        return view('welcome',['queues_count'=>$cQ]);
    }

}
