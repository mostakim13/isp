<?php

namespace App\Http\Controllers\Admin\Account;

use App\Http\Controllers\Controller;
use App\Models\DailyIncome;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DailyIncomeReportController extends Controller
{
    protected $routeName =  'dailyincomereports';
    protected $viewName =  'admin.pages.dailyincomereports';

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
                'label' => 'Served By',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'employee',
            ],

            [
                'label' => 'Service Amount',
                'data' => 'amount',
                'searchable' => false,

            ],
            [
                'label' => 'Paid Amount',
                'data' => 'paid_amount',
                'searchable' => false,
            ],
            [
                'label' => 'Due Amount',
                'data' => 'created_at',
                'searchable' => false,
            ],


        ];
    }


    public function index()
    {

        $page_title = "Daily Income";
        $page_heading = "Daily Income";

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
