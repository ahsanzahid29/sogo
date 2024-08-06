<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToSparePartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spare_parts', function (Blueprint $table) {
            $table->enum('status', ['active', 'inactive'])->default('active')->after('sold_quantity');

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
            $table->dropColumn('status');

        });
    }
}
