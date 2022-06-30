<?php

namespace App\Http\Controllers\Billing;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillingDetailsController extends Controller
{
    protected $routeName =  'billing_details';
    protected $viewName =  'admin.pages.billing_details';

    protected function getModel()
    {
        return new Billing();
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
                'label' => 'Sl',
                'data' => 'id',
                'searchable' => false,
            ],
            [
                'label' => 'Billing Amount',
                'data' => 'customer_billing_amount',
                'searchable' => false,
            ],

            [
                'label' => 'Paid Amount',
                'data' => 'pay_amount',
                'searchable' => false,
            ],
            [
                'label' => 'Discount',
                'data' => 'discount',
                'searchable' => false,
            ],
            [
                'label' => 'Due',
                'data' => 'partial',
                'searchable' => false,
            ],
            [
                'label' => 'Status',
                'data' => 'status',
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
        $page_title = "Billing Details";
        $page_heading = "Billing Details";
        $ajax_url = route($this->routeName . '.dataProcessing');
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
            $this->getModel()->where('customer_id', Auth::id()),
            //Table Columns Name
            $this->tableColumnNames(),
            //Route name
            $this->routeName,

        );
    }
}
