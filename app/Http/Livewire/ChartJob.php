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
//        $query = Task::select('job',DB::raw('count(*) as total'))
//        ->groupBy('job')
//        ->orderByRaw('total')
//        ->get();
//        $job = $query->map(function ($item) {
//            return $item->job;
//        })->toArray();
//        $jobCount = $query->map(function ($item) {
//            return $item->total;
//        })->toArray();

        $firstTenElements = Task::select('job',DB::raw('count(*) as total'))
            ->orderBy('total','desc')
            ->groupBy('job')
            ->limit(10)
            ->get();

        $fti=[];

        foreach ($firstTenElements as $firstTenElement)
        {
            $fti[]= $firstTenElement->instance;
        }

        $queryNot = Task::whereNotIn('job',$fti)->count();

        $job = $firstTenElements->map(function ($item) {
            return $item->job;
        })->toArray();
        $jobCount = $firstTenElements->map(function ($item) {
            return $item->total;
        })->toArray();
        if ($queryNot>0)
        {
            $instance[count($job)]='other';
            $instanceCount[count($jobCount)-1]=$queryNot;
        }

        $total = array_sum($jobCount);
        $jobCountPercentage = [];
        foreach ($jobCount as $index=>$i)
        {
            $jobCountPercentage[] = (string) round(($i/$total) * 100,1) ."% ".$job[$index];
        }

        return view('livewire.chart-job')->with('hour',json_encode($job,JSON_NUMERIC_CHECK))->with('job',json_encode($jobCount,JSON_NUMERIC_CHECK))->with('percentage',json_encode($jobCountPercentage,JSON_NUMERIC_CHECK));
    }
}
