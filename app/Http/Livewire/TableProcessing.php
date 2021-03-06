<?php

namespace App\Http\Livewire;

use App\Models\Task;
use Livewire\Component;
use Livewire\WithPagination;

class TableProcessing extends Component
{
    use WithPagination;

    public $instance;
    public $job,$created_at, $num_page;
    public $jobs;
    public $countJ = 0;
    public $countI = 1;
    public $countZ = 0;
    public $isOpen = 0;

    public $isModalSkip = 0;
    public $isModalRes = 0;


    public $instance1, $job1,$parameters, $process_status, $process_log, $Task_id;

    public $instances;

    public function openModalRes()
    {
        $this->isModalRes = true;
    }

    public function closeModalRes()
    {
        $this->isModalRes = false;
    }

    public function openModalSkip()
    {
        $this->isModalSkip = true;
    }

    public function closeModalSkip()
    {
        $this->isModalSkip = false;
    }


    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }


    public function closeModal()
    {
        $this->isOpen = false;
    }



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    private function resetInputFields(){
        $this->instance1 = '';
        $this->job1 = '';
        $this->parameters = '';
        $this->process_status = '';
        $this->process_log = '';
    }

    public function updatinginstance()
    {
        $this->resetPage();
    }

    public function mount($instance,$job,$created_at,$num_page)
    {
        $this->instance=$instance;
        $this->job=$job;
        $this->created_at=$created_at;
        $this->num_page=$num_page;
        $this->instances=[];
        $this->jobs=[];
    }

    public function editRes(Task $task)
    {
        $this->Task_id = $task->id;

        $this->openModalRes();

    }

    public function editSkip(Task $task)
    {
        $this->Task_id = $task->id;

        $this->openModalSkip();

    }

    public function updateRes()
    {

        Task::updateOrCreate(['id' => $this->Task_id], [
            'process_status' => 'new'
        ]);

        session()->flash('message',
            'changed the process status of ' .$this->Task_id . ' in NEW');

        $this->closeModalRes();
        $this->resetInputFields();

    }

    public function updateSkip()
    {

        Task::updateOrCreate(['id' => $this->Task_id], [
            'process_status' => 'skip'

        ]);

        session()->flash('message',
            'changed the process status of ' .$this->Task_id . ' in SKIP');

        $this->closeModalSkip();
        $this->resetInputFields();
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function edit(Task $task)
    {
        $this->Task_id = $task->id;
        $this->instance = $task->instance;
        $this->job = $task->job;

        $this->openModal();

    }




    public function render()
    {
        if (!empty($this->job))
        {
            $this->instances = Task::select('instance')->where('job',$this->job)->whereIn('process_status', ['processing'])->groupBy('instance')->orderBy('instance', 'asc')->get();
        }
        else $this->instances = Task::select('instance')->whereIn('process_status', ['processing'])->groupBy('instance')->orderBy('instance', 'asc')->get();

        if (!empty($this->instance))
        {
            $this->jobs = Task::select('job')->where('instance',$this->instance)->whereIn('process_status', ['processing'])->groupBy('job')->orderBy('job', 'asc')->get();
        }
        else $this->jobs = Task::select('job')->whereIn('process_status', ['processing'])->groupBy('job')->orderBy('job', 'asc')->get();


        if(!empty($this->job) && !empty($this->instance) && !empty($this->created_at) && !empty($this->num_page))
        {
            $tasks = Task::whereIn('process_status', ['processing'])
                ->where('job', 'like', $this->job)
                ->where('instance', 'like', $this->instance)
                ->orderBy('created_at', $this->created_at)
                ->paginate($this->num_page);
        }
        else if(!empty($this->created_at) && empty($this->job) && !empty($this->instance) && !empty($this->num_page))
        {
            $tasks = Task::whereIn('process_status', ['processing'])
                ->where('instance', 'like', $this->instance)
                ->orderBy('created_at', $this->created_at)
                ->paginate($this->num_page);
        }
        else if(!empty($this->created_at) && !empty($this->job) && empty($this->instance) && !empty($this->num_page))
        {
            $tasks = Task::whereIn('process_status', ['processing'])
                ->where('job', 'like', $this->job)
                ->orderBy('created_at', $this->created_at)
                ->paginate($this->num_page);
        }
        else if(!empty($this->created_at) && !empty($this->job) && !empty($this->instance) && empty($this->num_page))
        {
            $tasks = Task::whereIn('process_status', ['processing'])
                ->where('instance', 'like', $this->instance)
                ->where('job', 'like', $this->job)
                ->orderBy('created_at', $this->created_at)
                ->paginate(50);
        }
        else if(!empty($this->created_at) && !empty($this->job) && empty($this->instance) && empty($this->num_page))
        {
            $tasks = Task::whereIn('process_status', ['processing'])
                ->where('job', 'like', $this->job)
                ->orderBy('created_at', $this->created_at)
                ->paginate(50);
        }
        else if(empty($this->created_at) && !empty($this->job) && !empty($this->instance) && !empty($this->num_page))
        {
            $tasks = Task::whereIn('process_status', ['processing'])
                ->where('job', 'like', $this->job)
                ->where('instance', 'like', $this->instance)
                ->orderBy('created_at', 'asc')
                ->paginate($this->num_page);
        }
        else if(empty($this->created_at) && !empty($this->job) && !empty($this->instance) && empty($this->num_page))
        {
            $tasks = Task::whereIn('process_status', ['processing'])
                ->where('job', 'like', $this->job)
                ->where('instance', 'like', $this->instance)
                ->orderBy('created_at', 'asc')
                ->paginate(50);
        }
        else if(!empty($this->created_at) && empty($this->job) && !empty($this->instance) && !empty($this->num_page))
        {
            $tasks = Task::whereIn('process_status', ['processing'])
                ->where('instance', 'like', $this->instance)
                ->orderBy('created_at', $this->created_at)
                ->paginate($this->num_page);
        }
        else if(empty($this->created_at) && empty($this->job) && !empty($this->instance) && !empty($this->num_page))
        {
            $tasks = Task::whereIn('process_status', ['processing'])
                ->where('instance', 'like', $this->instance)
                ->orderBy('created_at', 'asc')
                ->paginate($this->num_page);
        }
        else if(empty($this->created_at) && empty($this->job) && !empty($this->instance) && empty($this->num_page))
        {
            $tasks = Task::whereIn('process_status', ['processing'])
                ->where('instance', 'like', $this->instance)
                ->orderBy('created_at', 'asc')
                ->paginate(50);
        }
        else if(!empty($this->created_at) && !empty($this->job) && empty($this->instance) && !empty($this->num_page))
        {
            $tasks = Task::whereIn('process_status', ['processing'])
                ->where('job', 'like', $this->job)
                ->orderBy('created_at', $this->created_at)
                ->paginate($this->num_page);
        }
        else if(empty($this->created_at) && !empty($this->job) && empty($this->instance) && !empty($this->num_page))
        {
            $tasks = Task::whereIn('process_status', ['processing'])
                ->where('job', 'like', $this->job)
                ->orderBy('created_at', 'asc')
                ->paginate($this->num_page);
        }
        else if(empty($this->created_at) && !empty($this->job) && empty($this->instance) && empty($this->num_page))
        {
            $tasks = Task::whereIn('process_status', ['processing'])
                ->where('job', 'like', $this->job)
                ->orderBy('created_at', 'asc')
                ->paginate(50);
        }
        else if(!empty($this->created_at) && empty($this->job) && empty($this->instance) && !empty($this->num_page))
        {
            $tasks = Task::whereIn('process_status', ['processing'])
                ->orderBy('created_at', $this->created_at)
                ->paginate($this->num_page);
        }
        else if(empty($this->created_at) && empty($this->job) && empty($this->instance) && !empty($this->num_page))
        {
            $tasks = Task::whereIn('process_status', ['processing'])
                ->orderBy('created_at', 'asc')
                ->paginate($this->num_page);
        }
        else if(!empty($this->created_at) && empty($this->job) && empty($this->instance) && empty($this->num_page))
        {
            $tasks = Task::whereIn('process_status', ['processing'])
                ->orderBy('created_at', $this->created_at)
                ->paginate(50);
        }
        else
        {
            $tasks = Task::whereIn('process_status', ['processing'])
                ->orderBy('created_at', 'asc')
                ->paginate(50);
        }

        return view('livewire.table-processing',['tasks' => $tasks]);
    }
}
