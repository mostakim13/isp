<?php

namespace App\Http\Controllers\Admin\Billing;

use App\Http\Controllers\Controller;
use App\Models\AdvanceBilling;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdvanceBillingController extends Controller
{
    protected $routeName =  'advancebilling';
    protected $viewName =  'admin.pages.advancebilling';

    protected function getModel()
    {
        return new AdvanceBilling();
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
                'label' => 'Date',
                'data' => 'date',
                'searchable' => false,
            ],
            [
                'label' => 'Customer',
                'data' => 'username',
                'searchable' => false,
                'relation' => 'getCustomer',
            ],
            [
                'label' => 'Advanced Payment',
                'data' => 'advanced_payment',
                'searchable' => false,
            ],
            [
                'label' => 'Created By',
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
        $page_title = "Advance Billing";
        $page_heading = "Advance Billing";
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
    public function dataProcessing()
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

    public function create()
    {
        $page_title = "Advance Billing Create";
        $page_heading = "Advance Billing Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
        $customers = Customer::where('disabled', false)->get();
        // $users = User::all();
        // $paymentMethods = PaymentMethod::where('status', 'active')->get();
        return view($this->viewName . '.create', get_defined_vars());
    }

    public function store(Request $request)
    {
        $validation = $this->validate($request, [
            "customer_id" => "required",
            "date" => "required",
            "advanced_payment" => "required",
        ]);

        try {
            $customer = Customer::find($request->customer_id);
            $customer->advanced_payment = $customer->advanced_payment ?? 0 + $request->advanced_payment;
            $customer->save();

            $validation['created_by'] = auth()->id();
            AdvanceBilling::create($validation);

            return redirect()->route('advancebilling.index')->with('success', 'Payment Successfully Done !!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
    }

    public function edit(AdvanceBilling $advancebilling)
    {
        $page_title = "Advance Billing Edit";
        $page_heading = "Advance Billing Edit";
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $advancebilling->id);
        $editinfo = $advancebilling;
        $customers = Customer::where('disabled', false)->get();

        return view($this->viewName . '.edit', get_defined_vars());
    }

    public function update(Request $request, AdvanceBilling $advancebilling)
    {
        $validation = $this->validate($request, [
            "customer_id" => "required",
            "date" => "required",
            "advanced_payment" => "required",
        ]);

        try {
            DB::beginTransaction();
            $advancebilling = $advancebilling->update($validation);
            DB::commit();
            return back()->with('success', 'Data Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
    }

    public function destroy(AdvanceBilling $advancebilling)
    {
        $advancebilling->delete();
        return back()->with('success', 'Data deleted successfully.');
    }
}
