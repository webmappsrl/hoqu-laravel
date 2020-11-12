<?php

namespace App\Http\Livewire;
    use Livewire\WithPagination;

    use App\Models\Task;
    use Livewire\Component;

    class TableDone extends Component
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

        public function mount($instance,$job)
        {
            $this->instance=$instance;
            $this->job=$job;
            $this->instances=[];
            $this->jobs=[];
        }

        public function updatedInstance()
        {
            if(!empty($this->instance))
            {
                $tasks= Task::whereIn('process_status', ['done'])
                ->where('instance','like', $this->instance)
                ->orderByRaw('FIELD(process_status, "new", "processing")asc')
                ->orderBy('created_at', 'asc')
                ->paginate(50)
                ;
            }
            else
            {
                $tasks= Task::whereIn('process_status', ['done'])
                ->orderByRaw('FIELD(process_status, "new", "processing")asc')
                ->orderBy('created_at', 'asc')
                ->paginate(50)
                ;
            }
            $this->countJ=0;
            $this->countI=1;
            return $tasks;

        }

        public function updatedJob()
        {

            if(!empty($this->job))
            {
                $tasks = Task::whereIn('process_status', ['done'])
                ->where('job', 'like', $this->job)
                ->orderByRaw('FIELD(process_status, "new", "processing")asc')
                ->orderBy('created_at', 'asc')
                ->paginate(50);
            }
            else
            {
                $tasks = Task::whereIn('process_status', ['done'])
                ->orderByRaw('FIELD(process_status, "new", "processing")asc')
                ->orderBy('created_at', 'asc')
                ->paginate(50);
            }
            $this->countJ=1;
            $this->countI=0;
            return $tasks;
        }

        public function update()
        {


            Task::updateOrCreate(['id' => $this->Task_id], [
                'instance' => $this->instance,
                'job' => $this->job,
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
            $this->instances = Task::select('instance')->whereIn('process_status', ['done'])->groupBy('instance')->orderBy('instance', 'asc')->get();

            $this->jobs = Task::select('job')->whereIn('process_status', ['done'])->groupBy('job')->orderBy('job', 'asc')->get();

            if($this->countJ == 1 && $this->countI == 0)
            {
                $this->countJ = 0;
                $tasks=$this->updatedJob();
            }
            if($this->countI == 1 && $this->countJ == 0)
            {
                $this->countI = 0;
                $tasks=$this->updatedInstance();
            }

            return view('livewire.table-done',['tasks' => $tasks]);
        }
    }