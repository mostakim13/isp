<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_profiles', function (Blueprint $table) {
            $table->id();
            $table->string("m_id")->nullable();
            $table->string("name")->nullable();
            $table->string("owner")->nullable();
            $table->string("name-for-users")->nullable();
            $table->string("validity")->nullable();
            $table->string("starts-at")->nullable();
            $table->string("price")->nullable();
            $table->string("override-shared-users")->nullable();
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
        Schema::dropIfExists('profiles');
    }
}
