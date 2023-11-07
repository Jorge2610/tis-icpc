<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PatrocinadorSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 200; $i++) {
            $currentDateTime = $faker->dateTimeBetween('-1 year', 'now');
            DB::table('patrocinadores')->insert([
                'nombre' => $faker->name(),
                'ruta_imagen' => $faker->imageUrl(),
                'enlace_web' => $faker->url(),
                'id_evento' => $faker->numberBetween(1, 100),
                'created_at' => $currentDateTime,
                'updated_at' => $faker->dateTimeBetween($currentDateTime, 'now'),
            ]);
        }
    }
}
