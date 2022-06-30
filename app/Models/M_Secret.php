<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Secret extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mid',
        'name',
        'service',
        'caller',
        'profile',
        'routes',
        'ipv6_routes',
        'limit_bytes_in',
        'limit_bytes_out',
        'disabled',
        'comment',
        'address',
        'uptime',
        'encoding',
        'session_id',
        'radius',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
