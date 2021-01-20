<?php

namespace App\Console\Commands;

use App\Models\Task;
use Illuminate\Console\Command;

class PruneTaskHoqu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hoqu:pruneTask {instance} {job} {process_status}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'clears all tasks with that specific job, instance and process_status';

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

        $i = $this->argument('instance') ?: $this->ask('miss instance');
        $j = $this->argument('job')?: $this->ask('miss job');;
        $p = $this->argument('process_status')?: $this->ask('miss process_status');;

        Task::where('instance',$i)->where('job',$j)->where('process_status',$p)->delete();
        $this->info('the commands have been entered correctly');
    }
}
