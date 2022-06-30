<?php

namespace App\Http\Controllers\Admin\Asset;

use App\Http\Controllers\Controller;
use App\Models\AssetsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssetCategoryController extends Controller
{
    protected $routeName =  'assets';
    protected $viewName =  'admin.pages.assets';

    protected function getModel()
    {
        return new AssetsCategory();
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
                'label' => 'Category Name',
                'data' => 'category_name',
                'searchable' => false,
            ],

            [
                'label' => 'Status',
                'data' => 'status',
                'checked' => [1],
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

    public function index()
    {
        $page_title = "Asset Category";
        $page_heading = "Asset Category";
        $ajax_url = route($this->routeName . '.dataProcessing');
        $create_url = route($this->routeName . '.create');
        $is_show_checkbox = false;
        $columns = $this->reformatForRelationalColumnName(
            $this->tableColumnNames()
        );
        return view('admin.pages.index', get_defined_vars());
    }

    public function dataProcessing(Request $request)
    {
        return $this->getDataResponse(
            //Model Instance
            $this->getModel()->where('type', 1),
            //Table Columns Name
            $this->tableColumnNames(),
            //Route name
            $this->routeName
        );
    }

    public function create()
    {
        $page_title = "Asset Category";
        $page_heading = "Asset Category";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');

        return view($this->viewName . '.create', get_defined_vars());
    }

    public function store(Request $request)
    {

        $valideted = $this->validate($request, [
            'category_name' => ['required'],
            'status' => ['required'],
        ]);

        try {
            DB::beginTransaction();
            $valideted['type'] = 1;
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

    public function edit(AssetsCategory $assetscategory)
    {
        $page_title = "Asset Category Edit";
        $page_heading = "Asset Category Edit";
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $assetscategory->id);
        $editinfo = $assetscategory;
        return view($this->viewName . '.edit', get_defined_vars());
    }

    public function update(Request $request, AssetsCategory $assetscategory)
    {
        $valideted = $this->validate($request, [
            'category_name' => ['required'],
            'status' => ['required'],
        ]);

        try {
            DB::beginTransaction();
            $assetscategory = $assetscategory->update($valideted);
            DB::commit();
            return back()->with('success', 'Data Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
    }

    public function destroy(AssetsCategory $assetscategory)
    {
        $assetscategory->delete();
        return back()->with('success', 'Data deleted successfully.');
    }

    public function status(AssetsCategory $assetscategory)
    {
        $status = $assetscategory->status == '1' ? '0' : '1';
        $assetscategory->update(['status' => $status]);
        return back()->with('success', 'Status Update successfully.');
    }
}
