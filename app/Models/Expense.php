<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'pay_method_id',
        'company_id',
        'account_id',
        'expense_category_id',
        'date',
        'amount',
        'note',
        'updated_by',
        'created_by',
    ];

    public function employelist()
    {
        return $this->belongsTo(User::class, 'employee_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id', 'id');
    }

    public function accountlist()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function paymentmethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'pay_method_id', 'id');
    }

    public function expense_category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id', 'id');
    }
}
