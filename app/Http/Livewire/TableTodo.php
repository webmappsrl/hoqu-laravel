<?php

namespace App\Http\Livewire;
use Livewire\WithPagination;

use App\Models\Task;
use Livewire\Component;

class TableTodo extends Component
{
    use WithPagination;

    public $instance;
    public $job;
    public $jobs;

    public $tasks;
    public $instances;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->instance='';
        $this->job='';
        $this->tasks=Task::whereIn('process_status', ['new','processing'])->orderByRaw('FIELD(process_status, "new", "processing")asc')->orderBy('created_at', 'asc')->get();
        $this->instances=[];
        $this->jobs=[];
    }

    public function updatedinstance()
    {
        $in = Task::find($this->instance);

        if(!empty($in))
        {
            $this->tasks= Task::whereIn('process_status', ['new','processing'])
            ->where('instance','like', $in->instance)
            ->orderByRaw('FIELD(process_status, "new", "processing")asc')
            ->orderBy('created_at', 'asc')
            ->get()
            ;
        }
        else
        {
            $this->tasks= Task::whereIn('process_status', ['new','processing'])
            ->orderByRaw('FIELD(process_status, "new", "processing")asc')
            ->orderBy('created_at', 'asc')
            ->get()
            ;

            $this->jobs = Task::whereIn('process_status', ['new','processing'])->orderBy('created_at', 'asc')->get();
        }

    }

    public function updatedjob()
    {

        $in_job = Task::find($this->job);

        if(!empty($in_job))
        {
            $this->tasks = Task::whereIn('process_status', ['new','processing'])
            ->where('job', 'like', $in_job->job)
            ->orderByRaw('FIELD(process_status, "new", "processing")asc')
            ->orderBy('created_at', 'asc')
            ->get();
        }
        else
        {
            $this->tasks = Task::whereIn('process_status', ['new','processing'])
            ->orderByRaw('FIELD(process_status, "new", "processing")asc')
            ->orderBy('created_at', 'asc')
            ->get();
        }

        $this->instances = Task::whereIn('process_status', ['new','processing'])->orderBy('created_at', 'asc')->get();

    }


    public function render()
    {
        $this->instances = Task::whereIn('process_status', ['new','processing'])->orderBy('created_at', 'asc')->get();

        $this->jobs = Task::whereIn('process_status', ['new','processing'])->orderBy('created_at', 'asc')->get();

        return view('livewire.table-todo',['posts' => Task::whereIn('process_status', ['new','processing'])->paginate(50)]);
    }
}
