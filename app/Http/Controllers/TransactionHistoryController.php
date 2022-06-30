<?php

namespace App\Http\Controllers;

use App\Models\TransactionHistory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TransactionHistoryController extends Controller
{

    public function store(array $arrayValue)
    {
        TransactionHistory::create($arrayValue);
        return true;
    }
}
