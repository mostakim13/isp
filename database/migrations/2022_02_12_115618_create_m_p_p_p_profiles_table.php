<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMPPPProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_p_p_p_profiles', function (Blueprint $table) {
            $table->id();
            $table->string("mid", 20)->unique();
            $table->string("name")->nullable();
            $table->string("local_address")->nullable();
            $table->foreignId("remote_address")->nullable();
            $table->string("bridge_learning")->nullable();
            $table->string("change_tcp_mss")->nullable();
            $table->string("use_upnp")->nullable();
            $table->string("dns_server")->nullable();
            $table->string("amount")->nullable();
            $table->string("speed")->nullable();
            $table->string("default")->nullable();
            $table->foreignId('server_id')->nullable();
            $table->foreignId("created_by")->nullable();
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
        Schema::dropIfExists('m_p_p_p_profiles');
    }
}
