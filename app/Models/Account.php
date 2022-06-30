<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $fillable = [
        'account_name',
        'account_details',
        'head_code',
        'parent_id',
        'is_transaction',
        'amount',
        'company_id',
        'status',
        'updated_by',
        'created_by',
        'deleted_by',
    ];

    public function parentAccount()
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    public function subAccount()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function getaccount()
    {
        return Self::where('status', 'Active')->where('is_transaction', 1)->where('company_id', auth()->user()->company_id);
    }
}
