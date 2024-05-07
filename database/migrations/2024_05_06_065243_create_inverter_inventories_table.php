<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInverterInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inverter_inventories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('inverter_id');
            $table->string('model_number')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('unique_sku')->nullable();
            $table->string('order_number')->nullable();
            $table->string('container')->nullable();
            $table->date('date_of_receipt')->nullable();
            $table->date('date_of_entry')->nullable();
            $table->string('csv_key')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('inverter_id')->references('id')->on('inverters');
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
        Schema::dropIfExists('inverter_inventories');
    }
}
