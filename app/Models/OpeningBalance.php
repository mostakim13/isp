<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OpeningBalance extends Model
{
    use HasFactory;

    protected $fillable = [
        '_date',
        'company_id',
        'account_id',
        'amount',
        'note',
        'created_by',
        'updated_by',
    ];

    public function getAccount()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }
}
