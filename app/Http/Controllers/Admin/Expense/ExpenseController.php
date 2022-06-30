<?php

namespace App\Http\Controllers\Admin\Expense;

use App\Models\Expense;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Customer;
use App\Models\ExpenseCategory;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'expenses';
    protected $viewName =  'admin.pages.expenses';

    protected function getModel()
    {
        return new Expense();
    }

    protected function tableColumnNames()
    {
        return [
            [
                'label' => 'Date',
                'data' => 'date',
                'searchable' => false,
            ],
            [
                'label' => 'Expense',
                'data' => 'name',
                'customesearch' => 'expense_category_id',
                'relation' => 'expense_category',
                'searchable' => false,
            ],
            [
                'label' => 'Customer',
                'data' => 'name',
                'customesearch' => 'customer_id',
                'searchable' => false,
                'relation' => 'customer'
            ],
            [
                'label' => 'Account',
                'data' => 'account_name',
                'customesearch' => 'account_id',
                'relation' => 'accountlist',
                'searchable' => false,
            ],
            [
                'label' => 'Payment Method',
                'data' => 'name',
                'customesearch' => 'pay_method_id',
                'relation' => 'paymentmethod',
                'searchable' => false,
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
        $page_title = "Expense";
        $page_heading = "Expense List";
        $ajax_url = route($this->routeName . '.dataProcessing');
        $create_url = route($this->routeName . '.create');
        $is_show_checkbox = false;
        $columns = $this->reformatForRelationalColumnName(
            $this->tableColumnNames()
        );
        $accounts = Account::getaccount()->get();
        $paymentods = PaymentMethod::where('status', 'active')->where('company_id', auth()->user()->company_id)->get();
        $expensecategorys = ExpenseCategory::where('status', 'Active')->get();
        $customers = Customer::where('company_id', auth()->user()->company_id)->get();
        return view($this->viewName . '.index', get_defined_vars());
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
            $this->getModel()->orderBy('id', 'desc'),
            //Table Columns Name
            $this->tableColumnNames(),
            //Route name
            $this->routeName,
            true,
            ['edit']
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = "Expense Create";
        $page_heading = "Expense Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
        $customers = Customer::where('company_id', auth()->user()->company_id)->get();
        $account = Account::getaccount()->get();
        $payMethods = PaymentMethod::where('status', 'active')->get();
        $categories = ExpenseCategory::where('status', 'Active')->get();

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
            'customer_id' => ['nullable'],
            'account_id' => ['nullable'],
            'pay_method_id' => ['nullable'],
            'expense_category_id' => ['required'],
            'date' => ['required'],
            'amount' => ['nullable'],
            'note' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();
            if (empty($request->account_id) && empty($request->pay_method_id)) {
                return back()->with('failed', "You Must Select a Transactional account.");
            } elseif ($request->account_id && $request->pay_method_id) {
                return back()->with('failed', "You Can't Select Two Transactional account.");
            }

            $account = Account::find($request->account_id);
            $paymentod = PaymentMethod::find($request->pay_method_id);

            if ($request->pay_method_id) {
                if ($paymentod->amount < $request->amount) {
                    return back()->with('failed', "Sorry! You have not enough balance.");
                }
                $paymentod->update(['amount' => ($paymentod->amount - $request->amount)]);
            }
            if ($request->account_id) {
                if ($account->amount < $request->amount) {
                    return back()->with('failed', "Sorry! You have not enough balance.");
                }
                $account->update(['amount' => ($account->amount - $request->amount)]);
            }

            $valideted['created_by'] = auth()->id();
            $valideted['company_id'] = auth()->user()->company_id;
            $expense =  Expense::create($valideted);


            $transaction['account_id'] = $request->account_id;
            $transaction['date'] = $request->date;
            $transaction['pay_method_id'] = $request->pay_method_id;
            $transaction['local_id'] = $expense->id;
            $transaction['customer_id'] = $request->customer_id;
            $transaction['type'] = 2;
            $transaction['company_id'] = auth()->user()->company_id;
            $transaction['debit'] = $request->amount;
            $transaction['amount'] = $request->amount;
            $transaction['note'] = $request->description;
            $transaction['created_by'] = Auth::id();
            Transaction::create($transaction);
            DB::commit();
            return back()->with('success', 'Data Store Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Something was wrong Message' . $e->getMessage() . 'Line' . $e->getLine());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Expense $Expense)
    {

        $modal_title = 'Account Details';
        $modal_data = $Expense;

        $html = view('admin.pages.Expense.show', get_defined_vars())->render();
        return $html;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $Expense)
    {
        $page_title = "Expense Edit";
        $page_heading = "Expense Edit";
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $Expense->id);
        $editinfo = $Expense;
        $payMethods = PaymentMethod::where('status', 'active')->get();
        $categories = ExpenseCategory::where('status', 'Active')->get();
        $customers = Customer::where('company_id', auth()->user()->company_id)->get();
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
    public function update(Request $request, Expense $expense)
    {
        $valideted = $this->validate($request, [
            'customer_id' => ['nullable'],
            'account_id' => ['nullable'],
            'pay_method_id' => ['nullable'],
            'expense_category_id' => ['required'],
            'date' => ['required'],
            'amount' => ['nullable'],
            'note' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();
            if (empty($request->account_id) && empty($request->pay_method_id)) {
                return back()->with('failed', "You Must Select a Transactional account.");
            } elseif ($request->account_id && $request->pay_method_id) {
                return back()->with('failed', "You Can't Select Two Transactional account.");
            }
            if ($expense->pay_method_id) {
                $old_pay_method = PaymentMethod::find($expense->pay_method_id);
                $amount['amount'] = $old_pay_method->amount + $expense->amount;
                $old_pay_method->update($amount);
            } elseif ($expense->account_id) {
                $old_amount = Account::find($expense->account_id);
                $amount['amount'] = $old_amount->amount + $expense->amount;
                $old_amount->update($amount);
            }

            $account = Account::find($request->account_id);
            $paymentod = PaymentMethod::find($request->pay_method_id);

            if ($request->pay_method_id) {
                if ($paymentod->amount < $request->amount) {
                    DB::rollBack();
                    return back()->with('failed', "Sorry! You have not enough balance.");
                }
                $valideted['account_id'] = null;
                $paymentod->update(['amount' => ($paymentod->amount - $request->amount)]);
            }

            if ($request->account_id) {
                if ($account->amount < $request->amount) {
                    DB::rollBack();
                    $valideted['pay_method_id'] = null;
                    return back()->with('failed', "Sorry! You have not enough balance.");
                }
                $account->update(['amount' => ($account->amount - $request->amount)]);
            }

            $valideted['updated_by'] = auth()->id();
            $expense->update($valideted);

            $transaction['account_id'] = $request->account_id;
            $transaction['date'] = $request->date;
            $transaction['pay_method_id'] = $request->pay_method_id;
            $transaction['customer_id'] = $request->customer_id;
            $transaction['type'] = 2;
            $transaction['debit'] = $request->amount;
            $transaction['amount'] = $request->amount;
            $transaction['note'] = $request->note;
            $transaction['created_by'] = Auth::id();
            Transaction::where('type', 2)->where('local_id', $expense->id)->update($transaction);

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
    public function destroy(Expense $Expense)
    {
        $Expense->delete();
        return Redirect()->back()->with('success', 'Data deleted successfully.');
    }
}
