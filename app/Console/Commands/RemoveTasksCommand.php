<?php

namespace App\Console\Commands;

use App\Models\DuplicateTask;
use App\Models\Task;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RemoveTasksCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hoqu:remove_tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove all tasks in DB';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $query='DELETE from duplicate_tasks';
        $res = DB::select(DB::raw($query));
        $query='DELETE from tasks';
        $res = DB::select(DB::raw($query));
        return 0;
    }
}
