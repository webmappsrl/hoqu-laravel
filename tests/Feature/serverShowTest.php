<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use App\Models\Wm_Server;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class serverShowTest extends TestCase
{

    public function test_token_create_server_show_fail()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['update']
        );
        $response = $this->get('api/getServer/mbtiles_staging');
        $response->assertStatus(403);

        Sanctum::actingAs(
            User::factory()->create(),
            ['create']
        );
        $response = $this->get('api/getServer/mbtiles_staging');
        $response->assertStatus(403);

        Sanctum::actingAs(
            User::factory()->create(),
            ['delete']
        );
        $response = $this->get('api/getServer/mbtiles_staging');
        $response->assertStatus(403);

        Sanctum::actingAs(
            User::factory()->create(),
            ['read']
        );
        $response = $this->get('api/getServer/mbtiles_staging');
        $response->assertStatus(404);
    }

    public function test_token_create_server_show_read_data()
    {
        Wm_Server::truncate();
        Mail::fake();

        $data = [
            "instance" => "https://monterumenotree.org",
            "job" => "mptupdatepoi",
            "parameters" => ["a"=> "yes", "b"=> "no"]
        ];
        Sanctum::actingAs(
            User::factory()->create(),
            ['read','create','update']
        );
        //OPERATIONS 1
        $response = $this->post('/api/store',$data);

        $task_processing_id = $response['id'];

        $this->assertSame( Wm_Server::count(),0);

        $timeStore = strtotime($response['updated_at']);

        $requestSvr1 = [
            "id_server" => 'ServerForCyclando',
            "task_available" => ["task11","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
        ];


        $response = $this->put('/api/pull',$requestSvr1);

        $responseServer = $this->get('api/getServer/ServerForCyclando');
        $responseServer->assertStatus(200);
        $server_db = Wm_Server::where('server_id','ServerForCyclando')->get();

        $id = $server_db->pluck('id')[0];
        $this->assertSame($id,$responseServer['id']);

        $server_id = $server_db->pluck('server_id')[0];
        $this->assertSame($server_id,$responseServer['server_id']);

        $server_ip = $server_db->pluck('server_ip')[0];
        $this->assertSame($server_ip,$responseServer['server_ip']);

        $this->assertSame('Active',$responseServer['status']);


        $responseServer = $this->get('api/getServer/ServerNotFound');
        $responseServer->assertStatus(404);

        Task::where('id_server',$server_id)->delete();

        $responseServer = $this->get('api/getServer/ServerForCyclando');
        $responseServer->assertStatus(200);
        $server_db = Wm_Server::where('server_id','ServerForCyclando')->get();

        $id = $server_db->pluck('id')[0];
        $this->assertSame($id,$responseServer['id']);

        $server_id = $server_db->pluck('server_id')[0];
        $this->assertSame($server_id,$responseServer['server_id']);

        $server_ip = $server_db->pluck('server_ip')[0];
        $this->assertSame($server_ip,$responseServer['server_ip']);

        $this->assertSame('Idle',$responseServer['status']);

        $response = $this->post('/api/store',$data);
        $response = $this->put('/api/pull',$requestSvr1);


        $server = Wm_Server::find($id);

        $server->updated_at = date("Y-m-d", strtotime("-5 minute"));
        $server->save();

        $responseServer = $this->get('api/getServer/ServerForCyclando');
        $responseServer->assertStatus(200);
        $server_db = Wm_Server::where('server_id','ServerForCyclando')->get();

        $id = $server_db->pluck('id')[0];
        $this->assertSame($id,$responseServer['id']);

        $server_id = $server_db->pluck('server_id')[0];
        $this->assertSame($server_id,$responseServer['server_id']);

        $server_ip = $server_db->pluck('server_ip')[0];
        $this->assertSame($server_ip,$responseServer['server_ip']);

        $this->assertSame('Warning',$responseServer['status']);

        Task::where('id_server',$server_id)->delete();

        $responseServer = $this->get('api/getServer/ServerForCyclando');
        $responseServer->assertStatus(200);
        $server_db = Wm_Server::where('server_id','ServerForCyclando')->get();

        $id = $server_db->pluck('id')[0];
        $this->assertSame($id,$responseServer['id']);

        $server_id = $server_db->pluck('server_id')[0];
        $this->assertSame($server_id,$responseServer['server_id']);

        $server_ip = $server_db->pluck('server_ip')[0];
        $this->assertSame($server_ip,$responseServer['server_ip']);

        $this->assertSame('Turned off',$responseServer['status']);

    }
}
