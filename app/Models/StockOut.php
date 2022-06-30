<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOut extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_no',
        'customer_id',
        'stuff_id',
        'date',
        'quantity',
        'narration',
        'create_by',
        'update_by',
    ];

    public function customerlist()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function stuff()
    {
        return $this->belongsTo(User::class, 'stuff_id', 'id');
    }
}
