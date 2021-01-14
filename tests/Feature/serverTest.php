<?php

namespace Tests\Feature;

use App\Http\Controllers\WmServerController;
use App\Models\Task;
use App\Models\User;
use App\Models\Wm_Server;
use App\Server;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class serverTest extends TestCase
{
    public function test_add_server_in_table_update_done()
    {
        Mail::fake();

        $data = [
            "instance" => "https://monterumenotree.org",
            "job" => "mptupdatepoi",
            "parameters" => ["a"=> "yes", "b"=> "no"]
        ];
        Sanctum::actingAs(
            User::factory()->create(),
            ['create','update']
        );
        //OPERATIONS 1
        $response = $this->post('/api/store',$data);

        $this->assertSame( Wm_Server::count(),0);

        $timeStore = strtotime($response['updated_at']);

        $requestSvr1 = [
            "id_server" => 'ServerForCyclando',
            "task_available" => ["task11","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
        ];
        sleep(2);

//        OPERATIONS
//        Check that server@webmapp.it access to api/
        $response = $this->put('/api/pull',$requestSvr1);

        //get value elaborate by pull
        $ja = Task::find($response['id']);
        $this->assertSame('processing',$ja['process_status']);
        //I check that the integer has become a string
        $this->assertSame(((string)$requestSvr1['id_server']),$ja['id_server']);
        $this->assertSame('127.0.0.1',$ja['ip_server']);
        $this->assertSame('monterumenotree.org',$ja['instance']);
        $this->assertSame($response['instance'],$ja['instance']);
        $this->assertSame($response['id'],$ja["id"]);
        $this->assertSame(json_decode($response['parameters'],TRUE),json_decode($ja['parameters'],TRUE));
        $this->assertSame($data['parameters'],json_decode($ja['parameters'],TRUE));

        //check update data field updated_at
        $timePull = strtotime($response['updated_at']);
        $this->assertGreaterThan( $timeStore,$timePull );

        //check store server
        $this->assertSame( Wm_Server::count(),1);
        $server = Wm_Server::where('server_id',$requestSvr1['id_server'])
            ->where('server_ip',$ja['ip_server'])->get();
        $this->assertSame( $server[0]['server_id'],'ServerForCyclando');

        $id_task = $response['id'];

        $requestSvr2 = [
            "id_server" => 'ServerForCyclando',
            "status" => "done",
            "log" => "log test",
            "id_task" => $id_task,
        ];

        sleep(2);

        $response = $this->put('/api/updateDone',$requestSvr2);

        $ja = Task::find($response['id']);
        $response ->assertStatus(200);

        $response ->assertStatus(200);
        $this->assertSame('done',$ja['process_status']);
        $this->assertSame($requestSvr2['log'],$ja['process_log']);
        $this->assertSame($requestSvr2['id_server'],$ja['id_server']);
        $this->assertSame('monterumenotree.org',$ja['instance']);
        $this->assertSame(json_decode($response['parameters'],TRUE),json_decode($ja['parameters'],TRUE));
        $this->assertSame($data['parameters'],json_decode($ja['parameters'],TRUE));
        $this->assertSame($response['id'],$ja["id"]);

        //check update data field updated_at
        $timeUpdateDone = strtotime($response['updated_at']);
        $this->assertGreaterThan( $timePull,$timeUpdateDone );




    }

    public function test_add_server_in_table_update_error()
    {
        Mail::fake();

        $data = [
            "instance" => "https://monterumenotree.org",
            "job" => "mptupdatepoi",
            "parameters" => ["a"=> "yes", "b"=> "no"]
        ];
        Sanctum::actingAs(
            User::factory()->create(),
            ['create','update']
        );
        //OPERATIONS 1
        $response = $this->post('/api/store',$data);

        $this->assertSame( Wm_Server::count(),0);

        $timeStore = strtotime($response['updated_at']);

        $requestSvr1 = [
            "id_server" => 'ServerForCyclando',
            "task_available" => ["task11","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
        ];
        sleep(2);

//        OPERATIONS
//        Check that server@webmapp.it access to api/
        $response = $this->put('/api/pull',$requestSvr1);

        //get value elaborate by pull
        $ja = Task::find($response['id']);
        $this->assertSame('processing',$ja['process_status']);
        //I check that the integer has become a string
        $this->assertSame(((string)$requestSvr1['id_server']),$ja['id_server']);
        $this->assertSame('127.0.0.1',$ja['ip_server']);
        $this->assertSame('monterumenotree.org',$ja['instance']);
        $this->assertSame($response['instance'],$ja['instance']);
        $this->assertSame($response['id'],$ja["id"]);
        $this->assertSame(json_decode($response['parameters'],TRUE),json_decode($ja['parameters'],TRUE));
        $this->assertSame($data['parameters'],json_decode($ja['parameters'],TRUE));

        //check update data field updated_at
        $timePull = strtotime($response['updated_at']);
        $this->assertGreaterThan( $timeStore,$timePull );

        //check store server
        $this->assertSame( Wm_Server::count(),1);
        $server = Wm_Server::where('server_id',$requestSvr1['id_server'])
            ->where('server_ip',$ja['ip_server'])->get();
        $this->assertSame( $server[0]['server_id'],'ServerForCyclando');

        $id_task = $response['id'];

        $requestSvr2 = [
            "id_server" => 'ServerForCyclando',
            "status" => "",
            "log" => "log test",
            "id_task" => $id_task,
        ];

        sleep(2);

        $response = $this->put('/api/updateError',$requestSvr2);

        $ja = Task::find($response['id']);
        $response ->assertStatus(200);

        $response ->assertStatus(200);
        $this->assertSame('error',$ja['process_status']);
        $this->assertSame($requestSvr2['log'],$ja['process_log']);
        $this->assertSame($requestSvr2['id_server'],$ja['id_server']);
        $this->assertSame('monterumenotree.org',$ja['instance']);
        $this->assertSame(json_decode($response['parameters'],TRUE),json_decode($ja['parameters'],TRUE));
        $this->assertSame($data['parameters'],json_decode($ja['parameters'],TRUE));
        $this->assertSame($response['id'],$ja["id"]);

        //check update data field updated_at
        $timeUpdateError = strtotime($response['updated_at']);
        $this->assertGreaterThan( $timePull,$timeUpdateError );
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh --seed');
    }
}
