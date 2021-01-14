<?php

namespace App\Http\Traits;
use App\Models\Wm_Server;
use function PHPUnit\Framework\isEmpty;
use Illuminate\Support\Facades\DB;

trait TaskTrait {

    public function storeServer($ip_server, $id_server)
    {
        $check = Wm_Server::where('server_ip', $ip_server)->where('server_id', $id_server)->count();
//        dd($check);
//
        if ($check==0)
        {
            $server = new Wm_Server();
            $server->server_ip= $ip_server;
            $server->server_id= $id_server;
//            dd($server);
            $server->save();
        }

    }

    public function updateServer($ip_server, $id_server)
    {
        $server = Wm_Server::where('server_ip',$ip_server)->where('server_id', $id_server)->first();
        if (empty($server))
        {
            $server->updated_at = now();
            $server->save();
        }

    }

}

