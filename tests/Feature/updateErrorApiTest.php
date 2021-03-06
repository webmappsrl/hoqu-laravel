<?php

namespace Tests\Feature;
use App\Models\Task;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

use Tests\TestCase;

class updateErrorApiTest extends TestCase
{

    protected function resetAuth(array $guards = null)
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

    public function checkPermissionTokenUE()
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
        ])->put('/api/updateError',$requestSvr1);
        $response->assertStatus(401);

        // WRONG TOKEN: assert 401
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$token_fake,
        ])->put('/api/updateError',$requestSvr1);
        $response->assertStatus(401);

        // Check that instance@webmapp.it access to api/pull with token only read/create
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$user_tokens['instance@webmapp.it'],
        ])->put('/api/updateError',$requestSvr1);
        $response->assertStatus(403);

        // Check that test-token@webmapp.it access to api/pull with token only create
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$user_tokens['test-token@webmapp.it'],
        ])->put('/api/updateError',$requestSvr1);
        $response->assertStatus(403);
    }

    public function idServerWrong()
    {
        $user_tokens = json_decode(Storage::get('test_data/tokens_users.json'),TRUE);

        //add data with api/store
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


    public function withoutLog()
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
        $response->assertStatus(400);
    }

    public function testCheckValueStatus_updateErrorApiHoqu()
    {
        Mail::fake();
        $user_tokens = json_decode(Storage::get('test_data/tokens_users.json'),TRUE);

        //add data with api/store
        $data = [
            "instance" => "https://montepisanotree.org",
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
            "id_server" => '10',
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
            "id_server" => '10',
            "status" => '',
            "log" => "log test",
            "id_task" => $dataDbTest['id'],
        ];

        //OPERATIONS 2
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$user_tokens['server@webmapp.it']
        ])->put('/api/updateError',$requestSvr2);
        //get value elaborated by updateError
        $dataDbTestUp = $response;
        $response->assertStatus(200);;
        $ja = Task::find($response['id']);
        $this->assertSame('error',$ja['process_status']);
        $this->assertSame($requestSvr2['log'],$ja['process_log']);
        $this->assertSame($requestSvr2['id_server'],$ja['id_server']);
        $this->assertSame('montepisanotree.org',$ja['instance']);
        $this->assertSame(json_decode($response['parameters'],TRUE),json_decode($ja['parameters'],TRUE));
        $this->assertSame($data['parameters'],json_decode($ja['parameters'],TRUE));
        $this->assertSame($response['id'],$ja["id"]);

        //request that sends the "requesting server 2"
        $requestSvr1 = [
            "id_server" => '10',
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
        $response->assertStatus(403);

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
        $response->assertStatus(403);
    }


    public function testErrorUpdateApiHoqu()
    {
        $user_tokens = json_decode(Storage::get('test_data/tokens_users.json'),TRUE);
        Mail::fake();


        //add data with api/store
        $data = [
            "instance" => "https://montepisanotree.org",
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
            "id_server" => '10',
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
            "id_server" => '10',
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
        $this->assertSame('montepisanotree.org',$ja['instance']);
        $this->assertSame(json_decode($response['parameters'],TRUE),json_decode($ja['parameters'],TRUE));
        $this->assertSame($data['parameters'],json_decode($ja['parameters'],TRUE));
        $this->assertSame($response['id'],$ja["id"]);
    }

    public function testCheckPositiveUE()
    {
        $user_tokens = json_decode(Storage::get('test_data/tokens_users.json'),TRUE);
        Mail::fake();

        //add data with api/store
        $data = [
            "instance" => "https://montepisanotree.org",
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
            "id_server" => '10',
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
            "id_server" => '10',
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
        $this->assertSame('montepisanotree.org',$ja['instance']);
        $this->assertSame(json_decode($response['parameters'],TRUE),json_decode($ja['parameters'],TRUE));
        $this->assertSame($data['parameters'],json_decode($ja['parameters'],TRUE));
        $this->assertSame($response['id'],$ja["id"]);
    }

    public function testCheckPositiveUE_with_error_log()
    {
        $user_tokens = json_decode(Storage::get('test_data/tokens_users.json'),TRUE);
        Mail::fake();

        //add data with api/store
        $data = [
            "instance" => "https://montepisanotree.org",
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
            "id_server" => '10',
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
            "id_server" => '10',
            "status" => "VDC",
            "log" => "log test",
            "error_log" => "error log test",
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
        $this->assertSame($requestSvr2['error_log'],$ja['error_log']);
        $this->assertSame($requestSvr2['id_server'],$ja['id_server']);
        $this->assertSame('montepisanotree.org',$ja['instance']);
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
