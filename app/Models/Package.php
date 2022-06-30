<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'm_download',
        'm_upload',
        'm_transfer',
        'm_uptime',
        'm_rate_limite_rx',
        'm_rate_limite_tx',
        'm_burst_rate_rx',
        'm_burst_rate_tx',
        'm_burst_threshold_rx',
        'm_burst_threshold_tx',
        'm_burst_time_rx',
        'm_burst_time_tx',
        'm_min_rate_rx',
        'm_min_rate_tx',
        'm_priority',
        'm_group_name',
        'm_ip_pool',
        'm_ipv6_pool',
        'm_address_list',
        'created_by',
    ];
}
