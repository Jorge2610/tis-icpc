<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class AficheSeeder extends Seeder
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
            $fecha = $faker->dateTimeBetween('-1 year', 'now');
            $updatedFecha = $faker->dateTimeBetween($fecha, 'now');
            DB::table('afiches')->insert([
                'ruta_imagen' => $faker->imageUrl(),
                'id_evento' => $faker->numberBetween(1, 100),
                'created_at' => $fecha,
                'updated_at' => $updatedFecha,
            ]);
        }
    }
}
