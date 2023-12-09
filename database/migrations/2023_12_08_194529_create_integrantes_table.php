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
            $table->integer('ci');
            $table->string('nombres', 64);
            $table->string('apellidos', 64);
            $table->string('correo', 64);
            $table->string('celular', 64);
            $table->date('fecha_nacimiento');
            $table->string('institucion', 64)->nullable();
            $table->string('grado_academico', 64)->nullable();
            $table->string('genero', 64)->nullable();
            $table->string('talla', 10)->nullable();
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
