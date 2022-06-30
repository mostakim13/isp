<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employe_id');
            $table->foreignId('user_id');
            $table->string('date_')->nullable();
            $table->float('amount')->default('0')->nullable();
            $table->float('due')->nullable();
            $table->longText('reason')->nullable();
            $table->foreignId('create_by')->nullable();
            $table->foreignId('update_by')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('salaries');
    }
}
