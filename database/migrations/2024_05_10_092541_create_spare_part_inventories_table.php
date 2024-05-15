<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSparePartInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spare_part_inventories', function (Blueprint $table) {
            $table->id();
            $table->string('factory_code');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('sparepart_id');
            $table->date('repair_date')->nullable();
            $table->string('csv_key')->nullable();
            $table->string('order_number')->nullable();
            $table->string('serial_number')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('sparepart_id')->references('id')->on('spare_parts');
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
        Schema::dropIfExists('spare_part_inventories');
    }
}
