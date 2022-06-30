<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_sessions', function (Blueprint $table) {
            $table->id();
            $table->string("m_id")->nullable();
            $table->string("customer")->nullable();
            $table->string("user")->nullable();
            $table->string("nas-port")->nullable();
            $table->string("nas-port-type")->nullable();
            $table->string("nas-port-id")->nullable();
            $table->string("calling-station-id")->nullable();
            $table->string("acct-session-id")->nullable();
            $table->string("user-ip")->nullable();
            $table->string("host-ip")->nullable();
            $table->string("status")->nullable();
            $table->string("from-time")->nullable();
            $table->string("till-time")->nullable();
            $table->string("terminate-cause")->nullable();
            $table->string("uptime")->nullable();
            $table->string("download")->nullable();
            $table->string("upload")->nullable();
            $table->string("active")->nullable();
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
        Schema::dropIfExists('user_sessions');
    }
}
