<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */


    public function run()
    {
        $faker = Faker::create();
            for ($i=500; $i < 505; $i++) {
                $inicio = strtotime("2022-02-27");
                $fin = strtotime("2022-03-27");
            
                // Buscamos un número aleatorio entre esas dos fechas
                $milisegundosAleatorios = mt_rand($inicio, $fin);
                  \DB::table('devices')->insert(
                        array(
                              'id'      => $i,
                              'key'     => $faker->unique()->randomNumber,
                              'status'  => rand(0,2),
                              'displacement' =>rand(0,100),
                              'type_brake' =>rand(0,3),
                              'reference'=>$faker->firstName("male"),
                              'licence_plate'=>rand(0,8),
                              'model' => rand(0,5),
                              'created_at' => date('Y-m-d H:m:s',$milisegundosAleatorios),
                              'updated_at' => date('Y-m-d H:m:s',$milisegundosAleatorios)
                        )
                  );
            }
    }
}
