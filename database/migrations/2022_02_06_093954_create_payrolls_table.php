<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id');
            $table->date('month')->nullable();
            $table->string('basic_salary')->nullable();
            $table->string('paid_salary')->nullable();
            $table->date('paid_date')->nullable();
            $table->string('overtime')->nullable();
            $table->string('incentive')->nullable();
            $table->string('bonus')->nullable();
            $table->string('advance_salary')->nullable();
            $table->string('due')->nullable();
            $table->string('total_amount')->nullable();
            $table->string('remarks')->nullable();
            $table->enum('status', ['paid', 'due'])->nullable();
            $table->foreignId('create_by')->nullable();
            $table->foreignId('update_by')->nullable();
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
        Schema::dropIfExists('payrolls');
    }
}
