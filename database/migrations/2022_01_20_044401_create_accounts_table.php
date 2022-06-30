<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->longText('account_details')->nullable();
            $table->string('head_code')->nullable();
            $table->string('account_name', 120)->nullable();
            $table->foreignId('parent_id')->nullable();
            $table->boolean('is_transaction')->default(0)->nullable();
            $table->foreignId('company_id');
            $table->float('amount', 10, 2)->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active')->comment('default status set active');
            $table->integer('updated_by')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('deleted_by')->nullable();
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
        Schema::dropIfExists('accounts');
    }
}
