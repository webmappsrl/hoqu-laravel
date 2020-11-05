<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Task;
use Carbon\Carbon;
use DB;

class Chart24hour extends Component
{
    public function render()
    {
        $hour = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24];

        $job = [];
        foreach ($hour as $key => $value) {
            $job[] = Task::where('created_at', '>', Carbon::now()->subHours($value))->count()-Task::where('created_at', '>', Carbon::now()->subHours($value-1))->count();
            // var_dump(Carbon::now()->subHours($value).' - '.Carbon::now()->subHours($value-1).' <--> '.$job[$key].' = '.Task::where('created_at', '>', Carbon::now()->subDays($value))->count().' - '.Task::where('created_at', '>', Carbon::now()->subDays($value-1))->count().'</br></br>');
        }
        // dd(json_encode($hour,JSON_NUMERIC_CHECK));

        return view('livewire.chart24hour')->with('hour',json_encode($hour,JSON_NUMERIC_CHECK))->with('job',json_encode($job,JSON_NUMERIC_CHECK));

    }
}
