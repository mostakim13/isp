<?php

namespace App\Helpers;

use App\Models\Salary;

trait EmployeSalaryFun
{
    public function paidable($usermodel, $amountpay, $date)
    {
        $paid = Salary::where('date_', 'like', '%' . $date . '%')->where('user_id', $usermodel->user_id)->get();
        if ($paid->isNotEmpty()) {
            $usermodel->update(['paidable' =>  abs($amountpay - $usermodel->paidable)]);
        } else {
            $paidable =  $usermodel->salary - $amountpay;
            $usermodel->update(['paidable' => $usermodel->paidable + $paidable]);
        }
        return true;
    }

    public function checkamount($usermodel, $date, $amount)
    {
        $paid = Salary::where('date_', 'like', '%' . $date . '%')->where('user_id', $usermodel->user_id)->sum('amount');
        $calculation = abs($paid - $usermodel->salary);
        return $calculation >=  $amount ? true : false;
    }
}
