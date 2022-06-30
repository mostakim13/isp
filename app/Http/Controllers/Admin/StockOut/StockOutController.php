<?php

namespace App\Http\Controllers\Admin\StockOut;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\StockOut;
use App\Models\StockSummary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Admin\StockOut\StockOutCalculation;

class StockOutController extends Controller
{
    /**
     * String property
     */
    use StockOutCalculation;
    protected $routeName =  'stockout';
    protected $viewName =  'admin.pages.stockout';

    protected function getModel()
    {
        return new StockOut();
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
                'label' => 'Invoice No',
                'data' => 'invoice_no',
                'searchable' => false,
            ],

            [
                'label' => 'Customer',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'customerlist',
            ],

            [
                'label' => 'Staff Id',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'stuff',
            ],

            [
                'label' => 'Total Quantity',
                'data' => 'quantity',
                'searchable' => false,
            ],

            // [
            //     'label' => 'Action',
            //     'data' => 'action',
            //     'class' => 'text-nowrap',
            //     'orderable' => false,
            //     'searchable' => false,
            // ],

        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = "Stock Out";
        $page_heading = "Stock Out List";
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
            []

        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = "Stock Out Create";
        $page_heading = "Stock Out Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
        $customers = Customer::get();
        $users = User::get();
        $categorys = ProductCategory::withCount('products')->get();
        $Stockout = StockOut::latest('id')->pluck('id')->first() ?? "0";
        $invoice_no = 'So' . str_pad($Stockout + 1, 5, "0", STR_PAD_LEFT);
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
            'invoice_no' => ['required'],
            'customer_id' => ['required'],
            'stuff_id' => ['required'],
            'date' => ['required'],
            'narration' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();

            $valideted['quantity'] = array_sum($request->qty);
            $valideted['create_by'] = auth()->id();
            $stockout = StockOut::create($valideted);

            $this->stockOutFromSummery($stockout, $request);

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
    public function show(Request $request, StockOut $stockout)
    {
        $modal_title = 'Stock Out Details';
        $modal_data = $stockout;
        $html = view($this->viewName . '.show', get_defined_vars())->render();
        return $html;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function edit(StockOut $stockout)
    {
        $page_title = "Stock Out Edit";
        $page_heading = "Stock Out Edit";
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $stockout->id);
        $editinfo = $stockout;
        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StockOut $stockout)
    {
        $valideted = $this->validate($request, [
            'name' => ['required'],
        ]);

        try {
            DB::beginTransaction();

            $valideted['update_by'] = auth()->id();
            $stockout->update($valideted);

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
    public function destroy(StockOut $stockout)
    {
        $stockout->delete();
        return back()->with('success', 'Data deleted successfully.');
    }

    public function getProductList(Request $request)
    {
        $cat_id = $request->category_id;
        $productList = Product::get()->where('product_category_id', $cat_id);
        $add = '';
        if (!empty($productList)) :
            $add .= "<option value='all'>All Product</option>";
            foreach ($productList as $key => $value) :
                $add .= "<option proName='" . $value->name . "'   value='" . $value->id . "'>" . $value->name . "</option>";
            endforeach;
            echo  $add;
            die;
        else :
            echo "<option value='' selected disabled>No Product Available</option>";
            die;
        endif;
    }

    public function getQty(Request $request)
    {
        $stocksummery = StockSummary::where('product_id', $request->product_id)->pluck('qty')->first() ?? 0;
        echo $stocksummery;
    }
}
