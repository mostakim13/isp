<?php

namespace App\Http\Controllers\Admin\Account;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class BillTransferController extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'billtransfer';
    protected $viewName =  'admin.pages.accounts.billtransfer';

    protected function getModel()
    {
        return new Transaction();
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
                'label' => 'From Payment Method',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'paymentmethod',
            ],

            [
                'label' => 'To Account',
                'data' => 'account_name',
                'searchable' => false,
                'relation' => 'BillTransAccount',
            ],

            [
                'label' => 'Amount',
                'data' => 'amount',
                'searchable' => false,
            ],

            [
                'label' => 'Note',
                'data' => 'note',
                'searchable' => false,
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
        $page_title = "Transfer";
        $page_heading = "Transfer List";
        $ajax_url = route($this->routeName . '.dataProcessing');
        $create_url = route($this->routeName . '.create');
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
            $this->getModel()->where('type', 9),
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
        $page_title = "Transfer Create";
        $page_heading = "Transfer Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
        $paymentmethods = PaymentMethod::where('company_id', auth()->user()->id)->get();
        $accounts = Account::getaccount()->get();
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
            'local_id' => ['required'],
            'account_id' => ['required'],
            'amount' => ['required'],
            'note' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();

            $paymentmethod = PaymentMethod::find($request->local_id);
            $paymentmethod->update(['amount' => $paymentmethod->amount - $request->amount]);

            $account = Account::find($request->account_id);
            $account->update(['amount' => $account->amount + $request->amount]);

            $valideted['type'] = 9;
            $valideted['company_id'] = auth()->user()->company_id;
            $valideted['created_by'] = auth()->id();
            Transaction::create($valideted);
            DB::commit();
            return back()->with('success', 'Data Store Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Something was wrong');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        $page_title = "Transfer Edit";
        $page_heading = "Transfer Edit";
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $transaction->id);
        $editinfo = $transaction;
        $paymentmethods = PaymentMethod::where('company_id', auth()->user()->id)->get();
        $accounts = Account::getaccount()->get();
        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        $valideted = $this->validate($request, [
            'local_id' => ['required'],
            'account_id' => ['required'],
            'amount' => ['required'],
            'note' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();

            $oldpaymentmethod = PaymentMethod::find($transaction->local_id);
            $oldpaymentmethod->update(['amount' => $oldpaymentmethod->amount + $transaction->amount]);
            $paymentmethod = PaymentMethod::find($request->local_id);
            $paymentmethod->update(['amount' => $paymentmethod->amount - $request->amount]);


            $oldaccount = Account::find($transaction->account_id);
            $oldaccount->update(['amount' => $oldaccount->amount - $transaction->amount]);
            $account = Account::find($request->account_id);
            $account->update(['amount' => $account->amount + $request->amount]);

            $valideted['created_by'] = auth()->id();
            $transaction->update($valideted);
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
    public function destroy(Account $Account)
    {
        $Account->delete();
        return back()->with('success', 'Data deleted successfully.');
    }
}
