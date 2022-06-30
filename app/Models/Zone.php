<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Zone extends Model
{
    use HasFactory;


    protected $fillable = [
        "name",
        "slug",
        "created_by",
        "updated_by",
        'district_id',
        'upozilla_id'
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

    public function subzones()
    {
        return $this->hasMany(Subzone::class, 'zone_id', 'id');
    }
}
