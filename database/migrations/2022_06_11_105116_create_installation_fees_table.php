<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstallationFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installation_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable();
            $table->string('created_on')->nullable();
            $table->string('installation_fee')->nullable();
            $table->string('received_amount')->nullable();
            $table->string('due')->nullable();
            $table->string('received_on')->nullable();
            $table->string('received_by')->nullable();
            $table->string('payment_by')->nullable();
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
        Schema::dropIfExists('installation_fees');
    }
}
