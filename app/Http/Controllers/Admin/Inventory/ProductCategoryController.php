<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductCategoryController extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'productCategory';
    protected $viewName =  'admin.pages.productCategory';

    protected function getModel()
    {
        return new ProductCategory();
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
                'label' => 'Create By',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'users',
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
        $page_title = "Product Category";
        $page_heading = "Product Category List";
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

        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = "Product Category Create";
        $page_heading = "Product Category Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
        $productCats = ProductCategory::select('id', 'name', 'category_id')->where('category_id', '0')->get();
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
            'category_id' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();

            $valideted['create_by'] = auth()->id();
            ProductCategory::create($valideted);

            DB::commit();
            return back()->with('success', 'Data Store Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Something was wrong' . $e->getMessage() . 'Line' . $e->getLine() . 'File' . $e->getFile());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ProductCategory $productcategory)
    {
        $modal_title = 'Product Category Details';
        $modal_data = $productcategory;
        $html = view($this->viewName . '.show', get_defined_vars())->render();
        return $html;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductCategory $productcategory)
    {
        $page_title = "Product Category Edit";
        $page_heading = "Product Category Edit";
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $productcategory->id);
        $productCats = ProductCategory::select('id', 'name', 'category_id')->where('category_id', '0')->get();
        $editinfo = $productcategory;
        // dd($editinfo);
        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductCategory $productcategory)
    {
        $valideted = $this->validate($request, [
            'name' => ['required'],
            'category_id' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();

            $valideted['update_by'] = auth()->id();
            $productcategory->update($valideted);

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
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCategory $productcategory)
    {
        $productcategory->delete();
        return back()->with('success', 'Data deleted successfully.');
    }
}
