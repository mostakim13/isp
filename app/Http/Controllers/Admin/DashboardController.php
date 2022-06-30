<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BandwidthCustomer;
use App\Models\Billing;
use App\Models\Customer;
use App\Models\MacReseller;
use App\Models\Product;
use App\Models\Supplier;

class DashboardController extends Controller
{

    public function index()
    {
        $customers = Customer::where('company_id', auth()->user()->company_id)->count();
        $active_customers = Customer::where('billing_status_id', 5)->count();
        $inactive_customers = Customer::where('billing_status_id', 4)->count();
        $new_customers = Customer::whereMonth('created_at', today()->format('m-Y'))->count();
        $suppliers = Supplier::count();
        $products = Product::count();
        $todays_billings = Billing::whereDate('updated_at', today())->sum('pay_amount');
        $total_billings = Customer::sum('total_paid');

        $total_unpaids = Customer::whereNull('total_paid')->whereNull('due')->count();
        $paid_customers = Customer::where('due', "<=", 0)->count();
        $partial_customers = Customer::where('due', ">", 0)->count();
        // $total_due = Billing::whereNotNull('due')->sum('due');
        $partial_dues = Billing::whereNotNull('partial')->sum('partial');
        $unpaid_dues = Billing::where('status', 'unpaid')->sum('customer_billing_amount');

        $total_due = $partial_dues + $unpaid_dues;

        $macsallers = MacReseller::count();
        $bandwith_clients = BandwidthCustomer::count();
        $billings = Billing::where('date_', today()->format('d-m-Y'))->get();
        return view('admin.pages.dashboard', get_defined_vars());
    }
}
