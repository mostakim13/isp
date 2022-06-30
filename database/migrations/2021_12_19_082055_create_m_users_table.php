<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_users', function (Blueprint $table) {
            $table->id();
            $table->string("m_id")->nullable();
            $table->string("customer")->nullable();
            $table->string("actual-profile")->nullable();
            $table->string("username")->nullable();
            $table->string("ipv6-dns")->nullable();
            $table->string("shared-users")->nullable();
            $table->string("wireless-psk")->nullable();
            $table->string("wireless-enc-key")->nullable();
            $table->string("wireless-enc-algo")->nullable();
            $table->string("uptime-used")->nullable();
            $table->string("download-used")->nullable();
            $table->string("upload-used")->nullable();
            $table->string("last-seen")->nullable();
            $table->string("active-sessions")->nullable();
            $table->string("active")->nullable();
            $table->string("incomplete")->nullable();
            $table->string("disabled")->nullable();
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
        Schema::dropIfExists('m_users');
    }
}
