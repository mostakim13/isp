<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetList extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        '_date',
        'company_id',
        'payment_method_id',
        'account_id',
        'category_asset_id',
        'status',
        'qty',
        'amount'
    ];
    public function assetcat()
    {
        return $this->belongsTo(AssetsCategory::class, 'category_asset_id', 'id');
    }
}
