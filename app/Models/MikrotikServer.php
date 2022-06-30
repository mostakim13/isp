<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Self_;

class MikrotikServer extends Model
{
    use HasFactory;

    protected $fillable = [
        "server_ip",
        "user_name",
        "password",
        "api_port",
        "version",
        "status",
    ];

    public function condition()
    {
        return Self::where('status', true);
    }
}
