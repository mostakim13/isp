<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MacReseller extends Model
{
    use HasFactory;
    protected $fillable = [
        'person_name',
        'email',
        'mobile',
        'phone',
        'national_id',
        'zone_id',
        'reseller_user_name',
        'reseller_code',
        'reseller_prefix',
        'set_prefix_mikrotikuser',
        'reseller_type',
        'rechargeable_amount',
        'address',
        'reseller_logo',
        'business_name',
        'tariff_id',
        'user_id',
        'user_name',
        'password',
        'viewpassword',
        'reseller_menu',
        'disabled_client',
        'minimum_balance'
    ];

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function tariff()
    {
        return $this->belongsTo(MacTariffConfig::class, 'tariff_id');
    }
}
