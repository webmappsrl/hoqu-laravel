<?php

namespace App\Http\Livewire;

use App\Models\Task;
use Livewire\Component;

class TableDashboard extends Component
{
    public $tasks;

    public function render()
    {
        $this->tasks = Task::orderBy('updated_at', 'desc')->paginate(10);
        return view('livewire.table-dashboard');
    }
}
