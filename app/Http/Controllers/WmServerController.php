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
            $d = [];
            $dr = [];
            foreach ($servers as $server)
            {
                $task_processing = Task::where('id_server',$server['server_id'])->count();
                $a = ['processing'=>$task_processing];
                $d  += array_merge($server,$a);
                $dr += $d;
            }



            return response()->json($dr,200);

        }
        else return abort(403,'Unauthorized');
    }

}
