<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockSummary extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'qty'
    ];

    public function productlist()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
