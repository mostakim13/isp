<?php

namespace App\Imports;

use App\Models\ClientType;
use App\Models\Customer;
use App\Models\MikrotikServer;
use App\Models\Package;
use App\Models\Package2;
use App\Models\Protocol;
use App\Models\Subzone;
use App\Models\Zone;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToCollection, WithValidation, SkipsOnError, WithHeadingRow
{
    use Importable, SkipsErrors;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row) {

            $package = Package::firstOrCreate([
                'name' => $row['package']
            ]);

            $clienttype = ClientType::firstOrCreate([
                'name' => $row['client_type']
            ]);

            $zone = Zone::firstOrCreate([
                'name' => $row['zone']
            ]);

            $service = Protocol::firstOrCreate([
                'name' => $row['protocol']
            ]);

            $server = MikrotikServer::firstOrCreate([
                'server_ip' => $row['server']
            ]);

            if (!empty($row['sub_zone'])) {
                $subzone = Subzone::firstOrCreate([
                    'name' => $row['sub_zone'],
                    'zone_id' => $zone->id
                ]);
            }

            Customer::create([
                "username" => $row['username'],
                "name" => $row['client_name'],
                "phone" => $row['mobile'],
                "zone_id" => $zone->id,
                "subzone_id" => isset($subzone) ? $subzone->id : null,
                "address" => $row['address'],
                "m_p_p_p_profile" => $package->id,
                "server_id" => $server->id,
                "speed" => $row['speed'],
                "exp_date" => $row['ex_date'] ?? $row['exdate'],
                "password" => Hash::make($row['password']),
                "secreat" => $row['password'],
                "connection_type" => $row['conn_type'] ?? $row['conntype'],
                "client_type_id" => $clienttype->id,
                "bill_amount" => $row['m_bill'] ?? $row['mbill'],
                "mac_address" => $row['m_a_c_address'] ?? null,
                "service" => $service->id,
                "disabled" => $row['b_status'] ?? $row['bstatus'],
            ]);
        }
    }


    public function rules(): array
    {
        return [
            // 'username' => [
            //     'required', 'unique',
            // ],
        ];
    }

    // public function chunkSize(): int
    // {
    //     return 100;
    // }
}
