<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Protocol extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'details',
        'status',
        'company_id',
        'created_by',
        'updated_by',
    ];
}
