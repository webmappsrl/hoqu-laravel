<?php

namespace Tests\Feature;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Tests\TestCase;
use App\Queue;

class pushTest extends TestCase
{
    //migrate tables before each test
    use RefreshDatabase;

    public function testMultiplePush()
    {
        Queue::truncate();
        $data = [
            "instance" => "https://montepisanotree.org",
            "task" => "mptupdatepoi",
            "parameters" => ["a"=> "yes", "b"=> "no"]
        ];
        //OPERATIONS 1
        $response = $this->post('/api/queue/push',$data);
        $response ->assertStatus(201);
        $response->assertJson($data);
        $ja = $this->get('api/queue/item/'.$response['id'])->json();
        $this->assertSame($ja['instance'],$data['instance']);
        $this->assertSame($ja['task'],$data['task']);
        $this->assertSame($ja['parameters'],$data['parameters']);
        $this->assertSame($ja['process_status'],'new');
        $this->assertSame(count($this->get('/api/queue/list')->json()),1);
        //OPERATIONS 2
        $response = $this->post('/api/queue/push',$data);
        $response ->assertStatus(201);
        $response->assertJson($data);
        $ja = $this->get('api/queue/item/'.$response['id'])->json();
        $this->assertSame($ja['id'],$response['id']);
        //OPERATIONS 3
        $response = $this->post('/api/queue/push',$data);
        $response ->assertStatus(201);
        $response->assertJson($data);
        $ja = $this->get('api/queue/item/'.$response['id'])->json();
        $this->assertSame($ja['id'],$response['id']);
        //OPERATIONS 4
        $response = $this->post('/api/queue/push',$data);
        $response ->assertStatus(201);
        $response->assertJson($data);
        $ja = $this->get('api/queue/item/'.$response['id'])->json();
        $this->assertSame($ja['id'],$response['id']);
        //OPERATIONS 5
        $response = $this->post('/api/queue/push',$data);
        $response ->assertStatus(201);
        $response->assertJson($data);
        $ja = $this->get('api/queue/item/'.$response['id'])->json();
        $this->assertSame($ja['id'],$response['id']);
        //OPERATIONS 6
        $response = $this->post('/api/queue/push',$data);
        $response ->assertStatus(201);
        $response->assertJson($data);
        $ja = $this->get('api/queue/item/'.$response['id'])->json();
        $this->assertSame($ja['id'],$response['id']);
        $dataDbTest = $response->json();
        $this->assertSame(count($this->get('/api/queue/list')->json()),6);
    }

    public function testPushApiHoquCheckInstance()
    {
        Queue::truncate();
        $data = [
            "instance" => "",
            "task" => "mptupdatepoi",
            "parameters" => ["a"=> "yes", "b"=> "no"]
        ];
        $response = $this->post('api/queue/push',$data);
        $response ->assertStatus(400);
    }

    public function testApiHoquCheckTaskPush()
    {
        $data = [
            "instance" => "https://frittomisto.com",
            "task" => "",
            "parameters" => ["a"=> "yes", "b"=> "no"]
        ];
        $response = $this->post('api/queue/push',$data);
        $response ->assertStatus(400);
    }

    public function testApiHoquPushCheckParametersEmpty()
    {
        Queue::truncate();
        $data = [
            "instance" => "https://frittomisto.com",
            "task" => "mptupdatepoi",
            "parameters" => []
        ];
        $response = $this->post('api/queue/push',$data);
        $response ->assertStatus(201);
        $response->assertJson($data);
        //OPERATION 1
        $response = $this->get('api/queue/list');
        $requestSvr1 = [
            "id_server" => 9,
            "taskAvailable" => ["task1","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
        ];
        //OPERATIONS 2
        $response = $this->put('api/queue/pull',$requestSvr1);
        $response ->assertStatus(200);
        $ja = $this->get('api/queue/item/'.$response['id'])->json();
        $this->assertSame('processing',$ja['process_status']);
        $this->assertSame($requestSvr1['id_server'],$ja['id_server']);
        $this->assertSame($data['instance'],$ja['instance']);
        $this->assertSame($data['parameters'],$ja['parameters']);
        $this->assertSame($response['id'],$ja["id"]);
    }

    public function testPushApiHoquCheckParametersValidateJson()
    {
        Queue::truncate();
        $data = [
            "instance" => "https://frittomisto.com",
            "task" => "mptupdatepoi",
            "parameters" => 's',
        ];
        $response = $this->post('api/queue/push',$data);
        $response ->assertStatus(400);
        $data = [
            "instance" => "https://frittomisto.com",
            "task" => "mptupdatepoi",
            "parameters" => [0,1,3],
        ];
        $response = $this->post('api/queue/push',$data);
        $response ->assertStatus(400);
        $data = [
            "instance" => "https://frittomisto.com",
            "task" => "mptupdatepoi",
            "parameters" => ["a"=> "yes", "b"=> "no"],
        ];
        $response = $this->post('api/queue/push',$data);
        $response ->assertStatus(201);
        $data = [
            "instance" => "https://frittomisto.com",
            "task" => "mptupdatepoi",
            "parameters" => 1,
        ];
        $response = $this->post('api/queue/push',$data);
        $response ->assertStatus(400);
        $data = [
            "instance" => "https://frittomisto.com",
            "task" => "mptupdatepoi",
            "parameters" => true,
        ];
        $response = $this->post('api/queue/push',$data);
        $response ->assertStatus(400);
        $data = [
            "instance" => "https://frittomisto.com",
            "task" => "mptupdatepoi",
            "parameters" => null,
        ];
        $response = $this->post('api/queue/push',$data);
        $response ->assertStatus(201);
        $data = [
            "instance" => "https://frittomisto.com",
            "task" => "mptupdatepoi",
        ];
        $response = $this->post('api/queue/push',$data);
        $response ->assertStatus(201);
    }

    public function testDuplicatePushApiHoqu()
    {
        $data = [ "instance" => "X", "task" => "X", "parameters" => ["k"=> "v"] ];
        //OPERATIONS 1
        $response = $this->post('api/queue/push',$data);
        $response->assertStatus(201);
        $response->assertJson($data);
        $ja = $this->get('api/queue/item/'.$response['id'])->json();
        $this->assertSame('new',$ja["process_status"]);
        //OPERATIONS 2
        $response = $this->post('api/queue/push',$data);
        $response ->assertStatus(201);
        $response->assertJson($data);
        $ja = $this->get('api/queue/item/'.$response['id'])->json();
        $this->assertSame('duplicate',$ja['process_status']);
    }

}
