<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class DriverSeeder extends Seeder
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
                  \DB::table('drivers')->insert(
                        array(
                              'id'      => $i,
                              'id_user'     => $i,
                              'id_device'  => $i,
                              'created_at' => date('Y-m-d H:m:s',$milisegundosAleatorios),
                              'updated_at' => date('Y-m-d H:m:s',$milisegundosAleatorios)
                        )
                  );
            }
    }
}