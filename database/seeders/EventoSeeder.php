<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class EventoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 50; $i++) {
            $currentDateTime = now();
            DB::table('eventos')->insert([
                'nombre' => "evento " . ($i + 1),
                'descripcion' => $faker->paragraph(6),
                'inicio_inscripcion' => $faker->date(),
                'fin_inscripcion' => $faker->date(),
                'inicio_evento' => $faker->dateTime(),
                'fin_evento' => $faker->dateTime(),
                'institucion' => $faker->company(),
                'region' => $faker->city(),
                'grado_academico' => $faker->randomElement(['ninguno', 'primaria', 'secundaria', 'universidad', 'postgrado', 'doctorado']),
                'evento_equipos' => $faker->randomElement(['on', '']),
                'requiere_registro' => $faker->randomElement(['on', '']),
                'edad_minima' => $faker->numberBetween(1, 100),
                'edad_maxima' => $faker->numberBetween(1, 100),
                'genero' => $faker->randomElement(['Femenino', 'Masculino', '']),
                'precio_inscripcion' => $faker->numberBetween(10, 100),
                'id_tipo_evento' => $faker->numberBetween(1, 10),
                'created_at' => $currentDateTime,
                'updated_at' => $currentDateTime
            ]);
        }
    }
}
