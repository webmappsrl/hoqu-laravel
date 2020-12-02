<?php

namespace App\Http\Livewire;

use App\Models\Task;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
class TableDashboard extends Component
{

    public function render()
    {

        $sql =
        <<<'SQL'
            SELECT *
            FROM (SELECT duplicate_tasks.id as id,tasks.`instance`,tasks.job,tasks.parameters,tasks.process_status,duplicate_tasks.created_at,duplicate_tasks.updated_at,duplicate_tasks.task_id
            FROM tasks
            inner JOIN duplicate_tasks
            ON tasks.id = duplicate_tasks.task_id
            UNION ALL
            SELECT tasks.id as id, `instance`,job,parameters,process_status,created_at,updated_at, null as task_id
            FROM tasks) as nedo
            ORDER by created_at DESC
            LIMIT 10
        SQL;

        $c = DB::select($sql);


        return view('livewire.table-dashboard', ['tasks' => $c]);
    }
}
