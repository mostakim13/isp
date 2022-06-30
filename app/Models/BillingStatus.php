<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'details',
        'status',
        'created_by',
        'updated_by',
    ];
}
