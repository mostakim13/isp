<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        "m_id",
        "name",
        "owner",
        "name-for-users",
        "validity",
        "starts-at",
        "price",
        "override-shared-users",
    ];
}
