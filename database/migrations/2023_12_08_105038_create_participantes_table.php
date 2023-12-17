<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participantes', function (Blueprint $table) {
            $table->id();
            $table->integer('ci');
            $table->string('nombres', 64);
            $table->string('apellidos', 64);
            $table->string('correo', 64);
            $table->string('codigo_telefono', 10);
            $table->string('telefono', 64);
            $table->date('fecha_nacimiento');
            $table->string('pais', 64)->nullable();
            $table->boolean('correo_confirmado')->default(0);
            $table->boolean('codigo')->nullable();
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
        Schema::dropIfExists('participantes');
    }
}
