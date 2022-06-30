<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'priority',
        'complain_number',
        'complain_time',
        'problem_category',
        'attachments',
        'assign_to',
        'status',
        'note',
        'created_by',
        'updated_by',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'client_id', 'id');
    }

    public function problem()
    {
        return $this->belongsTo(SupportCategory::class, 'problem_category', 'id');
    }

    public function assignUser()
    {
        return $this->belongsTo(User::class, 'assign_to', 'id');
    }

    public function getPriorityAttribute($value)
    {
        if ($value == 'low') {
            $button = "<button class='btn btn-square btn-primary'>Low</button>";
        } elseif ($value == 'medium') {
            $button = "<button class='btn btn-square btn-warning'>Medium</button>";
        } elseif ($value == 'high') {
            $button = "<button class='btn btn-square btn-danger'>High</button>";
        }
        return $button;
    }

    public function getStatusAttribute($value)
    {
        if ($value == 'Pending') {
            $button = "<a href='" . route('supportticket.status', $this->id) . "' class='btn btn-square btn-danger'>Pending</a>";
        } elseif ($value == 'Processing') {
            $button = "<a href='" . route('supportticket.status', $this->id) . "' class='btn btn-square btn-warning'>Processing</a>";
        } elseif ($value == 'Solved') {
            $button = "<button  class='btn btn-square btn-success'>Solved</button>";
        }
        return $button;
    }

    public function getCreatedAtAttribute($value)
    {
        return  Carbon::parse($value)->diffForHumans();
    }

    public function createBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
