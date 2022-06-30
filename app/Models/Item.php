<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'name',
        'category_id',
        'income_account_id',
        'expense_account_id',
        'unit',
        'vat',
        'status',
        'description',
        'created_by',
        'updated_by',
    ];
}
