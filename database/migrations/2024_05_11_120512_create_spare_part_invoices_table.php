<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSparePartInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spare_part_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->enum('foc', ['yes', 'no'])->nullable();
            $table->unsignedBigInteger('service_center_id');
            $table->unsignedBigInteger('user_id');
            $table->double('total_amount')->nullable();
            $table->double('discount')->nullable();
            $table->double('tax_adjustment')->nullable();
            $table->enum('foc_status', ['NON-FOC', 'FOC Approval Pending', 'FOC Approved'])->nullable();
            $table->enum('status',['invoice issued','out for delivery', 'delivered'])->nullable();
            $table->string('courier_service')->nullable();
            $table->string('invoice_receipt')->nullable();
            $table->foreign('service_center_id')->references('id')->on('users');
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
        Schema::dropIfExists('spare_part_invoices');
    }
}
