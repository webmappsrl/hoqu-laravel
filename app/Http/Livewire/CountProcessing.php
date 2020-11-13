<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Task;
class CountProcessing extends Component
{
    public $count_processing;
    public function render()
    {
        $this->count_processing = Task::where('process_status', '=', 'processing')->count();
        return view('livewire.count-processing');
    }
}
