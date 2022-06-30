<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'model_id',
        'date_',
        'amount',
        'discount',
        'payment_method',
        'paid_by',
        'type',
        'create_by',
        'description',
    ];
}
