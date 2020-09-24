<?php

namespace App\Http\Controllers;
use App\Models\Task;


use Illuminate\Http\Request;

class TasksController extends Controller
{
    public function index()
    {
        $task = Task::orwhere('process_status', '=', 'new')->orwhere('process_status', '=', 'processing')->orderByRaw('FIELD(process_status, "new", "processing")asc')->orderBy('created_at', 'asc')->paginate(50);
        return view('dashboard',['tasks'=>$task]);
    }

    public function index_done()
    {
        $task = Task::where('process_status', '=', 'done')->orderBy('created_at', 'asc')->paginate(50);
        return view('archive',['tasks'=>$task]);
    }

    public function show(Task $task)
    {
        return view('task_details',['task'=>$task]);
    }
}
