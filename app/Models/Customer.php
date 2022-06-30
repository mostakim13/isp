<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'mid',
        'name',
        'username',
        'advanced_payment',
        'father_name',
        'mother_name',
        'spouse_name',
        'nid',
        'passport',
        'dob',
        'email',
        'reference',
        'zone_id',
        'subzone_id',
        'comment',
        'm_p_p_p_profile',
        'package_id',
        'password',
        'm_password',
        'secreat',
        'phone',
        'billing_person',
        'doc_image',
        'mac_address',
        'ip_address',
        'remote_address',
        'address',
        'bill_amount',
        'connection_date',
        'duration',
        'start_date',
        'exp_date',
        'total_paid',
        'due',
        'group_id',
        'service',
        'caller',
        'routes',
        'limit_bytes_in',
        'limit_bytes_out',
        'last_logged_out',
        'speed',
        'status',
        'disabled',
        'is_notify',
        'protocol_type_id',
        'device_id',
        'connection_type_id',
        'client_type_id',
        'billing_status_id',
        'bill_collection_date',
        'server_id',
        'billing_type',
        'company_id',
        'queue_target',
        'queue_dst',
        'queue_max_upload',
        'queue_max_download',
        'queue_disabled',
        'queue_mid'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'billing_person', 'id');
    }

    // public function PaymentMethod()
    // {
    //     return $this->belongsTo(PaymentMethod::class, 'payment_method_id', 'id');
    // }

    public function getProfile()
    {
        return $this->belongsTo(Package2::class, 'package_id', 'id');
    }
    public function getMProfile()
    {
        return $this->belongsTo(MPPPProfile::class, 'm_p_p_p_profile', 'id');
    }
    public function getZone()
    {
        return $this->belongsTo(Zone::class, 'zone_id', 'id');
    }
    public function getConnectionType()
    {
        return $this->belongsTo(ConnectionType::class, 'connection_type_id', 'id');
    }
    public function getClientType()
    {
        return $this->belongsTo(ClientType::class, 'client_type_id', 'id');
    }
    public function getBillingStatus()
    {
        return $this->belongsTo(BillingStatus::class, 'billing_status_id', 'id');
    }
    public function getProtocolType()
    {
        return $this->belongsTo(Protocol::class, 'protocol_type_id', 'id');
    }

    public function getMikserver()
    {
        return $this->belongsTo(MikrotikServer::class, 'server_id', 'id');
    }

    public function getCompany()
    {
        return $this->belongsTo(Package2::class, 'package_id', 'id');
    }
}
