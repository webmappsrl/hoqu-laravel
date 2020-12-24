<?php

namespace App\Http\Livewire;
use App\Mail\sendTrello;
use App\Models\Task;



use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class StatusShow extends Component
{
    public $instance;
    public $job;
    public $jobs;
    public $isOpen = 0;
    public $isTrello = 0;
    public $isTrelloBug = 0;
    public $isReschedule = 0;
    public $created_at;


    public $instance1, $job1,$parameters, $process_status, $process_log, $Task_id, $trelloMember;

    public $instances;

    public $task;

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModalSkip()
    {
        $this->isOpen = false;
    }

    public function openModalTrello()
    {
        $this->isTrello = true;
    }

    public function closeModalTrello()
    {
        $this->isTrello = false;
    }
    public function openModalTrelloBug()
    {
        $this->isTrelloBug = true;
    }

    public function closeModalTrelloBug()
    {
        $this->isTrelloBug = false;
    }
    public function openModalRes()
    {
        $this->isReschedule = true;
    }

    public function closeModalRes()
    {
        $this->isReschedule = false;
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function createTrelloModal()
    {
        $this->resetInputFields();
        $this->openModalTrello();
    }

    public function createResModal()
    {
        $this->resetInputFields();
        $this->openModalRes();
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
        $this->trelloMember= '';
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

        $this->closeModalRes();
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

        $this->closeModalSkip();
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


    public function setCardTrello(Task $task)
    {
        $this->Task_id = $task->id;
        $this->instance = $task->instance;
        $this->job = $task->job;

        $this->openModalTrello();

    }

    public function setCardTrelloBug(Task $task)
    {
        $this->Task_id = $task->id;
        $this->instance = $task->instance;
        $this->job = $task->job;

        $this->openModalTrelloBug();

    }

    public function editRes(Task $task)
    {
        $this->Task_id = $task->id;
        $this->instance = $task->instance;
        $this->job = $task->job;

        $this->openModalRes();

    }

    public function sendCard(){

        $this->validate([
            'trelloMember' => 'required'
        ]);

        $taskError = Task::find($this->Task_id);
        $dataCard = ['member' => $this->trelloMember, 'error'=>$taskError];

        Mail::to('gianmarcogagliardi1+abk5rfgsorj10kmql4px@boards.trello.com')->send(new sendTrello($dataCard));

        $this->closeModalTrello();
        $this->resetInputFields();

        session()->flash('message',
            'you have created a trello card related to the task ' .$this->Task_id . ' assigned to '.$this->trelloMember );

    }

    public function sendCardBackLog(){

        $this->validate([
            'trelloMember' => 'required'
        ]);

        $taskError = Task::find($this->Task_id);
        $dataCard = ['member' => $this->trelloMember, 'error'=>$taskError];

        Mail::to('gianmarcogagliardi1+vdtsjbwisbsmv52v0h8x@boards.trello.com')->send(new sendTrello($dataCard));

        $this->closeModalTrelloBug();
        $this->resetInputFields();

        session()->flash('message',
            'you have created a trello card related to the task ' .$this->Task_id . ' assigned to '.$this->trelloMember );

    }

    public function render()
    {
        return view('livewire.status-show',['task' =>$this->task]);

    }
}
