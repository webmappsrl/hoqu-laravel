<?php

namespace Tests\Feature;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Tests\TestCase;
use App\Queue;
class updateTest extends TestCase
{
    //migrate tables before each test
    use RefreshDatabase;

    /**
     *UPDATE

        *UPDATE: è la chiamata che fa un server verso HOQU per comunicare L’avvenuto svolgimento del task. Il server invia l’ID del TASK assieme all’esito (“done”, “error”) e ad un LOG, invia anche l’id del server per verifica.

        *L’API recupera l’item in queues (verifica che sia in status process e che sia lo stesso server che ha preso i un carico il task, altrimenti manda un codice non autorizzato). In caso in cui ID non esiste manda il codice di non esistenza. Aggiorna lo stato dell’item con  status=done|error in base a quello che viene inviato dal server, inserisce anche il log inviato da server.

     *1. Clear DB, add queue (task1), srv1 chiama pull che restituisce id. srv2 chiama update dell’id di cui sopra. Verificare che status è non autorizzato
     */

    public function testNotAuthorizedIdSUpdateApiHoqu()
    {
        Queue::truncate();
        //add data with api/queues
        $data = [
            "instance" => "https:\/\/montepisanotree.org",
            "task" => "task1",
            "parameters" => ["a"=> "yes", "b"=> "no", "c" => "so and so", "d"=>"maybe"],
        ];
        $response = $this->post('api/queue/push',$data);
        //request that sends the "requesting server"
        $requestSvr1 = [
            "id_server" => 10,
            "taskAvailable" => ["task1","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
        ];
        //OPERATIONS 1
        $response = $this->put('api/queue/pull',$requestSvr1);
        $response ->assertStatus(200);
        //get value elaborate by pull
        $dataDbTest = $response;
        //request that sends the "requesting server 2"
        $requestSvr2 = [
            "id_server" => 25,
            "status" => "done",
            "log" => "log test",
            "idTask" => $dataDbTest['id'],
        ];
        //OPERATIONS 2
        $response = $this->put('api/queue/update',$requestSvr2);
        $dataDbTestUp = $response;
        $response ->assertForbidden();
    }

    /**
     * 2. Clear DB, add queue (task1) prendo ID del task. SRV1 chiama update con id del task. Verificare che status è non autorizzato.
     */

    public function testTaskNotAuthorizedUpdateApiHoqu()
    {
        Queue::truncate();
        //add data with api/queues
        $data = [
            "instance" => "https:\/\/montepisanotree.org",
            "task" => "task1",
            "parameters" => ["a"=> "yes", "b"=> "no", "c" => "so and so", "d"=>"maybe"],
        ];
        $response = $this->post('api/queue/push',$data);
        //request that sends the "requesting server"
        $requestSvr1 = [
            "id_server" => 10,
            "status" => "done",
            "log" => "log test",
            "idTask" => $response['id'],
        ];
        //OPERATIONS 2
        $response = $this->put('api/queue/update',$requestSvr1);
        $dataDbTestUp = $response;
        $response ->assertForbidden();
    }

    /**
     *3. Clear DB, add queue (task1), srv1 chiama pull che restituisce id. Srv1 chiama update con status in “done” e log “log test”. Verificare status UPDATE OK. Verificare da DB che la coda con ID abbia status in “done” e log “log test”
     */

    public function testDoneUpdateApiHoqu()
    {
        Queue::truncate();
        //add data with api/queues
        $data = [
            "instance" => "https:\/\/montepisanotree.org",
            "task" => "task1",
            "parameters" => ["a"=> "yes", "b"=> "no", "c" => "so and so", "d"=>["poi"=>02,"route"=>2345]],
        ];
        $response = $this->post('api/queue/push',$data);
        //request that sends the "requesting server"
        $requestSvr1 = [
            "id_server" => 10,
            "taskAvailable" => ["task1","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
        ];
        //OPERATIONS 1
        $response = $this->put('api/queue/pull',$requestSvr1);
        $response ->assertStatus(200);
        //get value elaborate by pull
        $dataDbTest = $response;
        //request that sends the "requesting server 2"
        $requestSvr1 = [
            "id_server" => 10,
            "status" => "done",
            "log" => "log test",
            "idTask" => $dataDbTest['id'],
        ];
        //OPERATIONS 2
        $response = $this->put('api/queue/update',$requestSvr1);
        //get value elaborated by update
        $ja = $this->get('api/queue/item/'.$response['id'])->json();
        $response ->assertStatus(200);
        $this->assertSame('done',$ja['process_status']);
        $this->assertSame($requestSvr1['log'],$ja['process_log']);
        $this->assertSame($requestSvr1['id_server'],$ja['id_server']);
        $this->assertSame($data['instance'],$ja['instance']);
        $this->assertSame($data['parameters'],$ja['parameters']);
        $this->assertSame($response['id'],$ja["id"]);
    }

    /**
     * 4. Clear DB, add queue (task1), srv1 chiama pull che restituisce id. Srv1 chiama update con status in “error” e log “log test”. Verificare status UPDATE OK. Verificare da DB che la coda con ID abbia status in “error” e log “log test”
     */
    public function testErrorUpdateApiHoqu()
    {
        Queue::truncate();
        //add data with api/queues
        $data = [
            "instance" => "https:\/\/montepisanotree.org",
            "task" => "task1",
            "parameters" => ["a"=> "yes", "b"=> "no", "c" => "so and so", "d"=>["poi"=>02,"route"=>2345]],
        ];
        $response = $this->post('api/queue/push',$data);
        //request that sends the "requesting server"
        $requestSvr1 = [
            "id_server" => 10,
            "taskAvailable" => ["task1","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
        ];
        //OPERATIONS 1
        $response = $this->put('api/queue/pull',$requestSvr1);
        $response ->assertStatus(200);
        //get value elaborate by pull
        $dataDbTest = $response;
        //request that sends the "requesting server 2"
        $requestSvr1 = [
            "id_server" => 10,
            "status" => "error",
            "log" => "log test",
            "idTask" => $dataDbTest['id'],
        ];
        //OPERATIONS 2
        $response = $this->put('api/queue/update',$requestSvr1);
        //get value elaborated by update
        $ja = $this->get('api/queue/item/'.$response['id'])->json();
        $response ->assertStatus(200);
        $this->assertSame('error',$ja['process_status']);
        $this->assertSame($requestSvr1['log'],$ja['process_log']);
        $this->assertSame($requestSvr1['id_server'],$ja['id_server']);
        $this->assertSame($data['instance'],$ja['instance']);
        $this->assertSame($data['parameters'],$ja['parameters']);
        $this->assertSame($response['id'],$ja["id"]);
    }

    public function testIdNotExistUpdateApiHoqu()
    {
        Queue::truncate();
        //add data with api/queues
        $data = [
            "instance" => "https:\/\/montepisanotree.org",
            "task" => "task1",
            "parameters" => ["a"=> "yes", "b"=> "no", "c" => "so and so", "d"=>["poi"=>02,"route"=>2345]],
        ];
        $response = $this->post('api/queue/push',$data);
        //request that sends the "requesting server"
        $requestSvr1 = [
            "id_server" => 10,
            "taskAvailable" => ["task1","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
        ];
        //OPERATIONS 1
        $response = $this->put('api/queue/pull',$requestSvr1);
        $response ->assertStatus(200);
        //get value elaborate by pull
        $dataDbTest = $response;
        //request that sends the "requesting server 2"
        $requestSvr1 = [
            "id_server" => 10,
            "taskAvailable" => ["task1","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
            "idTask" => 100,
        ];
        //OPERATIONS 2
        $response = $this->put('api/queue/update',$requestSvr1);
        //get value elaborated by update
        $dataDbTestUp = $response;
        $response ->assertForbidden();
    }

    public function testCheckValueStatusUpdateApiHoqu()
    {
        Queue::truncate();
        //add data with api/queues
        $data = [
            "instance" => "https:\/\/montepisanotree.org",
            "task" => "task1",
            "parameters" => ["a"=> "yes", "b"=> "no", "c" => "so and so", "d"=>["poi"=>02,"route"=>2345]],
        ];
        $response = $this->post('api/queue/push',$data);
        //request that sends the "requesting server"
        $requestSvr1 = [
            "id_server" => 10,
            "taskAvailable" => ["task1","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
        ];
        //OPERATIONS 1
        $response = $this->put('api/queue/pull',$requestSvr1);
        $response ->assertStatus(200);
        //get value elaborate by pull
        $dataDbTest = $response;
        //request that sends the "requesting server 2"
        $requestSvr1 = [
            "id_server" => 10,
            "status" => '',
            "log" => "log test",
            "idTask" => $dataDbTest['id'],
        ];
        //OPERATIONS 2
        $response = $this->put('api/queue/update',$requestSvr1);
        //get value elaborated by update
        $dataDbTestUp = $response;
        $response ->assertForbidden();
        //request that sends the "requesting server 2"
        $requestSvr1 = [
            "id_server" => 10,
            "status" => 'duplicate',
            "log" => "log test",
            "idTask" => $dataDbTest['id'],
        ];
        //OPERATIONS 2
        $response = $this->put('api/queue/update',$requestSvr1);
        //get value elaborated by update
        $dataDbTestUp = $response;
        $response ->assertForbidden();
        //request that sends the "requesting server 2"
        $requestSvr1 = [
            "id_server" => 10,
            "log" => "log test",
            "idTask" => $dataDbTest['id'],
        ];
        //OPERATIONS 2
        $response = $this->put('api/queue/update',$requestSvr1);
        $response ->assertForbidden();

    }




}
