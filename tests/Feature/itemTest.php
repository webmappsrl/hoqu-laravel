<?php

namespace Tests\Feature;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Tests\TestCase;
use App\Queue;

class itemTest extends TestCase
{
    public function testCheckItemHoqu()
    {
        Queue::truncate();
        $data = [ "instance" => "X", "task" => "X", "parameters" => ["k"=> "v"] ];
        $response = $this->json('POST', 'api/queue/push', $data);
        $ja = $this->get('api/queue/item/'.$response['id'])->json();
        $this->assertSame($response['id'],$ja["id"]);
        $this->assertSame(null,$ja["id_server"]);
        $this->assertSame($data['instance'],$ja["instance"]);
        $this->assertSame($data['task'],$ja["task"]);
        $this->assertSame('new',$ja["process_status"]);
        $this->assertSame('new',$ja["process_log"]);
        $this->assertSame($data['parameters'],json_decode(json_encode($ja['parameters']),true));
        $data = [ "instance" => "X", "task" => "Z", "parameters" => ["k"=> "v"] ];
        $response = $this->json('POST', 'api/queue/push', $data);
        $ja = $this->get('api/queue/item/'.$response['id'])->json();
        $this->assertSame($response['id'],$ja["id"]);
        $this->assertSame(null,$ja["id_server"]);
        $this->assertSame($data['instance'],$ja["instance"]);
        $this->assertSame($data['task'],$ja["task"]);
        $this->assertSame('new',$ja["process_status"]);
        $this->assertSame('new',$ja["process_log"]);
        $this->assertSame($data['parameters'],json_decode(json_encode($ja['parameters']),true));
        $data = [ "instance" => "X", "task" => "Z", "parameters" => ["k"=>null]];
        $response = $this->json('POST', 'api/queue/push', $data);
        $ja = $this->get('api/queue/item/'.$response['id'])->json();
        $this->assertSame($response['id'],$ja["id"]);
        $this->assertSame(null,$ja["id_server"]);
        $this->assertSame($data['instance'],$ja["instance"]);
        $this->assertSame($data['task'],$ja["task"]);
        $this->assertSame('new',$ja["process_status"]);
        $this->assertSame('new',$ja["process_log"]);
        $this->assertSame($data['parameters'],json_decode(json_encode($ja['parameters']),true));
        $ja = $this->get('/api/4');
        $ja->assertStatus(404);;
    }
}
