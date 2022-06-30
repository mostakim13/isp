<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackage2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package2', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_type_id')->nullable();
            $table->string('name')->nullable();
            $table->foreignId('company_id')->nullable();
            $table->double('price', 8, 2)->nullable();
            $table->string('bandwidth_allocation')->nullable();
            $table->string('description')->nullable();
            $table->boolean('is_show_in_client_profile')->default(false);
            $table->boolean('status')->default(true);

            $table->foreignId('tariffconfig_id')->default(0);
            $table->foreignId('mac_package_id')->nullable();
            $table->foreignId('server_id')->nullable();
            $table->foreignId('protocol_id')->nullable();
            $table->foreignId('m_profile_id')->nullable();
            $table->string('rate')->nullable();
            $table->string('selling_price')->nullable();
            $table->string('validity_day')->nullable();
            $table->string('minimum_activation_day')->nullable();

            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();
            $table->foreignId('deleted_by')->nullable();
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
        Schema::dropIfExists('package2');
    }
}
