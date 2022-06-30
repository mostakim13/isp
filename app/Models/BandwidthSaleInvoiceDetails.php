<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BandwidthSaleInvoiceDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'bandwidth_sale_invoice_id',
        'item_id',
        'description',
        'unit',
        'qty',
        'rate',
        'vat',
        'from_date',
        'to_date',
        'total',
    ];
}
