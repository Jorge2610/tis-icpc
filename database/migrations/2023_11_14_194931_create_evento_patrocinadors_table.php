<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventoPatrocinadorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evento_patrocinadores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_evento')->constrained('eventos')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('id_patrocinador')->constrained('patrocinadores')->restrictOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('evento_patrocinadores');
    }
}
