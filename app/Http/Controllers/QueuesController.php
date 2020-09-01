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
        //get all data
        $requestSvr1 = $requestSvr1->all(); 

        //order
        $queue = Queue::whereIn('task', $requestSvr1['taskAvailable'])->orderByRaw("FIELD(process_status, 'new', 'processing', 'done','error')")->orderBy('created_at', 'asc')->first();
       
        //var_dump($queue->count());
       
        if(!empty($queue))
        {
            $queue->process_status = 'processing';
            $queue->idServer = $requestSvr1['idServer'];

            $queue->save();

            //var_dump($queue);


            return response()->json($queue, 200);

        }
        else
        {
            return response()->json([], 204);
        } 

    }

    /*
    update
    */
    public function update(Request $requestSvr2)
    {
            //get all data
            $requestSvr2 = $requestSvr2->all();

            //get id queue
            $wouldLikeUpdate = Queue::find($requestSvr2['idTask'])->where('process_status', 'process')->first();;
            var_dump($wouldLikeUpdate);
            //check permission
            if(!empty($wouldLikeUpdate) && $requestSvr2['idServer']==$wouldLikeUpdate)
            {
                return response()->json([], 200);
            }
            else
            {
                return response()->json(['error' => 'Not authorized.'],403);
            }
    }
 




}
