<?php

namespace App\Http\Livewire;

namespace App\Http\Livewire;
use App\Models\Task;
use Livewire\Component;
use Illuminate\Support\Facades\DB;


class ChartJob extends Component
{
    public function render()
    {
        $query = Task::select('job',DB::raw('count(*) as total'))
        ->groupBy('job')
        ->get();
        $job = $query->map(function ($item) {
            return $item->job;
        })->toArray();
        $jobCount = $query->map(function ($item) {
            return $item->total;
        })->toArray();


        return view('livewire.chart-job')->with('hour',json_encode($job,JSON_NUMERIC_CHECK))->with('job',json_encode($jobCount,JSON_NUMERIC_CHECK));
    }
}
