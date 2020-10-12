<?php

namespace Tests\Feature;
use App\Models\Task;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class updateErrorApiTest extends TestCase
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

    public function testNotAuthorizedIdSUpdateErrorApiHoqu()
    {
        $user_tokens = json_decode(Storage::get('test_data/tokens_users.json'),TRUE);

        //add data with api/queues
        $data = [
            "instance" => "https:\/\/montepisanotree.org",
            "job" => "task1",
            "parameters" => ["a"=> "yes", "b"=> "no", "c" => "so and so", "d"=>"maybe"],
        ];
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$user_tokens['instance@webmapp.it']
        ])->post('/api/store',$data);
        $response->assertStatus(201);

        //logout user
        $this->resetAuth();

        //request that sends the "requesting server"
        $requestSvr1 = [
            "id_server" => 10,
            "task_available" => ["task1","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
        ];

        //OPERATIONS 1
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$user_tokens['server@webmapp.it']
        ])->put('/api/pull',$requestSvr1);
        $response->assertStatus(200);

        //get value elaborate by pull
        $dataDbTest = $response;
        //request that sends the "requesting server 2"
        $requestSvr2 = [
            "id_server" => 25,
            "status" => "done",
            "log" => "log test",
            "id_task" => $dataDbTest['id'],
        ];
        //OPERATIONS 2
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$user_tokens['server@webmapp.it']
        ])->put('/api/updateError',$requestSvr2);
        $response->assertStatus(403);
    }


    public function testIdNotExistupdateErrorApiHoqu()
    {
        $user_tokens = json_decode(Storage::get('test_data/tokens_users.json'),TRUE);
        //add data with api/store
        $data = [
            "instance" => "https:\/\/montepisanotree.org",
            "job" => "task1",
            "parameters" => ["a"=> "yes", "b"=> "no", "c" => "so and so", "d"=>["poi"=>02,"route"=>2345]],
        ];
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$user_tokens['instance@webmapp.it']
        ])->post('/api/store',$data);
        $response->assertStatus(201);

        //logout user
        $this->resetAuth();

        //request that sends the "requesting server"
        $requestSvr1 = [
            "id_server" => 10,
            "task_available" => ["task1","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
        ];
        //OPERATIONS 1
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$user_tokens['server@webmapp.it']
        ])->put('/api/pull',$requestSvr1);
        $response->assertStatus(200);

        //get value elaborate by pull
        $dataDbTest = $response;
        //request that sends the "requesting server 2"
        $requestSvr2 = [
            "id_server" => 10,
            "task_available" => ["task1","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
            "id_task" => 100,
        ];
        //OPERATIONS 2
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$user_tokens['server@webmapp.it']
        ])->put('/api/updateError',$requestSvr2);
        $dataDbTestUp = $response;
        $response->assertStatus(400);
    }

    public function testCheckValueStatusupdateErrorApiHoqu()
    {
        $user_tokens = json_decode(Storage::get('test_data/tokens_users.json'),TRUE);

        //add data with api/store
        $data = [
            "instance" => "https:\/\/montepisanotree.org",
            "job" => "task1",
            "parameters" => ["a"=> "yes", "b"=> "no", "c" => "so and so", "d"=>["poi"=>02,"route"=>2345]],
        ];
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$user_tokens['instance@webmapp.it']
        ])->post('/api/store',$data);
        $response->assertStatus(201);

        //logout user
        $this->resetAuth();

        //request that sends the "requesting server"
        $requestSvr1 = [
            "id_server" => 10,
            "task_available" => ["task1","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"]
        ];

        //OPERATIONS 1
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$user_tokens['server@webmapp.it']
        ])->put('/api/pull',$requestSvr1);
        $response ->assertStatus(200);
        //get value elaborate by pull
        $dataDbTest = $response;
        //request that sends the "requesting server 2"
        $requestSvr2 = [
            "id_server" => 10,
            "status" => '',
            "log" => "log test",
            "id_task" => $dataDbTest['id'],
        ];

        //OPERATIONS 2
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$user_tokens['server@webmapp.it']
        ])->put('/api/updateError',$requestSvr2);
        //get value elaborated by update
        $dataDbTestUp = $response;
        $response->assertStatus(400);

        //request that sends the "requesting server 2"
        $requestSvr1 = [
            "id_server" => 10,
            "status" => 'duplicate',
            "log" => "log test",
            "id_task" => $dataDbTest['id'],
        ];
        //OPERATIONS 3
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$user_tokens['server@webmapp.it']
        ])->put('/api/updateError',$requestSvr2);
        //get value elaborated by update
        $response->assertStatus(400);

        //request that sends the "requesting server 2"
        $requestSvr1 = [
            "id_server" => 10,
            "log" => "log test",
            "id_task" => $dataDbTest['id'],
        ];
        //OPERATIONS 4
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$user_tokens['server@webmapp.it']
        ])->put('/api/updateError',$requestSvr2);
        $response->assertStatus(400);
    }


    public function testErrorUpdateApiHoqu()
    {
        $user_tokens = json_decode(Storage::get('test_data/tokens_users.json'),TRUE);

        //add data with api/store
        $data = [
            "instance" => "https:\/\/montepisanotree.org",
            "job" => "task1",
            "parameters" => ["a"=> "yes", "b"=> "no", "c" => "so and so", "d"=>["poi"=>02,"route"=>2345]],
        ];

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$user_tokens['instance@webmapp.it']
        ])->post('/api/store',$data);
        $response->assertStatus(201);

        //logout user
        $this->resetAuth();

        //request that sends the "requesting server"
        $requestSvr1 = [
            "id_server" => 10,
            "task_available" => ["task1","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
        ];

        //OPERATIONS 1
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$user_tokens['server@webmapp.it']
        ])->put('/api/pull',$requestSvr1);
        $response ->assertStatus(200);

        //request that sends the "requesting server 2"
        $requestSvr2 = [
            "id_server" => 10,
            "status" => "error",
            "log" => "log test",
            "id_task" => $response['id'],
        ];
        //OPERATIONS 2
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$user_tokens['server@webmapp.it']
        ])->put('/api/updateError',$requestSvr2);
        //get value elaborated by update
        $response ->assertStatus(200);
        $ja = Task::find($response['id']);
        $this->assertSame('error',$ja['process_status']);
        $this->assertSame($requestSvr2['log'],$ja['process_log']);
        $this->assertSame($requestSvr2['id_server'],$ja['id_server']);
        $this->assertSame($data['instance'],$ja['instance']);
        $this->assertSame(json_decode($response['parameters'],TRUE),json_decode($ja['parameters'],TRUE));
        $this->assertSame($data['parameters'],json_decode($ja['parameters'],TRUE));
        $this->assertSame($response['id'],$ja["id"]);
    }

    public function testErrorUpdateCheckApiHoqu()
    {
        $user_tokens = json_decode(Storage::get('test_data/tokens_users.json'),TRUE);

        //add data with api/store
        $data = [
            "instance" => "https:\/\/montepisanotree.org",
            "job" => "task1",
            "parameters" => ["a"=> "yes", "b"=> "no", "c" => "so and so", "d"=>["poi"=>02,"route"=>2345]],
        ];

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$user_tokens['instance@webmapp.it']
        ])->post('/api/store',$data);
        $response->assertStatus(201);

        //logout user
        $this->resetAuth();

        //request that sends the "requesting server"
        $requestSvr1 = [
            "id_server" => 10,
            "task_available" => ["task1","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
        ];

        //OPERATIONS 1
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$user_tokens['server@webmapp.it']
        ])->put('/api/pull',$requestSvr1);
        $response ->assertStatus(200);

        //request that sends the "requesting server 2"
        $requestSvr2 = [
            "id_server" => 10,
            "status" => "VDC",
            "log" => "log test",
            "id_task" => $response['id'],
        ];
        //OPERATIONS 2
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$user_tokens['server@webmapp.it']
        ])->put('/api/updateError',$requestSvr2);
        //get value elaborated by update
        $response ->assertStatus(200);
        $ja = Task::find($response['id']);
        $this->assertSame('error',$ja['process_status']);
        $this->assertSame($requestSvr2['log'],$ja['process_log']);
        $this->assertSame($requestSvr2['id_server'],$ja['id_server']);
        $this->assertSame($data['instance'],$ja['instance']);
        $this->assertSame(json_decode($response['parameters'],TRUE),json_decode($ja['parameters'],TRUE));
        $this->assertSame($data['parameters'],json_decode($ja['parameters'],TRUE));
        $this->assertSame($response['id'],$ja["id"]);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh --seed');
    }

}
