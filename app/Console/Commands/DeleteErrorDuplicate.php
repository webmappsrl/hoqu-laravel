<?php

namespace App\Console\Commands;
use App\Models\Task;
use App\Models\DuplicateTask;
use Illuminate\Console\Command;

class DeleteErrorDuplicate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:deleteErrorDuplicate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'delete error and duplicate';

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
        if(request()->getHost() != 'https://hoqu.webmapp.it')
        {
            DuplicateTask::truncate();
            Task::whereIn('process_status',['error','done','duplicate','processing','new'])->delete();
        }

    }
}
