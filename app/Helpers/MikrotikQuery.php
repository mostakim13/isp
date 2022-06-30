<?php

namespace App\Helpers;

use \RouterOS\Query;
use App\Helpers\MikrotikConnection;

trait MikrotikQuery
{
    use MikrotikConnection;

    public function customer_active_inactive($customer)
    {
        $client = $this->client($customer->server_id);
        $query =  new Query('/ppp/secret/set');
        $query->equal('.id', $customer->mid);
        $query->equal('disabled', $customer->disabled);
        $client->query($query)->read();
    }

    public function ipaddressdisabled($ipaddress)
    {
        $client = $this->client($ipaddress->server_id);
        $query =  new Query('/ip/address/set');
        $query->equal('.id', $ipaddress->mid);
        $query->equal('disabled', $ipaddress->disabled);
        $client->query($query)->read();
    }

    public function vlanDisabledStatus($vlan)
    {
        $client = $this->client($vlan->server_id);
        $query =  new Query('/interface/vlan/set');
        $query->equal('.id', $vlan->mid);
        $query->equal('disabled', $vlan->disabled);
        $client->query($query)->read();
    }
}
