<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('m_download')->nullable();
            $table->string('m_upload')->nullable();
            $table->string('m_transfer')->nullable();
            $table->string('m_uptime')->nullable();
            $table->string('m_rate_limite_rx')->nullable();
            $table->string('m_rate_limite_tx')->nullable();
            $table->string('m_burst_rate_rx')->nullable();
            $table->string('m_burst_rate_tx')->nullable();
            $table->string('m_burst_threshold_rx')->nullable();
            $table->string('m_burst_threshold_tx')->nullable();
            $table->string('m_burst_time_rx')->nullable();
            $table->string('m_burst_time_tx')->nullable();
            $table->string('m_min_rate_rx')->nullable();
            $table->string('m_min_rate_tx')->nullable();
            $table->string('m_priority')->nullable();
            $table->string('m_group_name')->nullable();
            $table->string('m_ip_pool')->nullable();
            $table->string('m_ipv6_pool')->nullable();
            $table->string('m_address_list')->nullable();
            $table->foreignId('created_by')->nullable();
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
        Schema::dropIfExists('packages');
    }
}
