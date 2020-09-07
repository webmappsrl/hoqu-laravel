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
        $config = config('app.version');
        return view('welcome',['queues_count'=>$cQ, 'version'=>$config]);
    }


    /*
     give back all elements of the Queue
     FIFO sorting
     */
    public function index()
    {
       // return response()->json(Queue::get(), 200);
        $cQ= DB::table('queues')->orderByRaw("FIELD(process_status, 'new', 'processing', 'done','error')")->orderBy('created_at', 'asc')->get();
        return response()->json($cQ, 200);
    }

    
    /*
    add elementsin Queue
    */
    public function add(Request $request)
    {
        //get all data
        $request=$request->all();

        //check instance
        if(empty($request['instance'])) return response()->json(["error"=>"field instance is NULL"], 400);
        //check task
        if(empty($request['task'])) return response()->json(["error"=>"field task is NULL"], 400);
        //check parameters
        if(!empty($request['parameters']))
        {
            //check string
            if(!is_array($request['parameters'])) return response()->json(["error"=>"erroe json"], 400);
            //check multidimesional associative array
            else if(array_keys($request['parameters'])===range(0, count($request['parameters']) - 1))
            {
                return response()->json(["error"=>"erroe json"], 400);   
            }
            
        }
        
        $queue = Queue::create($request);
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

       
        //var_dump($queue);
       
        if(!empty($queue))
        {
            $queue->process_status = 'processing';
            $queue->id_server = $requestSvr1['id_server'];

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
        
        //query
        $wouldLikeUpdate = Queue::find($requestSvr2['idTask']);

        if(!empty($wouldLikeUpdate))
        {
            if($requestSvr2['id_server']==$wouldLikeUpdate->id_server && ('processing'==$wouldLikeUpdate->process_status))
            {
                $wouldLikeUpdate->process_status = $requestSvr2['status'];  
                $wouldLikeUpdate->process_log = $requestSvr2['log'];  
                $wouldLikeUpdate->save();
                return response()->json($wouldLikeUpdate, 200);
            }
            else return response()->json(['error' => 'Not authorized.'.$requestSvr2['id_server'].' VS '.$wouldLikeUpdate->id_server.''],403);

        }
        else return response()->json(['error' => 'Id not exist.'],403);
            
    }


}
