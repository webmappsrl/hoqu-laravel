<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Task;


class Search extends Component
{
    public $query;
    public $tasks;

    public function mount()
    {
        $this->query='';
        $this->tasks=[];
    }

    public function updatedQuery()
    {
        $this->tasks= Task::where('id','like','%'. $this->query .'%')
        ->orderBy('created_at', 'asc')
        ->get()
        ->toArray();

    }

    public function render()
    {
        return view('livewire.search');
    }
}
