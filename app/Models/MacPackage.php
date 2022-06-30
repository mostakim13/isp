<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MacPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'bandwidth_md',
        'details',
        'created_by',
        'updated_by',
    ];
}
