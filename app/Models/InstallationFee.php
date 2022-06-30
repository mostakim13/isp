<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstallationFee extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
    public function account()
    {
        return $this->belongsTo(Account::class, 'payment_by', 'id');
    }
}
