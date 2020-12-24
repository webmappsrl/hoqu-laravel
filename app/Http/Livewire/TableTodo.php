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
        public $countZ = 0;
        public $created_at;
        public $instance1, $job1,$parameters, $process_status, $process_log, $Task_id;



        public $instances;

        public $isOpen = 0;
        public $isModalDelete = 0;
        public $isModalSkip = 0;
        public $isModalRes = 0;

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

        private function resetInputFields(){
            $this->instance = '';
            $this->job = '';
            $this->parameters = '';
        }

        public function store()
    {
        $this->validate([
            'instance' => 'required',
            'job' => 'required',
            'parameters' => 'required|json'
        ]);



        $s = Task::updateOrCreate([
            'instance' => $this->instance,
            'job' => $this->job,
            'parameters' => $this->parameters
        ]);


        session()->flash('message',
                'Task entered successfully: id: ' .$s['id']. ' instance: '.$s['instance'].' job: '.$s['job'].' parameters: '.$s['parameters']);

        $this->closeModal();
        $this->resetInputFields();
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


        public function render()
        {
            if (!empty($this->job))
            {
                $this->instances = Task::select('instance')->where('job',$this->job)->whereIn('process_status', ['new','processing'])->groupBy('instance')->orderBy('instance', 'asc')->get();
            }
            else $this->instances = Task::select('instance')->whereIn('process_status', ['new','processing'])->groupBy('instance')->orderBy('instance', 'asc')->get();

            if (!empty($this->instance))
            {
                $this->jobs = Task::select('job')->where('instance',$this->instance)->whereIn('process_status', ['new','processing'])->groupBy('job')->orderBy('job', 'asc')->get();
            }
            else $this->jobs = Task::select('job')->whereIn('process_status', ['new','processing'])->groupBy('job')->orderBy('job', 'asc')->get();


            if(!empty($this->job) && !empty($this->instance) && !empty($this->created_at))
            {
                $tasks = Task::whereIn('process_status', ['new','processing'])
                    ->where('job', 'like', $this->job)
                    ->where('instance', 'like', $this->instance)
                    ->orderBy('created_at', $this->created_at)
                    ->paginate(50);
            }
            else if(!empty($this->created_at) && empty($this->job) && !empty($this->instance))
            {
                $tasks = Task::whereIn('process_status', ['new','processing'])
                    ->where('instance', 'like', $this->instance)
                    ->orderBy('created_at', $this->created_at)
                    ->paginate(50);
            }
            else if(!empty($this->created_at) && !empty($this->job) && empty($this->instance))
            {
                $tasks = Task::whereIn('process_status', ['new','processing'])
                    ->where('job', 'like', $this->job)
                    ->orderBy('created_at', $this->created_at)
                    ->paginate(50);
            }
            else if(!empty($this->created_at) && empty($this->job) && empty($this->instance))
            {
                $tasks = Task::whereIn('process_status', ['new','processing'])
                    ->orderBy('created_at', $this->created_at)
                    ->paginate(50);
            }
            else if(empty($this->created_at) && !empty($this->job) && !empty($this->instance))
            {
                $tasks = Task::whereIn('process_status', ['new','processing'])
                    ->where('job', 'like', $this->job)
                    ->where('instance', 'like', $this->instance)
                    ->orderBy('created_at', 'asc')
                    ->paginate(50);
            }
            else if(empty($this->created_at) && empty($this->job) && !empty($this->instance))
            {
                $tasks = Task::whereIn('process_status', ['new','processing'])
                    ->where('instance', 'like', $this->instance)
                    ->orderBy('created_at', 'asc')
                    ->paginate(50);
            }
            else if(empty($this->created_at) && !empty($this->job) && empty($this->instance))
            {
                $tasks = Task::whereIn('process_status', ['new','processing'])
                    ->where('job', 'like', $this->job)
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

            return view('livewire.table-todo',['tasks' => $tasks]);
        }
    }
