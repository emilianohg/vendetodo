<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurtidoresTable extends Migration
{
    public function up()
    {
        Schema::create('surtidores', function (Blueprint $table) {
            //$table->foreignId('surtidor_id');
            $table->id('surtidor_id');
            $table->foreignId('estante_id');
            //$table->primary(['surtidor_id']);
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
