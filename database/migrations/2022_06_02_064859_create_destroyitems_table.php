<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDestroyitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('destroyitems', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->nullable();
            $table->foreignId('company_id');
            $table->foreignId('reason_id')->nullable();
            $table->integer('qty')->nullable();
            $table->date('destroy_date')->nullable();
            $table->integer('destroy_by')->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('destroyitems');
    }
}
