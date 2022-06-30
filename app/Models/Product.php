<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'purchases_price',
        'sale_price',
        'product_category_id',
        'unit_id',
        'brand_id',
        'low_stock'
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id', 'id');
    }

    public function unitCat()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }
}
