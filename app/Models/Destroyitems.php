<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destroyitems extends Model
{
    use HasFactory;
    protected $fillable = [
        'asset_id',
        'company_id',
        'reason_id',
        'qty',
        'destroy_date',
        'destroy_by',
        'remarks',
    ];

    public function assets()
    {
        return $this->belongsTo(AssetList::class, 'asset_id', 'id');
    }
    public function reasons()
    {
        return $this->belongsTo(AssetsCategory::class, 'reason_id', 'id');
    }
}
