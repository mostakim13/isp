<?php

namespace App\Helpers;

use App\Models\Billing as ModelBilling;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class Billing
{

    public function start()
    {
        // akhane ase just 7 din por expire customer list show
        $customerLists = Customer::where('billing_status_id', 5);
        $customerList =  $customerLists->whereDate('exp_date', today()->addDays(2)->format('Y-m-d'))->get();
        if ($customerList->isNotEmpty()) {
            foreach ($customerList as $customer) {
                $message = "Dear Sir, Your internet billing amount is " . $customer->bill_amount . " Please Pay Your Internet Bill, Otherwise Your connection will be disconnected.";

                $billing =  ModelBilling::firstOrCreate([
                    'date_' => $customer->start_date,
                    'customer_id' => $customer->id,
                ], [
                    'company_id' => $customer->company_id,
                    'customer_phone' => $customer->phone,
                    'customer_profile_id' => $customer->package_id,
                    'customer_billing_amount' => $customer->bill_amount,
                    'biller_name' => $customer->billing_person,
                    'type' => "collection",
                    'status' => "unpaid"
                ]);
                if ($billing->wasRecentlyCreated) {
                    $this->smsSend($customer->phone, $message);
                };
            }
        }

        $customerExpire = $customerLists->whereDate('exp_date', '=', today()->addDays(1)->format('Y-m-d'))->get();
        if ($customerExpire->isNotEmpty()) {
            foreach ($customerExpire as $customer) {
                $message = "Dear Sir, Please Pay Your Internet Bill, Otherwise Your connection will be disconnected tomorrow.";
                $this->smsSend($customer->phone, $message);
                $billing = ModelBilling::firstOrCreate([
                    'date_' => $customer->start_date,
                    'customer_id' => $customer->id,
                ], [
                    'company_id' => $customer->company_id,
                    'customer_phone' => $customer->phone,
                    'customer_profile_id' => $customer->m_p_p_p_profile_id,
                    'customer_billing_amount' => $customer->bill_amount,
                    'biller_name' => $customer->billing_person,
                    'type' => "collection",
                    'alert' => "red",
                ]);
                if ($billing->wasRecentlyCreated) {
                    $this->smsSend($customer->phone, $message);
                };
            }
        }

        $customerExpired = $customerLists->whereDate('exp_date', '=', today()->format('Y-m-d'))->get();
        if ($customerExpired->isNotEmpty()) {
            foreach ($customerExpired as $customer) {
                $message = "Dear Sir, Your connection wash disconnected";
                $this->smsSend($customer->phone, $message);
                $billing = ModelBilling::firstOrCreate([
                    'date_' => $customer->start_date,
                    'customer_id' => $customer->id,
                ], [
                    'company_id' => $customer->company_id,
                    'customer_phone' => $customer->phone,
                    'customer_profile_id' => $customer->m_p_p_p_profile_id,
                    'customer_billing_amount' => $customer->bill_amount,
                    'biller_name' => $customer->billing_person,
                    'type' => "expired",
                    'alert' => "red",
                ]);
                if ($billing->wasRecentlyCreated) {
                    $this->smsSend($customer->phone, $message);
                };
                $customer->update(['disabled' => true]);
            }
        }
    }

    public function smsSend($number, $message)
    {
        $url = "https://sms.solutionsclan.com/api/sms/send";
        $data = [
            "apiKey" => "A000109b1eaf6f7-1748-456d-ac14-ccccb8b70bc2",
            "contactNumbers" => $number,
            "senderId" => "8809612441117",
            "textBody" => $message
        ];

        // Http::post($url, $data);
    }
}
