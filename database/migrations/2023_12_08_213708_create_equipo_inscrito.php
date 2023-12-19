<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipoInscrito extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipo_inscritos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_equipo')->constrained('equipos')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('id_evento')->constrained('eventos')->restrictOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipo_inscritos');
    }
}
