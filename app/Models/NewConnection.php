<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewConnection extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function zonename()
    {
        return $this->belongsTo(Zone::class, 'zone');
    }
    public function subzonename()
    {
        return $this->belongsTo(Subzone::class, 'subzone');
    }
    public function clienttypes()
    {
        return $this->belongsTo(ClientType::class, 'clienttype');
    }
    public function connectiontypes()
    {
        return $this->belongsTo(ConnectionType::class, 'connectiontype');
    }
    public function packages()
    {
        return $this->belongsTo(Package2::class, 'package_id');
    }
    public function statuses()
    {
        return $this->belongsTo(BillingStatus::class, 'billingstatus');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function employees()
    {
        return $this->belongsTo(Employee::class, 'setup_by');
    }
    public function getIsApproveAttribute($value)
    {

        if ($value == 1) {
            $button = "<button class='btn btn-sm btn-success'>Approved</button>";
        } elseif ($value == 0) {
            $button = "<a class='btn btn-sm btn-warning' onclick ='return confirm(`Are you sure?`)' href='" . route('newconnection.approved', $this->id) . "'>Approve</a>";
        }
        return $button;
    }
}
