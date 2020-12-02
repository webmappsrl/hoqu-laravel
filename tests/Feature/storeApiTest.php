<?php

namespace Tests\Feature;

use App\Models\DuplicateTask;
use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;



class storeApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testTokenCreateStoreFail()
    {
        $user_tokens = json_decode(Storage::get('test_data/tokens_users.json'),TRUE);
        $token_fake = 'token-fake';

        $data = [
            "instance" => "https://montepisanotree.org",
            "job" => "mptupdatepoi",
            "parameters" => ["a"=> "yes", "b"=> "no"]
        ];

        // NO TOKEN: assert 401
        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])->post('/api/store',$data);
        $response->assertStatus(401);

        // WRONG TOKEN: assert 401
        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$token_fake,
        ])->post('/api/store',$data);
        $response->assertStatus(401);

        // Check that server@webmapp.it access to api/store
        $response = $this->withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$user_tokens['server@webmapp.it'],
        ])->post('/api/store',$data);
        $response->assertStatus(403);
    }

    public function testStoreDone()
    {
        $user_tokens = json_decode(Storage::get('test_data/tokens_users.json'),TRUE);

        $data = [
            "instance" => "https://frittomisto.com",
            "job" => "mptupdatepoi",
        ];
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$user_tokens['instance@webmapp.it'],
        ])->post('/api/store',$data);
        $response ->assertStatus(201);

        $data = [
            "instance" => "https://montepisanotreee.org",
            "job" => "mptupdatepoi",
            "parameters" => ["a"=> "yes", "b"=> "no"]
        ];

        // Check that instance@webmapp.it access to api/
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$user_tokens['instance@webmapp.it'],
        ])->post('/api/store',$data);
        $response->assertStatus(201);
        $t1 = Task::find($response['id']);
        $this->assertSame($response['instance'],'montepisanotreee.org');
        $this->assertSame($response['job'],$t1['job']);
        $this->assertSame(json_decode($response['parameters'],TRUE),json_decode($t1['parameters'],TRUE));
        $this->assertSame('montepisanotreee.org',$t1['instance']);
        $this->assertSame($data['job'],$t1['job']);
        $this->assertSame($data['parameters'],json_decode($t1['parameters'],TRUE));

        // Check that instance@webmapp.it access to api/

        $data = [
            "instance" => "https://montepisanotrte.org",
            "job" => "mptupdatepoi",
            "parameters" => ["a"=> "yes", "b"=> "no"]
        ];
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$user_tokens['instance@webmapp.it'],
        ])->post('/api/store',$data);
        $response->assertStatus(201);
        $t1 = Task::find($response['id']);
        $this->assertSame($response['instance'],$t1['instance']);
        $this->assertSame($response['job'],$t1['job']);
        $this->assertSame(json_decode($response['parameters'],TRUE),json_decode($t1['parameters'],TRUE));
        $this->assertSame('montepisanotrte.org',$t1['instance']);
        $this->assertSame($data['job'],$t1['job']);
        $this->assertSame($data['parameters'],json_decode($t1['parameters'],TRUE));
        $data = [
            "instance" => "https://montepisanotrewe.org",
            "job" => "mptupdatepoi",
            "parameters" => ["a"=> "yes", "b"=> "no"]
        ];
        // Check that instance@webmapp.it access to api/
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$user_tokens['instance@webmapp.it'],
        ])->post('/api/store',$data);
        $response->assertStatus(201);
        $t1 = Task::find($response['id']);
        $this->assertSame($response['instance'],$t1['instance']);
        $this->assertSame($response['job'],$t1['job']);
        $this->assertSame(json_decode($response['parameters'],TRUE),json_decode($t1['parameters'],TRUE));
        $this->assertSame('montepisanotrewe.org',$t1['instance']);
        $this->assertSame($data['job'],$t1['job']);
        $this->assertSame($data['parameters'],json_decode($t1['parameters'],TRUE));

    }

    //check field json parameters
    public function testPushApiHoquCheckParametersValidateJson()
    {
        $user_tokens = json_decode(Storage::get('test_data/tokens_users.json'),TRUE);
        $data = [
            "instance" => "https://frittomisto.com",
            "job" => "mptupdatepoi",
            "parameters" => 's'
        ];
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$user_tokens['instance@webmapp.it'],
        ])->post('/api/store',$data);
        $response ->assertStatus(400);
        $data = [
            "instance" => "https://frittomisto.com",
            "job" => "mptupdatepoi",
            "parameters" => [0,1,3],
        ];
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$user_tokens['instance@webmapp.it'],
        ])->post('/api/store',$data);
        $response ->assertStatus(400);

        $data = [
            "instance" => "https://frittomisto.com",
            "job" => "mptupdatepoi",
            "parameters" => 1,
        ];
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$user_tokens['instance@webmapp.it'],
        ])->post('/api/store',$data);
        $response ->assertStatus(400);
        $data = [
            "instance" => "https://frittomisto.com",
            "job" => "mptupdatepoi",
            "parameters" => true,
        ];
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$user_tokens['instance@webmapp.it'],
        ])->post('/api/store',$data);
        $response ->assertStatus(400);
        $data = [
            "instance" => "https://frittomisto.com",
            "job" => "mptupdatepoi",
            "parameters" => null,
        ];
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$user_tokens['instance@webmapp.it'],
        ])->post('/api/store',$data);
        $response ->assertStatus(201);
    }

    public function testDuplicateStore()
    {
        $data = [
            "instance" => "https://montepisanotree.org",
            "job" => "mptupdatepoi",
            "parameters" => ["a"=> "yes", "b"=> "no"]
        ];
        Sanctum::actingAs(
            User::factory()->create(),
            ['create']
        );
        //OPERATIONS 1
        $response = $this->post('/api/store',$data);
        $response = $this->post('/api/store',$data);
        $response->assertStatus(201);
        $t1 = Task::find($response['task_id']);
        $t1_duplicate = DuplicateTask::find($response['id']);
        $this->assertSame($t1_duplicate['task_id'],$t1['id']);
        sleep(2);
        //OPERATIONS 2
        $response = $this->post('/api/store',$data);
        $response->assertStatus(201);
        $t1 = Task::find($response['task_id']);
        $t1_duplicate = DuplicateTask::find($response['id']);
        $this->assertSame($t1_duplicate['task_id'],$t1['id']);
        sleep(2);
        //OPERATIONS 3
        $response = $this->post('/api/store',$data);
        $response->assertStatus(201);
        $t1 = Task::find($response['task_id']);
        $t1_duplicate = DuplicateTask::find($response['id']);
        $this->assertSame($t1_duplicate['task_id'],$t1['id']);

    }

    public function testNotHttp()
    {
        $data = [
            "instance" => "https://monterumenotree.org",
            "job" => "mptupdatepoi",
            "parameters" => ["a"=> "yes", "b"=> "no"]
        ];
        Sanctum::actingAs(
            User::factory()->create(),
            ['create']
        );
        //OPERATIONS 1
        $response = $this->post('/api/store',$data);
        $response->assertStatus(201);
        $t1 = Task::find($response['id']);
        $this->assertSame($response['instance'],'monterumenotree.org');

        $data = [
            "instance" => "http://montebulgarotree.org",
            "job" => "mptupdatepoi",
            "parameters" => ["a"=> "yes", "b"=> "no"]
        ];

        //OPERATIONS 2
        $response = $this->post('/api/store',$data);
        $response->assertStatus(201);
        $t1 = Task::find($response['id']);
        $this->assertSame($response['instance'],'montebulgarotree.org');

        $data = [
            "instance" => "https://montesinti.org",
            "job" => "mptupdatepoi",
            "parameters" => ["a"=> "yes", "b"=> "no"]
        ];

        //OPERATIONS 3
        $response = $this->post('/api/store',$data);
        $response->assertStatus(201);
        $t1 = Task::find($response['id']);
        $this->assertSame($response['instance'],'montesinti.org');


    }
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh --seed');
    }
}
