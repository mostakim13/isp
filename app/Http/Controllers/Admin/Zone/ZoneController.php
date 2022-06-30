<?php

namespace App\Http\Controllers\Admin\Zone;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Upozilla;
use App\Models\Zone;
use Illuminate\Support\Facades\DB;

class ZoneController extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'zones';
    protected $viewName =  'admin.pages.zones';

    protected function getModel()
    {
        return new Zone();
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
                'label' => 'District Name',
                'data' => 'district_name',
                'searchable' => false,
                'relation' => 'district'
            ],
            [
                'label' => 'Upazila Name',
                'data' => 'upozilla_name',
                'searchable' => false,
                'relation' => 'upozilla'
            ],
            [
                'label' => 'Zone Name',
                'data' => 'name',
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
        $page_title = "Zone";
        $page_heading = "Zone List";
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
        $page_title = "Zone Create";
        $page_heading = "Zone Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
        $districts = District::get();
        $upozillas = Upozilla::get();
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
            'district_id' => ['required'],
            'upazila_id' => ['required'],
        ]);

        try {
            DB::beginTransaction();
            $valideted['created_by'] = auth()->id();
            $valideted['upozilla_id'] = $request->upazila_id;
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
     * @param  \App\Models\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Zone $zone)
    {

        $modal_title = 'Zone Details';
        $modal_data = $zone;

        $html = view($this->viewName . '.show', get_defined_vars())->render();
        return $html;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function edit(Zone $zone)
    {
        $page_title = "Zone Edit";
        $page_heading = "Zone Edit";
        $districts = District::get();
        $upozillas = Upozilla::get();
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $zone->id);
        $editinfo = $zone;
        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Zone $zone)
    {
        $valideted = $this->validate($request, [
            'name' => ['required'],
            'district_id' => ['required'],
            'upazila_id' => ['required'],
            // 'account_details' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();
            $valideted['updated_by'] = auth()->id();
            $zone = $zone->update($valideted);
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
     * @param  \App\Models\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function destroy(Zone $zone)
    {
        $zone->delete();
        return back()->with('success', 'Data deleted successfully.');
    }

    public function getSubCat(Request $req)
    {
        $subcat = Upozilla::where('district_id', $req->district_id)->orderBy('upozilla_name', 'ASC')->get();
        return json_encode($subcat);
    }
}
