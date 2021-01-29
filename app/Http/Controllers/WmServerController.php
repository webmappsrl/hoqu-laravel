<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Wm_Server;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WmServerController extends Controller
{
    public function get_server(Request $request)
    {
        if($request->user()->tokenCan('read'))
        {
            $servers = Wm_Server::all()->map->toArray();
            $single_server = [];
            $all_servers = [];
            foreach ($servers as $index => $server)
            {
                $task_processing = Task::where('id_server',$server['server_id'])->count();
                $single_server  = array_merge($server,['processing'=>$task_processing]);
                $all_servers[] = $single_server;
            }



            return response()->json($all_servers,200);

        }
        else return abort(403,'Unauthorized');
    }

}
