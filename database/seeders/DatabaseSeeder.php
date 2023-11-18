<?php

namespace Database\Seeders;

use App\Models\Afiche;
use App\Models\Patrocinador;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            TipoEvento::class,
            EventoSeeder::class,
            AficheSeeder::class,
            PatrocinadorSeed::class,
            SitioSeed::class
        ]);
    }
}
