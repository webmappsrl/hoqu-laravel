<?php

namespace Tests\Feature;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use App\Mail\sendError;


use Tests\TestCase;
use App\Model\Task;

class MailTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testMailError()
    {
        Mail::fake();
        $ja=["id"=>1,'id_server'=>10, 'process_status'=>'error','process_log'=>'log test'];
        $order = new sendError($ja);
        Mail::to('team@webmapp.it')->send($order);
        Mail::assertSent(function (sendError $mail) use ($order) {
            $count = 0;
            if($mail->itemHoqu['id'] === $order->itemHoqu['id']) $count++;
            if($mail->itemHoqu['id_server'] === $order->itemHoqu['id_server']) $count++;
            if($mail->itemHoqu['process_status'] === $order->itemHoqu['process_status']) $count++;
            if($mail->itemHoqu['process_log'] === $order->itemHoqu['process_log']) $count++;

            return 4 === $count;
        });


        Mail::assertSent(sendError::class, 1);
    }
}