<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'customer_phone',
        'customer_profile_id',
        'customer_billing_amount',
        'biller_name',
        'biller_phone',
        'payment_method_id',
        'type',
        'pay_amount',
        'partial',
        'discount',
        'description',
        'date_',
        'alert',
        'billing_by',
        'company_id',
        'status',
    ];

    public function PaymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id', 'id');
    }
    public function getCustomer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function getProfile()
    {
        return $this->belongsTo(Package2::class, 'customer_profile_id', 'id');
    }
    public function getBiller()
    {
        return $this->belongsTo(User::class, 'biller_name', 'id');
    }

    public function getBillinfBy()
    {
        return $this->belongsTo(User::class, 'billing_by', 'id');
    }
}
