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

}
