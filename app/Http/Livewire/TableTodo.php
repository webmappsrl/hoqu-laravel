<?php

namespace App\Http\Livewire;

use App\Models\Task;
use Livewire\Component;

class TableTodo extends Component
{
    public function render()
    {
        return view('livewire.table-todo', ['tasks' => Task::orwhere('process_status', '=', 'new')->orwhere('process_status', '=', 'processing')->orderByRaw('FIELD(process_status, "new", "processing")asc')->orderBy('created_at', 'asc')->paginate(50),'posts' => Task::where('process_status', '=', 'new')->orWhere('process_status', '=', 'processing')->paginate(50)]);
    }
}
