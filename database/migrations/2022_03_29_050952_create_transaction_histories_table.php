<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('model_id');
            $table->string('date_');
            $table->string('amount');
            $table->string('discount')->nullable();
            $table->foreignId('payment_method')->nullable();
            $table->string('paid_by')->nullable();
            $table->string('type')->comment('BandwidthSaleInvoice -> BandwidthSaleInvoice history');
            $table->string('create_by')->nullable();
            $table->longText('description')->nullable();
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
        Schema::dropIfExists('transaction_histories');
    }
}
