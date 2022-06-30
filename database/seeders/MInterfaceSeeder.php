<?php

namespace Database\Seeders;

use App\Helpers\MikrotikConnection;
use App\Models\MInterface;
use Illuminate\Database\Seeder;

class MInterfaceSeeder extends Seeder
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

        $interfaces = $client->qr('/interface/print');

        foreach ($interfaces as $interface) {
            MInterface::create([
                "mid" => isset($interface['.id']) ? $interface['.id'] : null,
                "name" => isset($interface['name']) ? $interface['name'] : null,
                "default_name" => isset($interface['default-name']) ? $interface['default-name'] : null,
                "type" => isset($interface['type']) ? $interface['type'] : null,
                "mtu" => isset($interface['mtu']) ? $interface['mtu'] : null,
                "actual_mtu" => isset($interface['actual-mtu']) ? $interface['actual-mtu'] : null,
                "l2mtu" => isset($interface['l2mtu']) ? $interface['l2mtu'] : null,
                "max_l2mtu" => isset($interface['max-l2mtu']) ? $interface['max-l2mtu'] : null,
                "mac_address" => isset($interface['mac-address']) ? $interface['mac-address'] : null,
                "last_link_down_time" => isset($interface['last-link-down-time']) ? $interface['last-link-down-time'] : null,
                "last_link_up_time" => isset($interface['last-link-up-time']) ? $interface['last-link-up-time'] : null,
                "link_downs" => isset($interface['link-downs']) ? $interface['link-downs'] : null,
                "rx_byte" => isset($interface['rx-byte']) ? $interface['rx-byte'] : null,
                "tx_byte" => isset($interface['tx-byte']) ? $interface['tx-byte'] : null,
                "rx_packet" => isset($interface['rx-packet']) ? $interface['rx-packet'] : null,
                "tx_packet" => isset($interface['tx-packet']) ? $interface['tx-packet'] : null,
                "rx_drop" => isset($interface['rx-drop']) ? $interface['rx-drop'] : null,
                "tx_drop" => isset($interface['tx-drop']) ? $interface['tx-drop'] : null,
                "tx_queue_drop" => isset($interface['tx-queue-drop']) ? $interface['tx-queue-drop'] : null,
                "rx_error" => isset($interface['rx-error']) ? $interface['rx-error'] : null,
                "tx_error" => isset($interface['tx-error']) ? $interface['tx-error'] : null,
                "fp_rx_byte" => isset($interface['fp-rx-byte']) ? $interface['fp-rx-byte'] : null,
                "fp_tx_byte" => isset($interface['fp-tx-byte']) ? $interface['fp-tx-byte'] : null,
                "fp_rx_packet" => isset($interface['fp-rx-packet']) ? $interface['fp-rx-packet'] : null,
                "fp_tx_packet" => isset($interface['fp-tx-packet']) ? $interface['fp-tx-packet'] : null,
                "running" => isset($interface['running']) ? $interface['running'] : null,
                "disabled" => isset($interface['disabled']) ? $interface['disabled'] : null,
                "created_at" => now(),
                "updated_at" => now(),
            ]);
        }

        // foreach (collect($insertable_interface)->chunk(500) as $chunk) {
        // }
    }
}
