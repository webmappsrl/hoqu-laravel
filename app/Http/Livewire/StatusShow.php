<?php

namespace App\Http\Livewire;
use App\Models\Task;


use Livewire\Component;

class StatusShow extends Component
{
    public $instance;
    public $job;
    public $jobs;
    public $isOpen = 0;
    public $created_at;


    public $instance1, $job1,$parameters, $process_status, $process_log, $Task_id;

    public $instances;

    public $task;

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

    public function mount($id)
    {
        $this->task = Task::find($id);
    }

    private function resetInputFields(){
        $this->instance1 = '';
        $this->job1 = '';
        $this->parameters = '';
        $this->process_status = '';
        $this->process_log = '';
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
        return view('livewire.status-show',['task' =>$this->task]);

    }
}
