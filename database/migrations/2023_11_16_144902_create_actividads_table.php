<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActividadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actividades', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 64);
            $table->dateTime('inicio_actividad')->format('d-m-Y');
            $table->dateTime('fin_actividad')->format('d-m-Y');
            $table->text('descripcion', 1000)->nullable();
            $table->integer('inscripcion')->nullable();
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
        Schema::dropIfExists('actividades');
    }
}
