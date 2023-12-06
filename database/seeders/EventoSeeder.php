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

        for ($i = 0; $i < 100; $i++) {
            $currentDateTime = $faker->dateTimeBetween('-1 year', 'now');
            $rangoMin = $faker->numberBetween(1, 100);
            $rangoMinEquipo = $faker->numberBetween(1, 9);

            $created_at = $currentDateTime;
            $updated_at = $faker->dateTimeBetween($created_at, 'now');

            $mes = '+1 month';

            $inicio_inscripcion = $faker->dateTimeBetween($created_at, $mes);
            $fin_inscripcion = $faker->dateTimeBetween($inicio_inscripcion, $mes);
            $inicio_evento = $faker->dateTimeBetween($fin_inscripcion, $mes);
            $fin_evento = $faker->dateTimeBetween($inicio_evento, $mes);

            DB::table('eventos')->insert([
                'nombre' => "evento " . ($i + 1),
                'descripcion' => $faker->paragraph(10),
                'inicio_evento' => $inicio_evento,
                'fin_evento' => $fin_evento,
                'institucion' => $faker->company() . ' - ' . $faker->companySuffix(),
                'region' => $faker->city(),
                'grado_academico' => $faker->randomElement(['ninguno', 'primaria', 'secundaria', 'universidad', 'postgrado', 'doctorado']),
                'equipo_minimo' => $faker->boolean(30)? null : $rangoMinEquipo,
                'equipo_maximo' => $faker->numberBetween($rangoMinEquipo, 10),
                'requiere_registro' => $faker->randomElement(['on', '']),
                'edad_minima' => $faker->boolean(30) ? null : $rangoMin,
                'edad_maxima' => $faker->boolean(30) ? null : $faker->numberBetween($rangoMin, 70),
                'genero' => $faker->randomElement(['Femenino', 'Masculino', '']),
                'precio_inscripcion' =>$faker->boolean(50) ? 0 : $faker->numberBetween(10, 100),
                'estado' => $faker->boolean(80) ? 0 : $faker->numberBetween(1, 2),
                'id_tipo_evento' => $faker->numberBetween(1, 10),
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ]);
        }
    }
}
