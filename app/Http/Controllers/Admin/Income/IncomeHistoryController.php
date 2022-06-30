<?php

namespace App\Http\Controllers\Admin\Income;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Customer;
use App\Models\DailyIncome;
use App\Models\IncomeCategory;
use App\Models\Supplier;

class IncomeHistoryController extends Controller
{

    /**
     * String property
     */
    protected $routeName =  'incomeHistory';
    protected $viewName =  'admin.pages.income_history';


    protected function getModel()
    {
        return new DailyIncome();
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
                'label' => 'SL',
                'data' => 'id',
                'searchable' => false,
            ],
            [
                'label' => 'Date',
                'data' => 'date',
                'searchable' => true,
            ],
            [
                'label' => 'Category',
                'data' => 'service_category_type',
                'customesearch' => 'category_id',
                'searchable' => false,
                'relation' => 'category'
            ],
            [
                'label' => 'Customer',
                'data' => 'name',
                'customesearch' => 'customer_id',
                'searchable' => false,
                'relation' => 'customer'
            ],
            [
                'label' => 'Account Head',
                'data' => 'account_name',
                'customesearch' => 'account_id',
                'searchable' => false,
                'relation' => 'account'
            ],
            [
                'label' => 'Supplier',
                'data' => 'name',
                'customesearch' => 'supplier_id',
                'searchable' => false,
                'relation' => 'supplier'
            ],
            [
                'label' => 'Served Charge',
                'data' => 'amount',
                'searchable' => false,
            ],
            [
                'label' => 'Paid Amount',
                'data' => 'paid_amount',
                'searchable' => false,
            ],
            [
                'label' => 'Description',
                'data' => 'description',
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
        $incomecategories = IncomeCategory::get();
        $ajax_url = route($this->routeName . '.dataProcessing');
        $columns = $this->reformatForRelationalColumnName(
            $this->tableColumnNames()
        );
        $incomecategories = IncomeCategory::get();
        $accounts = Account::getaccount()->get();
        $customers = Customer::where('company_id', auth()->user()->company_id)->get();
        $suppliers = Supplier::where('company_id', auth()->user()->company_id)->get();
        return view($this->viewName . '.index', get_defined_vars());
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
            $this->getModel()->where('company_id', auth()->user()->company_id),
            //Table Columns Name
            $this->tableColumnNames(),
            //Route name
            $this->routeName
        );
    }
}
