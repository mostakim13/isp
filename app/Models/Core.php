<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Core extends Model
{
    use HasFactory;

    protected $fillable = [
        'color',
        'status',
        'coreable_id',
        'coreable_type',
    ];


    /**
     * Get the parent imageable model (user or post).
     */
    public function coreable()
    {
        return $this->morphTo();
    }

    public function core_tj()
    {
        return $this->hasOne(Tj::class, 'core_id', 'id');
    }
}
