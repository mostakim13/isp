<?php

namespace App\Http\Controllers\Admin\BillingStatus;

use App\Http\Controllers\Controller;
use App\Models\BillingStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillingStatusController extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'billingstatus';
    protected $viewName =  'admin.pages.billingstatus';

    protected function getModel()
    {
        return new BillingStatus();
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
        $page_title = "Billing Status";
        $page_heading = "Billing Status List";
        $ajax_url = route($this->routeName . '.dataProcessing');
        // $create_url = route($this->routeName . '.create');
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
            true,
            [
                [
                    'method_name' => 'edit',
                    'class' => 'btn-success',
                    'fontawesome' => 'fa fa-edit',
                    'text' => '',
                    'title' => 'Edit',
                ],
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = "Billing Status Create";
        $page_heading = "Billing Status Create";
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
            'name' => ['required', 'string'],
            'details' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();
            $valideted['company_id'] = auth()->user()->company_id;
            $valideted['created_by'] = auth()->id();
            $this->getModel()->create($valideted);
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
     * @param  \App\Models\BillingStatus  $billingstatus
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, BillingStatus $billingstatus)
    {

        $modal_title = 'Billing Status Details';
        $modal_data = $billingstatus;

        $html = view($this->viewName . '.show', get_defined_vars())->render();
        return $html;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BillingStatus  $billingstatus
     * @return \Illuminate\Http\Response
     */
    public function edit(BillingStatus $billingstatus)
    {
        $page_title = "Billing Status Edit";
        $page_heading = "Billing Status Edit";

        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $billingstatus->id);
        $editinfo = $billingstatus;
        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BillingStatus  $billingstatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BillingStatus $billingstatus)
    {
        $valideted = $this->validate($request, [
            'name' => ['required', 'string'],
            'details' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();
            $valideted['updated_by'] = auth()->id();
            $billingstatus = $billingstatus->update($valideted);
            DB::commit();
            return back()->with('success', 'Data Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $this->getError($e));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BillingStatus  $billingstatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(BillingStatus $billingstatus)
    {
        $billingstatus->delete();
        return back()->with('success', 'Data deleted successfully.');
    }
}
