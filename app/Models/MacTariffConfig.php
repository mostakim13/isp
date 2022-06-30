<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MacTariffConfig extends Model
{
    use HasFactory;

    protected $fillable = [
        'tariff_name',
        'package_id',
        'package_rate',
        'package_validation_day',
        'package_minimum_activation_day',
        'server_id',
        'protocole_type',
        'ppp_profile',
        'created_by',
        'updated_by'
    ];

    public function macprofile()
    {
        return $this->belongsTo(MacPackage::class, 'package_id');
    }
    public function mikrotikserver()
    {
        return $this->belongsTo(MikrotikServer::class, 'server_id');
    }
}
