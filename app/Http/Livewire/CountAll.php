<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Task;


class CountAll extends Component
{
    public $count_all;

    public function render()
    {
        $this->count_all = Task::count();

        return view('livewire.count-all');
    }
}
