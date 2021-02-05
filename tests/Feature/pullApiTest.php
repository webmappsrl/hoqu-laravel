<?php

namespace Tests\Feature;

use App\Models\DuplicateTask;
use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Request;


use Tests\TestCase;

class pullApiTest extends TestCase
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
    public function testFineFirstElementPullApiHoqu()
    {
        $user_tokens = json_decode(Storage::get('test_data/tokens_users.json'),TRUE);

        //add data with api/store
        $data = [
            "instance" => "https://montepisqanotree.org",
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
            "instance" => "https://montelabronicotree.org",
            "job" => "task1",
            "parameters" => ["a"=> "yes", "b"=> "no", "c" => "boh"],
        ];

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$user_tokens['instance@webmapp.it']
        ])->post('/api/store',$data1);
        $response->assertStatus(201);
        $requestSvr1 = [
            "id_server" => 'webmapp_server_staging_all_nombtiles',
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
        //comparison server_id string with that on the DB
        $this->assertSame($requestSvr1['id_server'],$ja['id_server']);
        $this->assertSame('montepisqanotree.org',$ja['instance']);
        $this->assertSame($response['instance'],$ja['instance']);
        $this->assertSame($response['id'],$ja["id"]);
        $this->assertSame(json_decode($response['parameters'],TRUE),json_decode($ja['parameters'],TRUE));
        $this->assertSame($data['parameters'],json_decode($ja['parameters'],TRUE));

    }

    public function testTaskNoMatchPullApiHoqu()
    {
        // DuplicateTask::truncate();
        // Task::truncate();

        $user_tokens = json_decode(Storage::get('test_data/tokens_users.json'),TRUE);

        //add data with api/store
        $data = [
            "instance" => "https://molntepisanotree.org",
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
            "id_server" => 'webmapp_server_staging_all_nombtiles',
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




    public function testFineFirstElementPullIntegerApiHoqu()
    {
        $user_tokens = json_decode(Storage::get('test_data/tokens_users.json'),TRUE);

        //add data with api/store
        $data = [
            "instance" => "https://mdontepisanotree.org",
            "job" => "task11",
            "parameters" => ["a"=> "yes", "b"=> "no", "c" => "boh"],
        ];

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$user_tokens['instance@webmapp.it'],
        ])->post('/api/store',$data);
        $response->assertStatus(201);
        sleep(2);

        $requestSvr1 = [
            "id_server" => 999,
            "task_available" => ["task11","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
        ];

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
        //I check that the integer has become a string
        $this->assertSame(((string)$requestSvr1['id_server']),$ja['id_server']);
        $this->assertSame('127.0.0.1',$ja['ip_server']);
        $this->assertSame('mdontepisanotree.org',$ja['instance']);
        $this->assertSame($response['instance'],$ja['instance']);
        $this->assertSame($response['id'],$ja["id"]);
        $this->assertSame(json_decode($response['parameters'],TRUE),json_decode($ja['parameters'],TRUE));
        $this->assertSame($data['parameters'],json_decode($ja['parameters'],TRUE));
    }

    public function test_pull_filter_accept_instances()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['create']
        );

        //add data with api/store
        $data = [
            "instance" => "https://mdontepisanotree.org",
            "job" => "task11",
            "parameters" => ["a"=> "yes", "b"=> "no", "c" => "boh"],
        ];

        $response = $this->post('/api/store',$data);

        $response->assertStatus(201);

        sleep(2);

        $data1 = [
            "instance" => "https://romagnatree.org",
            "job" => "task11",
            "parameters" => ["a"=> "yes", "b"=> "no", "c" => "boh"],
        ];

        $response = $this->post('/api/store',$data1);

        $response->assertStatus(201);

        sleep(2);

        $requestSvr1 = [
            "id_server" => 999,
            "task_available" => ["task11","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
            "accept_instances" => ["mdontepisanotree.org","romagnatree.org"]
        ];

        Sanctum::actingAs(
            User::factory()->create(),
            ['update']
        );

        //OPERATIONS
        // Check that server@webmapp.it access to api/
        $response = $this->put('/api/pull',$requestSvr1);

        $response->assertStatus(200);
        //get value elaborate by pull
        $ja = Task::find($response['id']);
        $this->assertSame('processing',$ja['process_status']);
        //I check that the integer has become a string
        $this->assertSame(((string)$requestSvr1['id_server']),$ja['id_server']);
        $this->assertSame('127.0.0.1',$ja['ip_server']);
        $this->assertSame('mdontepisanotree.org',$ja['instance']);
        $this->assertSame($response['instance'],$ja['instance']);
        $this->assertSame($response['id'],$ja["id"]);
        $this->assertSame(json_decode($response['parameters'],TRUE),json_decode($ja['parameters'],TRUE));
        $this->assertSame($data['parameters'],json_decode($ja['parameters'],TRUE));

        $response = $this->put('/api/pull',$requestSvr1);

        $response->assertStatus(200);
        //get value elaborate by pull
        $ja = Task::find($response['id']);
        $this->assertSame('processing',$ja['process_status']);
        //I check that the integer has become a string
        $this->assertSame(((string)$requestSvr1['id_server']),$ja['id_server']);
        $this->assertSame('127.0.0.1',$ja['ip_server']);
        $this->assertSame('romagnatree.org',$ja['instance']);
        $this->assertSame($response['instance'],$ja['instance']);
        $this->assertSame($response['id'],$ja["id"]);
        $this->assertSame(json_decode($response['parameters'],TRUE),json_decode($ja['parameters'],TRUE));
        $this->assertSame($data['parameters'],json_decode($ja['parameters'],TRUE));
    }

    public function test_pull_filter_exclude_instances()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['create']
        );

        //add data with api/store
        $data = [
            "instance" => "https://mdontepisanotree.org",
            "job" => "task11",
            "parameters" => ["a"=> "yes", "b"=> "no", "c" => "boh"],
        ];

        $response = $this->post('/api/store',$data);

        $response->assertStatus(201);

        sleep(2);

        $data1 = [
            "instance" => "https://romagnatree.org",
            "job" => "task11",
            "parameters" => ["a"=> "yes", "b"=> "no", "c" => "boh"],
        ];

        $response = $this->post('/api/store',$data1);

        $response->assertStatus(201);

        sleep(2);

        $requestSvr1 = [
            "id_server" => 999,
            "task_available" => ["task11","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
            "exclude_instances" => ["romagnatree.org"]
        ];

        Sanctum::actingAs(
            User::factory()->create(),
            ['update']
        );

        //OPERATIONS
        // Check that server@webmapp.it access to api/
        $response = $this->put('/api/pull',$requestSvr1);

        $response->assertStatus(200);
        //get value elaborate by pull
        $ja = Task::find($response['id']);
        $this->assertSame('processing',$ja['process_status']);
        //I check that the integer has become a string
        $this->assertSame(((string)$requestSvr1['id_server']),$ja['id_server']);
        $this->assertSame('127.0.0.1',$ja['ip_server']);
        $this->assertSame('mdontepisanotree.org',$ja['instance']);
        $this->assertSame($response['instance'],$ja['instance']);
        $this->assertSame($response['id'],$ja["id"]);
        $this->assertSame(json_decode($response['parameters'],TRUE),json_decode($ja['parameters'],TRUE));
        $this->assertSame($data['parameters'],json_decode($ja['parameters'],TRUE));

        $response = $this->put('/api/pull',$requestSvr1);

        $response->assertStatus(204);

    }

    public function test_pull_filter_exclude_instances_and_accept_instances()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['create']
        );

        //add data with api/store
        $data = [
            "instance" => "https://mdontepisanotree.org",
            "job" => "task11",
            "parameters" => ["a"=> "yes", "b"=> "no", "c" => "boh"],
        ];

        $response = $this->post('/api/store',$data);

        $response->assertStatus(201);

        sleep(2);

        $data1 = [
            "instance" => "https://romagnatree.org",
            "job" => "task11",
            "parameters" => ["a"=> "yes", "b"=> "no", "c" => "boh"],
        ];

        $response = $this->post('/api/store',$data1);

        $response->assertStatus(201);

        sleep(2);

        $requestSvr1 = [
            "id_server" => 999,
            "task_available" => ["task11","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
            "exclude_instances" => ["romagnatree.org"],
            "accept_instances" => ["mdontepisanotree.org"]
        ];

        Sanctum::actingAs(
            User::factory()->create(),
            ['update']
        );

        //OPERATIONS
        // Check that server@webmapp.it access to api/
        $response = $this->put('/api/pull',$requestSvr1);

        $response->assertStatus(200);
        //get value elaborate by pull
        $ja = Task::find($response['id']);
        $this->assertSame('processing',$ja['process_status']);
        //I check that the integer has become a string
        $this->assertSame(((string)$requestSvr1['id_server']),$ja['id_server']);
        $this->assertSame('127.0.0.1',$ja['ip_server']);
        $this->assertSame('mdontepisanotree.org',$ja['instance']);
        $this->assertSame($response['instance'],$ja['instance']);
        $this->assertSame($response['id'],$ja["id"]);
        $this->assertSame(json_decode($response['parameters'],TRUE),json_decode($ja['parameters'],TRUE));
        $this->assertSame($data['parameters'],json_decode($ja['parameters'],TRUE));

        $response = $this->put('/api/pull',$requestSvr1);

        $response->assertStatus(204);

    }


    public function testStressPull()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['update']
        );

        $requestSvr1 = [
            "id_server" => 'webmapp_server_staging_all_nombtiles',
            "task_available" => ["mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"]
        ];

        for($i = 0;$i<1000;$i++)
        {
            $response = $this->put('/api/pull',$requestSvr1);
            $response->assertStatus(204);
        }

    }

    public function test_no_id_server_pull()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['create']
        );

        //add data with api/store
        $data = [
            "instance" => "https://mdontepisanotree.org",
            "job" => "task11",
            "parameters" => ["a"=> "yes", "b"=> "no", "c" => "boh"],
        ];

        $response = $this->post('/api/store',$data);

        $response->assertStatus(201);

        sleep(2);

        $data1 = [
            "instance" => "https://romagnatree.org",
            "job" => "task11",
            "parameters" => ["a"=> "yes", "b"=> "no", "c" => "boh"],
        ];

        $response = $this->post('/api/store',$data1);

        $response->assertStatus(201);

        sleep(2);

        $requestSvr1 = [

            "task_available" => ["task11","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
            "exclude_instances" => ["romage.org"],
            "accept_instances" => ["mde.org"]
        ];

        Sanctum::actingAs(
            User::factory()->create(),
            ['update']
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->put('/api/pull',$requestSvr1);

        $response->assertStatus(400);
    }

    public function test_no_task_available_pull()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['create']
        );

        //add data with api/store
        $data = [
            "instance" => "https://mdontepisanotree.org",
            "job" => "task11",
            "parameters" => ["a"=> "yes", "b"=> "no", "c" => "boh"],
        ];

        $response = $this->post('/api/store',$data);

        $response->assertStatus(201);

        sleep(2);

        $data1 = [
            "instance" => "https://romagnatree.org",
            "job" => "task11",
            "parameters" => ["a"=> "yes", "b"=> "no", "c" => "boh"],
        ];

        $response = $this->post('/api/store',$data1);

        $response->assertStatus(201);

        sleep(2);

        $requestSvr1 = [

            "id_server" => 999,
        ];

        Sanctum::actingAs(
            User::factory()->create(),
            ['update']
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->put('/api/pull',$requestSvr1);

        $response->assertStatus(400);
    }

    public function test_no_array_accept_instances_and_exclude_instances_pull()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['create']
        );

        //add data with api/store
        $data = [
            "instance" => "https://mdontepisanotree.org",
            "job" => "task11",
            "parameters" => ["a"=> "yes", "b"=> "no", "c" => "boh"],
        ];

        $response = $this->post('/api/store',$data);

        $response->assertStatus(201);

        sleep(2);

        $data1 = [
            "instance" => "https://romagnatree.org",
            "job" => "task11",
            "parameters" => ["a"=> "yes", "b"=> "no", "c" => "boh"],
        ];

        $response = $this->post('/api/store',$data1);

        $response->assertStatus(201);

        sleep(2);

        $requestSvr1 = [
            "id_server" => 999,
            "task_available" => ["task11","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
            "exclude_instances" => ["romagnatree.org"],
            "accept_instances" => 1
        ];

        Sanctum::actingAs(
            User::factory()->create(),
            ['update']
        );

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->put('/api/pull',$requestSvr1);

        $response->assertStatus(400);

        $requestSvr1 = [
            "id_server" => 999,
            "task_available" => ["task11","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
            "exclude_instances" => 1,
            "accept_instances" => ["romagnatree.org"]
        ];

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->put('/api/pull',$requestSvr1);

        $response->assertStatus(400);

        $requestSvr1 = [
            "id_server" => 999,
            "task_available" => ["task11","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
            "exclude_instances" => 'nedo',
            "accept_instances" => ["romagnatree.org"]
        ];

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->put('/api/pull',$requestSvr1);

        $response->assertStatus(400);

        $requestSvr1 = [
            "id_server" => 999,
            "task_available" => ["task11","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
            "exclude_instances" => ["romagnatree.org"],
            "accept_instances" => 'imstring'
        ];

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->put('/api/pull',$requestSvr1);

        $response->assertStatus(400);
    }

    public function test_double_pull()
    {

        Schema::disableForeignKeyConstraints();
        Task::truncate();
        DuplicateTask::truncate();
        Schema::enableForeignKeyConstraints();

        Sanctum::actingAs(
            User::factory()->create(),
            ['create']
        );

        //add data with api/store
        $data = [
            "instance" => "https://mdontepisanotree.org",
            "job" => "task11",
            "parameters" => ["a"=> "yes", "b"=> "no", "c" => "boh"],
        ];

        $response = $this->post('/api/store',$data);

        $response->assertStatus(201);



        $requestSvr1 = [
            "id_server" => "all_server",
            "task_available" => ["task11","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
            "exclude_instances" => ["romagnatree.org"]
        ];

        $requestSvr2 = [
            "id_server" => "cyclando",
            "task_available" => ["task11","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
            "exclude_instances" => ["romagnatree.org"]
        ];

        Sanctum::actingAs(
            User::factory()->create(),
            ['update']
        );

        //OPERATIONS
        // Check that server@webmapp.it access to api/
        $response = $this->put('/api/pull',$requestSvr1);
        $response1 = $this->put('/api/pull',$requestSvr2);

        $response->assertStatus(200);
        $response1->assertStatus(204);

//        //get value elaborate by pull
//        $ja = Task::find($response['id']);
//        $this->assertSame('processing',$ja['process_status']);
//        //I check that the integer has become a string
//        $this->assertSame(((string)$requestSvr1['id_server']),$ja['id_server']);
//        $this->assertSame('127.0.0.1',$ja['ip_server']);
//        $this->assertSame('mdontepisanotree.org',$ja['instance']);
//        $this->assertSame($response['instance'],$ja['instance']);
//        $this->assertSame($response['id'],$ja["id"]);
//        $this->assertSame(json_decode($response['parameters'],TRUE),json_decode($ja['parameters'],TRUE));
//        $this->assertSame($data['parameters'],json_decode($ja['parameters'],TRUE));


    }

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh --seed');
    }

}
