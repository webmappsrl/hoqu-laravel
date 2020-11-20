<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\DuplicateTask;
use App\Models\Task;
use Tests\TestCase;

class deleteErrorDuplicateTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testExample()
    {
        $countTask = Task::count();
        $countErrorTask = Task::whereIn('process_status',['error','done'])->count();

        if(request()->getHost() != 'https://hoqu.webmapp.it')
        {
            Task::whereIn('process_status',['error','done'])->delete();
            DuplicateTask::truncate();
        }

        $postCountTask = Task::count();
        $postCountDuplicate = DuplicateTask::count();

        $this->assertSame($postCountTask,($countTask-$countErrorTask));
        $this->assertSame($postCountDuplicate,0);

    }

}
