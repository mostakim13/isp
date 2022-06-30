<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Navigation extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'navigations';


    /**
     * Navigration Parent
     *
     */
    public function parent()
    {
        return  $this->belongsTo(self::class, 'parent_id', 'id');
    }

    /**
     * Navigration Parent
     *
     */
    public function children()
    {
        return  $this->hasMany(self::class, 'parent_id', 'id')->select(['id', 'label', 'route', 'parent_id', 'navigate_status']);
    }
}
