<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Task;

class Tasks extends Component
{
    public $tasks, $instance, $job,$parameters, $process_status, $process_log, $Task_id;
    public $isOpen = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function render()
    {
        $this->tasks = Task::where('process_status', '=', 'error')->orderBy('created_at', 'asc')->get();

        return view('livewire.tasks',['posts' => Task::where('process_status', '=', 'error')->paginate(50)]);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }





    public function index_done()
    {
        $task = Task::where('process_status', '=', 'done')->orderBy('created_at', 'desc')->paginate(50);
        return view('archive',['tasks'=>$task]);
    }

    public function index_error()
    {
        $task = Task::where('process_status', '=', 'error')->orderBy('created_at', 'asc')->paginate(50);
        return view('error',['tasks'=>$task]);
    }

    public function show(Task $task)
    {
        return view('task_details',['task'=>$task]);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function openModal()
    {
        $this->isOpen = true;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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
        $this->instance = '';
        $this->job = '';
        $this->parameters = '';
        $this->process_status = '';
        $this->process_log = '';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function delete($id)
    {
        Task::find($id)->delete();
        session()->flash('message', 'Task Deleted Successfully.');
    }
}
