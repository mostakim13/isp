<?php

namespace App\Http\Controllers\Admin\ClientType;

use App\Http\Controllers\Controller;
use App\Models\ClientType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ClientTypeController extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'client_types';
    protected $viewName =  'admin.pages.client_types';

    protected function getModel()
    {
        return new ClientType();
    }

    protected function tableColumnNames()
    {
        return [
            [
                'label' => 'ID',
                'data' => 'id',
                'searchable' => false,
            ],
            [
                'label' => 'Featured Image',
                'data' => 'image',
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
        $page_title = "Client Type";
        $page_heading = "Client Type List";
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
            $this->getModel()->where('company_id', auth()->user()->company_id),
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
        $page_title = "Client Type Create";
        $page_heading = "Client Type Create";
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
            'image' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();
            $valideted['company_id'] = auth()->user()->company_id;
            $valideted['created_by'] = auth()->id();

            if ($request->hasFile('image')) {
                $path =  $request->file('image')->store('client_type', 'public');
                $valideted['image'] = $path;
            }
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
     * @param  \App\Models\ClientType  $ClientType
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ClientType $ClientType)
    {

        $modal_title = 'Client Type Details';
        $modal_data = $ClientType;

        $html = view($this->viewName . '.show', get_defined_vars())->render();
        return $html;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClientType  $ClientType
     * @return \Illuminate\Http\Response
     */
    public function edit(ClientType $ClientType)
    {
        $page_title = "Client Type Edit";
        $page_heading = "Client Type Edit";

        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $ClientType->id);
        $editinfo = $ClientType;
        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClientType  $ClientType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClientType $ClientType)
    {
        $valideted = $this->validate($request, [
            'name' => ['required', 'string'],
            'details' => ['nullable'],
            'image' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();
            $valideted['updated_by'] = auth()->id();

            if ($request->hasFile('image')) {

                if ($ClientType->image) {
                    Storage::disk('public')->delete($ClientType->image);
                }

                $path = $request->file('image')->store('customer', 'public');

                $valideted['image'] = $path;
            }

            $ClientType = $ClientType->update($valideted);
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
     * @param  \App\Models\ClientType  $ClientType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClientType $ClientType)
    {
        $ClientType->delete();
        return back()->with('success', 'Data deleted successfully.');
    }
}
