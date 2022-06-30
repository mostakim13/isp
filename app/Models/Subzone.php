<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Subzone extends Model
{
    use HasFactory;

    protected $fillable = [
        'zone_id',
        'name',
        'district_id',
        'upozilla_id',
        'slug',
        'created_by',
        'updated_by',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }
    public function upozilla()
    {
        return $this->belongsTo(Upozilla::class, 'upozilla_id', 'id');
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id', 'id');
    }
}
