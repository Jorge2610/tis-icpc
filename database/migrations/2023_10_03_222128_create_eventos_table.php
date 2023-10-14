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
            $table->date('inicio_inscripcion')->format('d-m-Y');
            $table->date('fin_inscripcion')->format('d-m-Y');
            $table->date('inicio_evento')->format('d-m-Y');
            $table->date('fin_evento')->format('d-m-Y');
            $table->string('institucion')->nullable();
            $table->string('region',64)->nullable();
            $table->string('grado_academico',64)->default('Ninguno');
            $table->boolean('evento_pago')->default(false);
            $table->boolean('evento_equipos')->default(false);
            $table->boolean('requiere_registro')->default(false);
            $table->boolean('rango_edad')->default(false);
            $table->integer('edad_minima')->nullable();
            $table->integer('edad_maxima')->nullable();
            $table->boolean('evento_genero')->default(false);
            $table->enum('genero', ['Masculino', 'Femenino']);
            $table->boolean('evento_pago')->default(false);
            $table->decimal('costo')->nullable();
            $table->string('ruta_afiche',128)->default('/evento/afiche.jpg');
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
