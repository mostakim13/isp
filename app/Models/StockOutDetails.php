<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOutDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_out_id',
        'product_category_id',
        'product_id',
        'quantity'
    ];
}
