<?php

namespace App\Console;

use App\Console\Commands\MikPoopSync;
use App\Helpers\Billing;
use App\Helpers\MikrotikConnection;
use App\Models\M_Secret;
use App\Models\MikrotikServer;
use App\Models\MInterface;
use App\Models\MPool;
use App\Models\MPPPProfile;
use App\Models\Vlan;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    use MikrotikConnection;
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $client = $this->client();
            $response = $client->q('/ppp/active/print')->r();
            $users = [];
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
        })->everyMinute();

        $schedule->call(function () {
            $client = $this->client();
            $response = $client->qr('/interface/print');
            $users = [];
            foreach ($response as $interface) {

                try {
                    MInterface::updateOrCreate([
                        'mid' => $interface['.id'] ?? "",
                    ], [
                        'name' => $interface['name'],
                        'default_name' => $interface['default-name'] ?? "",
                        'type' => $interface['type'] ?? "",
                        'mtu' => $interface['mtu'] ?? "",
                        'actual_mtu' => $interface['actual-mtu'] ?? "",
                        'l2mtu' => $interface['l2mtu'] ?? "",
                        'max_l2mtu' => $interface['max-l2mtu'] ?? "",
                        'mac_address' => $interface['mac-address'] ?? "",
                        'last_link_down_time' => $interface['last-link-down-time'] ?? "",
                        'last_link_up_time' => $interface['last-link-up-time'] ?? "",
                        'link_downs' => $interface['link-downs'] ?? "",
                        'rx_byte' => $interface['rx-byte'] ?? "",
                        'tx_byte' => $interface['tx-byte'] ?? "",
                        'rx_packet' => $interface['rx-packet'] ?? "",
                        'tx_packet' => $interface['tx-packet'] ?? "",
                        'rx_drop' => $interface['rx-drop'] ?? "",
                        'tx_drop' => $interface['tx-drop'] ?? "",
                        'tx_queue_drop' => $interface['tx-queue-drop'] ?? "",
                        'rx_error' => $interface['rx-error'] ?? "",
                        'tx_error' => $interface['tx-error'] ?? "",
                        'fp_rx_byte' => $interface['fp-rx-byte'] ?? "",
                        'fp_tx_byte' => $interface['fp-tx-byte'] ?? "",
                        'fp_rx_packet' => $interface['fp-rx-packet'] ?? "",
                        'fp_tx_packet' => $interface['fp-tx-packet'] ?? "",
                        'running' => $interface['running'] ?? "",
                        'disabled' => $interface['disabled'] ?? ""
                    ]);

                    //code...
                } catch (\Exception $e) {
                    dd('error: ' . $e->getMessage() . ' Line: ' . $e->getLine() . ' File: ' . $e->getFile());
                }
            }
        })->everyMinute();

        $schedule->command('billing:update')->everyMinute();
        $schedule->command('poopsync:update')->everyMinute();
        $schedule->command('pprofilesync:update')->everyMinute();
        $schedule->command('vlanSync:update')->everyMinute();
        $schedule->command('ipaddresssync:update')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
