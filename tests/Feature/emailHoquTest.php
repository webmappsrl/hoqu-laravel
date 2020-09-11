<?php

namespace Tests\Feature;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use App\Mail\notifyHoqu;


use Tests\TestCase;
use App\Queue;

class emailHoquTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testMailError()
    {
        Queue::truncate();
        //add data with api/queues
        $data = [
            "instance" => "https:\/\/montepisanotree.org",
            "task" => "task1",
            "parameters" => ["a"=> "yes", "b"=> "no", "c" => "so and so", "d"=>["poi"=>02,"route"=>2345]],
        ];
        $response = $this->post('api/queue/push',$data);
        //request that sends the "requesting server"
        $requestSvr1 = [
            "id_server" => 10,
            "taskAvailable" => ["task1","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
        ];
        //OPERATIONS 1
        $response = $this->put('api/queue/pull',$requestSvr1);
        $response ->assertStatus(200);
        //get value elaborate by pull
        $dataDbTest = $response;
        //request that sends the "requesting server 2"
        $requestSvr1 = [
            "id_server" => 10,
            "status" => "error",
            "log" => "log test",
            "idTask" => $dataDbTest['id'],
        ];

        //OPERATIONS 2
        $response = $this->put('api/queue/update',$requestSvr1);
        //get value elaborated by update
        $ja = $this->get('api/queue/item/'.$response['id'])->json();
        $response ->assertStatus(200);
        $this->assertSame('error',$ja['process_status']);
        $this->assertSame($requestSvr1['log'],$ja['process_log']);
        $this->assertSame($requestSvr1['id_server'],$ja['id_server']);
        $this->assertSame($data['instance'],$ja['instance']);
        $this->assertSame($data['parameters'],$ja['parameters']);
        $this->assertSame($response['id'],$ja["id"]);

        Mail::fake();
        $order = new NotifyHoqu($ja);
        Mail::to('team@webmapp.it')->send($order);
        Mail::assertSent(function (NotifyHoqu $mail) use ($order) {
            $count = 0;
            if($mail->itemHoqu['id'] === $order->itemHoqu['id']) $count++;
            if($mail->itemHoqu['id_server'] === $order->itemHoqu['id_server']) $count++;
            if($mail->itemHoqu['process_status'] === $order->itemHoqu['process_status']) $count++;
            if($mail->itemHoqu['process_log'] === $order->itemHoqu['process_log']) $count++;

            return 4 === $count;
        });

        Mail::assertSent(NotifyHoqu::class, 1);
    }
}
