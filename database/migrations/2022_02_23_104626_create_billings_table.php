<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billings', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_profile_id')->nullable();
            $table->string('customer_billing_amount')->nullable();
            $table->string('biller_name')->nullable();
            $table->date('date_')->nullable();
            $table->foreignId('payment_method_id')->nullable();
            $table->string('biller_phone')->nullable();
            $table->string('pay_amount')->nullable();
            $table->string('partial')->nullable();
            $table->string('discount')->nullable();
            $table->longText('description')->nullable();
            $table->integer('billing_by')->nullable();
            $table->foreignId('company_id');
            $table->enum('alert', ['white', 'red'])->nullable();
            $table->enum('type', ['expired', 'collection'])->nullable();
            $table->enum('status', ['paid', 'unpaid', 'partial'])->nullable();
            // $table->string('status')->nullable(); //
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
        Schema::dropIfExists('billings');
    }
}
