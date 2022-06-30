<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBandwidthSaleInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bandwidth_sale_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id');
            $table->string('invoice_no')->nullable();
            $table->string('billing_month')->nullable();
            $table->string('payment_due')->nullable();
            $table->string('received_amount')->nullable();
            $table->string('discount')->nullable();
            $table->string('due')->nullable();
            $table->enum('status', ['due', 'pay', 'paid']);
            $table->longText('remark')->nullable();
            $table->string('total')->nullable();
            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bandwidth_sale_invoices');
    }
}
