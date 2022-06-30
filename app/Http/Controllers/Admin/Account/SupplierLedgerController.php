<?php

namespace App\Http\Controllers\Admin\Account;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SupplierLedgerController extends Controller
{
    protected $routeName =  'supplier_ledger';
    protected $viewName =  'admin.pages.supplier_ledger';

    protected function getModel()
    {
        return new Supplier();
    }

    protected function tableColumnNames()
    {
        return [
            // [
            //     'label' => 'Show in Table header',
            //     'data' => 'action',
            //     'class' => 'text-nowrap', class name
            //     'orderable' => false,
            //     'searchable' => false,
            // ],
            [
                'label' => 'ID',
                'data' => 'id',
                'searchable' => false,
            ],

            [
                'label' => 'Name',
                'data' => 'name',
                'searchable' => false,
            ],

            [
                'label' => 'Mobile Number',
                'data' => 'phone',
                'searchable' => false,
            ],

            [
                'label' => 'Email',
                'data' => 'email',
                'searchable' => false,
            ],

            [
                'label' => 'Address',
                'data' => 'address',
                'searchable' => false,
            ],


            [
                'label' => 'Due Amount',
                'data' => 'due_amount',
                'searchable' => false,
                'relation' => "purchase",
            ],

            // [
            //     'label' => 'Create By',
            //     'data' => 'name',
            //     'searchable' => false,
            //     'relation' => "usersdet",
            // ],

            [
                'label' => 'Action',
                'data' => 'action',
                'class' => 'text-nowrap',
                'orderable' => false,
                'searchable' => false,
            ],

        ];
    }

    public function index()
    {
        $page_title = "Supplier";
        $page_heading = "Supplier Ledger";
        $ajax_url = route($this->routeName . '.dataProcessing');
        // $create_url = route($this->routeName . '.create');
        $is_show_checkbox = false;
        $columns = $this->reformatForRelationalColumnName(
            $this->tableColumnNames()
        );
        return view('admin.pages.index', get_defined_vars());
    }

    public function dataProcessing(Request $request)
    {
        return $this->getDataResponse(
            //Model Instance
            $this->getModel(),
            //Table Columns Name
            $this->tableColumnNames(),
            //Route name
            $this->routeName,
            true,
            [
                [
                    'method_name' => 'pay',
                    'class' => 'btn-success',
                    'fontawesome' => 'fa fa-edit',
                    'text' => '',
                    'title' => 'View',
                ],
            ]
        );
    }

    public function edit(Supplier $supplier)
    {
        $page_title = "Supplier Ledger Edit";
        $page_heading = "Supplier Ledger Edit";
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $supplier->id);
        $editinfo = $supplier;
        return view($this->viewName . '.edit', get_defined_vars());
    }
    public function pay(Supplier $supplierledger)
    {
        $page_title = "Supplier Ledger Pay";
        $page_heading = "Supplier Ledger Pay";
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $supplierledger->id);
        $supplierInfo = $supplierledger;

        $invoice = Purchase::where('supplier_id', $supplierledger->id)->where('due_amount', '>', 0)->get();
        // dd($invoice);
        $accounts = Account::getaccount()->get();
        return view($this->viewName . '.pay', get_defined_vars());
    }

    public function update(Request $request, Supplier $supplier)
    {

        $valideted = $this->validate($request, [
            'date' => ['required'],
            'account_id' => ['required'],
            'invoice_no' => ['required'],
            'paid_amount' => ['required'],
            'description' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();
            $purchaseIn = Purchase::find($request->invoice_no);

            if ($purchaseIn->due_amount < $request->paid_amount) {
                return back()->with('failed', 'You can not pay greater than due amount');
            }

            $old_amount = Account::find($request->account_id);
            $account_amount['amount'] = $old_amount->amount - $request->paid_amount;
            $old_amount->update($account_amount);

            $transaction['account_id'] = $request->account_id;
            $transaction['supplier_id'] = $supplier->id;
            $transaction['purchase_id'] = $request->invoice_no;
            $transaction['date'] = $request->date;
            $transaction['type'] = 4;
            $transaction['debit'] = $request->paid_amount;
            $transaction['amount'] = $purchaseIn->due_amount;
            $transaction['due'] = $purchaseIn->due_amount - $request->paid_amount;
            $transaction['note'] = $request->description;
            $transaction['created_by'] = Auth::id();
            Transaction::create($transaction);

            $amount['due_amount'] = $purchaseIn->due_amount - $request->paid_amount;
            $amount['paid_amount'] = $purchaseIn->paid_amount + $request->paid_amount;
            $purchaseIn->update($amount);

            DB::commit();
            return back()->with('success', 'Data Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
    }
}
