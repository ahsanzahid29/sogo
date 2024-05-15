<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSparePartInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spare_part_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id');
            $table->unsignedBigInteger('sparepart_id');
            $table->unsignedBigInteger('service_center_id');
            $table->integer('quantity')->default(0);
            $table->double('sale_price')->nullable();
            $table->double('item_tax')->nullable();
            $table->double('item_discount')->nullable();
            $table->double('item_total')->nullable();
            $table->integer('is_sold')->default(0);
            $table->foreign('invoice_id')->references('id')->on('spare_part_invoices');
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
        Schema::dropIfExists('spare_part_invoice_items');
    }
}
