<?php

namespace Tests\Feature;

use App\Mail\sendError;
use App\Mail\sendTrello;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class trelloMailTest extends TestCase
{

    public function testMailSend()
    {
        Mail::fake();
        $order = new sendTrello(Task::first());
        Mail::to('gianmarcogagliardi1+abk5rfgsorj10kmql4px@boards.trello.com')->send(new sendTrello($order));
        Mail::assertSent(sendTrello::class, 1);
    }
}
