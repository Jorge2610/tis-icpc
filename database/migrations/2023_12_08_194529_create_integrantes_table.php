<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntegrantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('integrantes', function (Blueprint $table) {
            $table->id();
            $table->string('institucion', 64)->nullable();
            $table->string('grado_academico', 64)->nullable();
            $table->string('genero', 64)->nullable();
            $table->string('talla', 10)->nullable();
            $table->foreignId('id_participante')->constrained('participantes')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('id_equipo')->constrained('equipos')->restrictOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('integrantes');
    }
}
