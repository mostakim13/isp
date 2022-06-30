<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo',
        'favicon',
        'invoice_logo',
        'company_name',
        'website',
        'phone',
        'email',
        'address',
        'created_by',
        'updated_by',
    ];



    public function getLogoAttribute($val)
    {
        $img = empty($val) ? asset('logo.png') : asset('storage/' . $val);
        return "<img src='{$img}' style='height:55px;' alt='text' />";
    }
    public function getFaviconAttribute($val)
    {
        $img = empty($val) ? asset('img/avatar.png') : asset('storage/' . $val);
        return "<img src='{$img}' style='height:55px;' alt='text' />";
    }
    public function getInvoiceLogoAttribute($val)
    {
        $img = empty($val) ? asset('img/avatar.png') : asset('storage/' . $val);
        return "<img src='{$img}' style='height:55px;' alt='text' />";
    }
}
