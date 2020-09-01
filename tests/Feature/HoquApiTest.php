<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Queue;

class HoquApiTest extends TestCase
{
    //migrate tables before each test
    use RefreshDatabase;
    

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testHoquIndex()
    {
        $response = $this->get('/api/queues');

        $response->assertStatus(200);

        $response->assertJson([]);
    }

    public function testAddApiHoqu()
    {
        /* 
        prerequisites (system state in which we want to conduct the test)

           * we pass to the factory() method a class of which we want to generate a model
           * create() method generates a model and makes it persistent on the db
        */
        //$queue = factory(Queue::class)->create();


        /* 
        operations (which change the state of the system)
        */

        $data = [
            "instance" => "https:\/\/montepisanotree.org",
            "task" => "mptupdatepoi",
            "parameters" => "prova",
        ];


       // $response = $this->json('POST',route('queues.add'),$data);

        // $response = $this->json('POST',route('queues.add'),$data);

        $response = $this->post('/api/queues',$data);

        $response ->assertStatus(201);

        $response->assertJson($data);

        $response = $this->get('/api/queues');

        $response ->assertStatus(200);

       // $response->assertJson($data);

        $dataDbTest = $response->json();
        //var_dump($dataDbTest);

        $this->assertSame($dataDbTest[0]['instance'],$data['instance']);
        $this->assertSame($dataDbTest[0]['task'],$data['task']);
        $this->assertSame($dataDbTest[0]['parameters'],$data['parameters']);
        $this->assertSame($dataDbTest[0]['process_status'],'new');

        $this->assertSame(count($dataDbTest),1);


        $response = $this->post('/api/queues',$data);

        $response = $this->post('/api/queues',$data);

        $response = $this->post('/api/queues',$data);

        $response = $this->post('/api/queues',$data);

        $response = $this->post('/api/queues',$data);

        $dataDbTest = $response->json();

        $this->assertSame(count($dataDbTest),6);
        /* 
        assertion (post conditions on the final state of the system)
        */
       // $this->assertCount(1,$queue->add());
    } 

    public function testPullApiHoqu(){
    
        //1 TEST TDD

        //add data with api/queues
        $data = [
            "instance" => "https:\/\/montepisanotree.org",
            "task" => "mptupdatepoi",
            "parameters" => "prova",
        ];

        $response = $this->post('/api/queues',$data);

        //request that sends the "requesting server"
        $requestSvr1 = [
            "idServer" => 1,
            "taskAvailable" => ["mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
        ];

        //OPERATIONS
        $response = $this->put('/api/queuesPull',$requestSvr1);
        
        //check response 200
        //$response ->assertCreated();
        $response ->assertStatus(200);

        //get value elaborate by pull
        $dataDbTest = $response;

        //var_dump($dataDbTest);

        //check field process_status == processing
        $this->assertSame('processing',$dataDbTest['process_status']);

        //check idServer
        $this->assertSame($requestSvr1['idServer'],$dataDbTest['idServer']);

        //check instance
        $this->assertSame($data['instance'],$dataDbTest['instance']);

        //check parameters
        $this->assertSame($data['parameters'],$dataDbTest['parameters']);

    }

    public function testPullApiHoqu1()
    {
        //2 TEST TDD

        //add data with api/queues
        $data = [
            "instance" => "https:\/\/montepisanotree.org",
            "task" => "task1",
            "parameters" => "prova prova",
        ];

        $response = $this->post('/api/queues',$data);

        //request that sends the "requesting server"
        $requestSvr1 = [
            "idServer" => 9,
            "taskAvailable" => ["mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
        ];

        //OPERATIONS
        $response = $this->put('/api/queuesPull',$requestSvr1);
        
        //check response 204
        $response ->assertStatus(204);
        $response ->assertJson([]);
    }

    public function testPullApiHoqu2()
    {
        //2 TEST TDD

        //add data with api/queues
        $data = [
            "instance" => "https:\/\/montepisanotree.org",
            "task" => "task1",
            "parameters" => "prova prova",
        ];

        $response = $this->post('/api/queues',$data);

        sleep(2);

        $data1 = [
            "instance" => "https:\/\/montelabronicotree.org",
            "task" => "task1",
            "parameters" => "prova",
        ];

        $response = $this->post('/api/queues',$data1);

        //request that sends the "requesting server"
        $requestSvr1 = [
            "idServer" => 9,
            "taskAvailable" => ["task1","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
        ];

        //OPERATIONS
        $response = $this->put('/api/queuesPull',$requestSvr1);
        
        //check response 200
        //$response ->assertCreated();
        $response ->assertStatus(200);

        //get value elaborate by pull
        $dataDbTest = $response;

        //var_dump($dataDbTest);

        //check field process_status == processing
        $this->assertSame('processing',$dataDbTest['process_status']);

        //check idServer
        $this->assertSame($requestSvr1['idServer'],$dataDbTest['idServer']);

        //check instance
        $this->assertSame($data['instance'],$dataDbTest['instance']);

        //check parameters
        $this->assertSame($data['parameters'],$dataDbTest['parameters']);

        //check parameters
        $this->assertSame(1,$dataDbTest['id']);


    }
}
