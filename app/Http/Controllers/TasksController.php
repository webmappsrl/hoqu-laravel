<?php

namespace App\Http\Controllers;
use App\Models\Task;
use App\Models\DuplicateTask;
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

    public function show(Request $request,Task $task)
    {
        if($request->user()->tokenCan('read'))
        {
            return response()->json($task,200);
        }
        else return abort(403,'Unauthorized');

    }

    public function index()
    {
        $task = Task::orderBy('updated_at', 'desc')->paginate(10);
        return view('dashboard',['tasks'=>$task]);
    }

    public function indexTodo()
    {
        $task = Task::orwhere('process_status', '=', 'new')->orwhere('process_status', '=', 'processing')->orderByRaw('FIELD(process_status, "new", "processing")asc')->orderBy('created_at', 'asc')->paginate(50);
        return view('todo',['tasks'=>$task]);
    }

    public function indexDone()
    {
        $task = Task::orwhere('process_status', '=', 'done')->orwhere('process_status', '=', 'skip')->orderByRaw('FIELD(process_status, "done", "skip")asc')->orderBy('created_at', 'asc')->paginate(50);
        return view('archive',['tasks'=>$task]);
    }

    public function indexError()
    {
        $task = Task::orwhere('process_status', '=', 'error')->orderByRaw('FIELD(process_status, "done", "skip")asc')->orderBy('created_at', 'asc')->paginate(50);
        return view('error',['tasks'=>$task]);
    }

    public function indexDuplicate()
    {
        $task = Task::orwhere('process_status', '=', 'duplicate')->orderBy('created_at', 'asc')->paginate(50);
        return view('duplicate',['tasks'=>$task]);
    }

    public function store(Request $request)
    {
        if($request->user()->tokenCan('create'))
        {
            $request=$request->all();


            $request['instance'] = preg_replace('#^https?:/?/?#', '', $request['instance']);


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

            //check duplicate
            if(isset($request['parameters']))
            {
                $taskDuplicate = Task::where('instance','=',$request['instance'])
                ->where('job','=',$request['job'])
                ->where('process_status','=','new')
                ->whereJsonContains('parameters',json_decode($request['parameters'],TRUE))
                ->get();
            }
            else
            {
                $taskDuplicate = Task::where('instance','=',$request['instance'])
                ->where('job','=',$request['job'])
                ->where('process_status','=','new')
                ->whereNull('parameters')
                ->get();
            }

            // dd($request);
            if($taskDuplicate->isEmpty()) $task = Task::create($request);
            else
            {
                $task = new DuplicateTask();
                $task->task_id = $taskDuplicate[0]['id'];
                $task->save();
            }

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
            $requestSvr['id_server'] = (string) $requestSvr['id_server'];

            $validatedData = $requestSvr->validate([
                'id_server' => 'required|string',
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
            $requestSvr2['id_server'] = (string) $requestSvr2['id_server'];


            $validator = Validator::make($requestSvr2, [
                'id_server' => 'required|string',
                'id_task'=>'required|integer'
            ]);

            if($validator->fails()){
                return response(['error' => $validator->errors(), 'Validation Error'],400);
            }

            $wouldLikeUpdate = Task::find($requestSvr2['id_task']);

            if(!empty($wouldLikeUpdate))
            {
                if($requestSvr2['id_server']==$wouldLikeUpdate->id_server && ('processing'==$wouldLikeUpdate->process_status))
                {
                    $wouldLikeUpdate->process_status = 'done';
                    if(!empty($requestSvr2['log']))
                    {
                        $wouldLikeUpdate->process_log = $requestSvr2['log'];
                    }

                    $wouldLikeUpdate->save();
                    return response()->json($wouldLikeUpdate, 200);
                }
                else return abort(403,'You do not have the permissions');
            }
            else return response()->json(['error' => 'Id not exist.'],403);
        }
        else return abort(403,'Unauthorized');
    }

    public function updateError(Request $requestSvr2)
    {
        if($requestSvr2->user()->tokenCan('update'))
        {
            //get all data
            $requestSvr2 = $requestSvr2->all();
            $requestSvr2['id_server'] = (string) $requestSvr2['id_server'];

            $validator = Validator::make($requestSvr2, [
                'id_server' => 'required|string',
//                'log'=>'required',
//                'error_log'=>'required',
                'id_task'=>'required|integer'
            ]);

            if($validator->fails()){
                return response(['error' => $validator->errors(), 'Validation Error'],400);
            }

            $wouldLikeUpdate = Task::find($requestSvr2['id_task']);
            if(!empty($wouldLikeUpdate))
            {
                if($requestSvr2['id_server']==$wouldLikeUpdate->id_server && ('processing'==$wouldLikeUpdate->process_status))
                {
                    $wouldLikeUpdate->process_status = 'error';
                    if(!empty($requestSvr2['log']))
                    {
                        $wouldLikeUpdate->process_log = $requestSvr2['log'];
                    }
                    if(!empty($requestSvr2['error_log']))
                    {
                        $wouldLikeUpdate->error_log = $requestSvr2['error_log'];
                    }
//                    $wouldLikeUpdate->process_log = $requestSvr2['log'];
//                    $wouldLikeUpdate->error_log = $requestSvr2['error_log'];
                    $wouldLikeUpdate->save();
                    Mail::to('team@webmapp.it')->send(new sendError($wouldLikeUpdate));
                    return response()->json($wouldLikeUpdate, 200);
                }
                else return abort(403,'You do not have the permissions');
            }
            else return response()->json(['error' => 'Id not exist.'],403);
        }
        else return abort(403,'Unauthorized');
    }

    public function jobsByInstance(Request $request,$instance)
    {
        if($request->user()->tokenCan('read'))
        {
            if(!empty($instance))
            {
                $todo = Task::whereIn('process_status', ['new','processing'])->where('instance','=',$instance)->orderBy('created_at', 'asc')->get();
                $done = Task::where('process_status','=','done')->where('instance','=',$instance)->orderBy('created_at', 'desc')->limit(100)->get();
                $error = Task::where('process_status','=','error')->where('instance','=',$instance)->orderBy('created_at', 'asc')->get();

                return response()->json(['todo'=>$todo,'done'=>$done,'error'=>$error],200);
            }
            else
            {
                return response()->json('the instance has not been inserted',200);
            }

        }
        else return abort(403,'Unauthorized');
    }




}
