<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class IncidenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
            for ($i=500; $i < 531; $i++) {
                $inicio = strtotime("2022-02-27");
                $fin = strtotime("2022-03-27");
            
                // Buscamos un número aleatorio entre esas dos fechas
                $milisegundosAleatorios = mt_rand($inicio, $fin);
                  \DB::table('incidences')->insert(
                        array(
                              'id'         => $i,
                              'id_device'     => 500,
                              'id_driver'  => 500,
                              'lon' =>rand(0,90),
                              'lat' =>rand(0,90),
                              'speed'=>rand(20,100),
                              'type'=>rand(0,2),
                              'proximity' => rand(0,20),
                              'created_at' => date('Y-m-d H:m:s',$milisegundosAleatorios),
                              'updated_at' => date('Y-m-d H:m:s',$milisegundosAleatorios)
                        )
                  );
            }
    }
}
