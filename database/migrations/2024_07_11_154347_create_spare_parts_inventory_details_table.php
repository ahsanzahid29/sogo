<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSparePartsInventoryDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spare_parts_inventory_details', function (Blueprint $table) {
            $table->id();
            $table->string('principle_invoice_no')->nullable();
            $table->date('principle_invoice_date')->nullable();
            $table->string('grn')->nullable();
            $table->date('receiving_invoice_date')->nullable();
            $table->text('remarks')->nullable();
            $table->enum('status', ['pending', 'completed']);
            $table->unsignedBigInteger('user_id');
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
        Schema::dropIfExists('spare_parts_inventory_details');
    }
}
