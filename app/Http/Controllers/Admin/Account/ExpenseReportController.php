<?php

namespace App\Http\Controllers\Admin\Account;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseReportController extends Controller
{
    protected $routeName =  'expensereports';
    protected $viewName =  'admin.pages.expensereports';

    protected function getModel()
    {
        return new Expense();
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
                'searchable' => false,
            ],
            [
                'label' => 'Expense Category',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'category',
            ],

            [
                'label' => 'Served By',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'employee',
            ],
            [
                'label' => 'Amount',
                'data' => 'amount',
                'searchable' => false,
            ],

        ];
    }


    public function index()
    {

        $page_title = "Daily Expense";
        $page_heading = "Daily Expense";

        $ajax_url = route($this->routeName . '.dataProcessing');
        // $create_url = route($this->routeName . '.create');
        $is_show_checkbox = false;
        $columns = $this->reformatForRelationalColumnName(
            $this->tableColumnNames()
        );
        return view('admin.pages' . '.index', get_defined_vars());
        // $incomecategories = IncomeCategory::get();
        // $users = User::where('company_id', Auth::user()->company_id)->where('is_admin', 4)->get();
        // $dailyincomes = DailyIncome::with('category')->get();

        // // $incomecategories
        // return view('$viewName.index', compact('dailyincomes', 'incomecategories', 'users'));
    }

    public function dataProcessing(Request $request)
    {
        return $this->getDataResponse(
            //Model Instance
            $this->getModel()->whereDate('date', date('Y-m-d')),
            //Table Columns Name
            $this->tableColumnNames(),
            //Route name
            $this->routeName
        );
    }
}
