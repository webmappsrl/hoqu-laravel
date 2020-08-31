<?php

namespace App\Http\Controllers;

use App\Queue;
use DB;
use http\Env\Response;
use Illuminate\Http\Request;
use Validator;

class QueuesController extends Controller
{
    //return # elements in queue
    public function countQueue()
    {
        $cQ= DB::table('queues')->count();
        return view('welcome',['queues_count'=>$cQ]);
    }


    /*
     give back all elements of the Queue
     FIFO sorting
     */
    public function index()
    {
       // return response()->json(Queue::get(), 200);
        $cQ= DB::table('queues')->orderBy('created_at', 'asc')->get();
        return response()->json($cQ, 200);
    }

    
    /*
    add elementsin Queue
    */
    public function add(Request $request)
    {
        $queue = Queue::create($request->all());
        return response()->json($queue, 201);
    }

       /*
    pull elementsin Queue
    */
    public function pull(Request $requestSvr1)
    {
        //get data
        $requestSvr1 = $requestSvr1->all(); 

        //order
        $cQ= DB::table('queues')->whereIn('task', $requestSvr1['taskAvailable'])->orderByRaw("FIELD(process_status, 'new', 'processing', 'done','error')")->orderBy('created_at', 'asc')->limit(1)->get();
        //var_dump($cQ);

        //assignment of values
        $cQ->update(['idServer' => $requestSvr1['idServer']]);
        $cQ->update(['process_status' => 'processing']);

        return response()->json($cQ, 200);


    }



}
