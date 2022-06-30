<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MPPPProfile extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function mpoolRemoteAddressList()
    {
        return $this->belongsTo(MPool::class, 'remote_address', 'id');
    }
}
