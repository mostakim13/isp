<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'dob',
        'gender',
        'personal_phone',
        'office_phone',
        'marital_status',
        'nid',
        'email',
        'reference',
        'designation_id',
        'department_id',
        'experience',
        'present_address',
        'permanent_address',
        'achieved_degree',
        'institution',
        'passing_year',
        'salary',
        'join_date',
        'status',
        'image',
        'is_login'
    ];

    public function employelist()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
