<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 64)->unique();
            $table->text('descripcion', 2048)->nullable();
            $table->dateTime('inicio_inscripcion')->format('d-m-Y')->nullable();
            $table->dateTime('fin_inscripcion')->format('d-m-Y')->nullable();
            $table->dateTime('inicio_evento')->format('d-m-Y');
            $table->dateTime('fin_evento')->format('d-m-Y');
            $table->string('institucion')->nullable();
            $table->string('region', 64)->nullable();
            $table->string('grado_academico', 64)->default('Ninguno');
            $table->string('evento_equipos', 5)->nullable();
            $table->string('requiere_registro', 5)->nullable();
            $table->integer('edad_minima')->nullable();
            $table->integer('edad_maxima')->nullable();
            $table->string('genero', 10)->nullable();
            $table->decimal('precio_inscripcion')->nullable();
            $table->foreignId('id_tipo_evento')->constrained('tipo_eventos')->restrictOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('eventos');
    }
}
