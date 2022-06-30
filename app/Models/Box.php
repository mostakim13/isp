<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    use HasFactory;

    protected $fillable = [
        "zone_id",
        "subzone_id",
        "tj_id",
        "splitter_id",
        "box_id",
        "name",
        "core",
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
        return $this->belongsTo(Splitter::class, 'splitter_id', 'id');
    }

    public function box()
    {
        return $this->belongsTo(self::class, 'box_id', 'id');
    }



    /**
     * Get the core name.
     */
    public function cores()
    {
        return $this->morphMany(Core::class, 'coreable');
    }
}
