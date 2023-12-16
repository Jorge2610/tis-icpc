<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInscritosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inscritos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_evento')->constrained('eventos')->onDelete('cascade');
            $table->foreignId('id_participante')->constrained('participantes')->onDelete('cascade');
            $table->string('institucion', 64)->nullable();
            $table->string('grado_academico', 64)->nullable();
            $table->string('genero', 64)->nullable();
            $table->string('talla', 10)->nullable();
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
        Schema::dropIfExists('inscritos');
    }
}
