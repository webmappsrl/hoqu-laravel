<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Task;


class FormTodo extends Component
{
    public $tasks, $instance, $job,$parameters, $process_status, $process_log, $Task_id;
    public $isOpen = 0;

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
        dd($this->isOpen);

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
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function store()
    {
        $this->validate([
            'instance' => 'required',
                'job' => 'required'
        ]);

        Task::updateOrCreate(['id' => $this->Task_id], [
            'body' => $this->instance,
            'job' => $this->job,
            'parameters' => $this->parameters
        ]);

        session()->flash('message',
                'insert ' .$this->Task_id . ' in NEW');

        $this->closeModal();
        $this->resetInputFields();
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public function render()
    {

        return view('livewire.form-todo');
    }
}
