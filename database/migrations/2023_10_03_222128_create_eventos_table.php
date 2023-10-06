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
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->date('inicio_inscripcion')->format('d-m-Y');
            $table->date('fin_inscripcion')->format('d-m-Y');
            $table->date('inicio_evento')->format('d-m-Y');
            $table->date('fin_evento')->format('d-m-Y');
            $table->integer('limite_edad')->nullable();
            $table->tinyInteger('evento_pago')->default(0);
            $table->tinyInteger('competencia_general')->default(0);
            $table->tinyInteger('por_equipos')->default(0);
            $table->tinyInteger('requiere_registro')->default(0);
            $table->string('ruta_afiche')->default('/img/afiche.png');
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
