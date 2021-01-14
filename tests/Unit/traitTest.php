<?php

namespace Tests\Unit;
use Tests\TestCase;
use App\Models\Wm_Server;
//use PHPUnit\Framework\TestCase;
use App\Http\Traits\TaskTrait;

class traitTest extends TestCase
{
    use TaskTrait;

    public function test_register_a_server()
    {
        $server_id = 'CyclandoTheBest';
        $ip = '46.166.166.10';
        $this->storeServer($ip,$server_id);

        //check storeServer
        $this->assertSame( Wm_Server::count(),1);
        $server = Wm_Server::where('server_id',$server_id)
            ->where('server_ip',$ip)->get();
        $this->assertSame( $server[0]['server_id'],'CyclandoTheBest');

    }

    public function test_register_a_server_only_once()
    {
        $server_id = 'CyclandoTheBest';
        $ip = '46.166.166.10';

        //check store only once
        $this->storeServer($ip,$server_id);
        $this->storeServer($ip,$server_id);
        $this->storeServer($ip,$server_id);
        $this->assertSame( Wm_Server::count(),1);

    }

    public function test_update_field_updated_at()
    {
        $server_id = 'CyclandoTheBest';
        $ip = '46.166.166.10';

        $server = Wm_Server::where('server_id',$server_id)
            ->where('server_ip',$ip)->get();
        $time = strtotime($server[0]['updated_at']);
        sleep(2);
        $this->updateServer($ip,$server_id);
        $server = Wm_Server::where('server_id',$server_id)
            ->where('server_ip',$ip)->get();
        $timeAfterUpdate = strtotime($server[0]['updated_at']);

        //check updateServer
        $this->assertGreaterThan( $time,$timeAfterUpdate );


    }
}
