<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSparePartRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spare_part_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ticket_id');
            $table->unsignedBigInteger('sparepart_id');
            $table->unsignedBigInteger('service_center_id');
            $table->string('required_quantity')->default(0);
            $table->foreign('ticket_id')->references('id')->on(' repair_tickets');
            $table->foreign('sparepart_id')->references('id')->on('spare_parts');
            $table->foreign('service_center_id')->references('id')->on('users');





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
        Schema::dropIfExists('spare_part_requests');
    }
}
