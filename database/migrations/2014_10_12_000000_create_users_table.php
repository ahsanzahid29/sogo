<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->unsignedBigInteger('role_id');
            $table->string('profile_pic')->nullable();
            $table->string('phoneno_1')->nullable();
            $table->string('phoneno_2')->nullable();
            $table->text('address')->nullable();
            $table->text('billing_address')->nullable();
            $table->text('shipping_address')->nullable();
            $table->string('working_hours')->nullable();
            $table->string('monday_timing')->nullable();
            $table->string('tuesday_timing')->nullable();
            $table->string('wednesday_timing')->nullable();
            $table->string('thursday_timing')->nullable();
            $table->string('friday_timing')->nullable();
            $table->string('saturday_timing')->nullable();
            $table->string('sunday_timing')->nullable();
            $table->enum('status', ['active', 'inactive','deleted']);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
