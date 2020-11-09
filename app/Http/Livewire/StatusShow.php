<?php

namespace App\Http\Livewire;
use App\Models\Task;


use Livewire\Component;

class StatusShow extends Component
{
    public function show(Task $task)
    {
        return view('livewire.status-show',['task'=>$task]);
    }

    public function render()
    {

    }
}
