<?php

namespace App\Http\Livewire;
    use Livewire\WithPagination;

    use App\Models\Task;
    use Livewire\Component;
    use function PHPUnit\Framework\isEmpty;

    class TableDone extends Component
    {
        use WithPagination;

        public $instance;
        public $job,$created_at, $num_page;
        public $jobs;
        public $countJ = 0;
        public $countI = 1;
        public $countZ = 0;
        public $isOpen = 0;

        public $isOpenResAll = 0;
        public $isOpenSkipAll = 0;

        public $selectedErrors = [];


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

        public function openModalAllRes()
        {
            $this->isOpenResAll = true;
        }


        public function closeModalAllRes()
        {
            $this->isOpenResAll = false;
        }

        public function openModalAllSkip()
        {
            $this->isOpenSkipAll = true;
        }


        public function closeModalAllSkip()
        {
            $this->isOpenSkipAll = false;
        }

        public function editAllRes()
        {
            $this->openModalAllRes();

        }
        public function editAllSkip()
        {
            $this->openModalAllSkip();
        }



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
        private function resetInputFields(){
        $this->instance1 = '';
        $this->job1 = '';
        $this->created_at = '';
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

        public function bulkUpdateRes()
        {
            Task::whereIn('id', $this->selectedErrors)->update(['process_status' => 'new']);
            $this->closeModalAllRes();

            $mex='';

            foreach ($this->selectedErrors as $selectedError)
            {
                if ($selectedError!=false)
                {
                    $mex = $mex . 'changed the process status of ' . $selectedError . ' in NEW <br>';
                }
            }
            session()->flash('message',
                $mex );

            $this->selectedErrors = [];
        }

        public function bulkUpdateSkip()
        {
            Task::whereIn('id', $this->selectedErrors)->update(['process_status' => 'skip']);
            $this->closeModalAllSkip();

            $mex='';

            foreach ($this->selectedErrors as $selectedError)
            {
                if ($selectedError!=false)
                {
                    $mex =$mex. 'changed the process status of ' .$selectedError . ' in SKIP <br>';
                }
            }
            session()->flash('message',
                $mex );

            $this->selectedErrors = [];
        }

        public function render()
        {
            if (!empty($this->job))
            {
                $this->instances = Task::select('instance')->where('job',$this->job)->whereIn('process_status', ['done','skip'])->groupBy('instance')->orderBy('instance', 'asc')->get();
            }
            else $this->instances = Task::select('instance')->whereIn('process_status', ['done','skip'])->groupBy('instance')->orderBy('instance', 'asc')->get();

            if (!empty($this->instance))
            {
                $this->jobs = Task::select('job')->where('instance',$this->instance)->whereIn('process_status', ['done','skip'])->groupBy('job')->orderBy('job', 'asc')->get();
            }
            else $this->jobs = Task::select('job')->whereIn('process_status', ['done','skip'])->groupBy('job')->orderBy('job', 'asc')->get();


            if(!empty($this->job) && !empty($this->instance) && !empty($this->created_at) && !empty($this->num_page))
            {
                $tasks = Task::whereIn('process_status', ['done','skip'])
                    ->where('job', 'like', $this->job)
                    ->where('instance', 'like', $this->instance)
                    ->orderBy('created_at', $this->created_at)
                    ->paginate($this->num_page);
            }
            else if(!empty($this->created_at) && empty($this->job) && !empty($this->instance) && !empty($this->num_page))
            {
                $tasks = Task::whereIn('process_status', ['done','skip'])
                    ->where('instance', 'like', $this->instance)
                    ->orderBy('created_at', $this->created_at)
                    ->paginate($this->num_page);
            }
            else if(!empty($this->created_at) && !empty($this->job) && empty($this->instance) && !empty($this->num_page))
            {
                $tasks = Task::whereIn('process_status', ['done','skip'])
                    ->where('job', 'like', $this->job)
                    ->orderBy('created_at', $this->created_at)
                    ->paginate($this->num_page);
            }
            else if(!empty($this->created_at) && !empty($this->job) && empty($this->instance) && empty($this->num_page))
            {
                $tasks = Task::whereIn('process_status', ['done','skip'])
                    ->where('job', 'like', $this->job)
                    ->orderBy('created_at', $this->created_at)
                    ->paginate(50);
            }
            else if(!empty($this->created_at) && !empty($this->job) && !empty($this->instance) && empty($this->num_page))
            {
                $tasks = Task::whereIn('process_status', ['done','skip'])
                    ->where('instance', 'like', $this->instance)
                    ->where('job', 'like', $this->job)
                    ->orderBy('created_at', $this->created_at)
                    ->paginate(50);
            }
            else if(empty($this->created_at) && !empty($this->job) && !empty($this->instance) && !empty($this->num_page))
            {
                $tasks = Task::whereIn('process_status', ['done','skip'])
                    ->where('job', 'like', $this->job)
                    ->where('instance', 'like', $this->instance)
                    ->orderBy('created_at', 'asc')
                    ->paginate($this->num_page);
            }
            else if(empty($this->created_at) && !empty($this->job) && !empty($this->instance) && empty($this->num_page))
            {
                $tasks = Task::whereIn('process_status', ['done','skip'])
                    ->where('job', 'like', $this->job)
                    ->where('instance', 'like', $this->instance)
                    ->orderBy('created_at', 'asc')
                    ->paginate(50);
            }
            else if(!empty($this->created_at) && empty($this->job) && !empty($this->instance) && !empty($this->num_page))
            {
                $tasks = Task::whereIn('process_status', ['done','skip'])
                    ->where('instance', 'like', $this->instance)
                    ->orderBy('created_at', $this->created_at)
                    ->paginate($this->num_page);
            }
            else if(empty($this->created_at) && empty($this->job) && !empty($this->instance) && !empty($this->num_page))
            {
                $tasks = Task::whereIn('process_status', ['done','skip'])
                    ->where('instance', 'like', $this->instance)
                    ->orderBy('created_at', 'asc')
                    ->paginate($this->num_page);
            }
            else if(empty($this->created_at) && empty($this->job) && !empty($this->instance) && empty($this->num_page))
            {
                $tasks = Task::whereIn('process_status', ['done','skip'])
                    ->where('instance', 'like', $this->instance)
                    ->orderBy('created_at', 'asc')
                    ->paginate(50);
            }
            else if(!empty($this->created_at) && !empty($this->job) && empty($this->instance) && !empty($this->num_page))
            {
                $tasks = Task::whereIn('process_status', ['done','skip'])
                    ->where('job', 'like', $this->job)
                    ->orderBy('created_at', $this->created_at)
                    ->paginate($this->num_page);
            }
            else if(empty($this->created_at) && !empty($this->job) && empty($this->instance) && !empty($this->num_page))
            {
                $tasks = Task::whereIn('process_status', ['done','skip'])
                    ->where('job', 'like', $this->job)
                    ->orderBy('created_at', 'asc')
                    ->paginate($this->num_page);
            }
            else if(empty($this->created_at) && !empty($this->job) && empty($this->instance) && empty($this->num_page))
            {
                $tasks = Task::whereIn('process_status', ['done','skip'])
                    ->where('job', 'like', $this->job)
                    ->orderBy('created_at', 'asc')
                    ->paginate(50);
            }
            else if(!empty($this->created_at) && empty($this->job) && empty($this->instance) && !empty($this->num_page))
            {
                $tasks = Task::whereIn('process_status', ['done','skip'])
                    ->orderBy('created_at', $this->created_at)
                    ->paginate($this->num_page);
            }
            else if(empty($this->created_at) && empty($this->job) && empty($this->instance) && !empty($this->num_page))
            {
                $tasks = Task::whereIn('process_status', ['done','skip'])
                    ->orderBy('created_at', 'asc')
                    ->paginate($this->num_page);
            }
            else if(!empty($this->created_at) && empty($this->job) && empty($this->instance) && empty($this->num_page))
            {
                $tasks = Task::whereIn('process_status', ['done','skip'])
                    ->orderBy('created_at', $this->created_at)
                    ->paginate(50);
            }
            else
            {
                $tasks = Task::whereIn('process_status', ['done','skip'])
                    ->orderByRaw('FIELD(process_status, "done", "skip")asc')
                    ->orderBy('created_at', 'asc')
                    ->paginate(50);
            }



            return view('livewire.table-done',['tasks' => $tasks]);
        }
    }
