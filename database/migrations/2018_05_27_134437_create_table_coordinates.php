<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCoordinates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coordinates', function (Blueprint $table) {
            // Create PRIMARY KEY id field
            $table->increments('id');
            // Create a foreign key pointing our coordinates to user record
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            // Create the fields that we need to store the coordinates from csv file.
            $table->decimal('latitude', 8, 5);
            $table->decimal('longitude', 8, 5);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coordinates');
    }
}
