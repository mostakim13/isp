<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id');
            $table->enum('priority', ['low', 'medium', 'high']);
            $table->string('complain_number')->nullable();
            $table->string('complain_time')->nullable();
            $table->foreignId('problem_category')->nullable();
            $table->string('attachments')->nullable();
            $table->enum('status', ['Pending', 'Processing', 'Solved']);
            $table->longText('note')->nullable();
            $table->foreignId('assign_to')->nullable();
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
        Schema::dropIfExists('support_tickets');
    }
}
