<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyIncome extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'company_id',
        'category_id',
        'account_id',
        'customer_id',
        'supplier_id',
        'amount',
        'paid_amount',
        'description',
        'created_by'
    ];
    public function category()
    {
        return $this->belongsTo('App\models\IncomeCategory', 'category_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function getCreatedAtAttribute()
    {
        return $this->amount - $this->paid_amount;
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }
}
