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
            $table->dateTime('inicio_evento')->format('d-m-Y');
            $table->dateTime('fin_evento')->format('d-m-Y');
            $table->string('institucion')->nullable();
            $table->string('region', 64)->nullable();
            $table->string('grado_academico')->nullable();
            $table->integer('equipo_minimo')->nullable();
            $table->integer('equipo_maximo')->nullable();
            $table->string('talla', 5)->nullable();
            $table->integer('edad_minima')->nullable();
            $table->integer('edad_maxima')->nullable();
            $table->string('genero', 10)->nullable();
            $table->decimal('precio_inscripcion')->nullable();
            $table->tinyInteger('estado')->nullable()->default(0);
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
