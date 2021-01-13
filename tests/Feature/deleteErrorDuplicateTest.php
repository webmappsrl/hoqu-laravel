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

        if(request()->getHost() != 'https://hoqu.webmapp.it')
        {
            DuplicateTask::truncate();
            Task::whereIn('process_status',['error','done','duplicate','processing','new','skip'])->delete();
        }

        $postCountTask = Task::count();
        $postCountDuplicate = DuplicateTask::count();

        $this->assertSame($postCountTask,0);
        $this->assertSame($postCountDuplicate,0);

    }

}
