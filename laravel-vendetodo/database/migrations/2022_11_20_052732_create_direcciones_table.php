<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDireccionesTable extends Migration
{
    public function up()
    {
        Schema::create('direcciones', function (Blueprint $table) {
            $table->id('direccion_id');
            $table->string('colonia');
            $table->string('calle');
            $table->string('numero_ext',10);
            $table->string('codigo_postal',5);
            $table->foreignId('usuario_id');
            $table->foreignId('municipio_id');
            $table->enum('status',['activa','eliminada','envio']);

            $table->foreign('usuario_id')
            ->on('usuarios')
            ->references('usuario_id');

            $table->foreign('municipio_id')
            ->on('municipios')
            ->references('municipio_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('direcciones');
    }
}
