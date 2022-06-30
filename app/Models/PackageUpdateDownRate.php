<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageUpdateDownRate extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function package()
    {
        return $this->belongsTo(Package2::class, 'package_id');
    }
}
