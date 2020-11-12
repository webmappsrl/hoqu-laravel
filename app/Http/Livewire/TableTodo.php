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

        public $parameters,$in,$jo;


        public $instances;

        public $isOpen = 0;

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
            if(!empty($this->instance))
            {
                $tasks= Task::whereIn('process_status', ['new','processing'])
                ->where('instance','like', $this->instance)
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

            if(!empty($this->job))
            {
                $tasks = Task::whereIn('process_status', ['new','processing'])
                ->where('job', 'like', $this->job)
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
            $this->instances = Task::select('instance')->whereIn('process_status', ['new','processing'])->orderBy('instance', 'asc')->groupBy('instance')->get();

            $this->jobs = Task::select('job')->whereIn('process_status', ['new','processing'])->orderBy('job', 'asc')->groupBy('job')->get();

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
