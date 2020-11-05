<?php

namespace App\Http\Livewire;
use App\Models\Task;
use Livewire\Component;
use Illuminate\Support\Facades\DB;



class ChartInstance extends Component
{
    public function render()
    {

        $query = Task::select('instance',DB::raw('count(*) as total'))
        ->groupBy('instance')
        ->orderByRaw('total')
        ->get();
        $instance = $query->map(function ($item) {
            return $item->instance;
        })->toArray();
        $instanceCount = $query->map(function ($item) {
            return $item->total;
        })->toArray();


        return view('livewire.chart-instance')->with('hour',json_encode($instance,JSON_NUMERIC_CHECK))->with('job',json_encode($instanceCount,JSON_NUMERIC_CHECK));
    }
}
