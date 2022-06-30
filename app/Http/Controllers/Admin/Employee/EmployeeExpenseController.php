<?php

namespace App\Http\Controllers\Admin\Employee;

use App\Models\Expense;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;

class EmployeeExpenseController extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'em_expense';
    protected $viewName =  'admin.pages.employee.expenses';

    protected function getModel()
    {
        return new Expense();
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
                'label' => 'Employee',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'employelist',
            ],
            [
                'label' => 'Account',
                'data' => 'account_name',
                'searchable' => false,
                'relation' => 'accountlist',
            ],
            [
                'label' => 'Date',
                'data' => 'date',
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
        $columns = $this->reformatForRelationalColumnName($this->tableColumnNames());
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
        $page_title = "Expense Create";
        $page_heading = "Expense Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
        $account = Account::get()->where('status', 'Active');
        $employees = Employee::select('name', 'user_id')->get();
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
            'employee_id' => ['required'],
            'account_id' => ['required'],
            'amount' => ['required'],
            'date' => ['required'],
            'note' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();
            $valideted['type'] = "employe";
            $valideted['created_by'] = auth()->id();
            Expense::create($valideted);
            DB::commit();
            return back()->with('success', 'Data Store Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $this->getError($e));
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
        $account = Account::get()->where('status', 'Active');
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $Expense->id);
        $employees = Employee::select('name', 'user_id')->get();
        $editinfo = $Expense;
        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $Expense)
    {
        $valideted = $this->validate($request, [
            'employee_id' => ['required'],
            'account_id' => ['required'],
            'amount' => ['required'],
            'date' => ['required'],
            'note' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();
            $valideted['updated_by'] = auth()->id();
            $Expense = $Expense->update($valideted);
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
        return back()->with('success', 'Data deleted successfully.');
    }
}
