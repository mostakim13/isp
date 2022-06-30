<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewConnectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_connections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable();
            $table->foreignId('created_by')->nullable();
            $table->date('connected_at')->nullable();
            $table->foreignId('setup_by')->nullable();
            $table->float('otc', 10, 2)->nullable();
            $table->string('name')->nullable();
            $table->string('gender')->nullable();
            $table->string('occupation')->nullable();
            $table->date('dateofbirth')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('nid')->nullable();
            $table->string('registrationformno')->nullable();
            $table->text('remarks')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('nid_picture')->nullable();
            $table->string('registrationformpicture')->nullable();
            $table->string('mobilenumber')->nullable();
            $table->string('phonenumber')->nullable();
            $table->string('emailaddress')->nullable();
            $table->string('facebookprofilelink')->nullable();
            $table->string('linkedinprofilelink')->nullable();
            $table->foreignId('district')->nullable();
            $table->foreignId('upazila')->nullable();
            $table->string('roadnumber')->nullable();
            $table->string('housenumber')->nullable();
            $table->string('presentaddress')->nullable();
            $table->string('permanentaddress')->nullable();
            $table->foreignId('zone')->nullable();
            $table->foreignId('subzone')->nullable();
            $table->foreignId('connectiontype')->nullable();
            $table->foreignId('clienttype')->nullable();
            $table->foreignId('package_id')->nullable();
            $table->foreignId('billingstatus')->nullable();
            $table->string('monthlybill')->nullable();
            $table->date('commitedbilldate')->nullable();
            $table->string('referenceby')->nullable();
            $table->string('referralcontact')->nullable();
            $table->enum('is_approve', [0, 1])->default(0);
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
        Schema::dropIfExists('new_connections');
    }
}
