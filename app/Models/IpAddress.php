<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'mid',
        'address',
        'network',
        'interface',
        'disabled',
        'server_id',
        'company_id',
        'created_id',
        'updated_id',
    ];

    public function server()
    {
        return $this->belongsTo(MikrotikServer::class, 'server_id', 'id');
    }
}
