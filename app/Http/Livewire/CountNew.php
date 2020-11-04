<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Task;


class CountNew extends Component
{
    public $count_new;


    public function render()
    {
        $this->count_new = Task::where('process_status', '=', 'new')->count();
        return view('livewire.count-new');
    }
}
