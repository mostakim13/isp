<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupAccess extends Model
{
    protected $casts = [
        'group_access'  => "array",
    ];


    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }
}
