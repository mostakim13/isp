<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'products';
    protected $viewName =  'admin.pages.products';

    protected function getModel()
    {
        return new Product();
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
                'label' => 'Product Category',
                'data' => 'name',
                'searchable' => false,
                'relation' => "category",
            ],

            [
                'label' => 'Unit',
                'data' => 'name',
                'searchable' => false,
                'relation' => "unitCat",
            ],
            [
                'label' => 'Purchase Price',
                'data' => 'purchases_price',
                'searchable' => false,
            ],
            [
                'label' => 'Sale Price',
                'data' => 'sale_price',
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
        $page_title = "Product";
        $page_heading = "Product List";
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
        $page_title = "Product Create";
        $page_heading = "Product Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
        $ProductCategory = ProductCategory::get();
        $units = Unit::get();
        $brands = Brand::get();
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
            'purchases_price' => ['required'],
            'sale_price' => ['required'],
            'product_category_id' => ['required'],
            'unit_id' => ['required'],
            'brand_id' => ['required'],
            'low_stock' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();

            Product::create($valideted);

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
    public function show(Request $request, Product $products)
    {
        $modal_title = 'Product Details';
        $modal_data = $products;
        $html = view($this->viewName . '.show', get_defined_vars())->render();
        return $html;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $products)
    {
        $page_title = "Product Edit";
        $page_heading = "Product Edit";
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $products->id);
        $ProductCategory = ProductCategory::get();
        $units = Unit::get();
        $brands = Brand::get();
        $editinfo = $products;
        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $products)
    {
        $valideted = $this->validate($request, [
            'name' => ['required'],
            'purchases_price' => ['required'],
            'sale_price' => ['required'],
            'product_category_id' => ['required'],
            'unit_id' => ['required'],
            'brand_id' => ['required'],
            'low_stock' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();

            $products->update($valideted);

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
    public function destroy(Product $products)
    {
        $products->delete();
        return back()->with('success', 'Data deleted successfully.');
    }
}
