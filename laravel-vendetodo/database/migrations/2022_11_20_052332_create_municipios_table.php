<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMunicipiosTable extends Migration
{
    public function up()
    {
        Schema::create('municipios', function (Blueprint $table) {
            $table->id('municipio_id');
            $table->string('nombre');
            $table->foreignId('estado_id');

            $table->foreign('estado_id')
            ->on('estados')
            ->references('estado_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('municipios');
    }
}
