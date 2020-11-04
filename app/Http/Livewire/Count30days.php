<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Task;
use Carbon\Carbon;


class Count30days extends Component
{
    public $count_30days;
    public function render()
    {
        $this->count_30days = Task::whereDate('created_at', '>', Carbon::now()->subDays(30))->count();
        return view('livewire.count30days');
    }
}
