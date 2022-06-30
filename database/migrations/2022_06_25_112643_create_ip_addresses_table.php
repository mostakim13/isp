<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIpAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ip_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('mid')->nullable();
            $table->string('address')->nullable();
            $table->string('network')->nullable();
            $table->string('interface')->nullable();
            $table->string('disabled')->nullable();
            $table->foreignId('server_id')->nullable();
            $table->foreignId('company_id')->nullable();
            $table->foreignId('created_id')->nullable();
            $table->foreignId('updated_id')->nullable();
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
        Schema::dropIfExists('ip_addresses');
    }
}
