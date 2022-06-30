<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\BalanceTransfer;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BalanceTransferController extends Controller
{
    protected $routeName =  'balancetransfer';
    protected $viewName =  'admin.pages.balancetransfer';


    protected function getModel()
    {
        return new BalanceTransfer();
    }

    protected function tableColumnNames()
    {
        return [

            [
                'label' => 'SL',
                'data' => 'id',
                'searchable' => true,
            ],
            [
                'label' => 'Date',
                'data' => 'date',
                'searchable' => false,
            ],
            [
                'label' => 'From Account',
                'data' => 'account_name',
                'searchable' => false,
                'relation' => 'getFormAccount',
            ],
            [
                'label' => 'To Account',
                'data' => 'account_name',
                'searchable' => false,
                'relation' => 'getToAccount',
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
        $page_title = "Balance Transfer";
        $page_heading = "Balance Transfer List";
        $ajax_url = route($this->routeName . '.dataProcessing');
        $create_url = route($this->routeName . '.create');
        $is_show_checkbox = false;
        $columns = $this->reformatForRelationalColumnName(
            $this->tableColumnNames()
        );
        // dd(get_defined_vars());
        return view('admin.pages.index', get_defined_vars());
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
            $this->getModel(),
            //Table Columns Name
            $this->tableColumnNames(),
            //Route name
            $this->routeName,
            true,
            []
        );
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = "Balance Transfer Create";
        $page_heading = "Balance Transfer Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
        $accounts = Account::getaccount()->get();

        return view($this->viewName . '.create', get_defined_vars());
    }

    public function store(Request $request)
    {
        $valideted = $this->validate($request, [
            'from_account_id' => ['required'],
            'to_account_id' => ['required'],
            'date' => ['required'],
            'amount' => ['required'],
            'note' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();
            $valideted['company_id'] = auth()->user()->company_id;
            $valideted['created_by'] = auth()->id();
            $transfer = $this->getModel()->create($valideted);

            $fromaccount = Account::find($request->from_account_id);
            $fromaccount->update(['amount' => $fromaccount->amount - $request->amount]);

            $toaccount = Account::find($request->to_account_id);
            $toaccount->update(['amount' => $toaccount->amount + $request->amount]);

            $transaction['account_id'] = $request->from_account_id;
            $transaction['date'] = $request->_date;
            $transaction['local_id'] = $transfer->id;
            $transaction['type'] = 7;
            $transaction['company_id'] = auth()->user()->company_id;
            $transaction['debit'] = $request->amount;
            $transaction['amount'] = $request->amount;
            $transaction['note'] = $request->note;
            $transaction['created_by'] = auth()->id();
            Transaction::create($transaction);

            $transaction['account_id'] = $request->to_account_id;
            $transaction['date'] = $request->_date;
            $transaction['local_id'] = $transfer->id;
            $transaction['type'] = 7;
            $transaction['company_id'] = auth()->user()->company_id;
            $transaction['credit'] = $request->amount;
            $transaction['amount'] = $request->amount;
            $transaction['note'] = $request->note;
            $transaction['created_by'] = auth()->id();
            Transaction::create($transaction);

            DB::commit();
            return back()->with('success', 'Data Store Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $this->getError($e));
        }
    }

    public function edit(BalanceTransfer $balancetransfer)
    {
        $page_title = "Balance Transfer Edit";
        $page_heading = "Balance Transfer Edit";

        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $balancetransfer->id);
        $editinfo = $balancetransfer;
        return view($this->viewName . '.edit', get_defined_vars());
    }

    public function update(Request $request, BalanceTransfer $balancetransfer)
    {
        $valideted = $this->validate($request, [
            'openingbalance_name' => ['required'],
            'details' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();
            $openingbalance = $balancetransfer->update($valideted);
            DB::commit();
            return back()->with('success', 'Data Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
    }

    public function destroy(BalanceTransfer $balancetransfer)
    {
        $balancetransfer->delete();
        return back()->with('success', 'Data deleted successfully.');
    }
}
