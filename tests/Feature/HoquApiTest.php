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


        $this->json('POST',route('queues.add'),$data)->assertStatus(201)->assertJson($data);
        

        /* 
        assertion (post conditions on the final state of the system)
        */
       // $this->assertCount(1,$queue->add());
    } 
}
