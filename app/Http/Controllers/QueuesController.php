<?php

namespace App\Http\Controllers;



use App\Queue;
use DB;
use http\Env\Response;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\notifyHoqu;

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
    public function list()
    {
       // return response()->json(Queue::get(), 200);
        $cQ= DB::table('queues')->orderByRaw('FIELD(process_status, "new", "processing", "done","error","duplicate")asc')->orderBy('created_at', 'asc')->get();
        return response()->json($cQ, 200);
    }

    public function item($id)
    {
        return response()->json(Queue::findOrFail($id), 200);
    }


    /*
    add elementsin Queue
    */
    public function push(Request $request)
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

        $queueDuplicate = Queue::where('instance','=',$request['instance'])
        ->where('task','=',$request['task']);

        if(isset($request['parameters']))
        {
            $queueDuplicate = Queue::where('instance','=',$request['instance'])
            ->where('task','=',$request['task'])
            ->whereJsonContains('parameters',$request['parameters'])
            ->get();
        }
        else
        {
            $queueDuplicate = Queue::where('instance','=',$request['instance'])
            ->where('task','=',$request['task'])
            ->whereNull('parameters')
            ->get();
        }


        if($queueDuplicate->isEmpty()) $queue = Queue::create($request);
        else
        {
            $queue = Queue::create($request);
            $wouldLikeUpdate = Queue::find($queue->id);
            $wouldLikeUpdate->process_status='duplicate';
            $wouldLikeUpdate->save();
        }

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
        $queue = Queue::whereIn('task', $requestSvr1['taskAvailable'])->where('process_status','=','new')->orderBy('created_at', 'asc')->first();

        if(!empty($queue))
        {
            $queue->process_status = 'processing';
            $queue->id_server = $requestSvr1['id_server'];

            $queue->save();

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
        if(!empty($requestSvr2['status']) && ($requestSvr2['status']=='error'||$requestSvr2['status']=='done'))
        {
            //query
            $wouldLikeUpdate = Queue::find($requestSvr2['idTask']);

            if(!empty($wouldLikeUpdate))
            {
                if($requestSvr2['id_server']==$wouldLikeUpdate->id_server && ('processing'==$wouldLikeUpdate->process_status))
                {
                    $wouldLikeUpdate->process_status = $requestSvr2['status'];
                    $wouldLikeUpdate->process_log = $requestSvr2['log'];
                    $wouldLikeUpdate->save();
                    //send mail
                    if($requestSvr2['status']=='error')
                    {
                         Mail::to('gianmarcogagliardi@webmapp.it')->send(new NotifyHoqu($wouldLikeUpdate));
                    }
                    return response()->json($wouldLikeUpdate, 200);
                }
                else return response()->json(['error' => 'Not authorized.'.$requestSvr2['id_server'].' VS '.$wouldLikeUpdate->id_server.''],403);

            }
            else return response()->json(['error' => 'Id not exist.'],403);

        }
        else
        {
            return response()->json(['error' => 'status not exist or does not have the correct value.'],403);

        }


    }


}
