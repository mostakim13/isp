<?php

namespace App\Http\Controllers\Admin\SupportTicketing;

use App\Http\Controllers\Controller;
use App\Models\SupportCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupportCategoryController extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'supportcategory';
    protected $viewName =  'admin.pages.supportTicket.supportcategory';

    protected function getModel()
    {
        return new SupportCategory();
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
                'label' => 'Support Category',
                'data' => 'name',
                'searchable' => false,
            ],
            [
                'label' => 'Department',
                'data' => 'department',
                'searchable' => false,
            ],
            [
                'label' => 'Category Type',
                'data' => 'type',
                'searchable' => false,
            ],
            [
                'label' => 'Detail',
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
        $page_title = "Support Category";
        $page_heading = "Support Category List";
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
        $page_title = "Support Category Create";
        $page_heading = "Support Category Create";
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
            'department' => ['required'],
            'details' => ['nullable'],
            'type' => ['required'],
        ]);

        try {
            DB::beginTransaction();

            $valideted['created_by'] = auth()->id();
            SupportCategory::create($valideted);

            DB::commit();
            return back()->with('success', 'Data Store Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Something was wrong' . $e->getMessage() . 'Line' . $e->getLine() . 'File' . $e->getFile());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function edit(SupportCategory $supportcategory)
    {
        $page_title = "Support Category Edit";
        $page_heading = "Support Category Edit";
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $supportcategory->id);
        $editinfo = $supportcategory;
        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SupportCategory $supportcategory)
    {
        $valideted = $this->validate($request, [
            'name' => ['required'],
            'department' => ['required'],
            'details' => ['nullable'],
            'type' => ['required'],
        ]);

        try {
            DB::beginTransaction();

            $valideted['updated_by'] = auth()->id();
            $supportcategory->update($valideted);

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
    public function destroy(SupportCategory $supportcategory)
    {
        $supportcategory->delete();
        return back()->with('success', 'Data deleted successfully.');
    }
}
