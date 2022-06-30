<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('zone_id')->nullable();
            $table->foreignId('billing_person')->nullable();
            $table->string('package')->nullable()->comment('package means package id of profile');
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('spouse_name')->nullable();
            $table->string('nid')->nullable();
            $table->string('doc_image')->nullable();
            $table->date('dob')->nullable();
            $table->string('reference')->nullable();
            $table->string('user_type')->nullable();
            $table->string('mac_address')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('parent_id')->nullable();
            $table->string('limit')->nullable();
            $table->text('address')->nullable();
            $table->text('comment')->nullable();
            $table->date('connection_date')->nullable();
            $table->string('bill_amount')->nullable();
            $table->string('speed')->nullable();
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
        Schema::dropIfExists('user_details');
    }
}
