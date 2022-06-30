<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->nullable();
            $table->foreignId('supplier_id')->nullable();
            $table->foreignId('customer_id')->nullable();
            $table->foreignId('pay_method_id')->nullable();
            $table->foreignId('purchase_id')->nullable();
            $table->foreignId('asset_id')->nullable();
            $table->foreignId('local_id')->nullable();
            $table->integer('type')->nullable()->comment('Purchase = 1, Expense=2 , Daily Income = 3
            , Supplier Ledger = 4 , Installation Fee = 5, Opening Balance => 6 ,
             Balance Transfer => 7 , Payment Method = 8 , Bill transfer To account = 9');
            $table->date('date')->nullable();
            $table->float('qty', 10, 2)->nullable();
            $table->float('debit', 10, 2)->nullable();
            $table->float('credit', 10, 2)->nullable();
            $table->float('amount', 10, 2)->nullable();
            $table->float('due', 10, 2)->nullable();
            $table->longtext('note')->nullable();
            $table->foreignId('company_id');
            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();
            $table->foreignId('deleted_by')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('transactions');
    }
}
