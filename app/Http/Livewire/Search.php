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
        dd($this->instance);
        $in = Task::findOrFail($this->instance);


        $this->tasks= Task::where('process_status', '=', 'new')
        ->where('instance','=', $in->instance)
        ->orderBy('created_at', 'asc')
        ->get()
        ->toArray();

            $this->jobs = Task::where('process_status', '=', 'new')
            ->where('instance','=', $in->instance)
                        ->orderBy('created_at', 'asc')->get();



    }

    public function updatedjob()
    {

        $in = Task::find($this->instance);
        $in_job = Task::find($this->job);

        $this->tasks = Task::where('process_status', '=', 'new')
        ->where('instance', '=', $in->instance)
        ->where('job', '=', $in_job->job)
        ->orderBy('created_at', 'asc')->get();

    }



    public function render()
    {
        $this->instances = Task::where('process_status', '=', 'new')->orderBy('created_at', 'asc')->get();

        return view('livewire.search');
    }
}
