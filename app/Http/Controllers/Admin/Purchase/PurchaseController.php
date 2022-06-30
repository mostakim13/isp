<?php

namespace App\Http\Controllers\Admin\Purchase;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Admin\Purchase\PurchaseCalculation;
use App\Models\PurchaseDetails;
use App\Models\StockSummary;
use App\Models\Transaction;

class PurchaseController extends Controller
{
    /**
     * String property
     */
    use PurchaseCalculation;
    protected $routeName =  'purchases';
    protected $viewName =  'admin.pages.purchases';

    protected function getModel()
    {
        return new Purchase();
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
                'label' => 'Invoice No',
                'data' => 'invoice_no',
                'searchable' => false,
            ],

            [
                'label' => 'Supplier',
                'data' => 'name',
                'searchable' => false,
                'relation' => "supplier",
            ],

            [
                'label' => 'Sub Total',
                'data' => 'subtotal',
                'searchable' => false,
            ],

            [
                'label' => 'Discount',
                'data' => 'discount',
                'searchable' => false,
            ],

            [
                'label' => 'Total Qty',
                'data' => 'quantity',
                'searchable' => false,
            ],

            [
                'label' => 'Create By',
                'data' => 'name',
                'searchable' => false,
                'relation' => "usersdet",
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
        $page_title = "Purchase";
        $page_heading = "Purchase List";
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
            $this->routeName,
            true,
            [
                [
                    'method_name' => 'show',
                    'class' => 'btn-info',
                    'fontawesome' => 'fa fa-eye',
                    'text' => '',
                    'title' => 'View',
                ],
                [
                    'method_name' => 'destroy',
                    'class' => 'btn-info',
                    'fontawesome' => 'fa fa-trash',
                    'text' => '',
                    'title' => 'View',
                ],
                [
                    'method_name' => 'invoice',
                    'class' => 'btn-info btn-sm',
                    'fontawesome' => '',
                    'text' => 'Inv',
                    'title' => 'View',
                ]
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = "Purchase Create";
        $page_heading = "Purchase Create";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
        $purchaseLastData = Purchase::latest('id')->pluck('id')->first() ?? "0";
        $invoice_no = 'PV' . str_pad($purchaseLastData + 1, 5, "0", STR_PAD_LEFT);
        $supplier = Supplier::get();
        $category_info  = ProductCategory::withCount('products')->get();
        $account = Account::get();
        // dd($purchaseLastData);
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
            'date' => ['required'],
            'supplier_id' => ['required'],
            'invoice_no' => ['required'],
            'payment_type' => ['required'],
            'account_id' => ['nullable'],
            'discount' => ['nullable'],
            'narration' => ['nullable'],
            'paid_amount' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();
            $grandTotal = array_sum($request->total) - $request->discount;
            $dueAmount = $this->dueAmount($grandTotal, $request->paid_amount);

            $valideted['subtotal'] = array_sum($request->total);
            $valideted['quantity'] = array_sum($request->qty);
            $valideted['due_amount'] = $dueAmount;
            $valideted['grand_total'] = abs($grandTotal);
            $valideted['created_by'] = auth()->id();
            $purchase =  Purchase::create($valideted);

            $this->productDetailsWithStock($purchase, $request);

            if ($request->account_id) {
                $this->accountBalanceReduct(Account::find($request->account_id), $request->paid_amount);
            }

            $this->supplierUnpaid(Supplier::find($request->supplier_id), $dueAmount);

            $transaction['account_id'] = $request->account_id;
            $transaction['supplier_id'] = $request->supplier_id;
            $transaction['purchase_id'] = $purchase->id;
            $transaction['type'] = 1;
            $transaction['date'] = $request->date;
            $transaction['credit'] = $request->paid_amount;
            $transaction['amount'] = $request->paid_amount;
            $transaction['due'] = $dueAmount;
            $transaction['note'] = $request->narration;
            $transaction['created_by'] = auth()->id();
            Transaction::create($transaction);

            DB::commit();
            return back()->with('success', 'Data Store Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Something was wrong' . $e->getMessage() . 'Line' . $e->getLine() . 'File' . $e->getFile());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Purchase $purchase)
    {
        dd($purchase);
        return view($this->viewName . '.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        $page_title = "Purchase Edit";
        $page_heading = "Purchase Edit";
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $purchase->id);
        $supplier = Supplier::get();
        $category_info  = ProductCategory::get();
        $accounts = Account::get();
        $editinfo = $purchase;
        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purchase $purchase)
    {
        $valideted = $this->validate($request, [
            'name' => ['required'],
            'phone' => ['required'],
            'email' => ['nullable'],
            'address' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();

            $purchase->update($valideted);

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
    public function destroy(Purchase $purchase)
    {
        $purchase->delete();
        return back()->with('success', 'Data deleted successfully.');
    }

    public function getProductList(Request $request)
    {
        $cat_id = $request->cat_id;
        $productList = Product::withCount('category')->where('product_category_id', $cat_id)->get();
        $add = '';
        if (!empty($productList)) :
            $add .= "<option value='all'>All Product</option>";
            foreach ($productList as $key => $value) :
                $add .= "<option proName='" . $value->name . "'   value='" . $value->id . "'>$value->productCode - $value->name</option>";
            endforeach;
            echo $add;
            die;
        else :
            echo "<option value='' selected disabled>No Product Available</option>";
            die;
        endif;
    }

    public function unitPrice(Request $request)
    {
        $proid = $request->productId;
        $productPrice = Product::get()->where('id', $proid)->first();
        echo $productPrice->purchases_price;
    }

    public function getAccounts(Request $request)
    {
        $accounts = Account::get();
        $html = '';
        if ($accounts->isNotEmpty()) {
            $html .= "<option value='' selected disabled>--Select Account--</option>";
            foreach ($accounts as $key => $account) {
                $html .= "<option value='" . $account->id . "'>$account->accountCode - $account->account_name</option>";
            }
        } else {
            $html .= "<option value='' selected disabled>--No Account Available--</option>";
        }
        return $html;
    }

    public function allstock()
    {
        $stocks = StockSummary::get();
        return view($this->viewName . '.stock', get_defined_vars());
    }

    public function invoice(Purchase $purchase)
    {
        $invoice = Purchase::with('supplier')->findOrFail($purchase->id);
        $purchasesData = PurchaseDetails::with('productlist', 'productCategory')->where('purchases_id', $invoice->id)->get();
        return view('admin.pages.purchases.invoice', get_defined_vars());
    }
}
