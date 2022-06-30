<?php

namespace App\Http\Controllers\Admin\ConnectionType;

use App\Http\Controllers\Controller;
use App\Models\ConnectionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConnectionTypeController extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'connections';
    protected $viewName =  'admin.pages.connections';

    protected function getModel()
    {
        return new ConnectionType();
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
        $page_title = "Connection Type";
        $page_heading = "Connection Type List";
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
        $page_title = "Connection Type Create";
        $page_heading = "Connection Type Create";
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
     * @param  \App\Models\ConnectionType  $connection
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ConnectionType $connection)
    {

        $modal_title = 'Connection Type Details';
        $modal_data = $connection;

        $html = view($this->viewName . '.show', get_defined_vars())->render();
        return $html;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ModelsConnectionType  $connection
     * @return \Illuminate\Http\Response
     */
    public function edit(ConnectionType $connection)
    {
        $page_title = "Connection Type Edit";
        $page_heading = "Connection Type Edit";

        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $connection->id);
        $editinfo = $connection;
        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ConnectionType $connection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ConnectionType $connection)
    {
        $valideted = $this->validate($request, [
            'name' => ['required', 'string'],
            'details' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();
            $valideted['updated_by'] = auth()->id();
            $connection = $connection->update($valideted);
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
     * @param  \App\Models\ConnectionType  $connection
     * @return \Illuminate\Http\Response
     */
    public function destroy(ConnectionType $connection)
    {
        $connection->delete();
        return back()->with('success', 'Data deleted successfully.');
    }
}
