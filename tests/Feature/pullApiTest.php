<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Storage;

use Tests\TestCase;

class pullApiTest extends TestCase
{

    public function resetAuth(array $guards = null)
    {
        $guards = $guards ?: array_keys(config('auth.guards'));

        foreach ($guards as $guard) {
            $guard = $this->app['auth']->guard($guard);

            if ($guard instanceof \Illuminate\Auth\SessionGuard) {
                $guard->logout();
            }
        }

        $protectedProperty = new \ReflectionProperty($this->app['auth'], 'guards');
        $protectedProperty->setAccessible(true);
        $protectedProperty->setValue($this->app['auth'], []);
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testTokenPullFail()
    {
        $user_tokens = json_decode(Storage::get('test_data/tokens_users.json'),TRUE);
        $token_fake = 'token-fake';

        $requestSvr1 = [
            "id_server" => 10,
            "task_available" => ["mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
        ];
        $requestSvr1['task_available'] =  json_encode($requestSvr1['task_available']);

        // NO TOKEN: assert 401
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->put('/api/pull',$requestSvr1);
        $response->assertStatus(401);

        // WRONG TOKEN: assert 401
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$token_fake,
        ])->put('/api/pull',$requestSvr1);
        $response->assertStatus(401);

        // Check that instance@webmapp.it access to api/pull with token only read/create
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$user_tokens['instance@webmapp.it'],
        ])->put('/api/pull',$requestSvr1);
        $response->assertStatus(403);

        // Check that test-token@webmapp.it access to api/pull with token only create
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$user_tokens['test-token@webmapp.it'],
        ])->put('/api/pull',$requestSvr1);
        $response->assertStatus(403);
    }

    public function testTaskNoMatchPullApiHoqu()
    {
        Task::truncate();
        $user_tokens = json_decode(Storage::get('test_data/tokens_users.json'),TRUE);

        //add data with api/store
        $data = [
            "instance" => "https:\/\/montepisanotree.org",
            "job" => "task1",
            "parameters" => ["a"=> "yes", "b"=> "no", "c" => "boh"],
        ];

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$user_tokens['instance@webmapp.it'],
        ])->post('/api/store',$data);

        $response->assertStatus(201);

        $this->resetAuth();

        //request that sends the "requesting server"
        $requestSvr1 = [
            "id_server" => 9,
            "task_available" => ["mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"]
        ];

        //OPERATIONS
        // Check that instance@webmapp.it access to api/
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$user_tokens['server@webmapp.it'],
        ])->put('/api/pull',$requestSvr1);
        $response->assertStatus(204);
        $response ->assertNoContent($status = 204);
    }



public function testFineFirstElementPullApiHoqu()
    {
        $user_tokens = json_decode(Storage::get('test_data/tokens_users.json'),TRUE);

        //add data with api/store
        $data = [
            "instance" => "https:\/\/montepisanotree.org",
            "job" => "task1",
            "parameters" => ["a"=> "yes", "b"=> "no", "c" => "boh"],
        ];

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$user_tokens['instance@webmapp.it'],
        ])->post('/api/store',$data);
        $response->assertStatus(201);
        sleep(2);

        $data1 = [
            "instance" => "https:\/\/montelabronicotree.org",
            "job" => "task1",
            "parameters" => ["a"=> "yes", "b"=> "no", "c" => "boh"],
        ];

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$user_tokens['instance@webmapp.it']
        ])->post('/api/store',$data1);
        $response->assertStatus(201);
        $requestSvr1 = [
            "id_server" => 9,
            "task_available" => ["task1","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
        ];


        //OPERATIONS
        // Check that server@webmapp.it access to api/
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$user_tokens['instance@webmapp.it']
        ])->put('/api/pull',$requestSvr1);

        $this->resetAuth();

        //OPERATIONS
        // Check that server@webmapp.it access to api/
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$user_tokens['server@webmapp.it']
        ])->put('/api/pull',$requestSvr1);
        $response->assertStatus(200);
        //get value elaborate by pull
        $ja = Task::find($response['id']);
        $this->assertSame('processing',$ja['process_status']);
        $this->assertSame($requestSvr1['id_server'],$ja['id_server']);
        $this->assertSame($data['instance'],$ja['instance']);
        $this->assertSame($response['instance'],$ja['instance']);
        $this->assertSame($response['id'],$ja["id"]);
        $this->assertSame(json_decode($response['parameters'],TRUE),json_decode($ja['parameters'],TRUE));
        $this->assertSame($data['parameters'],json_decode($ja['parameters'],TRUE));

    }
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh --seed');
    }

}