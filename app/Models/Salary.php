<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;
    protected $table = 'payrolls';

    protected $fillable = [
        'employee_id',
        'user_id',
        'basic_salary',
        'total_amount',
        'month',
        'paid_salary',
        'overtime',
        'incentive',
        'bonus',
        'remarks',
        'date_',
        'paid_date',
        'amount',
        'due',
        'status',
        'reason',
        'create_by',
        'update_by'
    ];
    public function createBy()
    {
        return $this->belongsTo(User::class, 'create_by', 'id');
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function getMonthAttribute($date)
    {
        return date('M-Y', strtotime($date));
    }
}
