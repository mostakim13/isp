<?php

namespace App\Http\Controllers\Admin\Asset;

use App\Http\Controllers\Controller;
use App\Models\AssetsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReasonController extends Controller
{
    protected $routeName =  'reasons';
    protected $viewName =  'admin.pages.reasons';

    protected function getModel()
    {
        return new AssetsCategory();
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
                'label' => 'Reason Name',
                'data' => 'reason_name',
                'searchable' => false,
            ],
            [
                'label' => 'Status',
                'data' => 'status',
                'searchable' => false,
            ],

            [
                'label' => 'Type',
                'data' => 'type',
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

    public function dataProcessing(Request $request)
    {
        return $this->getDataResponse(
            //Model Instance
            $this->getModel()->where('type', 2),
            //Table Columns Name
            $this->tableColumnNames(),
            //Route name
            $this->routeName
        );
    }

    public function index()
    {
        $page_title = "Reason List";
        $page_heading = "Reason List";
        $ajax_url = route($this->routeName . '.dataProcessing');
        $create_url = route($this->routeName . '.create');
        $is_show_checkbox = false;
        $columns = $this->reformatForRelationalColumnName(
            $this->tableColumnNames()
        );
        return view('admin.pages.index', get_defined_vars());
    }

    public function create()
    {
        $page_title = "Reason Create";
        $page_heading = "Reason Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');

        return view($this->viewName . '.create', get_defined_vars());
    }

    public function store(Request $request)
    {

        $valideted = $this->validate($request, [
            'reason_name' => ['required'],
            'status' => ['required'],
        ]);

        try {
            DB::beginTransaction();
            $valideted['type'] = 2;
            $valideted['company_id'] = auth()->user()->company_id;
            $valideted['created_by'] = auth()->id();
            AssetsCategory::create($valideted);
            DB::commit();
            return back()->with('success', 'Data Store Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
    }

    public function edit(AssetsCategory $assetcategory)
    {
        $page_title = "Reason Edit";
        $page_heading = "Reason Edit";
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $assetcategory->id);
        $editinfo = $assetcategory;
        // $assetcategory = AssetsCategory::first();
        return view($this->viewName . '.edit', get_defined_vars());
    }

    public function update(Request $request, AssetsCategory $assetcategory)
    {
        $valideted = $this->validate($request, [
            'reason_name' => ['required'],
            'status' => ['required'],
        ]);

        try {
            DB::beginTransaction();
            $assetcategory = $assetcategory->update($valideted);
            DB::commit();
            return back()->with('success', 'Data Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
    }

    public function destroy(AssetsCategory $assetcategory)
    {
        $assetcategory->delete();
        return back()->with('success', 'Data deleted successfully.');
    }
}
