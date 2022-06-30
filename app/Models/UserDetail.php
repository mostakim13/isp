<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'zone_id',
        'billing_person',
        'package',
        'father_name',
        'mother_name',
        'spouse_name',
        'nid',
        'doc_image',
        'dob',
        'reference',
        'user_type',
        'mac_address',
        'ip_address',
        'parent_id',
        'limit',
        'address',
        // 'comment',
        'connection_date',
        'bill_amount',
        'speed',

    ];
}
