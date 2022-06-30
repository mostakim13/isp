<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'invoice_no',
        'supplier_id',
        'payment_type',
        'account_id',
        'subtotal',
        'discount',
        'grand_total',
        'transportation',
        'status',
        'quantity',
        'paid_amount',
        'narration',
        'due_amount',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function details()
    {
        return $this->hasMany(PurchaseDetails::class, 'purchases_id', "id");
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }


    public function usersdet()
    {
        return $this->belongsTo(User::class, 'created_by', "id");
    }
}
