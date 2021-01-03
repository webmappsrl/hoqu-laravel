<?php

namespace App\Http\Livewire;
    use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
    use App\Models\Task;
    use Livewire\Component;

    class TableDuplicate extends Component
    {
        use WithPagination;

        public $instance;
        public $job,$created_at, $num_page;
        public $jobs;
        public $countJ = 0;
        public $countI = 1;

        public $instances;

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


        public function render()
        {
//            dd($this->num_page);
            if (!empty($this->job))
            {
//                dd($this->job);

                $this->instances = DB::table('tasks')
                    ->join('duplicate_tasks', 'tasks.id', '=', 'duplicate_tasks.task_id')
                    ->select('tasks.instance')
                    ->orderBy('tasks.instance', 'asc')
                    ->groupBy('tasks.instance')
                    ->where('tasks.job',$this->job)
                    ->get();
//                dd($this->instances);
            }
            else  $this->instances = DB::table('tasks')->join('duplicate_tasks', 'tasks.id', '=', 'duplicate_tasks.task_id')
                ->select('tasks.instance')
                ->orderBy('tasks.instance', 'asc')
                ->groupBy('tasks.instance')
                ->get();

            if (!empty($this->instance))
            {
                $this->jobs = DB::table('tasks')->join('duplicate_tasks', 'tasks.id', '=', 'duplicate_tasks.task_id')
                    ->select('tasks.job')
                    ->where('tasks.instance',$this->instance)
                    ->orderBy('tasks.job', 'asc')
                    ->groupBy('tasks.job')
                    ->get();
            }
            else $this->jobs = DB::table('tasks')->join('duplicate_tasks', 'tasks.id', '=', 'duplicate_tasks.task_id')
                ->select('tasks.job')
                ->orderBy('tasks.job', 'asc')
                ->groupBy('tasks.job')
                ->get();


            if(!empty($this->job) && !empty($this->instance) && !empty($this->created_at) && !empty($this->num_page))
            {
                $tasks= DB::table('tasks')->join('duplicate_tasks', 'tasks.id', '=', 'duplicate_tasks.task_id')
                    ->select('duplicate_tasks.id','tasks.instance','tasks.job','tasks.parameters','duplicate_tasks.created_at','duplicate_tasks.task_id','tasks.process_status')
                    ->where('tasks.instance','like', $this->instance)
                    ->where('tasks.job','like', $this->job)
                    ->orderBy('duplicate_tasks.created_at', $this->created_at)
                    ->paginate($this->num_page);
            }
            else if(!empty($this->job) && !empty($this->instance) && !empty($this->created_at) && empty($this->num_page))
            {
                $tasks= DB::table('tasks')->join('duplicate_tasks', 'tasks.id', '=', 'duplicate_tasks.task_id')
                    ->select('duplicate_tasks.id','tasks.instance','tasks.job','tasks.parameters','duplicate_tasks.created_at','duplicate_tasks.task_id','tasks.process_status')
                    ->where('tasks.instance','like', $this->instance)
                    ->where('tasks.job','like', $this->job)
                    ->orderBy('duplicate_tasks.created_at', $this->created_at)
                    ->paginate(50);

            }
            else if(!empty($this->job) && !empty($this->instance) && empty($this->created_at) && empty($this->num_page))
            {
                $tasks= DB::table('tasks')->join('duplicate_tasks', 'tasks.id', '=', 'duplicate_tasks.task_id')
                    ->select('duplicate_tasks.id','tasks.instance','tasks.job','tasks.parameters','duplicate_tasks.created_at','duplicate_tasks.task_id','tasks.process_status')
                    ->where('tasks.instance','like', $this->instance)
                    ->where('tasks.job','like', $this->job)
                    ->orderBy('duplicate_tasks.created_at', 'asc')
                    ->paginate(50);

            }
            else if(!empty($this->job) && empty($this->instance) && empty($this->created_at) && empty($this->num_page))
            {
                $tasks= DB::table('tasks')->join('duplicate_tasks', 'tasks.id', '=', 'duplicate_tasks.task_id')
                    ->select('duplicate_tasks.id','tasks.instance','tasks.job','tasks.parameters','duplicate_tasks.created_at','duplicate_tasks.task_id','tasks.process_status')
                    ->where('tasks.job','like', $this->job)
                    ->orderBy('duplicate_tasks.created_at', 'asc')
                    ->paginate(50);
            }
            else if(empty($this->job) && !empty($this->instance) && empty($this->created_at) && empty($this->num_page))
            {
                $tasks= DB::table('tasks')->join('duplicate_tasks', 'tasks.id', '=', 'duplicate_tasks.task_id')
                    ->select('duplicate_tasks.id','tasks.instance','tasks.job','tasks.parameters','duplicate_tasks.created_at','duplicate_tasks.task_id','tasks.process_status')
                    ->where('tasks.instance','like', $this->instance)
                    ->orderBy('duplicate_tasks.created_at', 'asc')
                    ->paginate(50);
            }
            else if(empty($this->job) && empty($this->instance) && !empty($this->created_at) && empty($this->num_page))
            {
                $tasks= DB::table('tasks')->join('duplicate_tasks', 'tasks.id', '=', 'duplicate_tasks.task_id')
                    ->select('duplicate_tasks.id','tasks.instance','tasks.job','tasks.parameters','duplicate_tasks.created_at','duplicate_tasks.task_id','tasks.process_status')
                    ->orderBy('duplicate_tasks.created_at', $this->created_at)
                    ->paginate(50);
            }
            else if(empty($this->job) && empty($this->instance) && empty($this->created_at) && !empty($this->num_page))
            {
                $tasks= DB::table('tasks')->join('duplicate_tasks', 'tasks.id', '=', 'duplicate_tasks.task_id')
                    ->select('duplicate_tasks.id','tasks.instance','tasks.job','tasks.parameters','duplicate_tasks.created_at','duplicate_tasks.task_id','tasks.process_status')
                    ->orderBy('duplicate_tasks.created_at', 'asc')
                    ->paginate($this->num_page);
            }
            else if(empty($this->job) && !empty($this->instance) && empty($this->created_at) && !empty($this->num_page))
            {
                $tasks= DB::table('tasks')->join('duplicate_tasks', 'tasks.id', '=', 'duplicate_tasks.task_id')
                    ->select('duplicate_tasks.id','tasks.instance','tasks.job','tasks.parameters','duplicate_tasks.created_at','duplicate_tasks.task_id','tasks.process_status')
                    ->where('tasks.instance','like', $this->instance)
                    ->orderBy('duplicate_tasks.created_at', 'asc')
                    ->paginate($this->num_page);
            }
            else if(empty($this->job) && !empty($this->instance) && !empty($this->created_at) && !empty($this->num_page))
            {
                $tasks= DB::table('tasks')->join('duplicate_tasks', 'tasks.id', '=', 'duplicate_tasks.task_id')
                    ->select('duplicate_tasks.id','tasks.instance','tasks.job','tasks.parameters','duplicate_tasks.created_at','duplicate_tasks.task_id','tasks.process_status')
                    ->where('tasks.instance','like', $this->instance)
                    ->orderBy('duplicate_tasks.created_at', $this->created_at)
                    ->paginate($this->num_page);
            }
            else if(empty($this->job) && empty($this->instance) && !empty($this->created_at) && !empty($this->num_page))
            {
                $tasks= DB::table('tasks')->join('duplicate_tasks', 'tasks.id', '=', 'duplicate_tasks.task_id')
                    ->select('duplicate_tasks.id','tasks.instance','tasks.job','tasks.parameters','duplicate_tasks.created_at','duplicate_tasks.task_id','tasks.process_status')
                    ->orderBy('duplicate_tasks.created_at', $this->created_at)
                    ->paginate($this->num_page);
            }
            else if(!empty($this->job) && empty($this->instance) && empty($this->created_at) && !empty($this->num_page))
            {
                $tasks= DB::table('tasks')->join('duplicate_tasks', 'tasks.id', '=', 'duplicate_tasks.task_id')
                    ->select('duplicate_tasks.id','tasks.instance','tasks.job','tasks.parameters','duplicate_tasks.created_at','duplicate_tasks.task_id','tasks.process_status')
                    ->where('tasks.job','like', $this->job)
                    ->orderBy('duplicate_tasks.created_at', 'asc')
                    ->paginate($this->num_page);
            }
            else if(!empty($this->job) && empty($this->instance) && !empty($this->created_at) && !empty($this->num_page))
            {
                $tasks= DB::table('tasks')->join('duplicate_tasks', 'tasks.id', '=', 'duplicate_tasks.task_id')
                    ->select('duplicate_tasks.id','tasks.instance','tasks.job','tasks.parameters','duplicate_tasks.created_at','duplicate_tasks.task_id','tasks.process_status')
                    ->where('tasks.job','like', $this->job)
                    ->orderBy('duplicate_tasks.created_at', $this->created_at)
                    ->paginate($this->num_page);
            }
            else
            {
                $tasks= DB::table('tasks')->join('duplicate_tasks', 'tasks.id', '=', 'duplicate_tasks.task_id')
                    ->select('duplicate_tasks.id','tasks.instance','tasks.job','tasks.parameters','duplicate_tasks.created_at','duplicate_tasks.task_id','tasks.process_status')
                    ->orderBy('duplicate_tasks.created_at', 'asc')
                    ->paginate(50);
            }

            return view('livewire.table-duplicate',['tasks' => $tasks]);
        }
    }
