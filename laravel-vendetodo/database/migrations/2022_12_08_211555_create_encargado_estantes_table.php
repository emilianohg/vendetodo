<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEncargadoEstantesTable extends Migration
{
    public function up()
    {
        Schema::create('encargados_estantes', function (Blueprint $table) {
            $table->unsignedInteger('estante_id');
            $table->foreignId('usuario_id');

            $table->foreign('estante_id')
                ->on('almacen')
                ->references('estante_id');

            $table->foreign('usuario_id')
                ->on('usuarios')
                ->references('usuario_id');

            $table->primary(['estante_id', 'usuario_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('encargado_estantes');
    }
}
