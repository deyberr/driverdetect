<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->integer('status')->default('0');//0.Reposo,1.Activo,2.Suspendido
            $table->integer('displacement')->nullable();//Cilindraje
            $table->string('type_brake',50)->nullable();//tipo freno
            $table->string('reference',50)->nullable();//Referencia de la moto, susuky best
            $table->string('licence_plate',50)->nullable();//Placa
            $table->integer('model')->nullable();//Modelo de la moto
            $table->string('url_script',250)->nullable();//script  arduino
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
        Schema::dropIfExists('devices');
    }
}
