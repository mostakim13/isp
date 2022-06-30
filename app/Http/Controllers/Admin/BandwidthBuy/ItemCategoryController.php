<?php

namespace App\Http\Controllers\Admin\BandwidthBuy;

use App\Http\Controllers\Controller;
use App\Models\ItemCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemCategoryController extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'itemcategory';
    protected $viewName =  'admin.pages.bandwidthbuy.itemcategory';

    protected function getModel()
    {
        return new ItemCategory();
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
                'label' => 'name',
                'data' => 'name',
                'searchable' => false,
            ],
            [
                'label' => 'description',
                'data' => 'description',
                'searchable' => false,
            ],
            [
                'label' => 'status',
                'data' => 'status',
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
        $page_title = "Item Category";
        $page_heading = "Item Category List";
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
        $page_title = "Item Category Create";
        $page_heading = "Item Category Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
        $subcategorys = ItemCategory::where('parent', '0')->get();
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
            'status' => ['required'],
            'description' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();
            $valideted['parent'] = $request->parent ?? 0;
            $valideted['created_by'] = auth()->id();
            ItemCategory::create($valideted);
            DB::commit();
            return back()->with('success', 'Data Store Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Something was wrong' . 'Message' . $e->getMessage() . 'File' . $e->getFile());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ItemCategory  $ItemCategory
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ItemCategory $ItemCategory)
    {

        $modal_title = 'Item Category Details';
        $modal_data = $ItemCategory;

        $html = view('admin.pages.ItemCategorys.show', get_defined_vars())->render();
        return $html;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ItemCategory  $ItemCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ItemCategory $ItemCategory)
    {
        $page_title = "Item Category Edit";
        $page_heading = "Item Category Edit";
        $subcategorys = ItemCategory::where('parent', '0')->get();
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $ItemCategory->id);
        $editinfo = $ItemCategory;
        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ItemCategory  $ItemCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ItemCategory $ItemCategory)
    {
        $valideted = $this->validate($request, [
            'name' => ['required'],
            'status' => ['required'],
            'description' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();
            $valideted['parent'] = $request->parent;
            $valideted['updated_by'] = auth()->id();
            $ItemCategory = $ItemCategory->update($valideted);
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
     * @param  \App\Models\ItemCategory  $ItemCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItemCategory $ItemCategory)
    {
        $ItemCategory->delete();
        return back()->with('success', 'Data deleted successfully.');
    }

    public function getBalance(Request $request)
    {
        $ItemCategory = ItemCategory::find($request->ItemCategory_id);
        echo $ItemCategory->amount;
    }
}
