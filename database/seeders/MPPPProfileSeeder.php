<?php

namespace Database\Seeders;

use App\Helpers\MikrotikConnection;
use App\Models\MPPPProfile;
use Illuminate\Database\Seeder;

class MPPPProfileSeeder extends Seeder
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

        $profiles = $client->q('/ppp/profile/print')->r();

        $insertable_profiles = [];
        foreach ($profiles as $profile) {
            $insertable_profiles[] = [
                "mid" => isset($profile['.id']) ? $profile['.id'] : null,
                "name" => isset($profile['name']) ? $profile['name'] : null,
                "local_address" => isset($profile['local-address']) ? $profile['local-address'] : null,
                "remote_address" => isset($profile['remote-address']) ? $profile['remote-address'] : null,
                "bridge_learning" => isset($profile['bridge-learning']) ? $profile['bridge-learning'] : null,
                // "use_mpls" => isset($profile['use-mpls']) ? $profile['use-mpls'] : null,
                // "use_compression" => isset($profile['use-compression']) ? $profile['use-compression'] : null,
                // "use_encryption" => isset($profile['use-encryption']) ? $profile['use-encryption'] : null,
                // "only_one" => isset($profile['only-one']) ? $profile['only-one'] : null,
                "change_tcp_mss" => isset($profile['change-tcp-mss']) ? $profile['change-tcp-mss'] : null,
                "use_upnp" => isset($profile['use-upnp']) ? $profile['use-upnp'] : null,
                // "address_list" => isset($profile['address-list']) ? $profile['address-list'] : null,
                "dns_server" => isset($profile['dns-server']) ? $profile['dns-server'] : null,
                // "on_up" => isset($profile['on-up']) ? $profile['on-up'] : null,
                // "on_down" => isset($profile['on-down']) ? $profile['on-down'] : null,
                "default" => isset($profile['default']) ? $profile['default'] : null,
                "created_at" => now(),
                "updated_at" => now(),
            ];
        }

        foreach (collect($insertable_profiles)->chunk(500) as $chunk) {
            MPPPProfile::insert($chunk->toArray());
        }
    }
}
