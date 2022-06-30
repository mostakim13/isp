<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tj extends Model
{
    use HasFactory;

    protected $fillable = [
        "zone_id",
        "subzone_id",
        "tj_id",
        "name",
        "core",
        "connected",
        "remain",
        "core_id",
        "create_by",
        "update_by",
    ];


    public function setcoreAttribute($value)
    {
        $this->attributes['core'] = $value;
        $this->attributes['connected'] = 0;
        $this->attributes['remain'] = $value;
    }


    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id', 'id');
    }

    public function subzone()
    {
        return $this->belongsTo(Subzone::class, 'subzone_id', 'id');
    }

    public function tj()
    {
        return $this->belongsTo(Tj::class, 'tj_id', 'id');
    }

    public function tjs()
    {
        return $this->hasMany(self::class, 'tj_id', 'id');
    }


    /**
     * Get the core name.
     */
    public function cores()
    {
        return $this->morphMany(Core::class, 'coreable');
    }
}
