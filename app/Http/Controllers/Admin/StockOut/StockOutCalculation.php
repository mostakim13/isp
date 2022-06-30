<?php

namespace App\Http\Controllers\Admin\StockOut;

use App\Models\StockOutDetails;
use App\Models\StockSummary;
use Illuminate\Support\Facades\DB;

trait StockOutCalculation
{
    public function stockOutFromSummery($model, $req)
    {
        for ($i = 0; $i < count($req->products); $i++) {
            $stockoutDetails[] = [
                'stock_out_id' => $model->id,
                'product_category_id' => $req->categorys[$i],
                'product_id' => $req->products[$i],
                'quantity' => $req->qty[$i],
            ];
            $stocksummery[] = ['product_id' => $req->products[$i], 'qty' =>  $this->stockSummeryValue($req->products[$i], $req->qty[$i])];
        }
        StockSummary::upsert($stocksummery, ['product_id'], ['qty']);
        StockOutDetails::insert($stockoutDetails);
    }

    public function stockSummeryValue($productid, $qty)
    {
        $stockqty = StockSummary::where('product_id', $productid)->pluck('qty')->first() ?? 0;
        return  $stockqty - $qty;
    }
}
