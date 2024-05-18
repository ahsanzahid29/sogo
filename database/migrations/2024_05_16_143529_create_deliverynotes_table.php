<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliverynotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliverynotes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('dealer_id');
            $table->unsignedBigInteger('inverter_id');
            $table->integer('quantity')->default(0);
            $table->text('notes')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('dealer_id')->references('id')->on('users');
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
        Schema::dropIfExists('deliverynotes');
    }
}
