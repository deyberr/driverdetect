<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class SpeedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=500; $i < 550; $i++) {
            
            DB::table('speeds')->insert(
                array(
                      'id'         => $i,
                      'id_device'     => 500,
                       'value'=>$i,
                      'created_at' => date('Y-m-d H:m:s'),
                      'updated_at' => date('Y-m-d H:m:s')
                )
            );
        }
    }
}
