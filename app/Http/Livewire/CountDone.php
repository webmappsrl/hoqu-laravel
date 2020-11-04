<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Task;


class CountDone extends Component
{
    public $count_done;
    public function render()
    {
        $this->count_done = Task::where('process_status', '=', 'done')->count();
        return view('livewire.count-done');
    }
}
