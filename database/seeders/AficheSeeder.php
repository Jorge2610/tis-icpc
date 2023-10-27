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

        for ($i = 0; $i < 100; $i++) {
            $currentDateTime = now();
            DB::table('afiches')->insert([
                'ruta_afiche' => $faker->imageUrl(),
                'id_evento' => $faker->numberBetween(1, 50),
                'created_at' => $currentDateTime,
                'updated_at' => $currentDateTime
            ]);
        }
    }
}
