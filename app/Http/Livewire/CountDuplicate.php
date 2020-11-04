<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Task;

class CountDuplicate extends Component
{
    public $count_duplicate;

    public function render()
    {
        $this->count_duplicate = Task::where('process_status', '=', 'error')->count();
        return view('livewire.count-duplicate');
    }
}
