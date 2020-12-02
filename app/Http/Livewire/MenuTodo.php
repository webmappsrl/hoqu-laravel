<?php

namespace App\Http\Livewire;

use App\Models\DuplicateTask;
use App\Models\Task;
use Livewire\Component;

class MenuTodo extends Component
{
    public $count_processing;
    public $count_duplicate;
    public $count_new;
    public $count_error;
    public $count_done;
    public function render()
    {
        $this->count_duplicate = DuplicateTask::count();
        $this->count_done = Task::where('process_status', '=', 'done')->count();
        $this->count_new = Task::whereIn('process_status', ['new','processing'])->count();
        $this->count_processing = Task::where('process_status', '=', 'processing')->count();
        $this->count_error = Task::where('process_status', '=', 'error')->count();
        return view('livewire.menu-todo');
    }
}
