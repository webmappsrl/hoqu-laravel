<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;


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
            "instance" => "https://montepisanotree.org",
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
}
