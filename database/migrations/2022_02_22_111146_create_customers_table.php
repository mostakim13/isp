<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('mid', 30)->nullable()->unique();
            $table->text('name')->nullable();
            $table->string('username')->nullable()->unique();
            $table->string('advanced_payment')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('spouse_name')->nullable();
            $table->string('nid')->nullable();
            $table->string('passport')->nullable();
            $table->string('dob')->nullable();
            $table->string('email', 30)->nullable()->unique();
            $table->string('reference')->nullable();
            $table->string('district')->nullable();
            $table->string('upazila')->nullable();
            $table->foreignId('zone_id')->nullable();
            $table->foreignId('subzone_id')->nullable();
            $table->foreignId('tj_id')->nullable();
            $table->foreignId('tj_core_id')->nullable();
            $table->foreignId('splitter_id')->nullable();
            $table->foreignId('splitter_core_id')->nullable();
            $table->foreignId('box_id')->nullable();
            $table->foreignId('box_core_id')->nullable();
            $table->text('comment')->nullable();
            $table->foreignId('m_p_p_p_profile')->nullable(); //
            $table->foreignId('package_id')->nullable(); //
            $table->string('password')->nullable();
            $table->string('m_password')->nullable();
            $table->string('secreat')->nullable();
            $table->string('phone')->nullable();
            $table->foreignId('billing_person')->nullable()->comment('Person who collect the bill that person user id');
            $table->string('doc_image')->nullable();
            $table->string('mac_address')->nullable();
            $table->string('remote_address')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('address')->nullable();
            $table->string('bill_amount')->default(0)->nullable();
            $table->string('connection_date')->nullable();
            $table->enum('billing_type', ['month_to_month', 'day_to_day'])->nullable();
            $table->string('connectby')->nullable();
            $table->string('duration')->nullable()->default(1);
            $table->string('start_date')->nullable();
            $table->date('exp_date')->nullable();
            $table->string('total_paid')->default(0)->nullable();
            $table->string('due')->default(0)->nullable();
            $table->foreignId('group_id')->nullable()->constrained('groups')->onDelete('cascade');
            $table->string('service')->nullable()->comment('pppoe');
            $table->string('caller')->nullable(); //
            $table->string('routes')->nullable(); //
            $table->string('limit')->nullable();
            $table->string('limit_bytes_in')->nullable();
            $table->string('limit_bytes_out')->nullable();
            $table->string('last_logged_out')->nullable();
            $table->string('speed')->nullable();
            $table->foreignId('server_id')->nullable();

            $table->foreignId('protocol_type_id')->nullable();
            $table->foreignId('client_type_id')->nullable();
            $table->foreignId('connection_type_id')->nullable();
            $table->foreignId('billing_status_id')->nullable();
            $table->foreignId('device_id')->nullable();
            $table->string('bill_collection_date')->default(0)->nullable();
            $table->foreignId('company_id');

            $table->string('queue_name')->nullable();
            $table->string('queue_target')->nullable();
            $table->string('queue_dst')->nullable();
            $table->string('queue_max_upload')->nullable();
            $table->string('queue_max_download')->nullable();
            $table->string('queue_disabled')->nullable();
            $table->string('queue_mid')->nullable();

            $table->enum('status', ['pending', 'active', 'disabled'])->nullable();
            $table->string('disabled')->nullable();
            $table->enum('is_notify', ['yes', 'no'])->nullable();
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
        Schema::dropIfExists('customers');
    }
}
