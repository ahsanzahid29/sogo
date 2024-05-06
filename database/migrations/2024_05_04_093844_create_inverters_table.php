<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvertersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inverters', function (Blueprint $table) {
            $table->id();
            $table->string('inverter_name');
            $table->unsignedBigInteger('user_id');
            $table->string('inverter_packaging')->nullable();
            $table->string('no_of_pieces')->nullable();
            $table->string('brand')->nullable();
            $table->string('category')->nullable();
            $table->string('modal_number')->nullable();
            $table->string('product_warranty')->nullable();
            $table->string('service_warranty')->nullable();
            $table->string('warranty_lag')->nullable();
            $table->string('product_catalog')->nullable();
            $table->string('product_manual')->nullable();
            $table->string('troubleshoot_guide')->nullable();
            $table->string('inverter_image')->nullable();
            $table->integer('total_quantity')->default(0);
            $table->integer('sold_quantity')->default(0);
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('inverters');
    }
}
