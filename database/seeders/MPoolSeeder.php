<?php

namespace Database\Seeders;

use App\Helpers\MikrotikConnection;
use App\Models\MPool;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MPoolSeeder extends Seeder
{
    use MikrotikConnection;
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $client = $this->client();

        $pools = $client->q('/ip/pool/print')->r();

        foreach ($pools as $pool) {
            MPool::create([
                "mid" => isset($pool['.id']) ? $pool['.id'] : null,
                "name" => isset($pool['name']) ? $pool['name'] : null,
                "ranges" => isset($pool['ranges']) ? $pool['ranges'] : null,
            ]);
        }
    }
}
