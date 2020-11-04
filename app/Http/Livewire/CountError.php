<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Task;

class CountError extends Component
{
    public $count_error;
    public function render()
    {
        $this->count_error = Task::where('process_status', '=', 'error')->count();
        return view('livewire.count-error');
    }
}
