<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenTable extends Migration
{
    public function up()
    {
        Schema::create('orden', function (Blueprint $table) {
            $table->id('orden_id');
            $table->foreignId('usuario_id');
            $table->foreignId('surtidor_id')->nullable();
            $table->enum('status', ['pendiente','en_proceso','surtida','cancelada','finalizada']);
            $table->foreignId('pago_id');
            $table->dateTime('fecha_creacion');
            $table->foreignId('direccion_envio_id');
            $table->timestamps();

            $table->foreign('usuario_id')
            ->on('usuarios')
            ->references('usuario_id');

            $table->foreign('surtidor_id')
            ->on('usuarios')
            ->references('usuario_id');

            $table->foreign('pago_id')
            ->on('pagos')
            ->references('pago_id');

            $table->foreign('direccion_envio_id')
            ->on('direcciones')
            ->references('direccion_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orden');
    }
}
