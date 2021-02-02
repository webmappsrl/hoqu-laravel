<?php

namespace App\Http\Livewire;

use App\Models\Task;
use App\Models\Wm_Server;
use Livewire\Component;

class ServerActive extends Component
{
    public function render()
    {
        $servers = Wm_Server::all();
        $sa = 0;

        foreach ($servers as $server)
        {
            $task_processing = Task::where('id_server',$server->server_id)
                ->where('process_status','processing')
                ->count();
            if (now()->floatDiffInMinutes($server->updated_at) < 5 && $task_processing > 0)
            {
                $sa++;
            }
            if (now()->floatDiffInMinutes($server->updated_at) < 5 && $task_processing == 0)
            {
                $sa++;
            }
        }


        return view('livewire.server-active',['serverActive'=>$sa]);
    }
}
