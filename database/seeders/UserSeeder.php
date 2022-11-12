<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
            for ($i=500; $i < 510; $i++) {
                  \DB::table('users')->insert(
                        array(
                              'id'         => $i,
                              'name'     => $faker->firstName("male"),
                              'last_name'  => $faker->lastName,
                              'email' =>$faker->unique()->safeEmail,
                              'email_verified_at' =>now(),
                              'password'=>bcrypt('12345678'),
                              'avatar' =>'./images/default/photo-user-default.jpeg',
                              'role' => 'admin',
                              'status'=>'0',
                              'type_id'=>'1',
                              'id_user'=>$faker->unique()->randomNumber,
                              'gender'=>'m',
                              'city'=>'pasto',
                              'date_of_birth' =>date('Y-m-d H:m:s'),
                              'created_at' => date('Y-m-d H:m:s'),
                              'updated_at' => date('Y-m-d H:m:s')
                        )
                  );
            }
    }
}
