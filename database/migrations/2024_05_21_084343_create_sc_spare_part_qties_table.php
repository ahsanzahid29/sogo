<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScSparePartQtiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sc_spare_part_qties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sparepart_id');
            $table->unsignedBigInteger('service_center_id');
            $table->integer('quantity')->default(0);
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
        Schema::dropIfExists('sc_spare_part_qties');
    }
}
