<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Wm_Server;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class WmServerController extends Controller
{
    public function get_server(Request $request)
    {
        if($request->user()->tokenCan('read'))
        {
            $servers = Wm_Server::all()->map->toArray();
            $all_servers = [];
            foreach ($servers as $index => $server)
            {
                $task_processing = Task::where('id_server',$server['server_id'])->count();
                $all_servers[] = array_merge($server,['processing'=>$task_processing]);
            }

            return response()->json($all_servers,200);

        }
        else return abort(403,'Unauthorized');
    }

    public function get_single_server(Request $request, $server_id)
    {
        if($request->user()->tokenCan('read'))
        {
            $server = Wm_Server::where('server_id',$server_id)->get()->toArray();

            $task_processing = Task::where('id_server',$server[0]['server_id'])->count();
            $single_server = [];

            if (now()->floatDiffInMinutes($server[0]['updated_at']) < 5 && $task_processing > 0)
            {
                $single_server = array_merge($server,['status'=>'Idle']);
            }
            elseif (now()->floatDiffInMinutes($server[0]['updated_at']) >= 5 && $task_processing == 0)
            {
                $single_server = array_merge($server,['status'=>'Turned off']);
            }
            elseif (now()->floatDiffInMinutes($server[0]['updated_at']) >= 5 && $task_processing > 0)
            {
                $single_server = array_merge($server,['status'=>'Warning']);
            }
            elseif (now()->floatDiffInMinutes($server[0]['updated_at']) < 5 && $task_processing > 0)
            {
                $single_server = array_merge($server,['status'=>'Active']);
            }


            return response()->json($single_server,200);

        }
        else return abort(403,'Unauthorized');
    }




}
