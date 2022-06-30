<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'create_by',
        'update_by',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'category_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'product_category_id', 'id');
    }
}
