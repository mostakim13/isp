<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetsCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_name',
        'category_id',
        'company_id',
        'reason_name',
        'status',
        'type',
        'created_by',
        'updated_by',
    ];
}
