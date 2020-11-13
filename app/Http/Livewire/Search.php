<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Task;


class Search extends Component
{
    public $instance;
    public $job;
    public $jobs;

    public $tasks;
    public $instances;

    public function mount($instance,$job)
    {
        $this->instance=$instance;
        $this->job=$job;
        $this->tasks=[];
        $this->instances=[];
        $this->jobs=[];

    }

    public function updatedinstance()
    {
        $in = Task::find($this->instance);

        if(!empty($in))
        {
            $this->tasks= Task::whereIn('process_status', ['new','processing'])
            ->where('instance','=', $in->instance)
            ->orderByRaw('FIELD(process_status, "new", "processing")asc')
            ->orderBy('created_at', 'asc')
            ->get()
            ;

            $this->jobs = Task::where('process_status', '=', 'new')
            ->where('instance','=', $in->instance)
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

            $this->jobs = [];
        }

    }

    public function updatedjob()
    {

        $in = Task::find($this->instance);
        $in_job = Task::find($this->job);

        if(!empty($in_job))
        {
            $this->tasks = Task::whereIn('process_status', ['new','processing'])
            ->where('instance', '=', $in->instance)
            ->where('job', '=', $in_job->job)
            ->orderByRaw('FIELD(process_status, "new", "processing")asc')
            ->orderBy('created_at', 'asc')
            ->get();
        }
        else
        {
            $this->tasks = Task::whereIn('process_status', ['new','processing'])
            ->where('instance', '=', $in->instance)
            ->orderByRaw('FIELD(process_status, "new", "processing")asc')
            ->orderBy('created_at', 'asc')
            ->get();
        }

    }

    public function render()
    {
        $this->instances = Task::where('process_status', '=', 'new')->orderBy('created_at', 'asc')->get();
        return view('livewire.search');
    }
}
