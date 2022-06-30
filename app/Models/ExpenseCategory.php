<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        "company_id",
        "updated_by",
        "created_by",
        "deleted_by",
        "company_id",
        "name",
        "description",
        "status",
    ];
}
