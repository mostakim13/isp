<?php

namespace App\Console\Commands;

use App\Helpers\MikrotikConnection;
use App\Models\MikrotikServer;
use App\Models\MPool;
use App\Models\MPPPProfile;
use Illuminate\Console\Command;

class MikpppProfileSync extends Command
{
    use MikrotikConnection;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pprofilesync:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $servers = MikrotikServer::where('status', true)->get();
        foreach ($servers as $server) {
            $client = $this->client($server->id);
            $mikrotik = $client->q('/ppp/profile/print')->r();
            foreach ($mikrotik as $PProfilelist) {
                if ($PProfilelist['default'] == 'false') {
                    $ippool = isset($PProfilelist['remote-address']) ? MPool::where('name', $PProfilelist['remote-address'])->first() : null;
                    MPPPProfile::updateOrCreate(
                        [
                            'mid' => $PProfilelist['.id'],
                        ],
                        [
                            'server_id' => $server->id,
                            'name' => $PProfilelist['name'],
                            'bridge_learning' => $PProfilelist['bridge-learning'] ?? null,
                            'remote_address' => $ippool->id,
                            'local_address' => $PProfilelist['local-address'] ?? null,
                            'change_tcp_mss' => $PProfilelist['change-tcp-mss'] ?? null,
                            'use_upnp' => $PProfilelist['use-upnp']  ?? null,
                        ]
                    );
                }
            }
        }
        return "Mikrotik Profile Update successfully";
    }
}
