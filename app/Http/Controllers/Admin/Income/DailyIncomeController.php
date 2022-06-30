<?php

namespace App\Http\Controllers\Admin\Income;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Customer;
use App\Models\DailyIncome;
use App\Models\Employee;
use App\Models\IncomeCategory;
use App\Models\Supplier;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DailyIncomeController extends Controller
{

    protected $routeName =  'dailyIncome';
    protected $viewName =  'admin.pages.daily_incomes';

    protected function getModel()
    {
        return new DailyIncome();
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
                'label' => 'SL',
                'data' => 'id',
                'searchable' => false,
            ],
            [
                'label' => 'Date',
                'data' => 'date',
                'searchable' => true,
            ],
            [
                'label' => 'Category',
                'data' => 'service_category_type',
                'searchable' => false,
                'relation' => 'category'
            ],
            [
                'label' => 'Customer',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'customer'
            ],
            [
                'label' => 'Supplier',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'supplier'
            ],
            [
                'label' => 'Account Head',
                'data' => 'account_name',
                'searchable' => false,
                'relation' => 'account'
            ],
            [
                'label' => 'Served Charge',
                'data' => 'amount',
                'searchable' => false,
            ],
            [
                'label' => 'Paid Amount',
                'data' => 'paid_amount',
                'searchable' => false,
            ],
            [
                'label' => 'Description',
                'data' => 'description',
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


    public function index()
    {


        $incomecategories = IncomeCategory::get();
        $ajax_url = route($this->routeName . '.dataProcessing');
        $create_url = route($this->routeName . '.create');
        $is_show_checkbox = false;
        $columns = $this->reformatForRelationalColumnName(
            $this->tableColumnNames()
        );
        return view($this->viewName . '.index', get_defined_vars());
    }

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


    public function create()
    {
        $page_title = "Daily Income Create";
        $page_heading = "Daily Income Create";
        $incomecategories = IncomeCategory::get();
        $customers = Customer::where('company_id', auth()->user()->company_id)->get();
        $suppliers = Supplier::where('company_id', auth()->user()->company_id)->get();
        $accounts = Account::getaccount()->get();
        $dailyincomes = DailyIncome::with('category')->get();
        $back_url = route($this->routeName . '.index');
        return view('admin.pages.daily_incomes.create', get_defined_vars());
    }

    public function store(Request $request)
    {
        $valideted = $this->validate($request, [
            'date' => ['required'],
            'category_id' => ['required'],
            'customer_id' => ['nullable'],
            'supplier_id' => ['nullable'],
            'amount' => ['required'],
            'paid_amount' => ['nullable'],
            'account_id' => ['nullable'],
            'description' => ['nullable'],
        ]);
        try {
            DB::beginTransaction();
            $valideted['company_id'] = auth()->user()->company_id;
            $valideted['created_by'] = auth()->id();
            $dailyincome = DailyIncome::create($valideted);

            $old_amount = Account::find($request->account_id);
            $account['amount'] = $old_amount->amount + $request->paid_amount;
            $old_amount->update($account);

            $transaction['account_id'] = $request->account_id;
            $transaction['date'] = $request->date;
            $transaction['local_id'] = $dailyincome->id;
            $transaction['customer_id'] = $request->customer_id;
            $transaction['supplier_id'] = $request->supplier_id;
            $transaction['type'] = 3;
            $transaction['company_id'] = auth()->user()->company_id;
            $transaction['debit'] = $request->paid_amount;
            $transaction['amount'] = $request->amount;
            $transaction['due'] = $request->amount - $request->paid_amount;
            $transaction['note'] = $request->description;
            $transaction['created_by'] = Auth::id();
            Transaction::create($transaction);


            DB::commit();
            return back()->with('success', 'Data Store Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
    }

    public function edit($id)
    {
        $page_title = "Daily Income Edit";
        $page_heading = "Daily Income Edit";
        $back_url = route($this->routeName . '.index');
        $dailyincome = DailyIncome::findOrFail($id);
        $incomecategories = IncomeCategory::get();
        $customers = Customer::where('company_id', auth()->user()->company_id)->get();
        $suppliers = Supplier::where('company_id', auth()->user()->company_id)->get();
        $accounts = Account::getaccount()->get();
        $users = User::where('company_id', Auth::user()->company_id)->where('is_admin', 4)->get();

        return view('admin.pages.daily_incomes.edit', get_defined_vars());
    }

    public function update(Request $request, DailyIncome $dailyincome)
    {
        $valideted = $this->validate($request, [
            'date' => ['required'],
            'category_id' => ['required'],
            'customer_id' => ['nullable'],
            'supplier_id' => ['nullable'],
            'amount' => ['required'],
            'paid_amount' => ['nullable'],
            'account_id' => ['nullable'],
            'description' => ['nullable'],
        ]);
        try {
            DB::beginTransaction();
            $old_amount = Account::find($dailyincome->account_id);
            $account['amount'] = $old_amount->amount - $dailyincome->paid_amount;
            $old_amount->update($account);

            $dailyincome->update($valideted);

            $old_amount = Account::find($request->account_id);
            $account['amount'] = $old_amount->amount + $request->paid_amount;
            $old_amount->update($account);

            $transaction['account_id'] = $request->account_id;
            $transaction['date'] = $request->date;
            $transaction['type'] = 3;
            $transaction['customer_id'] = $request->customer_id;
            $transaction['supplier_id'] = $request->supplier_id;
            $transaction['debit'] = $request->paid_amount;
            $transaction['amount'] = $request->amount;
            $transaction['due'] = $request->amount - $request->paid_amount;
            $transaction['note'] = $request->description;
            $transaction['created_by'] = Auth::id();
            Transaction::where('type', 3)->where('local_id', $dailyincome->id)->update($transaction);


            DB::commit();
            return back()->with('success', 'Data Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
    }

    public function destroy($id)
    {
        DailyIncome::findOrFail($id)->delete();
        return Redirect()->back();
    }

    public function search(Request $request)
    {

        $incomecategories = IncomeCategory::get();
        $category = $request->category;
        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);
        $dailyincomes = DailyIncome::with('category')->whereDate('date', '<=', $end->format('Y-m-d'))
            ->whereDate('date', '>=', $start->format('Y-m-d'));

        // dd($dailyincomes);

        return view('admin.pages.daily_incomes.index', compact('dailyincomes', 'incomecategories'));
    }
}
