<?php

namespace App\Http\Controllers\Admin\Subzone;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Subzone;
use App\Models\Upozilla;
use App\Models\Zone;
use Illuminate\Support\Facades\DB;

class SubzoneController extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'subzones';
    protected $viewName =  'admin.pages.subzones';

    protected function getModel()
    {
        return new Subzone();
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
                'relation' => 'district',
            ],
            [
                'label' => 'Upazila Name',
                'data' => 'upozilla_name',
                'searchable' => false,
                'relation' => 'upozilla',
            ],
            [
                'label' => 'Zone Name',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'zone',
            ],
            [
                'label' => 'SubZone Name',
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
        $page_title = "Subzone";
        $page_heading = "Subzone List";
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
        $page_title = "Subzone Create";
        $page_heading = "Subzone Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
        $zones = Zone::get(['name', 'id']);
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
            'zone_id' => ['required', 'exists:zones,id'],
            'district_id' => ['required', 'exists:districts,id'],
            'upazila_id' => ['required', 'exists:upozillas,id'],

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
     * @param  \App\Models\Subzone  $subzone
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Subzone $subzone)
    {

        $modal_title = 'Subzone Details';
        $modal_data = $subzone;

        $html = view($this->viewName . '.show', get_defined_vars())->render();
        return $html;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subzone  $subzone
     * @return \Illuminate\Http\Response
     */
    public function edit(Subzone $subzone)
    {
        $page_title = "Subzone Edit";
        $page_heading = "Subzone Edit";
        $zones = Zone::get(['name', 'id']);

        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $subzone->id);
        $districts = District::get();
        $upozillas = Upozilla::get();
        $editinfo = $subzone;
        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subzone  $subzone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subzone $subzone)
    {
        $valideted = $this->validate($request, [
            'name' => ['required'],
            'zone_id' => ['required', 'exists:zones,id'],
            'district_id' => ['required', 'exists:districts,id'],
            'upazila_id' => ['required', 'exists:upozillas,id'],
        ]);

        try {
            DB::beginTransaction();
            $valideted['updated_by'] = auth()->id();
            $valideted['upozilla_id'] = $request->upazila_id;
            $subzone = $subzone->update($valideted);
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
     * @param  \App\Models\Subzone  $subzone
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subzone $subzone)
    {
        $subzone->delete();
        return back()->with('success', 'Data deleted successfully.');
    }

    public function getSubSubCat(Request $req)
    {
        $subsubCat = Zone::where('upozilla_id', $req->upozilla_id)->orderBy('name', 'ASC')->get();
        return json_encode($subsubCat);
    }
}
