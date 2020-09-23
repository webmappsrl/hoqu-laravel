<?php

namespace App\Http\Controllers;
use App\Models\Task;


use Illuminate\Http\Request;

class TasksController extends Controller
{
    public function index()
    {
        $task = Task::orderByRaw('FIELD(process_status, "new", "processing", "done","error")asc')->orderBy('created_at', 'asc')->latest()->paginate(50);
        // dd($task);
        return view('dashboard',['tasks'=>$task]);
    }

    public function show(Task $task)
    {
        return view('task_details',['task'=>$task]);
    }
}
