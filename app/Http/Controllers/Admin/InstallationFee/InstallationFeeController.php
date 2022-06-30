<?php

namespace App\Http\Controllers\Admin\InstallationFee;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\InstallationFee;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InstallationFeeController extends Controller
{
    protected $routeName =  'installationFee';
    protected $viewName =  'admin.pages.installationFee';

    protected function getModel()
    {
        return new InstallationFee();
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
                'label' => 'SN',
                'data' => 'id',
                'searchable' => false,
            ],
            [
                'label' => 'Created On',
                'data' => 'created_on',
                'searchable' => false,

            ],

            [
                'label' => 'Name',
                'data' => 'name',
                'searchable' => false,
                'relation' => 'customer'

            ],
            [
                'label' => 'User ID/IP',
                'data' => 'ip_address',
                'searchable' => false,
                'relation' => 'customer'
            ],
            [
                'label' => 'Mobile No.',
                'data' => 'phone',
                'searchable' => false,
                'relation' => 'customer'
            ],
            [
                'label' => 'Installation Fee',
                'data' => 'installation_fee',
                'searchable' => false,

            ],
            [
                'label' => 'Received Amount',
                'data' => 'received_amount',
                'searchable' => false,
            ],
            [
                'label' => 'Due',
                'data' => 'due',
                'searchable' => false,
            ],
            [
                'label' => 'Received On',
                'data' => 'received_on',
                'searchable' => false,
            ],
            [
                'label' => 'Payment By',
                'data' => 'account_name',
                'searchable' => false,
                'relation' => 'account'
            ],
            [
                'label' => 'Reference No',
                'data' => 'reference',
                'searchable' => false,
                'relation' => 'customer'
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


    public function index()
    {
        $customers = Customer::get();
        $ajax_url = route($this->routeName . '.dataProcessing');
        // $create_url = route($this->routeName . '.create');
        $is_show_checkbox = false;
        $columns = $this->reformatForRelationalColumnName(
            $this->tableColumnNames()
        );
        $installationFee = InstallationFee::get();
        return view('admin.pages.index', get_defined_vars());
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
            $this->getModel(),
            //Table Columns Name
            $this->tableColumnNames(),
            //Route name
            $this->routeName,
            true,
            [
                [
                    'method_name' => 'pay',
                    'class' => 'btn-info',
                    'fontawesome' => '',
                    'text' => 'Pay',
                    'title' => 'View',
                ],
            ],
        );
    }

    public function pay(InstallationFee $installationFee)
    {
        $accounts = Account::get();
        $employees = Employee::get();
        $page_title = "Pay Amount";
        $page_heading = "Pay Amount";
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $installationFee->id);
        return view($this->viewName . '.pay', get_defined_vars());
    }

    public function update(Request $request, InstallationFee $installationFee)
    {
        $valideted = $this->validate($request, [
            'payment_by' => 'required',
            'received_by' => 'required',
            'received_on' => 'required'
        ]);

        try {
            DB::beginTransaction();
            $account = Account::findOrFail($request->payment_by);

            $valideted['received_amount'] = $installationFee->received_amount + $request->received_amount;
            $valideted['due'] = $installationFee->installation_fee - $valideted['received_amount'];
            $installationFee->update($valideted);


            $account->update(['amount' => ($account->amount + $request->received_amount)]);

            $transaction['account_id'] = $request->payment_by;
            $transaction['date'] = $request->received_on;
            $transaction['local_id'] = $installationFee->id;
            $transaction['type'] = 5;
            $transaction['credit'] = $request->received_amount;
            $transaction['amount'] = $installationFee->installation_fee;
            $transaction['due'] = $installationFee->due;
            $transaction['created_by'] = Auth::id();
            Transaction::create($transaction);

            DB::commit();
            return back()->with('success', 'Data Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
    }
}
