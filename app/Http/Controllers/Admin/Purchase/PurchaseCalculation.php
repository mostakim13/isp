<?php

namespace App\Http\Controllers\Admin\Purchase;

use App\Models\PurchaseDetails;
use App\Models\StockSummary;
use Illuminate\Support\Facades\DB;

trait PurchaseCalculation
{

    public function dueAmount($total, $paid)
    {
        $due = $total - $paid;
        return $due;
    }

    public function productDetailsWithStock($model, $req)
    {

        for ($i = 0; $i < count($req->proName); $i++) {
            $value[] = [
                'purchases_id' => $model->id,
                'product_category_id' => $req->catName[$i],
                'product_id' => $req->proName[$i],
                'quantity' => $req->qty[$i],
                'unit_price' => $req->unitprice[$i],
                'total_price' => $req->total[$i],
            ];

            $stocksummery[] = ['product_id' => $req->proName[$i], 'qty' =>  $this->stockSummeryValue($req->proName[$i], $req->qty[$i])];
        }
        StockSummary::upsert($stocksummery, ['product_id'], ['qty']);
        PurchaseDetails::insert($value);
    }

    public function accountBalanceReduct($model, $amount)
    {
        return  $model->update(['amount' => $model->amount - $amount]);
    }

    public function supplierUnpaid($model, $amount)
    {
        $model->update(['unpaid' => $model->unpaid + $amount]);
        return true;
    }

    public function stockSummeryValue($productid, $qty)
    {
        $stockqty = StockSummary::where('product_id', $productid)->pluck('qty')->first() ?? 0;
        return  $stockqty + $qty;
    }
}
