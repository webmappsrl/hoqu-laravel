<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;

class showApiTest extends TestCase
{

    public function testTokenCreateShowFail()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['update']
        );
        $response = $this->get('api/show/1');
        $response->assertStatus(403);

        Sanctum::actingAs(
            User::factory()->create(),
            ['create']
        );
        $response = $this->get('api/show/1');
        $response->assertStatus(403);

        Sanctum::actingAs(
            User::factory()->create(),
            ['delete']
        );
        $response = $this->get('api/show/1');
        $response->assertStatus(403);

        Sanctum::actingAs(
            User::factory()->create(),
            ['read']
        );
        $response = $this->get('api/show/1');
        $response->assertStatus(200);
    }

    public function testCheckShowHoqu()
    {
        $data = [ "instance" => "X", "job" => "X", "parameters" => ["k"=> "v"] ];
        Sanctum::actingAs(
            User::factory()->create(),
            ['create']
        );
        $response = $this->json('POST', 'api/store', $data);

        $response->assertStatus(201);

        Sanctum::actingAs(
            User::factory()->create(),
            ['read']
        );
        $t1 = $this->get('api/show/'.$response['id']);
        $t1->assertStatus(200);
        $this->assertSame($response['id'],$t1["id"]);
        $this->assertSame(null,$t1["id_server"]);
        $this->assertSame($data['instance'],$t1["instance"]);
        $this->assertSame($data['job'],$t1["job"]);
        $this->assertSame('new',$t1["process_status"]);
        $this->assertSame(null,$t1["process_log"]);
        $this->assertSame(json_decode($response['parameters'],TRUE),json_decode($t1['parameters'],TRUE));

        $data = [ "instance" => "Xs", "job" => "X", "parameters" => ["k"=> "v"] ];
        Sanctum::actingAs(
            User::factory()->create(),
            ['create']
        );
        $response = $this->json('POST', 'api/store', $data);
        $response->assertStatus(201);

        Sanctum::actingAs(
            User::factory()->create(),
            ['read']
        );
        $t1 = $this->get('api/show/'.$response['id']);
        $t1->assertStatus(200);
        $this->assertSame($response['id'],$t1["id"]);
        $this->assertSame(null,$t1["id_server"]);
        $this->assertSame($data['instance'],$t1["instance"]);
        $this->assertSame($data['job'],$t1["job"]);
        $this->assertSame('new',$t1["process_status"]);
        $this->assertSame(null,$t1["process_log"]);
        $this->assertSame(json_decode($response['parameters'],TRUE),json_decode($t1['parameters'],TRUE));

        $data = [ "instance" => "Xq", "job" => "X", "parameters" => ["k"=> "v"] ];
        Sanctum::actingAs(
            User::factory()->create(),
            ['create']
        );
        $response = $this->json('POST', 'api/store', $data);
        $response->assertStatus(201);

        Sanctum::actingAs(
            User::factory()->create(),
            ['read']
        );
        $t1 = $this->get('api/show/'.$response['id']);
        $t1->assertStatus(200);
        $this->assertSame($response['id'],$t1["id"]);
        $this->assertSame(null,$t1["id_server"]);
        $this->assertSame($data['instance'],$t1["instance"]);
        $this->assertSame($data['job'],$t1["job"]);
        $this->assertSame('new',$t1["process_status"]);
        $this->assertSame(null,$t1["process_log"]);
        $this->assertSame(json_decode($response['parameters'],TRUE),json_decode($t1['parameters'],TRUE));

        $data = [ "instance" => "Xda", "job" => "X", "parameters" => ["k"=> "v"] ];
        Sanctum::actingAs(
            User::factory()->create(),
            ['create']
        );
        $response = $this->json('POST', 'api/store', $data);
        $response->assertStatus(201);

        Sanctum::actingAs(
            User::factory()->create(),
            ['read']
        );
        $idNotFound = $response['id'];
        $idNotFound++;
        $t1 = $this->get('api/show/'.$idNotFound);
        $t1->assertStatus(404);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh --seed');
    }

}
