<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockOutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_outs', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no');
            $table->foreignId('customer_id');
            $table->foreignId('stuff_id');
            $table->string('date');
            $table->string('quantity')->nullable();
            $table->longText('narration')->nullable();
            $table->foreignId('create_by')->nullable();
            $table->foreignId('update_by')->nullable();
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
        Schema::dropIfExists('stock_outs');
    }
}
