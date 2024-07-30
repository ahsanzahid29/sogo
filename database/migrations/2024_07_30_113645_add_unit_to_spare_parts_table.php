<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUnitToSparePartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spare_parts', function (Blueprint $table) {

            $table->string('unit')->nullable(); // Adding the unit column

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('spare_parts', function (Blueprint $table) {

            $table->dropColumn('unit'); // Dropping the unit column if the migration is rolled back
        });
    }
}
