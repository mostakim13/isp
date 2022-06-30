<?php

namespace App\Console\Commands;

use App\Helpers\MikrotikConnection;
use App\Models\MikrotikServer;
use App\Models\MPool;
use Illuminate\Console\Command;

class MikPoopSync extends Command
{
    use MikrotikConnection;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'poopsync:update';

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
        foreach ($servers as $servers) {
            $client = $this->client($servers->id);
            $pooplists = $client->q('/ip/pool/print')->r();
            foreach ($pooplists as $pooplist) {
                MPool::updateOrCreate(
                    [
                        'mid' => $pooplist['.id'],
                    ],
                    [
                        'name' => $pooplist['name'],
                        'server_id' => $servers->id,
                        'ranges' => $pooplist['ranges'],
                    ]
                );
            }
        }
        return "Mikrotik Poop Update successfully";
    }
}
