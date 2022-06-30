<?php

namespace Database\Seeders;

use App\Helpers\MikrotikConnection;
use App\Models\Customer;
use App\Models\MPPPProfile;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    use MikrotikConnection;

    public function run()
    {
        $client = $this->client();

        $users = $client->q('/ppp/secret/print')->r();

        foreach ($users as $key => $user) {
            if ($key) {
                $startDate = new Carbon('first day of this month');
                $customer[] =   [
                    "mid" => isset($user['.id']) ? $user['.id'] : null,
                    "username" => isset($user['name']) ? $user['name'] : null,
                    "service" => isset($user['service']) ? $user['service'] : null,
                    "caller" => isset($user['caller-id']) ? $user['caller-id'] : null,
                    "m_p_p_p_profile" => isset($user['profile']) ? rand(1, 24) : null,
                    "remote_address" => isset($user['remote-address']) ? $user['remote-address'] : null,
                    "routes" => isset($user['routes']) ? $user['routes'] : null,
                    // "ipv6_routes" => isset($user['ipv6-routes']) ? $user['ipv6-routes'] : null,
                    "m_password" => isset($user['password']) ? $user['password'] : null,
                    "password" => isset($user['password']) ? Hash::make($user['password']) : null,
                    "limit_bytes_in" => isset($user['limit-bytes-in']) ? $user['limit-bytes-in'] : null,
                    "limit_bytes_out" => isset($user['limit-bytes-out']) ? $user['limit-bytes-out'] : null,
                    "last_logged_out" => isset($user['last-logged-out']) ? $user['last-logged-out'] : null,
                    "disabled" => isset($user['disabled']) ? $user['disabled'] : null,
                    "comment" => isset($user['comment']) ? $user['comment'] : null,
                    "company_id" => 1,
                    // 'connection_date' => now(),
                    // 'start_date' => $startDate,
                    // 'bill_collection_date' => 1,
                    // 'billing_status_id' => 5,
                    // 'exp_date' =>  Carbon::parse($startDate)->addMonths(1)->addDay(0)->format('Y-m-d') //today()->addDay(2)->format('Y-m-d') ;
                ];
            }
        }

        DB::table('customers')->upsert($customer, ['mid', 'username'], ['comment']);
    }
}
