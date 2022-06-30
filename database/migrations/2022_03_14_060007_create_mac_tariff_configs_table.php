<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMacTariffConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mac_tariff_configs', function (Blueprint $table) {
            $table->id();
            $table->string('tariff_name')->nullable();
            $table->text('package_id')->nullable();
            $table->text('package_rate')->nullable();
            $table->text('package_validation_day')->nullable();
            $table->text('package_minimum_activation_day')->nullable();
            $table->text('server_id')->nullable();
            $table->text('protocole_type')->nullable();
            $table->text('ppp_profile')->nullable();
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
        Schema::dropIfExists('mac_tariff_configs');
    }
}
