<?php

namespace App\Http\Controllers\Admin\Billing;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\Customer;
use App\Models\DailyIncome;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationData;

class BillingController extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'billcollect';
    protected $viewName =  'admin.pages.billcollect';

    protected function getModel()
    {
        return new Billing();
    }

    protected function tableColumnNames()
    {
        return [
            [
                'label' => 'ID',
                'data' => 'id',
                'searchable' => false,
            ],
            [
                'label' => 'Customer',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'getCustomer',
            ],
            [
                'label' => 'EXP Date',
                'data' => 'exp_date',
                'searchable' => false,
                'relation' => 'getCustomer',
            ],
            [
                'label' => 'Customer Phone',
                'data' => 'customer_phone',
                'searchable' => false,
            ],
            [
                'label' => 'Customer Profile Id',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'getProfile',
            ],
            [
                'label' => 'Payment Method',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'PaymentMethod',
            ],
            [
                'label' => 'Customer Billing Amount',
                'data' => 'customer_billing_amount',
                'searchable' => false,
            ],
            [
                'label' => 'Biller Name',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'getBiller',
            ],

            [
                'label' => 'Action',
                'data' => 'action',
                'class' => 'text-nowrap',
                'orderable' => false,
                'searchable' => false,
            ],

        ];
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = "Bill Collection";
        $page_heading = "Bill Collection List";
        $ajax_url = route($this->routeName . '.dataProcessing');
        $create_url = route($this->routeName . '.create');
        $is_show_checkbox = false;
        $paymentmethods = PaymentMethod::where('status', 'active')->get();
        $columns = $this->reformatForRelationalColumnName(
            $this->tableColumnNames()
        );
        return view($this->viewName . '.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dataProcessing()
    {

        return $this->getDataResponse(
            //Model Instance
            $this->getModel()->where('company_id', auth()->user()->company_id)
                ->where('status', 'unpaid')->whereMonth('date_', date('m'))->whereYear('date_', date('Y')),
            //Table Columns Name
            $this->tableColumnNames(),
            //Route name
            $this->routeName,
            true,
            [
                [
                    'method_name' => 'pay',
                    'class' => 'btn-info  btn-sm paymodel',
                    'fontawesome' => '',
                    'text' => 'Pay',
                    'title' => 'View',
                    'code' => "data-toggle='modal' data-target='#default'",
                ],
                [
                    'method_name' => 'payment',
                    'class' => 'btn-success btn-sm',
                    'fontawesome' => '',
                    'text' => 'View',
                    'title' => 'View',
                ],
                [
                    'method_name' => 'invoice',
                    'class' => 'btn-info btn-sm',
                    'fontawesome' => '',
                    'text' => 'Inv',
                    'title' => 'View',
                ],
            ]

        );
    }

    public function create()
    {
        $page_title = "Bill Create";
        $page_heading = "Bill Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
        $customers = Customer::where('disabled', false)->get();
        $users = User::all();
        $paymentMethods = PaymentMethod::where('status', 'active')->get();
        return view($this->viewName . '.create', get_defined_vars());
    }

    public function store(Request $request)
    {
        $validation = $this->validate($request, [
            "customer_id" => "required",
            "biller_name" => "required",
            "customer_billing_amount" => "required",
            "payment_method_id" => "required",
            "date_" => "required",
            "pay_amount" => "nullable",
            "partial" => "nullable",
            "discount" => "nullable",
            "description" => "nullable",
            "status" => "required",
        ]);

        try {
            $customer = Customer::find($request->customer_id);
            $customer->total_paid = $customer->total_paid ?? 0 + $request->pay_amount;
            $customer->due = $customer->due ?? 0 + $request->partial;
            $customer->save();

            $validation['customer_phone'] = $customer->phone;
            $validation['customer_profile_id'] = $customer->m_p_p_p_profile_id;
            $validation['company_id'] = auth()->user()->company_id;
            $validation['type'] = "collection";
            $validation['billing_by'] = auth()->id();

            Billing::create($validation);
            return redirect()->route('billcollect.index')->with('success', 'Payment Successfully Done !!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bill Collection  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Billing $billing)
    {
        $modal_title = 'Bill Collection Details';
        $modal_data = $billing;
        $html = view($this->viewName . '.show', get_defined_vars())->render();
        return $html;
    }

    public function payment(Billing $billing)
    {
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $billing->id);
        $data = $billing;
        $paymentMethods = PaymentMethod::where('status', 'active')->get();
        $customerPaymentDetails = Billing::where('customer_id', $billing->customer_id)->where('status', '!=', 'unpaid')->get();
        $customerDetails = Billing::where('customer_id', $billing->customer_id)->where('status', '!=', 'paid')->get();
        return view('admin.pages.billcollect.pay', get_defined_vars());
    }

    public function paylist(Billing $billing)
    {
        $back_url = route($this->routeName . '.index');
        $customerPaymentDetails = Billing::where('customer_id', $billing->customer_id)->where('status', '!=', 'unpaid')->get();
        return view('admin.pages.billcollect.pay', get_defined_vars());
    }

    public function pay(Request $request, Billing $billing)
    {
        $this->validate($request, [
            'payment_method_id' => ['required'],
        ]);
        try {
            $billing->update([
                'alert' => "white",
                'pay_amount' => $billing->customer_billing_amount,
                "payment_method_id" => $request->payment_method_id,
                'status' => 'paid',
                'billing_by' => auth()->id()
            ]);

            $paymentMethods = PaymentMethod::find($request->payment_method_id);
            $paymentMethods ? $paymentMethods->update(['amount' => $paymentMethods->amount + $billing->customer_billing_amount]) : null;

            // $transaction['account_id'] = $request->account_id;
            $transaction['date'] = $billing->getCustomer->start_date;
            $transaction['local_id'] = $request->payment_method_id ?? null;
            $transaction['type'] = 8;
            $transaction['company_id'] = auth()->user()->company_id;
            $transaction['debit'] = $billing->customer_billing_amount;
            $transaction['amount'] = $billing->customer_billing_amount;
            // $transaction['note'] = $request->description;
            $transaction['created_by'] = auth()->id();
            Transaction::create($transaction);

            $startDate = Carbon::parse($billing->getCustomer->start_date)->addMonths($billing->getCustomer->duration);
            $endDate = Carbon::parse($startDate)->addMonths($billing->getCustomer->duration)->addDay($billing->getCustomer->bill_collection_date)->format('Y-m-d');
            $billing->getCustomer->update([
                'start_date' => $startDate,
                'exp_date' => $endDate,
                'disabled' => 'false',
                "total_paid" => $billing->getCustomer->total_paid +  $billing->customer_billing_amount,

            ]);

            return redirect()->route('billcollect.index')->with('success', 'Payment Successfully Done !!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
    }

    public function invoice(Billing $billing)
    {
        $customerPaymentDetails = Billing::where('customer_id', $billing->customer_id)->where('status', '!=', 'paid')->get();
        $serviceCharges = DailyIncome::where('customer_id', $billing->customer_id)->get();
        return view($this->viewName . '.invoice', get_defined_vars());
    }



    public function update(Request $request, Billing $billing)
    {
        if ($request->pay_type == 'full_pay') {
            $valideted = $this->validate($request, [
                'pay_amount' => ['nullable'],
                'discount' => ['nullable'],
                'month' => ['nullable'],
                'payment_method_id' => ['required'],
                'pay_type' => ['required'],
                'description' => ['nullable'],
            ]);
        } elseif ($request->pay_type == 'partial') {
            $valideted = $this->validate($request, [
                'pay_amount' => ['required'],
                'payment_method_id' => ['required'],
                'discount' => ['nullable'],
                'month' => ['required'],
            ]);
        }
        try {
            DB::beginTransaction();
            $billingsub = Billing::find($request->month);
            // $transaction['account_id'] = $request->account_id;

            if ($request->pay_type == 'full_pay') {
                DB::beginTransaction();
                $valideted['billing_by'] = auth()->id();
                $billing->update($valideted);
                $customerDetails = Billing::where('customer_id', $billing->customer_id)
                    ->where('status', '!=', 'paid')
                    ->get();

                foreach ($customerDetails as $paid) {
                    $paid->update([
                        'partial' => 0,
                        'pay_amount' => $paid->customer_billing_amount,
                        'status' => 'paid'
                    ]);

                    $paymentMethods = PaymentMethod::find($request->payment_method_id);
                    $paymentMethods ? $paymentMethods->update(['amount' => $paymentMethods->amount + $paid->customer_billing_amount]) : null;

                    $transaction['date'] = $paid->getCustomer->start_date;
                    $transaction['local_id'] = $request->payment_method_id ?? null;
                    $transaction['type'] = 8;
                    $transaction['company_id'] = auth()->user()->company_id;
                    $transaction['debit'] =  $paid->customer_billing_amount;
                    $transaction['amount'] = $paid->customer_billing_amount;
                    $transaction['note'] = $request->description;
                    $transaction['created_by'] = auth()->id();
                    Transaction::create($transaction);
                }
                $customer['total_paid'] = $billing->getCustomer->total_paid + $billing->getCustomer->due; //+ $paidAmount;
                $customer['due'] = 0;
                $billing->getCustomer->update($customer);
            } elseif ($request->pay_type == 'partial') {
                // $amount = $billingsub->getCustomer->bill_amount - $request->discount;
                $amount = $billingsub->customer_billing_amount - $request->discount;
                $paidAmount = $request->pay_amount;
                $total = abs($amount -  $paidAmount);
                // dd($billingsub->getCustomer->due +  $total);
                if (empty($billingsub->partial)) {
                    if ($request->filled('extend_date')) {
                        $billingsub->getCustomer->update(['exp_date' => Carbon::parse($billingsub->getCustomer->exp_date)->addDay($request->extend_date)->format('Y-m-d')]);
                    } else {
                        $startDate = Carbon::parse($billing->getCustomer->start_date)->addMonths($billing->getCustomer->duration);
                        $endDate = Carbon::parse($startDate)->addMonths($billing->getCustomer->duration)->addDay($billing->getCustomer->bill_collection_date)->format('Y-m-d');
                        $billingsub->getCustomer->update(['start_date' => $startDate, 'exp_date' => $endDate]);
                    }
                    $duepaid['partial'] = $billingsub->partial + $total;
                    $billingsub->getCustomer->update(
                        [
                            'total_paid' => $billingsub->getCustomer->total_paid + $paidAmount,
                            'due' => $billingsub->getCustomer->due +  $total
                        ]
                    );
                } else {
                    $duepaid['partial'] = $billingsub->partial - $paidAmount;
                    $billingsub->getCustomer->update(
                        [
                            'total_paid' => $billingsub->getCustomer->total_paid + $paidAmount,
                            'due' => $billingsub->getCustomer->due -  $paidAmount
                        ]
                    );
                }
                $duepaid['status'] =  $amount > $paidAmount ? "partial" : "paid";
                $duepaid['pay_amount'] = $billingsub->pay_amount + $paidAmount;
                $duepaid['payment_method_id'] = $request->payment_method_id;
                $duepaid['discount'] = $request->discount;
                $duepaid['billing_by'] = auth()->id();
                $billingsub->update($duepaid);

                $paymentMethods = PaymentMethod::find($request->payment_method_id);
                $paymentMethods ? $paymentMethods->update(['amount' => $paymentMethods->amount + $paidAmount]) : null;

                $transaction['date'] = $billingsub->getCustomer->start_date;
                $transaction['local_id'] = $request->payment_method_id ?? null;
                $transaction['type'] = 8;
                $transaction['company_id'] = auth()->user()->company_id;
                $transaction['debit'] =  $billingsub->customer_billing_amount;
                $transaction['amount'] = $billingsub->customer_billing_amount;
                $transaction['note'] = $request->description;
                $transaction['created_by'] = auth()->id();
                Transaction::create($transaction);
            } else {
                return back()->with('failed', 'Opps...Something was Wrong');
            }
            DB::commit();
            return back()->with('success', 'Data Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
    }
}
