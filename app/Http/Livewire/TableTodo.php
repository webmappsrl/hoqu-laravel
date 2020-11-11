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
        public $countJ = 0;
        public $countI = 1;

        public $instances;

        public function updatinginstance()
        {
            $this->resetPage();
        }

        public function mount($instance,$job)
        {
            $this->instance=$instance;
            $this->job=$job;
            // $this->tasks=[];
            $this->instances=[];
            $this->jobs=[];
        }

        public function updatedinstance()
        {
            $in = Task::find($this->instance);

            if(!empty($in))
            {
                $tasks= Task::whereIn('process_status', ['new','processing'])
                ->where('instance','like', $in->instance)
                ->orderByRaw('FIELD(process_status, "new", "processing")asc')
                ->orderBy('created_at', 'asc')
                ->paginate(50)
                ;
            }
            else
            {
                $tasks= Task::whereIn('process_status', ['new','processing'])
                ->orderByRaw('FIELD(process_status, "new", "processing")asc')
                ->orderBy('created_at', 'asc')
                ->paginate(50)
                ;
            }
            $this->countJ=0;
            $this->countI=1;
            return $tasks;

        }

        public function updatedjob()
        {

            $in_job = Task::find($this->job);

            if(!empty($in_job))
            {
                $tasks = Task::whereIn('process_status', ['new','processing'])
                ->where('job', 'like', $in_job->job)
                ->orderByRaw('FIELD(process_status, "new", "processing")asc')
                ->orderBy('created_at', 'asc')
                ->paginate(50);
            }
            else
            {
                $tasks = Task::whereIn('process_status', ['new','processing'])
                ->orderByRaw('FIELD(process_status, "new", "processing")asc')
                ->orderBy('created_at', 'asc')
                ->paginate(50);
            }
            $this->countJ=1;
            $this->countI=0;
            return $tasks;
        }


        public function render()
        {
            $this->instances = Task::whereIn('process_status', ['new','processing'])->orderBy('created_at', 'asc')->distinct('instance')->get();

            $this->jobs = Task::whereIn('process_status', ['new','processing'])->orderBy('created_at', 'asc')->distinct('job')->get();

            if($this->countJ == 1 && $this->countI == 0)
            {
                $this->countJ = 0;
                $tasks=$this->updatedjob();
            }
            if($this->countI == 1 && $this->countJ == 0)
            {
                $this->countI = 0;
                $tasks=$this->updatedinstance();
            }

            return view('livewire.table-todo',['tasks' => $tasks]);
        }
    }
