<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSparePartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spare_parts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name')->nullable();
            $table->string('factory_code')->nullable();
            $table->string('part_type')->nullable();
            $table->string('voltage_rating')->nullable();
            $table->string('ampeare_rating')->nullable();
            $table->string('sale_price')->nullable();
            $table->string('base_unit')->nullable();
            $table->string('pieces')->nullable();
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
        Schema::dropIfExists('spare_parts');
    }
}
