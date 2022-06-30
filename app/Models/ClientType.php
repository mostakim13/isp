<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'details',
        'image',
        'status',
        'company_id',
        'created_by',
        'updated_by',
    ];



    public function getImageAttribute($val)
    {
        $img = empty($val) ? asset('img/avatar.png') : asset('storage/' . $val);
        return "<img src='{$img}' style='width:80px;' />";
    }
}
