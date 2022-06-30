<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('item_id');
            $table->string('name');
            $table->foreignId('category_id')->nullable();
            $table->foreignId('income_account_id')->nullable();
            $table->foreignId('expense_account_id')->nullable();
            $table->string('unit')->nullable();
            $table->enum('status', ['active', 'inactive']);
            $table->string('vat')->nullable();
            $table->string('description')->nullable();
            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();
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
        Schema::dropIfExists('items');
    }
}
