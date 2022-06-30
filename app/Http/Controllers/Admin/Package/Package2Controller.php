<?php

namespace App\Http\Controllers\Admin\Package;

use App\Models\Package2;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ClientType;
use App\Models\MPPPProfile;
use Illuminate\Support\Facades\DB;

class Package2Controller extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'packages2';
    protected $viewName =  'admin.pages.packages2';

    protected function getModel()
    {
        return new Package2();
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
                'label' => 'Client Type',
                'data' => 'name',
                'relation' => 'client_type',
                'searchable' => false,
            ],
            [
                'label' => 'Bandwidth Allocation MB',
                'data' => 'bandwidth_allocation',
                'searchable' => false,
            ],
            [
                'label' => 'Price',
                'data' => 'price',
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
        $page_title = "Package";
        $page_heading = "Package List";
        $ajax_url = route($this->routeName . '.dataProcessing');
        auth()->user()->is_admin != 3 ? $create_url = route($this->routeName . '.create') : "";
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
            $this->getModel()->where('tariffconfig_id', 0),
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
        $page_title = "Package Create";
        $page_heading = "Package Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
        $client_types = ClientType::where('status', true)->get();
        $mprofiles = MPPPProfile::get();
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
            "client_type_id" => ['nullable', 'exists:client_types,id'],
            "name" => ['required'],
            "price" => ['required'],
            "bandwidth_allocation" => ['required'],
            "m_profile_id" => ['required'],
            "description" => ['nullable'],
            "is_show_in_client_profile" => ['nullable'],
        ]);

        try {
            DB::beginTransaction();
            $valideted['created_by'] = auth()->id();
            $valideted['company_id'] = auth()->user()->company_id;
            $this->getModel()->create($valideted);
            DB::commit();
            return back()->with('success', 'Data Store Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $e->getMessage() . ' ' . $e->getLine() . ' ' . $e->getFile());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Package2 $package2)
    {

        $modal_title = 'Package Details';
        $modal_data = $package2;

        $html = view('admin.pages.packages.show', get_defined_vars())->render();
        return $html;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit(Package2 $package2)
    {
        $page_title = "Package Edit";
        $page_heading = "Package Edit";

        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $package2->id);
        $editinfo = $package2;
        $mprofiles = MPPPProfile::get();
        $client_types = ClientType::where('status', true)->get();
        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Package2 $package2)
    {
        $valideted = $this->validate($request, [
            "client_type_id" => ['nullable', 'exists:client_types,id'],
            "name" => ['required'],
            "price" => ['required'],
            "m_profile_id" => ['required'],
            "bandwidth_allocation" => ['required'],
            "description" => ['nullable'],
            "is_show_in_client_profile" => ['nullable'],
        ]);

        try {
            DB::beginTransaction();

            $valideted['updated_by'] = auth()->id();
            $package = $package2->update($valideted);
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
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package2 $package2)
    {
        $package2->delete();
        return back()->with('success', 'Data deleted successfully.');
    }
}
