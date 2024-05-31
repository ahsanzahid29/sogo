<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepairTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repair_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('inverter_id');
            $table->unsignedBigInteger('service_center_id');
            $table->unsignedBigInteger('dealer_id');
            $table->string('serial_number')->nullable();
            $table->text('fault_detail')->nullable();
            $table->string('fault_video')->nullable();
            $table->enum('status', ['pending', 'completed','cancelled']);
            $table->enum('is_request', ['yes', 'no'])->default('no');
            $table->text('explain_more')->nullable();
            $table->date('repair_request_date')->nullable();
            $table->date('repair_complete_date')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('inverter_id')->references('id')->on('inverters');
            $table->foreign('service_center_id')->references('id')->on('users');
            $table->foreign('dealer_id')->references('id')->on('users');
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
        Schema::dropIfExists('repair_tickets');
    }
}
