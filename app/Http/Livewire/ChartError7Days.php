<?php

namespace App\Http\Livewire;

use App\Models\Task;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Carbon\Carbon;


class ChartError7Days extends Component
{
    public function render()
    {
        $date = Carbon::today()->subDays(6);

        $query = Task::select('process_status','created_at')
            ->where('process_status','error')
            ->where('created_at','>=',$date)
            ->orderBy('created_at')
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('d');
            });

        $days = [];
        $errorDays = [];



        foreach ($query as $index => $quer)
        {
            $days[]= $index;
            $errorDays[]= count($quer);

        }

;

        return view('livewire.chart-error7-days')->with('hour',json_encode($days,JSON_NUMERIC_CHECK))->with('job',json_encode($errorDays,JSON_NUMERIC_CHECK));
    }
}
