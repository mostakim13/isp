<?php

namespace App\Console\Commands;

use App\Helpers\MikrotikConnection;
use App\Models\M_Secret;
use Illuminate\Console\Command;

class Pppupdate extends Command
{
    use MikrotikConnection;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto_secreat:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check has new data. if find any new data then inserted.';

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
        $client = $this->client();
        $response = $client->q('/ppp/active/print')->r();
        foreach ($response as $user) {
            $secret = M_Secret::where([['name', $user['name']], ['service', $user['service']]])->first();
            try {
                if ($secret) {
                    $secret->update([
                        'address' => $user['address'],
                        'uptime' => $user['uptime'],
                        'encoding' => $user['encoding'],
                        'session_id' => $user['session-id'],
                        'radius' => $user['radius'],
                        'caller' => $user['caller-id'],
                    ]);
                }
                //code...
            } catch (\Exception $e) {
                dd('error: ' . $e->getMessage() . ' Line: ' . $e->getLine() . ' File: ' . $e->getFile());
            }
        }
    }
}
