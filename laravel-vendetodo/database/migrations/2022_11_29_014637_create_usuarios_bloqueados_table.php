<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosBloqueadosTable extends Migration
{

    public function up()
    {
        Schema::create('usuarios_bloqueados', function (Blueprint $table) {
            $table->id('usuario_id');
            $table->dateTime('fecha')->nullable();

            $table->foreign('usuario_id')
              ->on('usuarios')
              ->references('usuario_id');
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('usuarios_bloqueados');
    }
}
