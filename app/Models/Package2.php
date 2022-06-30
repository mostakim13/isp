<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package2 extends Model
{
    use HasFactory;

    protected $table = 'package2';

    protected $fillable = [
        "client_type_id",
        'company_id',
        "name",
        "price",
        "bandwidth_allocation",
        "description",
        "is_show_in_client_profile",
        "status",

        'tariffconfig_id',
        'mac_package_id',
        'server_id',
        'protocol_id',
        'm_profile_id',
        'rate',
        'selling_price',
        'validity_day',
        'minimum_activation_day',

        "created_by",
        "updated_by",
        "deleted_by",
    ];


    public function client_type()
    {
        return $this->belongsTo(ClientType::class, 'client_type_id', 'id');
    }

    public function mikrotikserver()
    {
        return $this->belongsTo(MikrotikServer::class, 'server_id');
    }
    public function macpackage()
    {
        return $this->belongsTo(MacPackage::class, 'mac_package_id');
    }
}
