<?php

namespace App\Http\Livewire;

use App\Models\Task;
use Livewire\Component;

class TableDashboard extends Component
{

    public function render()
    {
        return view('livewire.table-dashboard', ['tasks' => Task::orderBy('updated_at', 'desc')->paginate(10)] );
    }
}
