<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BalanceTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_account_id',
        'to_account_id',
        'company_id',
        'date',
        'amount',
        'note',
        'created_by',
        'updated_by',
    ];

    public function getFormAccount()
    {
        return $this->belongsTo(Account::class, 'from_account_id', 'id');
    }
    public function getToAccount()
    {
        return $this->belongsTo(Account::class, 'to_account_id', 'id');
    }
}
