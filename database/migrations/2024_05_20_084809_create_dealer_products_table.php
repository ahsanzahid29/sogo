<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealerProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dealer_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dealer_id');
            $table->unsignedBigInteger('inverter_id');
            $table->unsignedBigInteger('deliverynote_id');
            $table->string('serial_number')->nullable();
            $table->foreign('dealer_id')->references('id')->on('users');
            $table->foreign('inverter_id')->references('id')->on('inverters');
            $table->foreign('deliverynote_id')->references('id')->on('deliverynotes');
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
        Schema::dropIfExists('dealer_products');
    }
}
