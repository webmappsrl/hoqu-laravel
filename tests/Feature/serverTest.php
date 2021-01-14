<?php

namespace Tests\Feature;

use App\Http\Controllers\WmServerController;
use App\Models\Task;
use App\Models\User;
use App\Server;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class serverTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_add_server_in_table()
    {
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



        $requestSvr1 = [
            "id_server" => 999,
            "task_available" => ["task11","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
            'ip_server' => '111.1111.111'
        ];

//
//        OPERATIONS
//         Check that server@webmapp.it access to api/
        $response = $this->put('/api/pull',$requestSvr1);
//        dd($response);

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
}
