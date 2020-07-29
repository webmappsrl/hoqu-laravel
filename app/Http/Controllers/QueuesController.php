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
     check if the queue is empty
     */
    public function is_empty()
    {
        $cQ= DB::table('queues')->count();
        if($cQ == 0) return response()->json('Queue is empty',200);
        else return response()->json('Queue has '.$cQ,200);
    }


    /*
     give back all elements of the Queue
     FIFO sorting
     */
    public function index()
    {
       // return response()->json(Queue::get(), 200);
        $cQ= DB::table('queues')->orderBy('updated_at', 'desc')->get();
        return response()->json($cQ, 200);
    }

    /*
    takes the first element from Queues and eleminates it
    the first item is selected based on the FIFO sorting
    */
    public function pull_element()
    {
        /*
         to be implemented later:
         before deleting an item from the queue, it must be sent to the service that requested it
         ********
         l'elemento dalla coda viene eliminato sse è stato inviato al servizio che lo ha richiesto
         e la lavorazione da parte del servizio ha dato buon esito (200)
        */
        $cQ= DB::table('queues')->orderBy('updated_at', 'desc')->limit(1)->delete();
        return response()->json($cQ, 204);
    }

    /*
    add elementsin Queue
    */
    public function add_queue(Request $request)
    {
        $queue = Queue::create($request->all());
        return response()->json($queue, 201);
    }

}
