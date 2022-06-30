<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'department',
        'details',
        'type',
        'created_by',
        'updated_by',
    ];

    public function getTypeAttribute($value)
    {
        if ($value == 'public') {
            $button = "<button class='btn btn-success'>For Everyone</button>";
        } elseif ($value == 'unpublic') {
            $button = "<button class='btn btn-danger'>Only For Office</button>";
        }
        return $button;
    }
}
