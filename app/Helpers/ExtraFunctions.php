<?php

use App\Helpers\Billing as HelpersBilling;
use App\Models\Billing;
use App\Models\Tj;

if (!function_exists('format_bytes')) {
    /**
     * Format bytes to kb, mb, gb, tb
     *
     * @param  integer $size
     * @param  integer $precision
     * @return integer
     */
    function format_bytes($size, $precision = 2)
    {
        if ($size > 0) {
            $size = (int) $size;
            $base = log($size) / log(1024);
            $suffixes = array(' bytes', ' kbps', ' Mbps', ' Gbps', ' Tbps');

            return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
        } else {
            return $size;
        }
    }
}

if (!function_exists('invoiceNumber')) {
    /**
     *
     * @return integer
     */
    function invoiceNumber($id)
    {

        $purchaseLastData = Billing::find($id);
        if ($purchaseLastData) :
            $purchaseData = $purchaseLastData->id;
        else :
            $purchaseData = 1;
        endif;
        $invoice_no = 'BV' . str_pad($purchaseData, 5, "0", STR_PAD_LEFT);

        return $invoice_no;
    }
}
