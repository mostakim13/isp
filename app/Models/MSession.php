<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MSession extends Model
{
    use HasFactory;

    protected $fillable = [
        "m_id",
        "customer",
        "user",
        "nas-port",
        "nas-port-type",
        "nas-port-id",
        "calling-station-id",
        "acct-session-id",
        "user-ip",
        "host-ip",
        "status",
        "from-time",
        "till-time",
        "terminate-cause",
        "uptime",
        "download",
        "upload",
        "active",
    ];
}
