<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\TipoActividad;
class TipoActividadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $currentDateTime = $faker->dateTimeBetween('-1 year', 'now');
            DB::table('tipo_actividades')->insert([
                'nombre' => "tipo actividad " . ($i + 1),
                'descripcion' => $faker->paragraph(10),
                'created_at' => $currentDateTime,
                'updated_at' => $faker->dateTimeBetween($currentDateTime, 'now'),
            ]);
        }
    }
}
