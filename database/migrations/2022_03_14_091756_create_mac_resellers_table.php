<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMacResellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mac_resellers', function (Blueprint $table) {
            $table->id();
            $table->string('person_name');
            $table->string('email');
            $table->string('mobile');
            $table->string('phone')->nullable();
            $table->string('national_id')->nullable();
            $table->foreignId('zone_id')->nullable();
            $table->string('reseller_user_name');
            $table->string('reseller_code')->nullable();
            $table->string('reseller_prefix')->nullable();
            $table->enum('set_prefix_mikrotikuser', ['no', 'yes']);
            $table->enum('reseller_type', ['prepaid', 'postpaid']);
            $table->string('rechargeable_amount')->nullable();
            $table->string('address')->nullable();
            $table->string('reseller_logo')->nullable();

            $table->string('business_name')->nullable();
            $table->foreignId('tariff_id')->nullable();
            $table->foreignId('user_id');
            $table->enum('disabled_client', ['false', 'true'])->nullable();
            $table->string('minimum_balance')->nullable();
            $table->string('user_name')->nullable();
            $table->string('password');
            $table->string('viewpassword');
            $table->string('reseller_menu')->nullable();
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
        Schema::dropIfExists('mac_resellers');
    }
}
