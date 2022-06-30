<?php

namespace App\Http\Controllers\Admin\Employee;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\RollPermission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'employees';
    protected $viewName =  'admin.pages.employee';

    protected function getModel()
    {
        return new Employee();
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
                'label' => 'Email',
                'data' => 'email',
                'searchable' => false,
            ],
            [
                'label' => 'Phone',
                'data' => 'office_phone',
                'searchable' => false,
            ],
            [
                'label' => 'Nid',
                'data' => 'nid',
                'searchable' => false,
            ],
            [
                'label' => 'Join Date',
                'data' => 'join_date',
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
        $page_title = "Employee";
        $page_heading = "Employee List";
        $ajax_url = route($this->routeName . '.dataProcessing');
        $create_url = route($this->routeName . '.create');
        $is_show_checkbox = false;
        $model = $this->viewName . '.salarystore';
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
            $this->routeName,
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = "Employee Create";
        $page_heading = "Employee Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
        $designations = Designation::get();
        $userrolls = RollPermission::get();
        $departments = Department::get();
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
            'name' => ['required'],
            'dob' => ['nullable'],
            'gender' => ['required'],
            'personal_phone' => ['required'],
            'office_phone' => ['nullable', 'numeric'],
            'marital_status' => ['nullable'],
            'nid' => ['nullable'],
            'username' => ['nullable', 'unique:users,username'],
            'email' => ['nullable'],
            'reference' => ['nullable'],
            'designation_id' => ['required'],
            'department_id' => ['required'],
            'experience' => ['nullable'],
            'present_address' => ['nullable'],
            'permanent_address' => ['nullable'],
            'achieved_degree' => ['nullable'],
            'institution' => ['nullable'],
            'passing_year' => ['nullable'],
            'salary' => ['required'],
            'join_date' => ['nullable'],
            'status' => ['nullable'],
            'image' => ['nullable'],
            'is_login' => ['nullable'],
            'password' => ['nullable', 'confirmed', 'min:6',],
        ]);
        try {
            DB::beginTransaction();
            if ($request->is_login == "true") {
                $user['name'] = $request->name;
                $user['username'] = $request->username;
                $user['email'] = $request->email;
                $user['office_phone'] = $request->office_phone;
                $user['roll_id'] = $request->roll_id;
                $user['company_id'] = auth()->user()->company_id;
                $user['is_admin'] = 4;
                $user['password'] = Hash::make($request->password);
                $userDs = User::create($user);
                $valideted['user_id'] = $userDs->id;
            }

            Employee::create($valideted);

            DB::commit();
            return back()->with('success', 'Data Store Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Something was wrong' . $e->getMessage() . 'File' . $e->getFile() . "Line" . $e->getLine());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Employee $employee)
    {

        $modal_title = 'Employee Details';
        $modal_data = $employee;
        $html = view($this->viewName . '.show', get_defined_vars())->render();
        return $html;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        $page_title = "Employee Edit";
        $page_heading = "Employee Edit";
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $employee->id);
        $designations = Designation::get();
        $userrolls = RollPermission::get();
        $departments = Department::get();
        $editinfo = $employee;
        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $valideted = $this->validate($request, [
            'name' => ['required'],
            'dob' => ['nullable'],
            'gender' => ['required'],
            'personal_phone' => ['required'],
            'office_phone' => ['nullable'],
            'marital_status' => ['nullable'],
            'nid' => ['nullable'],
            'username' => ['nullable', 'unique:users,username,' . optional($employee->employelist)->id,],
            'email' => ['nullable'],
            'reference' => ['nullable'],
            'designation_id' => ['required'],
            'department_id' => ['required'],
            'experience' => ['nullable'],
            'present_address' => ['nullable'],
            'permanent_address' => ['nullable'],
            'achieved_degree' => ['nullable'],
            'institution' => ['nullable'],
            'passing_year' => ['nullable'],
            'salary' => ['required'],
            'join_date' => ['nullable'],
            'status' => ['nullable'],
            'image' => ['nullable'],
            'is_login' => ['nullable'],
            'password' => ['nullable', 'confirmed', 'min:6',],
        ]);

        try {
            DB::beginTransaction();

            if ($request->is_login == "true") {
                $user['name'] = $request->name;
                $number['username'] = $request->username;
                $number['is_admin'] = 4;
                $user['email'] = $request->email;
                $user['phone'] = $request->phone;
                $user['roll_id'] = $request->roll_id;
                $user['password'] = $request->password ? Hash::make($request->password) : $employee->employelist->password;
                $employee->employelist->updateOrCreate($number, $user);
            }

            $employee->update($valideted);
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
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return back()->with('success', 'Data deleted successfully.');
    }
}
