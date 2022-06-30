<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Navigation;
use App\Models\RollPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RollPermissionController extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'rollPermission';
    protected $viewName =  'admin.pages.rollPermission';

    protected function getModel()
    {
        return new RollPermission();
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
        $page_title = "Roll Permission";
        $page_heading = "Roll Permission List";
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
        $page_title = "Roll Permission Create";
        $page_heading = "Roll Permission Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');

        $result = Navigation::where('parent_id', 0)->get();
        $allMenuList = array();
        foreach ($result as $key => $each_parent) :
            $menuList['menu_id'] = $each_parent->id;
            $menuList['label'] = $each_parent->label;
            $menuList['sub_menu']  =  Navigation::where('parent_id', $each_parent->id)->get();
            array_push($allMenuList, $menuList);
        endforeach;
        $userRole = $allMenuList;
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
            'name' => ['required'],
        ]);
        try {
            DB::beginTransaction();
            $userRole['name'] =  $request->name;
            $userRole['parent_id'] = implode(',', $request->parent_id);
            $userRole['child_id'] = implode(',', $request->child_id);
            $userRole['created_by'] = auth()->id();
            $this->getModel()->create($userRole);
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
     * @param  \App\Models\Roll Permission  $Roll Permission
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, RollPermission $rollpermission)
    {

        $modal_title = 'Roll Permission Details';
        $modal_data = $rollpermission;

        $html = view($this->viewName . '.show', get_defined_vars())->render();
        return $html;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Roll Permission  $Roll Permission
     * @return \Illuminate\Http\Response
     */
    public function edit(RollPermission $rollpermission)
    {
        $page_title = "Roll Permission Edit";
        $page_heading = "Roll Permission Edit";

        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $rollpermission->id);
        $result = Navigation::where('parent_id', 0)->get();
        $allMenuList = array();
        foreach ($result as $key => $each_parent) :
            $menuList['menu_id'] = $each_parent->id;
            $menuList['label'] = $each_parent->label;
            $menuList['sub_menu']  =  Navigation::where('parent_id', $each_parent->id)->get();
            array_push($allMenuList, $menuList);
        endforeach;
        $userRole = $allMenuList;
        $menuExp = explode(',', $rollpermission->parent_id);
        $submenuExp = explode(',', $rollpermission->child_id);

        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Roll Permission  $Roll Permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RollPermission $rollpermission)
    {
        $valideted = $this->validate($request, [
            'name' => ['required'],
            // 'account_details' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();
            $userRole['name'] =  $request->name;
            $userRole['parent_id'] = implode(',', $request->parent_id);
            $userRole['child_id'] = implode(',', $request->child_id);
            $userRole['updated_by'] = auth()->id();
            $rollpermission = $rollpermission->update($userRole);
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
    public function destroy(RollPermission $rollpermission)
    {
        $rollpermission->delete();
        return back()->with('success', 'Data deleted successfully.');
    }
}
