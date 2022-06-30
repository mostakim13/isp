<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_incomes', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->foreignId('company_id');
            $table->foreignId('category_id')->nullable();
            $table->foreignId('account_id')->nullable();
            $table->foreignId('customer_id')->nullable();
            $table->foreignId('supplier_id')->nullable();
            $table->double('amount')->nullable();
            $table->double('paid_amount')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('created_by')->nullable();
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
        Schema::dropIfExists('daily_incomes');
    }
}
