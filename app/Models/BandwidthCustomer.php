<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BandwidthCustomer extends Model
{
    use HasFactory;


    protected $fillable = [
        "name",
        "code",
        "contact_person",
        "email",
        "mobile",
        "phone",
        "status",
        "reference_by",
        "address",
        "remarks",
        "facebook",
        "skypeid",
        "website",
        "nttn_info",
        "vlan_info",
        "vlan_id",
        "scr_or_link_id",
        "activition_date",
        "ipaddress",
        "pop_name",
        "username",
        "password",
        "image",
    ];


    public function getImageAttribute($val)
    {
        $img = empty($val) ? asset('img/avatar.png') : asset('storage/' . $val);
        return "<img src='{$img}' style='width:80px;' />";
    }
}
