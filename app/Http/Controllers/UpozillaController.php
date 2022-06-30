<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Upozilla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UpozillaController extends Controller
{
    protected $routeName =  'upozilla';
    protected $viewName =  'admin.pages.upozilla';


    protected function getModel()
    {
        return new Upozilla();
    }

    protected function tableColumnNames()
    {
        return [

            [
                'label' => 'SL',
                'data' => 'id',
                'searchable' => true,
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
        $page_title = "Upazila";
        $page_heading = "Upazila List";
        $ajax_url = route($this->routeName . '.dataProcessing');
        $create_url = route($this->routeName . '.create');
        $is_show_checkbox = false;
        $columns = $this->reformatForRelationalColumnName(
            $this->tableColumnNames()
        );
        // dd(get_defined_vars());
        return view('admin.pages.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dataProcessing()
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
        $page_title = "Upazila Create";
        $page_heading = "Upazila Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
        $districts = District::get();
        return view($this->viewName . '.create', get_defined_vars());
    }

    public function store(Request $request)
    {
        $valideted = $this->validate($request, [
            'upozilla_name' => ['required'],
            'details' => ['nullable'],
            'district_id' => ['required'],
        ]);

        try {
            DB::beginTransaction();
            $this->getModel()->create($valideted);
            DB::commit();
            return back()->with('success', 'Data Store Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', $this->getError($e));
        }
    }

    public function edit(Upozilla $upozilla)
    {
        $page_title = "Upazila Edit";
        $page_heading = "Upazila Edit";

        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $upozilla->id);
        $districts = District::get();
        $editinfo = $upozilla;
        return view($this->viewName . '.edit', get_defined_vars());
    }

    public function update(Request $request, Upozilla $upozilla)
    {
        $valideted = $this->validate($request, [
            'upozilla_name' => ['required'],
            'details' => ['nullable'],
            'district_id' => ['required'],
        ]);

        try {
            DB::beginTransaction();
            $upozilla = $upozilla->update($valideted);
            DB::commit();
            return back()->with('success', 'Data Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
    }

    public function destroy(Upozilla $upozilla)
    {
        $upozilla->delete();
        return back()->with('success', 'Data deleted successfully.');
    }
}
