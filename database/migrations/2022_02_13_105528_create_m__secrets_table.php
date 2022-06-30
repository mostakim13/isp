<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMSecretsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m__secrets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->string('mid', 20)->unique();
            $table->string('name')->nullable();
            $table->string('service')->nullable();
            $table->string('caller')->nullable();
            $table->string('profile')->nullable();
            $table->string('routes')->nullable();
            $table->string('ipv6_routes')->nullable();
            $table->string('limit_bytes_in')->nullable();
            $table->string('limit_bytes_out')->nullable();
            $table->string('last_logged_out')->nullable();
            $table->string('disabled')->nullable();
            $table->string('comment')->nullable();
            // Active Connection fild
            $table->string('address')->nullable();
            $table->string('uptime')->nullable();
            $table->string('encoding')->nullable();
            $table->string('session_id')->nullable();
            $table->string('radius')->nullable();
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
        Schema::dropIfExists('m__secrets');
    }
}
