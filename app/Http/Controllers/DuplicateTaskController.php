<?php

namespace App\Http\Controllers;
use App\Models\DuplicateTask;
use Illuminate\Support\Facades\DB;
use App\Models\Task;



class DuplicateTaskController extends Controller
{
    public function showDuplicate(DuplicateTask $duplicateTask)
    {
        $data = Task::find($duplicateTask->task_id);

        return view('duplicate_task_details',['duplicateTask'=>$duplicateTask, 'task'=>$data]);
    }
}
