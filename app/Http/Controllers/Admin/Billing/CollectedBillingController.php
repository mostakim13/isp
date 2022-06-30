<?php

namespace App\Http\Controllers\Admin\Billing;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\Customer;


class CollectedBillingController extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'billcollected';
    protected $viewName =  'admin.pages.billcollect';

    protected function getModel()
    {
        return new Customer();
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
                'label' => 'User Name',
                'data' => 'username',
                'searchable' => true,
            ],
            [
                'label' => 'Name',
                'data' => 'name',
                'searchable' => true,
            ],
            [
                'label' => 'Customer Phone',
                'data' => 'phone',
                'searchable' => false,
            ],
            [
                'label' => 'Speed',
                'data' => 'speed',
                'searchable' => false,
            ],
            [
                'label' => 'Biller Name',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'user',
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
        $page_title = "Bill Collected";
        $page_heading = "Bill Collected List";
        $ajax_url = route($this->routeName . '.dataProcessing');
        // $create_url = route($this->routeName . '.create');
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
    public function dataProcessing()
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
                [
                    'method_name' => 'paylist',
                    'class' => 'btn-success',
                    'fontawesome' => 'fa fa-eye',
                    'text' => '',
                    'title' => 'View',
                ],
            ]

        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bill Collection  $user
     * @return \Illuminate\Http\Response
     */

    public function paylist(Customer $billcollected)
    {
        $back_url = route($this->routeName . '.index');
        $customerPaymentDetails = Billing::where('customer_id', $billcollected->id)->get();
        return view('admin.pages.billcollect.view', get_defined_vars());
    }
}
