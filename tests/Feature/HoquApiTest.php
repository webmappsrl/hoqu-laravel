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

        $response = $this->get('/api');

        $response->assertStatus(200);

        $response->assertJson([]);
    }

    public function testAddApiHoqu()
    {
        Queue::truncate();


        $data = [
            "instance" => "https://montepisanotree.org",
            "task" => "mptupdatepoi",
            "parameters" => ["a"=> "yes", "b"=> "no"]
        ];


        $response = $this->post('/api',$data);

        $response ->assertStatus(201);

        $response->assertJson($data);

        $response = $this->get('/api');

        $response ->assertStatus(200);

        $dataDbTest = $response->json();

        $this->assertSame($dataDbTest[0]['instance'],$data['instance']);
        $this->assertSame($dataDbTest[0]['task'],$data['task']);
        $this->assertSame(json_decode($dataDbTest[0]['parameters'],true),$data['parameters']);
        $this->assertSame($dataDbTest[0]['process_status'],'new');

        $this->assertSame(count($dataDbTest),1);


        $response = $this->post('/api',$data);

        $response = $this->post('/api',$data);

        $response = $this->post('/api',$data);

        $response = $this->post('/api',$data);

        $response = $this->post('/api',$data);

        $dataDbTest = $response->json();

        $this->assertSame(count($dataDbTest),6);

    } 

    /*
    Recupera il primo item di queues processabile di una richiesta di un server. Cambia lo stato in “processing” aggiunge id del server all’item e restituisce il json dell’item che deve essere processato.

    Processabile: è il primo item in ordine temporale secondo logica FIFO che abbia nel campo task uno della lista inviata dal server


    JSON di richiesta:

    - lista dei task (array con lista dei nomi)
    - server ID

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
            "parameters" => ["a"=> "yes", "b"=> "no"],
        ];

        $response = $this->post('/api',$data);

        //request that sends the "requesting server"
        $requestSvr1 = [
            "id_server" => 10,
            "taskAvailable" => ["mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
        ];

        //OPERATIONS
        $response = $this->put('/api/pull',$requestSvr1);
        
        $response ->assertStatus(200);

        //get value elaborated by pull
        $dataDbTest = $response;

        $this->assertSame('processing',$dataDbTest['process_status']);

        $this->assertSame($requestSvr1['id_server'],$dataDbTest['id_server']);

        $this->assertSame($data['instance'],$dataDbTest['instance']);
        
        $this->assertSame($data['parameters'],json_decode(json_encode($dataDbTest['parameters']),true));

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

        $response = $this->post('/api',$data);

        //request that sends the "requesting server"
        $requestSvr1 = [
            "id_server" => 9,
            "taskAvailable" => ["mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
        ];

        //OPERATIONS
        $response = $this->put('/api/pull',$requestSvr1);
        
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
            "parameters" => ["a"=> "yes", "b"=> "no", "c" => "boh"],
        ];

        $response = $this->post('/api',$data);

        sleep(2);

        $data1 = [
            "instance" => "https:\/\/montelabronicotree.org",
            "task" => "task1",
            "parameters" => "prova",
        ];

        $response = $this->post('/api',$data1);

        //request that sends the "requesting server"
        $requestSvr1 = [
            "id_server" => 9,
            "taskAvailable" => ["task1","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
        ];

        //OPERATIONS
        $response = $this->put('/api/pull',$requestSvr1);
        
        //check response 200
        //$response ->assertCreated();
        $response ->assertStatus(200);

        //get value elaborate by pull
        $dataDbTest = $response;

        //var_dump($dataDbTest);

        //check field process_status == processing
        $this->assertSame('processing',$dataDbTest['process_status']);

        //check id_server
        $this->assertSame($requestSvr1['id_server'],$dataDbTest['id_server']);

        //check instance
        $this->assertSame($data['instance'],$dataDbTest['instance']);

        //check parameters
        $this->assertSame($data['parameters'],json_decode(json_encode($dataDbTest['parameters']),true));

        //check parameters
        $this->assertSame(1,$dataDbTest["id"]);
        //$response2 = $this->get('/api');
        //var_dump($response2);
        

    }

    /**
     *UPDATE

        *UPDATE: è la chiamata che fa un server verso HOQU per comunicare L’avvenuto svolgimento del task. Il server invia l’ID del TASK assieme all’esito (“done”, “error”) e ad un LOG, invia anche l’id del server per verifica. 

        *L’API recupera l’item in queues (verifica che sia in status process e che sia lo stesso server che ha preso i un carico il task, altrimenti manda un codice non autorizzato). In caso in cui ID non esiste manda il codice di non esistenza. Aggiorna lo stato dell’item con  status=done|error in base a quello che viene inviato dal server, inserisce anche il log inviato da server.

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
            "parameters" => ["a"=> "yes", "b"=> "no", "c" => "so and so", "d"=>"maybe"],
        ];

        $response = $this->post('/api',$data);

        //request that sends the "requesting server"
        $requestSvr1 = [
            "id_server" => 10,
            "taskAvailable" => ["task1","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
        ];

        //OPERATIONS 1
        $response = $this->put('/api/pull',$requestSvr1);
        
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
        $response = $this->put('/api/update',$requestSvr2);

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
            "parameters" => ["a"=> "yes", "b"=> "no", "c" => "so and so", "d"=>"maybe"],
        ];

        $response = $this->post('/api',$data);

        //request that sends the "requesting server"
        $requestSvr1 = [
            "id_server" => 10,
            "status" => "done",
            "log" => "log test",
            "idTask" => $response['id'],
        ];

        //OPERATIONS 2
        $response = $this->put('/api/update',$requestSvr1);

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
            "parameters" => ["a"=> "yes", "b"=> "no", "c" => "so and so", "d"=>["poi"=>02,"route"=>2345]],
        ];

        $response = $this->post('/api',$data);

        //request that sends the "requesting server"
        $requestSvr1 = [
            "id_server" => 10,
            "taskAvailable" => ["task1","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
        ];

        //OPERATIONS 1
        $response = $this->put('/api/pull',$requestSvr1);
        
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
        $response = $this->put('/api/update',$requestSvr1);

        //get value elaborated by update
        $dataDbTestUp = $response;

        $response ->assertStatus(200);


        $this->assertSame('done',$dataDbTestUp['process_status']);

        $this->assertSame($requestSvr1['log'],$dataDbTestUp['process_log']);

        $this->assertSame($requestSvr1['id_server'],$dataDbTestUp['id_server']);

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
            "parameters" => ["a"=> "yes", "b"=> "no", "c" => "so and so", "d"=>["poi"=>02,"route"=>2345]],
        ];

        $response = $this->post('/api',$data);

        //request that sends the "requesting server"
        $requestSvr1 = [
            "id_server" => 10,
            "taskAvailable" => ["task1","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
        ];

        //OPERATIONS 1
        $response = $this->put('/api/pull',$requestSvr1);
        
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
        $response = $this->put('/api/update',$requestSvr1);

        //get value elaborated by update
        $dataDbTestUp = $response;

        $response ->assertStatus(200);


        $this->assertSame('error',$dataDbTestUp['process_status']);

        $this->assertSame($requestSvr1['log'],$dataDbTestUp['process_log']);

        $this->assertSame($requestSvr1['id_server'],$dataDbTestUp['id_server']);

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
            "parameters" => ["a"=> "yes", "b"=> "no", "c" => "so and so", "d"=>["poi"=>02,"route"=>2345]],
        ];

        $response = $this->post('/api',$data);

        //request that sends the "requesting server"
        $requestSvr1 = [
            "id_server" => 10,
            "taskAvailable" => ["task1","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
        ];

        //OPERATIONS 1
        $response = $this->put('/api/pull',$requestSvr1);
        
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
        $response = $this->put('/api/update',$requestSvr1);

        //get value elaborated by update
        $dataDbTestUp = $response;

        $response ->assertForbidden();

    }

    public function testAddApiHoquCheckInstance()
    {
        Queue::truncate();


        $data = [
            "instance" => "",
            "task" => "mptupdatepoi",
            "parameters" => ["a"=> "yes", "b"=> "no"]
        ];

        $response = $this->post('/api',$data);

        $response ->assertStatus(400);


    }

    public function testAddApiHoquCheckTask()
    {


        $data = [
            "instance" => "https://frittomisto.com",
            "task" => "",
            "parameters" => ["a"=> "yes", "b"=> "no"]
        ];

        $response = $this->post('/api',$data);

        $response ->assertStatus(400);


    }

    public function testAddApiHoquCheckParametersEmpty()
    {
        Queue::truncate();

        $data = [
            "instance" => "https://frittomisto.com",
            "task" => "mptupdatepoi",
            "parameters" => []
        ];

        $response = $this->post('/api',$data);
        $response ->assertStatus(201);
        $response->assertJson($data);

        //OPERATION 1
        $response = $this->get('/api');

         //request that sends the "requesting server"
         $requestSvr1 = [
            "id_server" => 9,
            "taskAvailable" => ["task1","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
        ];

        //OPERATIONS 2
        $response = $this->put('/api/pull',$requestSvr1);
        
        //check response 200
        $response ->assertStatus(200);

        //get value elaborate by pull
        $dataDbTest = $response;

        //check field process_status == processing
        $this->assertSame('processing',$dataDbTest['process_status']);

        //check id_server
        $this->assertSame($requestSvr1['id_server'],$dataDbTest['id_server']);

        //check instance
        $this->assertSame($data['instance'],$dataDbTest['instance']);

        //check parameters
        $this->assertSame($data['parameters'],json_decode(json_encode($dataDbTest['parameters']),true));

        //check parameters
        $this->assertSame(1,$dataDbTest["id"]);


    }

    public function testAddApiHoquCheckParametersValidateJson()
    {
        
        $data = [
            "instance" => "https://frittomisto.com",
            "task" => "mptupdatepoi",
            "parameters" => 's',
        ];

        $response = $this->post('/api',$data);

        $response ->assertStatus(400);

        $data = [
            "instance" => "https://frittomisto.com",
            "task" => "mptupdatepoi",
            "parameters" => [0,1,3],
        ];

        $response = $this->post('/api',$data);

        $response ->assertStatus(400);

        $data = [
            "instance" => "https://frittomisto.com",
            "task" => "mptupdatepoi",
            "parameters" => ["a"=> "yes", "b"=> "no"],
        ];

        $response = $this->post('/api',$data);

        $response ->assertStatus(201);

        $data = [
            "instance" => "https://frittomisto.com",
            "task" => "mptupdatepoi",
            "parameters" => 1,
        ];

        $response = $this->post('/api',$data);

        $response ->assertStatus(400);

        $data = [
            "instance" => "https://frittomisto.com",
            "task" => "mptupdatepoi",
            "parameters" => true,
        ];

        $response = $this->post('/api',$data);

        $response ->assertStatus(400);

        $data = [
            "instance" => "https://frittomisto.com",
            "task" => "mptupdatepoi",
            "parameters" => null,
        ];

        $response = $this->post('/api',$data);

        $response ->assertStatus(201);

        $data = [
            "instance" => "https://frittomisto.com",
            "task" => "mptupdatepoi",
        ];

        $response = $this->post('/api',$data);

        $response ->assertStatus(201);


    }


    
}
