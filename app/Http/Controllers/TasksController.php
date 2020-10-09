<?php

namespace App\Http\Controllers;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

use App\Mail\sendError;

class TasksController extends Controller
{
    public function sendEmail()
    {
        $wouldLikeUpdate = Task::where('process_status','=','error')->first();
        Mail::to('gianmarxgagliardi@gmail.com')->send(new sendError($wouldLikeUpdate));

    }

    public function show(Task $task)
    {
        return response()->json($task,200);
    }

    public function index()
    {
        $task = Task::orwhere('process_status', '=', 'new')->orwhere('process_status', '=', 'processing')->orderByRaw('FIELD(process_status, "new", "processing")asc')->orderBy('created_at', 'asc')->paginate(50);
        return view('dashboard',['tasks'=>$task]);
    }

    public function store(Request $request)
    {
        if($request->user()->tokenCan('create'))
        {
            $request=$request->all();

            if(!empty($request['parameters']))
            {
                //check string
                if(!is_array($request['parameters'])) return response()->json(["error"=>"error json"], 400);
                //check multidimesional associative array
                else if(array_keys($request['parameters'])===range(0, count($request['parameters']) - 1))
                {
                    return response()->json(["error"=>"error json"], 400);
                }
                $request['parameters'] = json_encode($request['parameters']);
            }

            $validator = Validator::make($request, [
                'instance' => 'required',
                'job' => 'required'
            ]);

            if($validator->fails()){
                return response(['error' => $validator->errors(), 'Validation Error'],400);
            }
            $task = Task::create($request);

            return response()->json($task, 201);

        }
        else return abort(403,'Unauthorized');

    }

    public function pull(Request $requestSvr)
    {
        // echo(json_encode($requestSvr->user()) . "\n\n");
        if($requestSvr->user()->tokenCan('update'))
        {
            $requestSvr->all();

            $validatedData = $requestSvr->validate([
                'id_server' => 'required|integer',
                'task_available' => 'required|array'
            ]);

            $task = Task::whereIn('job', $requestSvr['task_available'])->where('process_status','=','new')->orderBy('created_at', 'asc')->first();

            if(!empty($task))
            {
                $task->process_status = 'processing';
                $task->id_server = $requestSvr['id_server'];

                $task->save();

                return response()->json($task, 200);

            }
            else
            {
                return response()->json([], 204);
            }

        }
        else return abort(403,'Unauthorized');

    }

    public function updateDone(Request $requestSvr2)
    {
        if($requestSvr2->user()->tokenCan('update'))
        {
            //get all data
            $requestSvr2 = $requestSvr2->all();

            $validator = Validator::make($requestSvr2, [
                'id_server' => 'required|integer',
                'status' => 'required',
                'log'=>'required',
                'id_task'=>'required'
            ]);

            if($validator->fails()){
                return response(['error' => $validator->errors(), 'Validation Error'],400);
            }

            $wouldLikeUpdate = Task::findOrFail($requestSvr2['id_task']);

            if(!empty($wouldLikeUpdate))
            {
                if($requestSvr2['id_server']==$wouldLikeUpdate->id_server && ('processing'==$wouldLikeUpdate->process_status))
                {
                    $wouldLikeUpdate->process_status = $requestSvr2['status'];
                    $wouldLikeUpdate->process_log = $requestSvr2['log'];
                    $wouldLikeUpdate->save();
                    return response()->json($wouldLikeUpdate, 200);
                }
                else return abort(403,'You do not have the permissions');
            }
            else return response()->json(['error' => 'Id not exist.'],403);
        }
        else return abort(403,'Unauthorized');
    }

}
