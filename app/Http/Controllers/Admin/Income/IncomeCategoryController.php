<?php

namespace App\Http\Controllers\Admin\Income;

use App\Http\Controllers\Controller;
use App\Models\IncomeCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncomeCategoryController extends Controller
{
    protected $routeName =  'incomeCategory';
    protected $viewName =  'admin.pages.income_categories';

    protected function getModel()
    {
        return new IncomeCategory();
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
                'label' => 'Serial',
                'data' => 'id',
                'searchable' => false,
            ],
            [
                'label' => 'Service Category Type',
                'data' => 'service_category_type',
                'searchable' => true,
            ],

            [
                'label' => 'Details',
                'data' => 'details',
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
        $page_title = "Income";
        $page_heading = "Service Category";
        $ajax_url = route($this->routeName . '.dataProcessing');
        $create_url = route($this->routeName . '.create');
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
            $this->routeName
        );
    }

    public function create()
    {
        $page_title = "Income";
        $page_heading = "Add Service Category";
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
        // dd($request->all());
        $valideted = $this->validate($request, [
            'service_category_type' => ['required'],
            'details' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();
            $valideted['company_id'] = auth()->user()->company_id;
            IncomeCategory::create($valideted);
            DB::commit();
            return back()->with('success', 'Data Store Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Something was wrong');
        }
    }

    public function edit(IncomeCategory $Incomecategory)
    {
        $page_title = "Edit Service Category";
        $page_heading = "Edit Service Category";

        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $Incomecategory->id);
        $editinfo = $Incomecategory;
        return view($this->viewName . '.edit', get_defined_vars());
    }

    public function update(Request $request, IncomeCategory $Incomecategory)
    {
        $valideted = $this->validate($request, [
            'service_category_type' => ['required'],
            'details' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();
            $Incomecategory = $Incomecategory->update($valideted);
            DB::commit();
            return back()->with('success', 'Data Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
    }

    public function destroy(IncomeCategory $Incomecategory)
    {
        $Incomecategory->delete();
        return back()->with('success', 'Data deleted successfully.');
    }
}
