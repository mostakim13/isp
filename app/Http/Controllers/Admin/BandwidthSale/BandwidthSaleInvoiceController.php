<?php

namespace App\Http\Controllers\Admin\BandwidthSale;

use App\Http\Controllers\Controller;
use App\Models\BandwidthCustomer;
use App\Models\BandwidthSaleInvoice;
use App\Models\Company;
use App\Models\Item;
use App\Models\PaymentMethod;
use App\Models\TransactionHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BandwidthSaleInvoiceController extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'bandwidthsaleinvoice';
    protected $viewName =  'admin.pages.bandwidthsale.bandwidthsaleinvoice';

    protected function getModel()
    {
        return new BandwidthSaleInvoice();
    }

    protected function tableColumnNames()
    {
        return [
            [
                'label' => 'SN',
                'data' => 'id',
                'searchable' => false,
            ],
            [
                'label' => 'Customer',
                'data' => 'name',
                'searchable' => false,
            ],
            [
                'label' => 'Contact Person',
                'data' => 'contact_person',
                'searchable' => false,
            ],
            [
                'label' => 'Bill No',
                'data' => 'contact_person',
                'searchable' => false,
            ],
            [
                'label' => 'Invoice of Month',
                'data' => 'contact_person',
                'searchable' => false,
            ],
            [
                'label' => 'Total Amount',
                'data' => 'contact_person',
                'searchable' => false,
            ],
            [
                'label' => 'Received Amount',
                'data' => 'contact_person',
                'searchable' => false,
            ],
            [
                'label' => 'Discount',
                'data' => 'contact_person',
                'searchable' => false,
            ],
            [
                'label' => 'Due',
                'data' => 'email',
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
        $page_title = "Bandwidth Sale Invoice";
        $page_heading = "Bandwidth Sale Invoice List";
        $create_url = route($this->routeName . '.create');
        $bandwidthsales = BandwidthSaleInvoice::get();
        return view($this->viewName . '.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = "Bandwidth Sale Invoice Create";
        $page_heading = "Bandwidth Sale Invoice Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
        $customers = BandwidthCustomer::get();
        $items = Item::where('status', 'active')->get();
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
            "customer_id" => ["required",],
            "invoice_no" => ["nullable"],
            "billing_month" => ["required",],
            "payment_due" => ["required"],
            "remark" => ["nullable"],
        ]);

        try {
            DB::beginTransaction();
            $valideted['due'] = array_sum($request->total);
            $valideted['total'] = array_sum($request->total);
            $valideted['created_by'] = auth()->id();
            $bandwidthsaleinvoice = $this->getModel()->create($valideted);

            for ($i = 0; $i < count($request->item_id); $i++) {
                $details[] = [
                    'bandwidth_sale_invoice_id' => $bandwidthsaleinvoice->id,
                    'item_id' => $request->item_id[$i],
                    'description' => $request->description[$i],
                    'unit' => $request->unit[$i],
                    'qty' => $request->qty[$i],
                    'rate' => $request->rate[$i],
                    'vat' => $request->vat[$i],
                    'from_date' => $request->from_date[$i],
                    'to_date' => $request->to_date[$i],
                    'total' => $request->total[$i],
                ];
            }

            $this->getModel()->detaile()->insert($details);

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
     * @param  \App\Models\ItemCategory  $ItemCategory
     * @return \Illuminate\Http\Response
     */
    public function invoice(BandwidthSaleInvoice $banseidthsaleinvoice)
    {
        $page_title = "Bandwidth Sale Invoice Edit";
        $page_heading = "Bandwidth Sale Invoice Edit";
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $banseidthsaleinvoice->id);
        $editinfo = $banseidthsaleinvoice;
        $customers = BandwidthCustomer::get();
        $items = Item::where('status', 'active')->get();
        $company = Company::orderBy('id', 'desc')->first();
        return view($this->viewName . '.invoice', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ItemCategory  $ItemCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(BandwidthSaleInvoice $banseidthsaleinvoice)
    {
        $page_title = "Bandwidth Sale Invoice Edit";
        $page_heading = "Bandwidth Sale Invoice Edit";
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $banseidthsaleinvoice->id);
        $editinfo = $banseidthsaleinvoice;
        $customers = BandwidthCustomer::get();
        $items = Item::where('status', 'active')->get();
        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ItemCategory  $ItemCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BandwidthSaleInvoice $banseidthsaleinvoice)
    {
        $valideted = $this->validate($request, [
            "customer_id" => ["required",],
            "invoice_no" => ["nullable"],
            "billing_month" => ["required",],
            "payment_due" => ["required"],
            "remark" => ["nullable"],
        ]);

        try {
            DB::beginTransaction();
            $valideted['due'] = array_sum($request->total);
            $valideted['total'] = array_sum($request->total);
            $valideted['updated_by'] = auth()->id();
            $banseidthsaleinvoice->update($valideted);
            $banseidthsaleinvoice->detaile()->delete();
            for ($i = 0; $i < count($request->item_id); $i++) {
                $details[] = [
                    'bandwidth_sale_invoice_id' => $banseidthsaleinvoice->id,
                    'item_id' => $request->item_id[$i],
                    'description' => $request->description[$i],
                    'unit' => $request->unit[$i],
                    'qty' => $request->qty[$i],
                    'rate' => $request->rate[$i],
                    'vat' => $request->vat[$i],
                    'from_date' => $request->from_date[$i],
                    'to_date' => $request->to_date[$i],
                    'total' => $request->total[$i],
                ];
            }

            $this->getModel()->detaile()->insert($details);

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
     * @param  \App\Models\ItemCategory  $ItemCategory
     * @return \Illuminate\Http\Response
     */
    public function itemval(Request $request)
    {
        $itels = Item::select('unit', 'vat')->find($request->item_id);
        return response()->json($itels);
    }
    public function destroy(BandwidthSaleInvoice $banseidthsaleinvoice)
    {
        $banseidthsaleinvoice->delete();
        return back()->with('success', 'Data deleted successfully.');
    }

    public function pay(BandwidthSaleInvoice $banseidthsaleinvoice)
    {
        $paymentmethods = PaymentMethod::where('status', 'active')->get();
        $back_url = route($this->routeName . '.index');

        return view($this->viewName . '.pay', get_defined_vars());
    }

    public function paystore(Request $request, BandwidthSaleInvoice $banseidthsaleinvoice)
    {
        $valideted = $this->validate($request, [
            "date_" => ["required",],
            "amount" => ["required",],
            "discount" => ["nullable",],
            "payment_method" => ["required",],
            "paid_by" => ["required",],
            "description" => ["required",],
        ]);

        try {
            DB::beginTransaction();
            $received = abs($banseidthsaleinvoice->received_amount + $request->amount);
            $discount = abs($banseidthsaleinvoice->discount + $request->discount);
            $due = $banseidthsaleinvoice->total - ($received + $discount);
            $payment = [
                'received_amount' => $received,
                'discount' => $discount,
                'due' => $due,
            ];

            if ($due < 1) {
                $payment['status'] = 'paid';
            }

            $banseidthsaleinvoice->update($payment);

            $valideted['model_id'] = $banseidthsaleinvoice->id;
            $valideted['type'] = "BandwidthSaleInvoice";
            $valideted['create_by'] = auth()->id();

            TransactionHistory::create($valideted);

            DB::commit();
            return back()->with('success', 'Data Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
    }
}
