<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class TipoEvento extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            $currentDateTime = now();
            DB::table('tipo_eventos')->insert([
                'nombre' => "tipo evento " . ($i+1),
                'descripcion' => $faker->paragraph(1),
                'color' => $faker->hexColor(),
                'created_at' => $currentDateTime,
                'updated_at' => $currentDateTime
            ]);
        }
    }
}
