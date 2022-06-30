<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vlans', function (Blueprint $table) {
            $table->id();
            $table->string('mid')->nullable();
            $table->string('name')->nullable();
            $table->string('mtu')->nullable();
            $table->string('arp')->nullable();
            $table->string('vlan_id')->nullable();
            $table->foreignId('server_id')->nullable();
            $table->string('interface')->nullable();
            $table->foreignId('company_id')->nullable();
            $table->string('use_service_tag')->nullable();
            $table->string('disabled')->nullable();
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
        Schema::dropIfExists('vlans');
    }
}
