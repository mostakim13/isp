<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubzonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subzones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('zone_id')->nullable();
            $table->foreignId('district_id')->nullable();
            $table->foreignId('upozilla_id')->nullable();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
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
        Schema::dropIfExists('subzones');
    }
}
