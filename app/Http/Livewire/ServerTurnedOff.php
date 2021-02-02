<?php

namespace App\Http\Livewire;

use App\Models\Task;
use App\Models\Wm_Server;
use Livewire\Component;

class ServerTurnedOff extends Component
{
    public function render()
    {
        $servers = Wm_Server::all();
        $st = 0;

        foreach ($servers as $server)
        {
            $task_processing = Task::where('id_server',$server->server_id)
                ->where('process_status','processing')
                ->count();
            if (now()->floatDiffInMinutes($server->updated_at) >= 5 && $task_processing == 0)
            {
                $st++;
            }
            if (now()->floatDiffInMinutes($server->updated_at) >= 5 && $task_processing > 0)
            {
                $st++;
            }
        }
        return view('livewire.server-turned-off',['serverTurnedOff'=>$st]);
    }
}
