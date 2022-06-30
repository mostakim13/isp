<?php

namespace App\Imports;

use App\Models\Billing;
use App\Models\Customer;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BillingImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $customer = Customer::where('username', $row['idip'])->first();
        if (!empty($customer)) {
            $customer->update([
                'due' => $customer->due + $row['balancedue'],
                'total_paid' =>  $customer->total_paid + $row['received'],
                'advanced_payment' => $customer->advanced_payment + $row['advancepayemnt']
            ]);
        }

        if ($row['balancedue'] > 0 && $row['received'] > 0) {
            $status = 'partial';
        } elseif ($row['balancedue'] > 0 && $row['received'] <= 0) {
            $status = 'unpaid';
        } elseif ($row['balancedue'] <= 0 && $row['received'] > 0) {
            $status = 'paid';
        } else {
            $status = 'unpaid';
        }
        $billing = [];
        if (!empty($customer)) {
            $billing = new Billing([
                "customer_id" => $customer->id,
                "customer_phone" => $customer->phone,
                "company_id" => auth()->id(),
                "customer_billing_amount" =>  $row['mbill'],
                "date_" => date('Y-m-d', strtotime(str_replace('/', '-', $row['paymentdate']))) ?? null,
                "pay_amount" => $row['received'],
                "partial" => $row['balancedue'],
                "discount" => 0,
                "status" => $status,
            ]);
        }

        return $billing;
    }

    // public function headingRow(): int
    // {
    //     return 1;
    // }
}
