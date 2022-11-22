<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurtidoresTable extends Migration
{
    public function up()
    {
        Schema::create('surtidores', function (Blueprint $table) {
            $table->id('surtidor_id');
            $table->unsignedInteger('estante_id');
            $table->timestamps();

            $table->foreign('surtidor_id')
            ->on('usuarios')
            ->references('usuario_id');

            $table->foreign('estante_id')
            ->on('almacen')
            ->references('estante_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('surtidores');
    }
}
