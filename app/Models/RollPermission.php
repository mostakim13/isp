<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RollPermission extends Model
{

    use HasFactory;

    protected  $fillable = [
        'name',
        'parent_id',
        'child_id',
        'created_by',
        'updated_by'
    ];
}
