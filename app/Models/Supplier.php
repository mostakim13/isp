<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Purchase;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'company_id',
        'email',
        'address',
        'unpaid'
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'id', 'supplier_id');
    }
}
