<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BillCollectionReportController extends Controller
{
    //
    public function index()
    {
        $ajax_url = route('reports.bill_collections');
        return view('admin.pages.reports.billcollection.index', get_defined_vars());
    }


    public function bill_collections(Request $request)
    {
        $model = new Billing();
        /**
         * Sortable column list mgenerate
         */
        $sortableColumns = [];
        // foreach ($tableColumnsName as $columnName) {
        //     if (isset($columnName['orderable']) && $columnName['orderable'] == true) {
        //         $sortableColumns[] = $columnName['data'];
        //     } else {
        //         $sortableColumns[] = $columnName['data'];
        //     }
        // }

        // end

        $totalData = $model->count();
        $limit = request('length');
        $start = request('start');
        // $order = $sortableColumns[request('order.0.column')];
        $dir = request('order.0.dir');

        if (empty(request('search.value'))) {
            $results = $model->offset($start)
                ->limit($limit)
                // ->orderBy($order, $dir)
                ->get();
            $totalFiltered = $model->count();
        } else {
            $search = request('search.value');
            $results = $model->where('name', 'like', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                // ->orderBy($order, $dir)
                ->get();
            $totalFiltered = $model->where('name', 'like', "%{$search}%")->count();
        }
        $data = array();
        if ($results) {
            foreach ($results as $key => $item) {
                $data[] = [
                    'code' => Str::padLeft($item->getCustomer->id, 4, 0),
                    'name' => $item->getCustomer->name ?? "N/A",
                    'username' => $item->getCustomer->username ?? "N/A",
                    'r_date' => Carbon::parse($item->date_)->format('d-m-Y'),
                    'zone' => "Zone",
                    'package' => $item->getProfile->name ?? "N/A",
                    'status' => $item->status ?? "N/A",
                    'customer_billing_amount' => $item->customer_billing_amount ?? "N/A",
                    'pay_amount' => $item->pay_amount ?? "N/A",
                    'money_receipt' => Str::padLeft($item->id, 4, 0) ?? "N/A",
                    'created_by' => $item->getBillinfBy->name ?? "N/A",
                    'received_by' => $item->getBiller->name ?? "N/A",
                ];
            }
        }
        $json_data = array(
            "draw" => intval(request('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        return $json_data;
    }
}
