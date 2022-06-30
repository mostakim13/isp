<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    // protected $dates = ['deleted_at'];

    public function users()
    {
        return $this->hasMany('App\User', 'group_id');
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_admin' => 'boolean',
    ];

    public function group_accesses()
    {
        return $this->hasOne(GroupAccess::class, 'group_id', 'id');
    }


    public function setNameAttribute($val)
    {
        $this->attributes['name'] = Str::lower($val);
        $this->attributes['slug'] = Str::slug($val);
    }
}
