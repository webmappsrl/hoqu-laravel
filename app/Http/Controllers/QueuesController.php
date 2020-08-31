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
    public function pull(Request $request,Request $requestSvr1)
    {
        if (in_array($request[1], $requestSvr1[1]))
        {
            $cQ= DB::table('queues')->orderBy('created_at', 'asc')->get();
            $cQ->orderByRaw("FIELD(priority, 'new', 'processing', 'done','error')");
            $cQ->limit(1);
            $cQ->idServer = $requestSvr1[0];
            $cQ->process_status = 'processing';
            $cQ->save();
            return response()->json($cQ, 200);
        }
        else return response()->json($cQ, 204);

    }



}
