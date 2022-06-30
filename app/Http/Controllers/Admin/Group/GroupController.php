<?php

namespace App\Http\Controllers\Admin\Group;

use Illuminate\Support\Facades\Validator;
use App\Models\Group;
use App\Http\Controllers\AccessController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GroupController extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'groups';
    protected $viewName =  'admin.pages.groups';

    protected function getModel()
    {
        return new Group();
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
                'label' => 'Name',
                'data' => 'name',
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
        $page_title = "Group";
        $page_heading = "Group List";
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
            true,
            [
                'edit',
                [
                    'method_name' => '',
                    'class' => 'btn-success',
                    'fontawesome' => 'fa fa-lock',
                    'text' => '',
                    'title' => 'Access',
                ],
                'destroy'
            ]
        );
    }

    public function view(Group $group, Request $request)
    {
        $params = [
            'group'    => $group,
        ];
        return view('group.view', $params);
    }

    public function create(Request $request)
    {
        // if (!AccessController::checkAccess("group_update")) {
        //     abort(403);
        // }
        $groups = Group::all();
        $group         = null;
        $group_id      = null;
        $group_title   = null;
        $page_title = "Create Group";
        $page_heading = "Create Group";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');

        return view($this->viewName . '.create', get_defined_vars());
    }

    public function store(Request $request)
    {
        // if (!AccessController::checkAccess("group_update")) {
        //     abort(403);
        // }

        $group = new Group;

        $validator = Validator::make($request->all(), [
            'name'          => ['required', 'string', 'max:255'],
            'description'   => ['max:1000'],
            'designation_id'   => ['nullable', 'exists:designations,id'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $group->name = $request->input('name');
        $group->slug = Str::slug($group->name);
        $group->description = $request->input('description');

        if ($group->save()) {
            return redirect()->route('group.access', [$group->slug])->with('success', 'Group created! Assign some page access permission to this group.');
        }
    }

    public function edit(Group $group, Request $request)
    {
        // dd('bad');
        // if (!AccessController::checkAccess("group_update")) {
        //     abort(403);
        // }

        $groups = Group::all();
        $group_id      = $group->id;
        $group_title   = $group->title;
        $page_title = "Update Group";
        $page_heading = "Update Group";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.update', $group->id);


        return view($this->viewName . '.edit', get_defined_vars());
    }

    public function update(Group $group, Request $request)
    {


        $validator = Validator::make($request->all(), [
            'name'          => ['required', 'string', 'max:255', Rule::unique('groups')->ignore($group->id)],
            'description'   => ['max:1000'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->withInput();
        }

        $group->name = $request->input('name');
        $group->description = $request->input('description');

        if ($group->save()) {
            return redirect()->route('group.update', [$group->slug])->with('success', 'Group updated!');
        }
    }

    public function access(Group $group, Request $request)
    {
        // if (!AccessController::checkAccess("group_access")) {
        //     abort(403);
        // }

        $access_arr = $group->group_accesses->group_access ?? [];
        $all_access = AccessController::getAccessArr();
        $groups = Group::all();
        $group = $group;
        $group_id = $group->id;
        $group_title = $group->name;
        $route_name = 'groups.access';

        return view($this->viewName . '.access', get_defined_vars());
    }

    public function accessStore(Group $group, Request $request)
    {
        // if (!AccessController::checkAccess("group_access")) {
        //     abort(403);
        // }
        return (new AccessController())->storePermission($request, $group);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $group->delete();
        return back()->with('success', 'Data deleted successfully.');
    }
}
