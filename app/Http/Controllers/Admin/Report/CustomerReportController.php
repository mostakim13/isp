<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CustomerReportController extends Controller
{
    //
    public function index()
    {
        $ajax_url = route('reports.customer_process');
        return view('admin.pages.reports.customers.index', get_defined_vars());
    }


    public function customer_process(Request $request)
    {
        $model = new Customer();
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
                    'code' => Str::padLeft($item->id, 4, 0),
                    'username' => $item->username ?? "N/A",
                    'secreat' => $item->secreat ?? "N/A",
                    'name' => $item->name ?? "N/A",
                    'phone' => $item->phone ?? "N/A",
                    'package' => $item->getProfile->name ?? "N/A",
                    'service' => $item->service ?? "N/A",
                    'bill_amount' => $item->bill_amount ?? "N/A",
                    'profile' => $item->getProfile->name ?? "N/A",
                    'status' => $item->status ?? "N/A",
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
