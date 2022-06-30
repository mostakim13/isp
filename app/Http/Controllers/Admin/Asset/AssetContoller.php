<?php

namespace App\Http\Controllers\Admin\Asset;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\AssetList;
use App\Models\AssetsCategory;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssetContoller extends Controller
{
    protected $routeName =  'assetlist';
    protected $viewName =  'admin.pages.assetlists';

    protected function getModel()
    {
        return new AssetList();
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
                'label' => 'Name',
                'data' => 'name',
                'searchable' => false,
            ],
            // [
            //     'label' => 'Asset ID',
            //     'data' => 'asset_id',
            //     'searchable' => false,
            // ],
            [
                'label' => 'Asset Category',
                'data' => 'category_name',
                'searchable' => false,
                'relation' => 'assetcat',
            ],
            [
                'label' => 'Quantity (PCs)',
                'data' => 'qty',
                'searchable' => false,
            ],
            [
                'label' => 'Amount',
                'data' => 'amount',
                'searchable' => false,
            ],

            [
                'label' => 'Status',
                'data' => 'status',
                'checked' => ['true'],
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

    public function index()
    {
        $page_title = "Asset List";
        $page_heading = "Asset List";
        $ajax_url = route($this->routeName . '.dataProcessing');
        $create_url = route($this->routeName . '.create');
        $is_show_checkbox = false;
        $columns = $this->reformatForRelationalColumnName(
            $this->tableColumnNames()
        );
        return view('admin.pages.index', get_defined_vars());
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
                'edit'
            ]
        );
    }

    public function create()
    {
        $page_title = "Asset List";
        $page_heading = "Asset List";
        $back_url = route($this->routeName . '.index');
        $store_url = route($this->routeName . '.store');
        $accounts = Account::getaccount()->get();
        $assets = AssetsCategory::where('status', 1)->where('type', 1)->get();
        return view($this->viewName . '.create', get_defined_vars());
    }

    public function store(Request $request)
    {
        $valideted = $this->validate($request, [
            '_date' => ['required'],
            'name' => ['required'],
            'account_id' => ['required'],
            'category_asset_id' => ['required'],
            'qty' => ['required'],
            'amount' => ['required'],
        ]);

        try {
            DB::beginTransaction();
            $account = Account::find($request->account_id);

            if ($request->amount > $account->amount) {
                return back()->with('failed', 'Not enough balance on your account');
            }

            $account->update(['amount' => $account->amount - $request->amount]);
            $valideted['status'] = 'true';
            $valideted['company_id'] = auth()->user()->company_id;
            $asset = AssetList::create($valideted);

            $transaction['account_id'] = $request->account_id;
            $transaction['date'] = $request->_date;
            $transaction['asset_id'] = $asset->id;
            $transaction['local_id'] = 1;
            $transaction['type'] = 2;
            $transaction['company_id'] = auth()->user()->company_id;
            $transaction['debit'] = $request->amount;
            $transaction['amount'] = $request->amount;
            $transaction['note'] = $request->name . " Buy";
            $transaction['created_by'] = auth()->id();
            Transaction::create($transaction);

            DB::commit();
            return back()->with('success', 'Data Store Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
    }

    public function edit(AssetList $assetlist)
    {
        $page_title = "Asset Edit";
        $page_heading = "Asset Edit";
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $assetlist->id);
        $editinfo = $assetlist;
        $accounts = Account::getaccount()->get();
        $assets = AssetsCategory::where('status', 1)->where('type', 1)->get();
        return view($this->viewName . '.edit', get_defined_vars());
    }

    public function update(Request $request, AssetList $assetlist)
    {
        $valideted = $this->validate($request, [
            '_date' => ['required'],
            'name' => ['required'],
            'account_id' => ['required'],
            'category_asset_id' => ['required'],
            'qty' => ['required'],
            'amount' => ['required'],
        ]);

        try {
            DB::beginTransaction();

            $accountrollback = Account::find($assetlist->account_id);
            $accountrollback->update(['amount' => $accountrollback->amount + $assetlist->amount]);

            $account = Account::find($request->account_id);
            if ($request->amount > $account->amount) {
                DB::rollBack();
                return back()->with('failed', 'Not enough balance on your account');
            }

            $account->update(['amount' => $account->amount - $request->amount]);

            $assetlist->update($valideted);

            $transaction['account_id'] = $request->account_id;
            $transaction['date'] = $request->_date;
            $transaction['company_id'] = auth()->user()->company_id;
            $transaction['debit'] = $request->amount;
            $transaction['amount'] = $request->amount;
            $transaction['note'] = $request->name . " Buy";
            $transaction['created_by'] = auth()->id();
            Transaction::where('asset_id', $assetlist->id)->where('local_id', 1)->update($transaction);


            DB::commit();
            return back()->with('success', 'Data Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
    }

    public function destroy(AssetList $assetlist)
    {
        $assetlist->delete();
        return back()->with('success', 'Data deleted successfully.');
    }

    public function status(AssetList $assetlist)
    {
        $status = $assetlist->status == 'true' ? "false" : 'true';
        $assetlist->update(['status' => $status]);
        return back()->with('success', 'Status update successfully.');
    }
}
