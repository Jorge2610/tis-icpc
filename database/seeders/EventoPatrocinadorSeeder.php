<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventoPatrocinadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 200; $i++) {
            $currentDateTime = $faker->dateTimeBetween('-1 year', 'now');
            DB::table('evento_patrocinadores')->insert([
                'id_evento' => $faker->numberBetween(1, 100),
                'id_patrocinador' => $faker->numberBetween(1, 200),
                'created_at' => $currentDateTime,
                'updated_at' => $faker->dateTimeBetween($currentDateTime, 'now'),
            ]);
        }
    }
}
