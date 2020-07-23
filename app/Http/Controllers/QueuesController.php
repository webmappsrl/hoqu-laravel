<?php

namespace App\Http\Controllers;

use App\Queue;
use DB;

class QueuesController extends Controller
{
    public function countQueue()
    {
        $cQ= DB::table('queues')->count();
        return $cQ;
    }

    public function countQueue1()
    {
        $queues = DB::table('queues')->count();

        return view('prova')->with('a',$queues);
    }
}
