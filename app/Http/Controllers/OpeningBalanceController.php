<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\OpeningBalance;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OpeningBalanceController extends Controller
{
    protected $routeName =  'openingbalance';
    protected $viewName =  'admin.pages.openingbalance';


    protected function getModel()
    {
        return new OpeningBalance();
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
                'data' => '_date',
                'searchable' => false,
            ],
            [
                'label' => 'Account Name',
                'data' => 'account_name',
                'searchable' => false,
                'relation' => 'getAccount',
            ],
            [
                'label' => 'Amount',
                'data' => 'amount',
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
        $page_title = "Opening Balance";
        $page_heading = "Opening Balance List";
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
        $page_title = "Opening Balance Create";
        $page_heading = "Opening Balance Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
        $accounts = Account::getaccount()->get();

        return view($this->viewName . '.create', get_defined_vars());
    }

    public function store(Request $request)
    {
        $valideted = $this->validate($request, [
            '_date' => ['required'],
            'account_id' => ['required'],
            'amount' => ['required'],
            'note' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();
            $valideted['company_id'] = auth()->user()->company_id;
            $valideted['created_by'] = auth()->id();
            $opening = $this->getModel()->create($valideted);

            $account = Account::find($request->account_id);
            $account->update(['amount' => $account->amount + $request->amount]);

            $transaction['account_id'] = $request->account_id;
            $transaction['date'] = $request->_date;
            $transaction['company_id'] = auth()->user()->company_id;
            $transaction['local_id'] = $opening->id;
            $transaction['type'] = 6;
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

    public function edit(openingbalance $openingbalance)
    {
        $page_title = "Opening Balance Edit";
        $page_heading = "Opening Balance Edit";

        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $openingbalance->id);
        $editinfo = $openingbalance;
        return view($this->viewName . '.edit', get_defined_vars());
    }

    public function update(Request $request, openingbalance $openingbalance)
    {
        $valideted = $this->validate($request, [
            'openingbalance_name' => ['required'],
            'details' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();
            $openingbalance = $openingbalance->update($valideted);
            DB::commit();
            return back()->with('success', 'Data Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
    }

    public function destroy(openingbalance $openingbalance)
    {
        $openingbalance->delete();
        return back()->with('success', 'Data deleted successfully.');
    }
}
