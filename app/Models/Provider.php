<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{

    use HasFactory;

    protected $fillable = [
        'company_name',
        'contact_person',
        'email',
        'phone',
        'mobile',
        'facebook_url',
        'skype_id',
        'website_url',
        'image',
        'address',
        'created_by',
        'updated_by'
    ];
}
