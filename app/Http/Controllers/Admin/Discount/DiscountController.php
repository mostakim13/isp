<?php

namespace App\Http\Controllers\Admin\Discount;

use App\Models\Discount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\User;
use App\Models\UserManage;
use Illuminate\Support\Facades\DB;

class DiscountController extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'discounts';
    protected $viewName =  'admin.pages.discounts';

    protected function getModel()
    {
        return new Discount();
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
                'label' => 'Customer',
                'data' => 'customer_id',
                'searchable' => false,
                'relation' => '',
            ],

            [
                'label' => 'Date',
                'data' => 'date',
                'searchable' => false,
            ],
            [
                'label' => 'Amount',
                'data' => 'amount',
                'searchable' => false,
            ],
            [
                'label' => 'Note',
                'data' => 'note',
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
        $page_title = "Discount";
        $page_heading = "Discount List";
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
        $page_title = "Discount Create";
        $page_heading = "Discount Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');


        $user = User::get();

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
        //dd($request->all());
        $valideted = $this->validate($request, [
            'customer_id' => ['required'],
            'amount' => ['required'],
            'date' => ['required'],
            'note' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();
            $valideted['created_by'] = auth()->id();
            Discount::create($valideted);
            DB::commit();
            return back()->with('success', 'Data Store Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Something was wrong');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Discount $Discount)
    {

        $modal_title = 'Account Details';
        $modal_data = $Discount;

        $html = view('admin.pages.Discount.show', get_defined_vars())->render();
        return $html;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function edit(Discount $Discount)
    {
        $page_title = "Discount Edit";
        $page_heading = "Discount Edit";
        $account = Account::get()->where('status', 'Active');
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $Discount->id);
        $user = User::get();
        $editinfo = $Discount;
        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Discount $Discount)
    {
        $valideted = $this->validate($request, [
            'customer_id' => ['required'],
            'amount' => ['required'],
            'date' => ['required'],
            'note' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();
            $valideted['updated_by'] = auth()->id();
            $Discount = $Discount->update($valideted);
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
    public function destroy(Discount $Discount)
    {
        $Discount->delete();
        return back()->with('success', 'Data deleted successfully.');
    }
}
