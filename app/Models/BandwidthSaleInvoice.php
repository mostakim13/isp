<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BandwidthSaleInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'invoice_no',
        'billing_month',
        'payment_due',
        'received_amount',
        'discount',
        'due',
        'status',
        'remark',
        'total',
        'created_by',
        'updated_by',
    ];

    public function detaile()
    {
        return $this->hasMany(BandwidthSaleInvoiceDetails::class, 'bandwidth_sale_invoice_id', 'id');
    }
    public function customer()
    {
        return $this->belongsTo(BandwidthCustomer::class, 'customer_id', 'id');
    }
}
