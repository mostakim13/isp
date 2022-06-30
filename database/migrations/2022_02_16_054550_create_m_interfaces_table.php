<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMInterfacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_interfaces', function (Blueprint $table) {
            $table->id();
            $table->string('mid', 20)->unique();
            $table->string('name')->nullable();
            $table->string('default_name')->nullable();
            $table->string('type')->nullable();
            $table->string('mtu')->nullable();
            $table->string('actual_mtu')->nullable();
            $table->string('l2mtu')->nullable();
            $table->string('max_l2mtu')->nullable();
            $table->string('mac_address')->nullable();
            $table->string('last_link_down_time')->nullable();
            $table->string('last_link_up_time')->nullable();
            $table->string('link_downs')->nullable();
            $table->string('rx_byte')->nullable();
            $table->string('tx_byte')->nullable();
            $table->string('rx_packet')->nullable();
            $table->string('tx_packet')->nullable();
            $table->string('rx_drop')->nullable();
            $table->string('tx_drop')->nullable();
            $table->string('tx_queue_drop')->nullable();
            $table->string('rx_error')->nullable();
            $table->string('tx_error')->nullable();
            $table->string('fp_rx_byte')->nullable();
            $table->string('fp_tx_byte')->nullable();
            $table->string('fp_rx_packet')->nullable();
            $table->string('fp_tx_packet')->nullable();
            $table->string('running')->nullable();
            $table->string('disabled')->nullable();
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
        Schema::dropIfExists('m_interfaces');
    }
}
