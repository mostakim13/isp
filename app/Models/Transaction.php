<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'supplier_id',
        'customer_id',
        'pay_method_id',
        'asset_id',
        'qty',
        'company_id',
        'purchase_id',
        'local_id',
        'type',
        'date',
        'debit',
        'credit',
        'amount',
        'due',
        'note',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function BillTransAccount()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id')->where('company_id', auth()->user()->company_id);
    }

    public function paymentmethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'local_id');
    }
}
