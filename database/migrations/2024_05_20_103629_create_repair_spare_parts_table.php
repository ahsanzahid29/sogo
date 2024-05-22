<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepairSparePartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repair_spare_parts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('repair_id');
            $table->unsignedBigInteger('sparepart_id');
            $table->integer('current_stock')->default(0);
            $table->integer('stock_needed')->default(0);
            $table->text('any_comments')->nullable();
            $table->foreign('repair_id')->references('id')->on('repair_tickets');
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
        Schema::dropIfExists('repair_spare_parts');
    }
}
