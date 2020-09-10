<?php

namespace Tests\Feature;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Tests\TestCase;
use App\Queue;

class pullTest extends TestCase
{
    //migrate tables before each test
    use RefreshDatabase;
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
        $data = [
            "instance" => "https:\/\/montepisanotree.org",
            "task" => "mptupdatepoi",
            "parameters" => ["a"=> "yes", "b"=> "no"],
        ];
        $response = $this->post('api/queue/push',$data);
        $requestSvr1 = [
            "id_server" => 10,
            "taskAvailable" => ["mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
        ];
        //OPERATIONS
        $response = $this->put('api/queue/pull',$requestSvr1);        
        $response ->assertStatus(200);
        $ja = $this->get('api/queue/item/'.$response['id'])->json();
        $this->assertSame('processing',$ja['process_status']);
        $this->assertSame($requestSvr1['id_server'],$ja['id_server']);
        $this->assertSame($data['instance'],$ja['instance']);
        $this->assertSame($data['parameters'],$ja['parameters']);
        $this->assertSame($response['id'],$ja["id"]);
    }

    /**
     * 2. CLEAR DB Aggiungo con add un item con task “task1”, con pul richiedo task “task2”. Il json di risposta deve essere vuoto (con 204 non necessario questo controllo). Lo status HTTP deve essere 204(204 No Content)
     */

    public function testTaskNoMatchPullApiHoqu()
    {
        Queue::truncate();
        //add data with api/queues
        $data = [
            "instance" => "https:\/\/montepisanotree.org",
            "task" => "task1",
            "parameters" => "prova prova",
        ];
        $response = $this->post('api/queue/push',$data);
        //request that sends the "requesting server"
        $requestSvr1 = [
            "id_server" => 9,
            "taskAvailable" => ["mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
        ];
        //OPERATIONS
        $response = $this->put('api/queue/pull',$requestSvr1);
        $response ->assertNoContent($status = 204);
    }

    /**
     * 3. CLERA DB. Aggiungo 2 item a distanza di 2 secondi (sleep (sec)) con task “task1”. Faccio la chiamata PULL con task “task1”. Verifico che la chiamata PULL prenda il primo e non il secondo.
     */

    public function testFineFirstElementPullApiHoqu()
    {
        Queue::truncate();
        //add data with api/queues
        $data = [
            "instance" => "https:\/\/montepisanotree.org",
            "task" => "task1",
            "parameters" => ["a"=> "yes", "b"=> "no", "c" => "boh"],
        ];
        $response = $this->post('api/queue/push',$data);
        sleep(2);
        $data1 = [
            "instance" => "https:\/\/montelabronicotree.org",
            "task" => "task1",
            "parameters" => "prova",
        ];
        $response = $this->post('api/queue/push',$data1);
        $requestSvr1 = [
            "id_server" => 9,
            "taskAvailable" => ["task1","mptupdatepoi", "mptupdatetrack", "mptupdateroute", "mptdeleteroute","mptdeletepoi"],
        ];
        //OPERATIONS
        $response = $this->put('api/queue/pull',$requestSvr1);
        $response ->assertStatus(200);
        //get value elaborate by pull
        $ja = $this->get('api/queue/item/'.$response['id'])->json();
        $this->assertSame('processing',$ja['process_status']);
        $this->assertSame($requestSvr1['id_server'],$ja['id_server']);
        $this->assertSame($data['instance'],$ja['instance']);
        $this->assertSame($data['parameters'],$ja['parameters']);
        $this->assertSame($response['id'],$ja["id"]);

    }
}
