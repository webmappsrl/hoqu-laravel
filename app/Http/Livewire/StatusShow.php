<?php

namespace App\Http\Livewire;
use App\Models\Task;


use Livewire\Component;

class StatusShow extends Component
{

    public $task;

    public function mount($id)
    {
        $this->task = Task::find($id);
    }

    public function render()
    {
        return view('livewire.status-show',['task' =>$this->task]);

    }
}
