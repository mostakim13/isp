<?php

namespace App\Helpers;

use App\Models\MikrotikServer;
use \RouterOS\Client;

trait MikrotikConnection
{
    public function client($id = null)
    {
        if ($id) {
            $mikrotikConnection = MikrotikServer::where('status', true)->find($id);
        } else {
            $mikrotikConnection = MikrotikServer::where('status', true)->first();
        }
        return new Client([
            'host' => $mikrotikConnection->server_ip,
            'user' => $mikrotikConnection->user_name,
            'pass' => $mikrotikConnection->password,
            'port' => intval($mikrotikConnection->api_port),
        ]);
        return new Client([
            'host' => '103.126.113.193',
            'user' => 'ITWAY',
            'pass' => 'ITWAY@123',
            'port' => 1122,
        ]);
    }
}
