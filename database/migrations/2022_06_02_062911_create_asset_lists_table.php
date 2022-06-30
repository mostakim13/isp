<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_lists', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->foreignId('payment_method_id')->nullable();
            $table->foreignId('account_id')->nullable();
            $table->foreignId('company_id');
            $table->foreignId('category_asset_id')->nullable();
            $table->date('_date')->nullable();
            $table->integer('qty')->nullable();
            $table->integer('amount')->nullable();
            $table->string('status')->default(true)->nullable();
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
        Schema::dropIfExists('asset_lists');
    }
}
