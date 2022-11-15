<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variables', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('id_device');
            $table->foreign('id_device')->references('id')->on('devices')->onDelete('cascade');
            $table->unsignedInteger('id_driver');
            $table->foreign('id_driver')->references('id')->on('drivers')->onDelete('cascade');
            $table->string('lon',200)->nullable();
            $table->string('lat',200)->nullable();
            $table->integer('speed')->nullable();
            $table->integer('proximity')->nullable();
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
        Schema::dropIfExists('variables');
    }
}
