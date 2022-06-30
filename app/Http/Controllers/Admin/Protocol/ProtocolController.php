<?php

namespace App\Http\Controllers\Admin\Protocol;

use App\Http\Controllers\Controller;
use App\Models\Protocol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProtocolController extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'protocols';
    protected $viewName =  'admin.pages.protocols';

    protected function getModel()
    {
        return new Protocol();
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
        $page_title = "Protocol Type";
        $page_heading = "Protocol Type List";
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
        $page_title = "Protocol Type Create";
        $page_heading = "Protocol Type Create";
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
     * @param  \App\Models\Protocol  $protocol
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Protocol $protocol)
    {

        $modal_title = 'Protocol Type Details';
        $modal_data = $protocol;

        $html = view($this->viewName . '.show', get_defined_vars())->render();
        return $html;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Protocol  $protocol
     * @return \Illuminate\Http\Response
     */
    public function edit(Protocol $protocol)
    {
        $page_title = "Protocol Type Edit";
        $page_heading = "Protocol Type Edit";

        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $protocol->id);
        $editinfo = $protocol;
        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Protocol  $protocol
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Protocol $protocol)
    {
        $valideted = $this->validate($request, [
            'name' => ['required', 'string'],
            'details' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();
            $valideted['updated_by'] = auth()->id();
            $protocol = $protocol->update($valideted);
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
     * @param  \App\Models\Protocol  $protocol
     * @return \Illuminate\Http\Response
     */
    public function destroy(Protocol $protocol)
    {
        if ($protocol->id != 1  && $protocol->id != 2 && $protocol->id != 3) {
            $protocol->delete();
            return back()->with('success', 'Data deleted successfully.');
        } else {
            return back()->with('failed', "Sorry! It can't be deleted because it's a default data.");
        }
    }
}
