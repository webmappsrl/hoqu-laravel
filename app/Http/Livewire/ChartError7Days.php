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
        $date = Carbon::today()->subDays(7);

        $query = Task::selectRaw('DAY(created_at) as day,COUNT(*) as error')
            ->where('process_status','error')
            ->where('created_at','>=',$date)
            ->groupBy('day')
            ->get();
        $days = [];
        $errorDays = [];


        foreach ($query as  $quer)
        {
            $days[]= $quer->day;
            $errorDays[]= $quer->error;

        }



        return view('livewire.chart-error7-days')->with('hour',json_encode($days,JSON_NUMERIC_CHECK))->with('job',json_encode($errorDays,JSON_NUMERIC_CHECK));
    }
}
