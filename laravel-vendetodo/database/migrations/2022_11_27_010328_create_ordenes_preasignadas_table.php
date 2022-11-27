<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenesPreasignadasTable extends Migration
{
    public function up()
    {
        Schema::create('ordenes_preasignadas', function (Blueprint $table) {
            $table->foreignId('orden_id');
            $table->foreignId('surtidor_id');
            $table->foreignId('intento');
            $table->dateTime('fecha');
            $table->enum('status', ['pendiente', 'aceptada', 'rechazada']);

            $table->primary(['orden_id', 'surtidor_id', 'intento']);

            $table->foreign('orden_id')
              ->on('orden')
              ->references('orden_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ordenes_preasignadas');
    }
}
