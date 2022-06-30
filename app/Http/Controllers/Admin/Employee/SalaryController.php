<?php

namespace App\Http\Controllers\Admin\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Salary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SalaryController extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'salarys';
    protected $viewName =  'admin.pages.employee.salary';

    protected function getModel()
    {
        return new Salary();
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
            //     'relation' => 'employelist',


            // ],
            [
                'label' => 'SL',
                'data' => 'id',
                'searchable' => false,
            ],
            [
                'label' => 'Name',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'employee',
            ],
            [
                'label' => 'Month',
                'data' => 'month',
                'searchable' => false,
            ],

            [
                'label' => 'Basic Salary',
                'data' => 'basic_salary',
                'searchable' => false,

            ],
            [
                'label' => 'Paid Salary',
                'data' => 'paid_salary',
                'searchable' => false,

            ],
            [
                'label' => 'Overtime',
                'data' => 'overtime',
                'searchable' => false,

            ],
            [
                'label' => 'Incentive',
                'data' => 'incentive',
                'searchable' => false,

            ],
            [
                'label' => 'Bonus',
                'data' => 'bonus',
                'searchable' => false,

            ],
            [
                'label' => 'Due',
                'data' => 'due',
                'searchable' => false,
            ],
            [
                'label' => 'Total Amount',
                'data' => 'total_amount',
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
        $page_title = "Salary";
        $page_heading = "Salary List";
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
        $page_title = "Salary Create";
        $page_heading = "Salary Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
        $employees = Employee::get();

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
            'month' => ['required'],
            'paid_salary' => ['required'],
            'paid_date' => ['required'],
            'overtime' => ['nullable'],
            'incentive' => ['nullable'],
            'bonus' => ['nullable'],
            'paid_date' => ['nullable'],
            'remarks' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();

            $salary = Salary::where('month', date('Y-m-d', strtotime($request->month)))->where('employee_id', $request->employee_id)->exists();
            if ($salary) {
                return back()->with('failed', 'You are already paid this user for this month');
            }
            $basic_salary = Employee::select('salary')->findOrFail($request->employee_id);


            if ($basic_salary->salary > $request->paid_salary) {
                $valideted['status'] = "due";
            } else if ($basic_salary->salary == $request->paid_salary) {
                $valideted['status'] = "paid";
            } else {
                return back()->with('failed', 'You are paid too much salary');
            }

            $valideted['basic_salary'] = $basic_salary->salary;
            $valideted['due'] = $basic_salary->salary - $request->paid_salary;
            $valideted['total_amount'] = $request->paid_salary + $request->overtime + $request->incentive + $request->bonus;
            // $valideted['month'] = $request->month->format('Y-m');
            $valideted['month'] = date('Y-m-d', strtotime($request->month));
            $valideted['created_by'] = auth()->id();

            Salary::create($valideted);
            DB::commit();
            return back()->with('success', 'Data Store Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
    }

    /**
     * Display the specified resource.s
     *
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Salary $Salary)
    {

        $modal_title = 'Account Details';
        $modal_data = $Salary;

        $html = view('admin.pages.Salary.show', get_defined_vars())->render();
        return $html;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function edit(Salary $Salary)
    {
        $page_title = "Salary Edit";
        $page_heading = "Salary Edit";
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $Salary->id);
        $editinfo = $Salary;
        return view($this->viewName . '.edit', get_defined_vars());
    }

    public function viewAjax(Request $req)
    {
        $salary = Salary::with('employee')->findOrFail($req->id);
        $paid = $salary->paid_salary;
        $due =  $salary->employee->salary - $paid;
        return response()->json(array(
            'salary' => $salary,
            'due' => $due
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Salary $Salary)
    {
        $valideted = $this->validate($request, [
            'month' => ['required'],
            'due' => ['required'],
            'paid_salary' => ['required'],
        ]);
        $paid_salary = Salary::select('paid_salary')->findOrFail($Salary->id);
        $total_amount = Salary::select('total_amount')->findOrFail($Salary->id);
        try {
            DB::beginTransaction();
            $valideted['month'] = date('Y-m-d', strtotime($request->month));
            $valideted['due'] = $request->due - $request->paid_salary;
            $valideted['paid_salary'] = $request->paid_salary + $paid_salary->paid_salary;
            $valideted['total_amount'] = $request->paid_salary + $total_amount->total_amount;
            $valideted['updated_by'] = auth()->id();
            $Salary = $Salary->update($valideted);
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
    public function destroy(Salary $Salary)
    {
        $Salary->delete();
        return back()->with('success', 'Data deleted successfully.');
    }
}
