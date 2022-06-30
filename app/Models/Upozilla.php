<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upozilla extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
}
