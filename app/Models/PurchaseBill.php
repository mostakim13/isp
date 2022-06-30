<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseBill extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider_id',
        'bill_no',
        'billing_month',
        'payment_due',
        'invoice_no',
        'attachment',
        'created_by',
        'updated_by',
    ];
}
