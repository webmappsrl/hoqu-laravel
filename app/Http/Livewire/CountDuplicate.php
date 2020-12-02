<?php

namespace App\Http\Livewire;

use App\Models\DuplicateTask;
use Livewire\Component;
use App\Models\Task;

class CountDuplicate extends Component
{
    public $count_duplicate;

    public function render()
    {
        $this->count_duplicate = DuplicateTask::count();
        return view('livewire.count-duplicate');
    }
}
