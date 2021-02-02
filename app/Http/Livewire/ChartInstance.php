<?php

namespace App\Http\Livewire;
use App\Models\Task;
use Livewire\Component;
use Illuminate\Support\Facades\DB;



class ChartInstance extends Component
{
    public function render()
    {

        $firstTenElements = Task::select('instance',DB::raw('count(*) as total'))
            ->orderBy('total','desc')
            ->groupBy('instance')
            ->limit(10)
            ->get();

        $fti=[];

        foreach ($firstTenElements as $firstTenElement)
        {
            $fti[]= $firstTenElement->instance;
        }

        $queryNot = Task::whereNotIn('instance',$fti)->count();

        $instance = $firstTenElements->map(function ($item) {
            return $item->instance;
        })->toArray();
        $instanceCount = $firstTenElements->map(function ($item) {
            return $item->total;
        })->toArray();
        if ($queryNot>0)
        {

            $instance[count($instance)]='other';
            $instanceCount[count($instance)-1]=$queryNot;
            }

        $total = array_sum($instanceCount);

        foreach ($instanceCount as $index=>$i)
        {
            $instanceCountPercentage[] = (string) round(($i/$total) * 100,1) ."% ".$instance[$index];
        }
        return view('livewire.chart-instance')->with('hour',json_encode($instance,JSON_NUMERIC_CHECK))->with('job',json_encode($instanceCount,JSON_NUMERIC_CHECK))->with('percentage',json_encode($instanceCountPercentage,JSON_NUMERIC_CHECK));
    }
}
