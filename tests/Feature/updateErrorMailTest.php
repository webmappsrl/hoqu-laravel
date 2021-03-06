<?php

namespace Tests\Feature;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\sendError;

use Tests\TestCase;
use App\Model\Task;

class updateErrorMailTest extends TestCase
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
     * viene chiamata api/store ("job" => "task1"), srv1 chiama pull che restituisce id. Srv2 chiama updateError con status in “VDC” e log “log test” perché il server ha avuto qualche problema. SI verifica il corretto invio della email e dei suoi contenuti.
     */

    public function testMailSendUpdateError()
    {
        $user_tokens = json_decode(Storage::get('test_data/tokens_users.json'),TRUE);
        Mail::fake();
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
        $order = new sendError($response);
        Mail::assertSent(function (sendError $mail) use ($order) {
            $count = 0;
            if($mail->itemHoqu['id'] === $order->itemHoqu['id']) $count++;
            if($mail->itemHoqu['id_server'] === $order->itemHoqu['id_server']) $count++;
            if($mail->itemHoqu['job'] === $order->itemHoqu['job']) $count++;
            if($mail->itemHoqu['instance'] === $order->itemHoqu['instance']) $count++;
            if($mail->itemHoqu['process_status'] === $order->itemHoqu['process_status']) $count++;
            if($mail->itemHoqu['process_log'] === $order->itemHoqu['process_log']) $count++;
            if($mail->itemHoqu['parameters'] === $order->itemHoqu['parameters']) $count++;
            if(request()->getHost() === 'hoqu-laravel.test') $count++;
            if(request()->getHost() === 'localhost') $count++;
            return 8 === $count;
        });
        Mail::assertSent(sendError::class, 1);
    }

    /**
     * Srv2 chiama updateError senza il parametro status e con id non esistente. Viene risposto errore 400 e si verifica che la mail non venga inviata.
     */
    public function testMailNoSendUpdateError()
    {
        $user_tokens = json_decode(Storage::get('test_data/tokens_users.json'),TRUE);
        Mail::fake();

        //request that sends the "requesting server 2"
        $requestSvr2 = [
            "id_server" => 10,
            "log" => "log test",
            "id_task" => 567,
        ];
        //OPERATIONS 2
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$user_tokens['server@webmapp.it']
        ])->put('/api/updateError',$requestSvr2);
        $response->assertStatus(403);
        Mail::assertNotSent(sendError::class);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh --seed');
    }

}
