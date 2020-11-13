<?php

namespace App\Http\Livewire;
    use Livewire\WithPagination;

    use App\Models\Task;
    use Livewire\Component;

    class TableDuplicate extends Component
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
            if(!empty($this->instance))
            {
                $tasks= Task::whereIn('process_status', ['duplicate'])
                ->where('instance','like', $this->instance)
                ->orderBy('created_at', 'asc')
                ->paginate(50)
                ;
            }
            else
            {
                $tasks= Task::whereIn('process_status', ['duplicate'])
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
                $tasks = Task::whereIn('process_status', ['duplicate'])
                ->where('job', 'like', $this->job)
                ->orderBy('created_at', 'asc')
                ->paginate(50);
            }
            else
            {
                $tasks = Task::whereIn('process_status', ['duplicate'])
                ->orderBy('created_at', 'asc')
                ->paginate(50);
            }
            $this->countJ=1;
            $this->countI=0;
            return $tasks;
        }


        public function render()
        {
            $this->instances = Task::select('instance')->whereIn('process_status', ['duplicate'])->orderBy('instance', 'asc')->groupBy('instance')->get();

            $this->jobs = Task::select('job')->whereIn('process_status', ['duplicate'])->orderBy('job', 'asc')->groupBy('job')->get();

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

            return view('livewire.table-duplicate',['tasks' => $tasks]);
        }
    }
