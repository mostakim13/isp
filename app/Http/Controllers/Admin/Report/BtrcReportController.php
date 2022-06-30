<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class BtrcReportController extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'reports';
    protected $viewName =  'admin.pages.reports';

    protected function getModel()
    {
        return new Customer();
    }

    protected function tableColumnNames()
    {
        return [
            // [
            //     'label' => "name_operator",
            //     'data' => "name",
            //     'searchable' => false,
            // ],
            // [
            //     'label' => "type_of_client",
            //     'data' => "type_of_client",
            //     'searchable' => false,
            // ],
            // [
            //     'label' => "distribution Location point",
            //     'data' => "distribution",
            //     'searchable' => false,
            // ],
            [
                'label' => "name_of_client",
                'data' => "name",
                'searchable' => false,
            ],
            [
                'label' => "type_of_connection",
                'data' => "connection_type",
                'searchable' => false,
            ],
            // [
            //     'label' => "type_of_connectivity",
            //     'data' => "type_of_connectivity",
            //     'searchable' => false,
            // ],
            [
                'label' => "activation_date",
                'data' => "start_date",
                'searchable' => false,
            ],
            [
                'label' => "bandwidth_allocation MB",
                'data' => "speed",
                'searchable' => false,
            ],
            [
                'label' => "allowcated_ip",
                'data' => "username",
                'searchable' => false,
            ],
            [
                'label' => "house_no",
                'data' => "address",
                'searchable' => false,
            ],
            // [
            //     'label' => "road_no",
            //     'data' => "road_no",
            //     'searchable' => false,
            // ],
            [
                'label' => "area",
                'data' => "zone_id",
                'searchable' => false,
            ],
            [
                'label' => "client_phone",
                'data' => "phone",
                'searchable' => false,
            ],
            [
                'label' => "mail",
                'data' => "email",
                'searchable' => false,
            ],
            [
                'label' => "selling_bandwidthBDT (Excluding VAT)",
                'data' => "bill_amount",
                'searchable' => false,
            ],
            // [
            //     'label' => 'Action',
            //     'data' => 'action',
            //     'class' => 'text-nowrap',
            //     'orderable' => false,
            //     'searchable' => false,
            // ],
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = "BTRC Report";
        $page_heading = "BTRC Report";
        $ajax_url = route($this->routeName . '.dataProcessing');
        // $create_url = route($this->routeName . '.create');
        $is_show_checkbox = false;
        $columns = $this->reformatForRelationalColumnName(
            $this->tableColumnNames()
        );
        return view('admin.pages.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dataProcessing(Request $request)
    {
        return $this->getDataResponse(
            //Model Instance
            $this->getModel(),
            //Table Columns Name
            $this->tableColumnNames(),
            //Route name
            $this->routeName
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = "Purchase Create";
        $page_heading = "Purchase Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
        $purchaseLastData = Purchase::latest('id')->pluck('id')->first() ?? "0";
        $invoice_no = 'PV' . str_pad($purchaseLastData + 1, 5, "0", STR_PAD_LEFT);
        $supplier = Supplier::get();
        $category_info  = ProductCategory::withCount('products')->get();
        $account = Account::get();
        // dd($purchaseLastData);
        return view($this->viewName . '.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valideted = $this->validate($request, [
            'date' => ['required'],
            'supplier_id' => ['required'],
            'invoice_no' => ['required'],
            'payment_type' => ['required'],
            'account_id' => ['nullable'],
            'discount' => ['nullable'],
            'narration' => ['nullable'],
            'paid_amount' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();
            $grandTotal = array_sum($request->total) - $request->discount;
            $dueAmount = $this->dueAmount($grandTotal, $request->paid_amount);

            $valideted['subtotal'] = array_sum($request->total);
            $valideted['quantity'] = array_sum($request->qty);
            $valideted['due_amount'] = $dueAmount;
            $valideted['grand_total'] = abs($grandTotal);
            $valideted['created_by'] = auth()->id();
            $purchase =  Purchase::create($valideted);

            $this->productDetailsWithStock($purchase, $request);

            if ($request->account_id) {
                $this->accountBalanceReduct(Account::find($request->account_id), $request->paid_amount);
            }

            $this->supplierUnpaid(Supplier::find($request->supplier_id), $dueAmount);

            $transaction['account_id'] = $request->account_id;
            $transaction['supplier_id'] = $request->supplier_id;
            $transaction['purchase_id'] = $purchase->id;
            $transaction['type'] = 1;
            $transaction['date'] = $request->date;
            $transaction['credit'] = $request->paid_amount;
            $transaction['amount'] = $request->paid_amount;
            $transaction['due'] = $dueAmount;
            $transaction['note'] = $request->narration;
            $transaction['created_by'] = auth()->id();
            Transaction::create($transaction);

            DB::commit();
            return back()->with('success', 'Data Store Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Something was wrong' . $e->getMessage() . 'Line' . $e->getLine() . 'File' . $e->getFile());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Purchase $purchase)
    {
        dd($purchase);
        return view($this->viewName . '.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        $page_title = "Purchase Edit";
        $page_heading = "Purchase Edit";
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $purchase->id);
        $supplier = Supplier::get();
        $category_info  = ProductCategory::get();
        $accounts = Account::get();
        $editinfo = $purchase;
        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purchase $purchase)
    {
        $valideted = $this->validate($request, [
            'name' => ['required'],
            'phone' => ['required'],
            'email' => ['nullable'],
            'address' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();

            $purchase->update($valideted);

            DB::commit();
            return back()->with('success', 'Data Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        $purchase->delete();
        return back()->with('success', 'Data deleted successfully.');
    }
}
