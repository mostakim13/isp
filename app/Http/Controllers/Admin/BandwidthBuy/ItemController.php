<?php

namespace App\Http\Controllers\Admin\BandwidthBuy;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Item;
use App\Models\ItemCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'items';
    protected $viewName =  'admin.pages.bandwidthbuy.item';

    protected function getModel()
    {
        return new Item();
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
                'label' => 'Unit',
                'data' => 'unit',
                'searchable' => false,
            ],
            [
                'label' => 'Vat',
                'data' => 'vat',
                'searchable' => false,
            ],
            [
                'label' => 'Status',
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
        $page_title = "Item ";
        $page_heading = "Item  List";
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
        $page_title = "Item  Create";
        $page_heading = "Item  Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
        $categorys = ItemCategory::get();
        $accounts = Account::get();
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
            'item_id' => ['required'],
            'name' => ['required'],
            'category_id' => ['nullable'],
            'income_account_id' => ['required'],
            'expense_account_id' => ['required'],
            'unit' => ['nullable'],
            'status' => ['required'],
            'vat' => ['nullable'],
            'description' => ['required'],
        ]);

        try {
            DB::beginTransaction();
            $valideted['created_by'] = auth()->id();
            Item::create($valideted);
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
     * @param  \App\Models\Item  $Item
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Item $Item)
    {

        $modal_title = 'Item Details';
        $modal_data = $Item;

        $html = view('admin.pages.Items.show', get_defined_vars())->render();
        return $html;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $Item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $Item)
    {
        $page_title = "Item Edit";
        $page_heading = "Item Edit";
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $Item->id);
        $editinfo = $Item;
        $categorys = ItemCategory::get();
        $accounts = Account::get();
        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $Item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $Item)
    {
        $valideted = $this->validate($request, [
            'item_id' => ['required'],
            'name' => ['required'],
            'category_id' => ['nullable'],
            'income_account_id' => ['required'],
            'expense_account_id' => ['required'],
            'unit' => ['nullable'],
            'status' => ['required'],
            'vat' => ['nullable'],
            'description' => ['required'],
        ]);

        try {
            DB::beginTransaction();
            $valideted['updated_by'] = auth()->id();
            $Item = $Item->update($valideted);
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
     * @param  \App\Models\Item  $Item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $Item)
    {
        $Item->delete();
        return back()->with('success', 'Data deleted successfully.');
    }

    public function getBalance(Request $request)
    {
        $Item = Item::find($request->Item_id);
        echo $Item->amount;
    }
}
