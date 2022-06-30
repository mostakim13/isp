<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->string('name')->nullable();
            $table->string('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('personal_phone')->nullable();
            $table->string('office_phone')->nullable();
            $table->enum('marital_status', ['married', 'unmarried'])->nullable();
            $table->string('nid')->nullable();
            $table->string('email')->nullable();
            $table->string('reference')->nullable();
            $table->longText('experience')->nullable();
            $table->longText('present_address')->nullable();
            $table->longText('permanent_address')->nullable();

            $table->foreignId('department_id')->nullable();
            $table->foreignId('designation_id')->nullable();

            $table->longText('achieved_degree')->nullable();
            $table->longText('institution')->nullable();
            $table->text('passing_year')->nullable();

            $table->float('salary')->nullable();
            $table->string('join_date')->nullable();
            $table->enum('status', ['active', 'left'])->nullable();
            $table->string('image')->nullable();
            $table->string('is_login')->default(false);
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
        Schema::dropIfExists('employees');
    }
}
