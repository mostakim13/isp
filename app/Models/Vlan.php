<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'mid',
        'name',
        'mtu',
        'company_id',
        'server_id',
        'arp',
        'disabled',
        'vlan_id',
        'interface',
        'use_service_tag',
        'created_by',
        'updated_by',
    ];
}
