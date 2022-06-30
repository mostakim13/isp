<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBandwidthSaleInvoiceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bandwidth_sale_invoice_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bandwidth_sale_invoice_id');
            $table->foreignId('item_id');
            $table->longText('description')->nullable();
            $table->string('unit')->nullable();
            $table->string('qty')->nullable();
            $table->string('rate')->nullable();
            $table->string('vat')->nullable();
            $table->string('from_date')->nullable();
            $table->string('to_date')->nullable();
            $table->string('total')->nullable();
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
        Schema::dropIfExists('bandwidth_sale_invoice_details');
    }
}
