<?php

namespace App\Http\Livewire;
    use Livewire\WithPagination;

    use App\Models\Task;
    use Livewire\Component;

    class TableError extends Component
    {
        use WithPagination;

        public $instance;
        public $job;
        public $jobs;
        public $countJ = 0;
        public $countI = 1;
        public $isOpen = 0;

        public $instance1, $job1,$parameters, $process_status, $process_log, $Task_id;

        public $instances;

        public function create()
        {
            $this->resetInputFields();
            $this->openModal();
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

        public function mount($instance,$job)
        {
            $this->instance=$instance;
            $this->job=$job;
            $this->instances=[];
            $this->jobs=[];
        }

        public function updatedinstance()
        {
            $in = Task::find($this->instance);

            if(!empty($in))
            {
                $tasks= Task::whereIn('process_status', ['error'])
                ->where('instance','like', $in->instance)
                ->orderBy('created_at', 'asc')
                ->paginate(50)
                ;
            }
            else
            {
                $tasks= Task::whereIn('process_status', ['error'])
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
                $tasks = Task::whereIn('process_status', ['error'])
                ->where('job', 'like', $in_job->job)
                ->orderBy('created_at', 'asc')
                ->paginate(50);
            }
            else
            {
                $tasks = Task::whereIn('process_status', ['error'])
                ->orderBy('created_at', 'asc')
                ->paginate(50);
            }
            $this->countJ=1;
            $this->countI=0;
            return $tasks;
        }


        public function render()
        {
            $this->instances = Task::whereIn('process_status', ['error'])->orderBy('created_at', 'asc')->get();

            $this->jobs = Task::whereIn('process_status', ['error'])->orderBy('created_at', 'asc')->get();

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

            return view('livewire.table-error',['tasks' => $tasks]);
        }
    }
