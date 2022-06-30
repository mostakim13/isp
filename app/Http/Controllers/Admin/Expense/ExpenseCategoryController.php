<?php

namespace App\Http\Controllers\Admin\Expense;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\ExpenseCategory;
use Illuminate\Support\Facades\DB;

class ExpenseCategoryController extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'expense_category';
    protected $viewName =  'admin.pages.expense_category';

    protected function getModel()
    {
        return new ExpenseCategory();
    }

    protected function tableColumnNames()
    {
        return [
            [
                'label' => 'Name',
                'data' => 'name',
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = "Expense Category";
        $page_heading = "Expense Category List";
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
        $page_title = "Expense Category Create";
        $page_heading = "Expense Category Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');

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
            'description' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();
            $valideted['company_id'] = auth()->user()->company_id;
            $valideted['created_by'] = auth()->id();
            ExpenseCategory::create($valideted);
            DB::commit();
            return back()->with('success', 'Data Store Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Something was wrong');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ExpenseCategory $ExpenseCategory)
    {

        $modal_title = 'Account Details';
        $modal_data = $ExpenseCategory;

        $html = view('admin.pages.Expense.show', get_defined_vars())->render();
        return $html;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function edit(ExpenseCategory $ExpenseCategory)
    {
        $page_title = "Expense Category Edit";
        $page_heading = "Expense Category Edit";
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $ExpenseCategory->id);
        $editinfo = $ExpenseCategory;
        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  ExpenseCategory $ExpenseCategory)
    {
        $valideted = $this->validate($request, [
            'name' => ['required'],
            'description' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();
            $valideted['updated_by'] = auth()->id();
            $Expense = $ExpenseCategory->update($valideted);
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
    public function destroy(ExpenseCategory $expensecategory)
    {
        $expensecategory->delete();
        return back()->with('success', 'Data deleted successfully.');
    }
}
