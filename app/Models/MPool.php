<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MPool extends Model
{
    use HasFactory;
    protected $fillable = [
        'mid',
        'name',
        'ranges',
        'server_id',
    ];

    public function server()
    {
        return $this->belongsTo(MikrotikServer::class, 'server_id', 'id');
    }
}
