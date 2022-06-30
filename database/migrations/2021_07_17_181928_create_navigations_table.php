<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNavigationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('navigations', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->unsigned();
            $table->string('label')->nullable();
            $table->string('route')->nullable();
            $table->tinyInteger('navigate_status')->nullable();
            $table->string('icon')->nullable();
            $table->string('object_class')->nullable();
            $table->string('extra_attribute')->nullable();
            $table->integer('active')->nullable();
            $table->integer('orderBy')->nullable();
            $table->index(['parent_id']);
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
        Schema::dropIfExists('navigations');
    }
}
