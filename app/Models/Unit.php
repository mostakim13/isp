<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'create_by',
        'update_by',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'create_by', 'id');
    }
}
