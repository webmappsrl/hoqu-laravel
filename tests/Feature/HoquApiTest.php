<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Queue;

class HoquApiTest extends TestCase
{
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
    
    // prerequisites

        //aggiungo item with add
        $data = [
            "instance" => "https:\/\/montepisanotree.org",
            "task" => "mptupdatepoi",
            "parameters" => "prova",
        ];

        $response = $this->post('/api/queues',$data);

        //con pull controllo che l'operazione sia eseguibile ed in caso la recupero il dato inserito con add
        $requestSvr1 = [
            "idServer" => 1,
            "taskAvailable" => ["mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"]
        ];

        //OPERATIONS
        $response = $this->get('/api/queuesPull',$data,$requestSvr1);

        //I check/assert that it $response is json format
        $response->assertJson($data);

        //check field process_status == processing
        $dataDbTest = $response->json();
        $this->assertSame('processing',$dataDbTest[0]['process_status']);

        //check idServer
        $this->assertSame($data['idServer'],$dataDbTest[0]['idServer']);

        $response->assertJson($data);

        var_dump($response);

       



    }
}
