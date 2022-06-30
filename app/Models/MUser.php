<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MUser extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'm_id',
        'customer',
        'actual-profile',
        'username',
        'ipv6-dns',
        'shared-users',
        'wireless-psk',
        'wireless-enc-key',
        'wireless-enc-algo',
        'uptime-used',
        'download-used',
        'upload-used',
        'last-seen',
        'active-sessions',
        'active',
        'incomplete',
        'disabled',
    ];
}
