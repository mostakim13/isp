<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Splitter extends Model
{
    use HasFactory;


    protected $fillable = [
        "zone_id",
        "subzone_id",
        "tj_id",
        "splitter_id",
        "name",
        "core",
        "tj_core_id",
        "splitter_core_id",
        "connected",
        "remain",
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

    public function splitter()
    {
        return $this->belongsTo(self::class, 'splitter_id', 'id');
    }

    public function splitters()
    {
        return $this->hasMany(self::class, 'splitter_id', 'id');
    }

    /**
     * Get the core name.
     */
    public function cores()
    {
        return $this->morphMany(Core::class, 'coreable');
    }
}
