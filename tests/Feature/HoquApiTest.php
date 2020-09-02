<?php

namespace Tests\Feature;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Tests\TestCase;
use App\Queue;

class HoquApiTest extends TestCase
{
    //migrate tables before each test
    use RefreshDatabase;
    
    

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testHoquIndex()
    {
        Queue::truncate();

        $response = $this->get('/api/queues');

        $response->assertStatus(200);

        $response->assertJson([]);
    }

    public function testAddApiHoqu()
    {
        Queue::truncate();

        $data = [
            "instance" => "https:\/\/montepisanotree.org",
            "task" => "mptupdatepoi",
            "parameters" => "prova",
        ];

        $response = $this->post('/api/queues',$data);

        $response ->assertStatus(201);

        $response->assertJson($data);

        $response = $this->get('/api/queues');

        $response ->assertStatus(200);

        $dataDbTest = $response->json();

     //   $this->assertSame($dataDbTest[0]['instance'],$data['instance']);
        $this->assertSame($dataDbTest[0]['task'],$data['task']);
        $this->assertSame($dataDbTest[0]['parameters'],$data['parameters']);
        $this->assertSame($dataDbTest[0]['process_status'],'new');

        $this->assertSame(count($dataDbTest),1);


        $response = $this->post('/api/queues',$data);

        $response = $this->post('/api/queues',$data);

        $response = $this->post('/api/queues',$data);

        $response = $this->post('/api/queues',$data);

        $response = $this->post('/api/queues',$data);

        $dataDbTest = $response->json();

        $this->assertSame(count($dataDbTest),6);

    } 

    /*
    1. CLEAR DB Aggiungo con add un item, con pull lo recupero mettendo lo stesso task con cui ho inserito add. Verifico che la risposta sia un json con item con status in processing. Stato di uscita è 200. Verifico che instance sia uguale a quella che ha richiesto add, che parameters sia lo stesso che ha richiesto add
    */
    public function test1PullApiHoqu()
    {
        Queue::truncate();

        //1 TEST TDD

        //add data with api/queues
        $data = [
            "instance" => "https:\/\/montepisanotree.org",
            "task" => "mptupdatepoi",
            "parameters" => "prova",
        ];

        $response = $this->post('/api/queues',$data);

        //request that sends the "requesting server"
        $requestSvr1 = [
            "idServer" => 10,
            "taskAvailable" => ["mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
        ];

        //OPERATIONS
        $response = $this->put('/api/queuesPull',$requestSvr1);
        
        $response ->assertStatus(200);

        //get value elaborated by pull
        $dataDbTest = $response;

        $this->assertSame('processing',$dataDbTest['process_status']);

        $this->assertSame($requestSvr1['idServer'],$dataDbTest['idServer']);

        $this->assertSame($data['instance'],$dataDbTest['instance']);

        $this->assertSame($data['parameters'],$dataDbTest['parameters']);

    }

    /**
     * 2. CLEAR DB Aggiungo con add un item con task “task1”, con pul richiedo task “task2”. Il json di risposta deve essere vuoto (con 204 non necessario questo controllo). Lo status HTTP deve essere 204(204 No Content)
     */

    public function test2PullApiHoqu()
    {
        Queue::truncate();

        //2 TEST TDD

        //add data with api/queues
        $data = [
            "instance" => "https:\/\/montepisanotree.org",
            "task" => "task1",
            "parameters" => "prova prova",
        ];

        $response = $this->post('/api/queues',$data);

        //request that sends the "requesting server"
        $requestSvr1 = [
            "idServer" => 9,
            "taskAvailable" => ["mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
        ];

        //OPERATIONS
        $response = $this->put('/api/queuesPull',$requestSvr1);
        
        //check response 204
        $response ->assertNoContent($status = 204);
        //$response ->assertJson([]);
    }

    /**
     * 3. CLERA DB. Aggiungo 2 item a distanza di 2 secondi (sleep (sec)) con task “task1”. Faccio la chiamata PULL con task “task1”. Verifico che la chiamata PULL prenda il primo e non il secondo.
     */

    public function test3PullApiHoqu()
    {
        Queue::truncate();

        //3 TEST TDD

        //add data with api/queues
        $data = [
            "instance" => "https:\/\/montepisanotree.org",
            "task" => "task1",
            "parameters" => "prova prova",
        ];

        $response = $this->post('/api/queues',$data);

        sleep(2);

        $data1 = [
            "instance" => "https:\/\/montelabronicotree.org",
            "task" => "task1",
            "parameters" => "prova",
        ];

        $response = $this->post('/api/queues',$data1);

        //request that sends the "requesting server"
        $requestSvr1 = [
            "idServer" => 9,
            "taskAvailable" => ["task1","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
        ];

        //OPERATIONS
        $response = $this->put('/api/queuesPull',$requestSvr1);
        
        //check response 200
        //$response ->assertCreated();
        $response ->assertStatus(200);

        //get value elaborate by pull
        $dataDbTest = $response;

        //var_dump($dataDbTest);

        //check field process_status == processing
        $this->assertSame('processing',$dataDbTest['process_status']);

        //check idServer
        $this->assertSame($requestSvr1['idServer'],$dataDbTest['idServer']);

        //check instance
        $this->assertSame($data['instance'],$dataDbTest['instance']);

        //check parameters
        $this->assertSame($data['parameters'],$dataDbTest['parameters']);

        //check parameters
        $this->assertSame(1,$dataDbTest["id"]);
        //$response2 = $this->get('/api/queues');
        //var_dump($response2);
        

    }

    /**
     *1. Clear DB, add queue (task1), srv1 chiama pull che restituisce id. srv2 chiama update dell’id di cui sopra. Verificare che status è non autorizzato
     */

    public function test1UpdateApiHoqu()
    {
        Queue::truncate();

        //1 TEST TDD

        //add data with api/queues
        $data = [
            "instance" => "https:\/\/montepisanotree.org",
            "task" => "task1",
            "parameters" => "prova",
        ];

        $response = $this->post('/api/queues',$data);

        //request that sends the "requesting server"
        $requestSvr1 = [
            "idServer" => 10,
            "taskAvailable" => ["task1","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
        ];

        //OPERATIONS 1
        $response = $this->put('/api/queuesPull',$requestSvr1);
        
        $response ->assertStatus(200);

        //get value elaborate by pull
        $dataDbTest = $response;

        //request that sends the "requesting server 2"
        $requestSvr2 = [
            "idServer" => 25,
            "taskAvailable" => ["task1","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi","mptinsertpoi", "mptinserttrack"],
            "idTask" => $dataDbTest['id'],
        ];

        //OPERATIONS 2
        $response = $this->put('/api/queuesUpdate',$requestSvr2);

        $dataDbTestUp = $response;

       // var_dump($dataDbTestUp['error']);

        $response ->assertForbidden();
    }

    /**
     * 2. Clear DB, add queue (task1) prendo ID del task. SRV1 chiama update con id del task. Verificare che status è non autorizzato.
     */

    public function test2UpdateApiHoqu()
    {
        Queue::truncate();

        //2 TEST TDD

        //add data with api/queues
        $data = [
            "instance" => "https:\/\/montepisanotree.org",
            "task" => "task1",
            "parameters" => "prova",
        ];

        $response = $this->post('/api/queues',$data);

        //request that sends the "requesting server"
        $requestSvr1 = [
            "idServer" => 10,
            "taskAvailable" => ["task1","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
            "idTask" => $response['id'],
        ];

        //OPERATIONS 2
        $response = $this->put('/api/queuesUpdate',$requestSvr1);

        $dataDbTestUp = $response;

       // var_dump($dataDbTestUp['error']);

        $response ->assertForbidden();
    }

    /**
     *3. Clear DB, add queue (task1), srv1 chiama pull che restituisce id. Srv1 chiama update con status in “done” e log “log test”. Verificare status UPDATE OK. Verificare da DB che la coda con ID abbia status in “done” e log “log test”
     */

    public function test3UpdateApiHoqu()
    {
        Queue::truncate();

        //1 TEST TDD

        //add data with api/queues
        $data = [
            "instance" => "https:\/\/montepisanotree.org",
            "task" => "task1",
            "parameters" => "prova",
        ];

        $response = $this->post('/api/queues',$data);

        //request that sends the "requesting server"
        $requestSvr1 = [
            "idServer" => 10,
            "taskAvailable" => ["task1","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
        ];

        //OPERATIONS 1
        $response = $this->put('/api/queuesPull',$requestSvr1);
        
        $response ->assertStatus(200);

        //get value elaborate by pull
        $dataDbTest = $response;

        //request that sends the "requesting server 2"
        $requestSvr1 = [
            "idServer" => 10,
            "taskAvailable" => ["task1","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
            "idTask" => $dataDbTest['id'],
        ];

        //OPERATIONS 2
        $response = $this->put('/api/queuesUpdate',$requestSvr1);

        //get value elaborated by update
        $dataDbTestUp = $response;

        $response ->assertStatus(200);


        $this->assertSame('done',$dataDbTestUp['process_status']);

        $this->assertSame($requestSvr1['idServer'],$dataDbTestUp['idServer']);

        $this->assertSame($data['instance'],$dataDbTestUp['instance']);

        $this->assertSame($data['parameters'],$dataDbTestUp['parameters']);

        $this->assertSame(1,$dataDbTestUp["id"]);


    }

    /**
     * 4. Clear DB, add queue (task1), srv1 chiama pull che restituisce id. Srv1 chiama update con status in “error” e log “log test”. Verificare status UPDATE OK. Verificare da DB che la coda con ID abbia status in “error” e log “log test”
     */
    public function test4UpdateApiHoqu()
    {
        Queue::truncate();

        //1 TEST TDD

        //add data with api/queues
        $data = [
            "instance" => "https:\/\/montepisanotree.org",
            "task" => "task1",
            "parameters" => "prova",
        ];

        $response = $this->post('/api/queues',$data);

        //request that sends the "requesting server"
        $requestSvr1 = [
            "idServer" => 10,
            "taskAvailable" => ["task1","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
        ];

        //OPERATIONS 1
        $response = $this->put('/api/queuesPull',$requestSvr1);
        
        $response ->assertStatus(200);

        //get value elaborate by pull
        $dataDbTest = $response;

        //request that sends the "requesting server 2"
        $requestSvr1 = [
            "idServer" => 10,
            "taskAvailable" => ["task1","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
            "idTask" => $dataDbTest['id'],
        ];

        $changeStatus = Queue::find(1);
        $changeStatus->process_status = 'error';
        $changeStatus->save(); 


        //OPERATIONS 2
        $response = $this->put('/api/queuesUpdate',$requestSvr1);

        //get value elaborated by update
        $dataDbTestUp = $response;

        $response ->assertStatus(200);


        $this->assertSame('done',$dataDbTestUp['process_status']);

        $this->assertSame($requestSvr1['idServer'],$dataDbTestUp['idServer']);

        $this->assertSame($data['instance'],$dataDbTestUp['instance']);

        $this->assertSame($data['parameters'],$dataDbTestUp['parameters']);

        $this->assertSame(1,$dataDbTestUp["id"]);

    }

    public function testIdNotExistUpdateApiHoqu()
    {
        //add data with api/queues
        $data = [
            "instance" => "https:\/\/montepisanotree.org",
            "task" => "task1",
            "parameters" => "prova",
        ];

        $response = $this->post('/api/queues',$data);

        //request that sends the "requesting server"
        $requestSvr1 = [
            "idServer" => 10,
            "taskAvailable" => ["task1","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
        ];

        //OPERATIONS 1
        $response = $this->put('/api/queuesPull',$requestSvr1);
        
        $response ->assertStatus(200);

        //get value elaborate by pull
        $dataDbTest = $response;

        //request that sends the "requesting server 2"
        $requestSvr1 = [
            "idServer" => 10,
            "taskAvailable" => ["task1","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
            "idTask" => 100,
        ];

        //OPERATIONS 2
        $response = $this->put('/api/queuesUpdate',$requestSvr1);

        //get value elaborated by update
        $dataDbTestUp = $response;

        $response ->assertForbidden();

    }

    
}
