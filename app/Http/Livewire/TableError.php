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
        public $countZ = 0;
        public $isOpen = 0;
        public $created_at;


        public $instance1, $job1,$parameters, $process_status, $process_log, $Task_id;

        public $instances;

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

        public function mount($instance,$job, $created_at)
        {
            $this->instance=$instance;
            $this->created_at=$created_at;
            $this->job=$job;
            $this->instances=[];
            $this->jobs=[];
        }

        public function update()
        {


            Task::updateOrCreate(['id' => $this->Task_id], [
                'process_status' => 'new'

            ]);

            session()->flash('message',
                'changed the process status of ' .$this->Task_id . ' in NEW');

            $this->closeModal();
            $this->resetInputFields();

        }

        public function updateSkip()
        {

            Task::updateOrCreate(['id' => $this->Task_id], [
                'instance' => $this->instance,
                'job' => $this->job,
                'process_status' => 'skip'

            ]);

            session()->flash('message',
                'changed the process status of ' .$this->Task_id . ' in SKIP');

            $this->closeModal();
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
                $this->instances = Task::select('instance')->where('job',$this->job)->whereIn('process_status', ['error'])->groupBy('instance')->orderBy('instance', 'asc')->get();
            }
            else $this->instances = Task::select('instance')->whereIn('process_status', ['error'])->groupBy('instance')->orderBy('instance', 'asc')->get();

            if (!empty($this->instance))
            {
                $this->jobs = Task::select('job')->where('instance',$this->instance)->whereIn('process_status', ['error'])->groupBy('job')->orderBy('job', 'asc')->get();
            }
            else $this->jobs = Task::select('job')->whereIn('process_status', ['error'])->groupBy('job')->orderBy('job', 'asc')->get();


            if(!empty($this->job) && !empty($this->instance) && !empty($this->created_at))
            {
                $tasks = Task::whereIn('process_status', ['error'])
                    ->where('job', 'like', $this->job)
                    ->where('instance', 'like', $this->instance)
                    ->orderBy('created_at', $this->created_at)
                    ->paginate(50);
            }
            else if(!empty($this->created_at) && empty($this->job) && !empty($this->instance))
            {
                $tasks = Task::whereIn('process_status', ['error'])
                    ->where('instance', 'like', $this->instance)
                    ->orderBy('created_at', $this->created_at)
                    ->paginate(50);
            }
            else if(!empty($this->created_at) && !empty($this->job) && empty($this->instance))
            {
                $tasks = Task::whereIn('process_status', ['error'])
                    ->where('job', 'like', $this->job)
                    ->orderBy('created_at', $this->created_at)
                    ->paginate(50);
            }
            else if(!empty($this->created_at) && empty($this->job) && empty($this->instance))
            {
                $tasks = Task::whereIn('process_status', ['error'])
                    ->orderBy('created_at', $this->created_at)
                    ->paginate(50);
            }
            else if(empty($this->created_at) && !empty($this->job) && !empty($this->instance))
            {
                $tasks = Task::whereIn('process_status', ['error'])
                    ->where('job', 'like', $this->job)
                    ->where('instance', 'like', $this->instance)
                    ->orderBy('created_at', 'asc')
                    ->paginate(50);
            }
            else if(empty($this->created_at) && empty($this->job) && !empty($this->instance))
            {
                $tasks = Task::whereIn('process_status', ['error'])
                    ->where('instance', 'like', $this->instance)
                    ->orderBy('created_at', 'asc')
                    ->paginate(50);
            }
            else if(empty($this->created_at) && !empty($this->job) && empty($this->instance))
            {
                $tasks = Task::whereIn('process_status', ['error'])
                    ->where('job', 'like', $this->job)
                    ->orderBy('created_at', 'asc')
                    ->paginate(50);
            }
            else
            {
                $tasks = Task::whereIn('process_status', ['error'])
                    ->orderBy('created_at', 'asc')
                    ->paginate(50);
            }

            return view('livewire.table-error',['tasks' => $tasks]);
        }
    }
