<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DiscountReportController extends Controller
{
    //
    public function index()
    {
        $ajax_url = route('reports.discount_process');
        return view('admin.pages.reports.discounts.index', get_defined_vars());
    }


    public function discount_process(Request $request)
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
                    'ip' => $item->getCustomer->username ?? "N/A",
                    'name' => $item->getCustomer->name ?? "N/A",
                    'zone' => "Zone",
                    'package' => $item->getProfile->name ?? "N/A",
                    'customer_billing_amount' => $item->customer_billing_amount ?? "N/A",
                    'discount' => $item->discount ?? "N/A",
                    'r_date' => Carbon::parse($item->date_)->format('d-m-Y'),
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
