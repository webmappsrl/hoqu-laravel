<?php

namespace App\Http\Livewire;

use App\Models\Task;
use App\Models\Wm_Server;
use Livewire\Component;

class TableServer extends Component
{
    public function render()
    {
        $tasks = Task::where('process_status','processing')->get();
        $server = Wm_Server::all();

        return view('livewire.table-server',['tasks' => $tasks, 'servers'=>$server]);
    }
}
