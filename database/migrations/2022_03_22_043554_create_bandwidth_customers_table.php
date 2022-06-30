<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBandwidthCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bandwidth_customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('phone')->nullable();
            $table->enum('status', ['active', 'inactive'])->nullable();
            $table->string('reference_by')->nullable();
            $table->string('address')->nullable();
            $table->string('remarks')->nullable();
            $table->string('facebook')->nullable();
            $table->string('skypeid')->nullable();
            $table->string('website')->nullable();
            $table->string('nttn_info')->nullable();
            $table->text('vlan_info')->nullable();
            $table->text('vlan_id')->nullable();
            $table->string('scr_or_link_id')->nullable();
            $table->string('activition_date')->nullable();
            $table->text('ipaddress')->nullable();
            $table->string('pop_name')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('bandwidth_customers');
    }
}
