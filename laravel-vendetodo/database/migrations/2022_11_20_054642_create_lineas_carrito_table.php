<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLineasCarritoTable extends Migration
{
    public function up()
    {
        Schema::create('lineas_carrito', function (Blueprint $table) {
            $table->id('linea_carrito_id');
            $table->foreignId('usuario_id');
            $table->foreignId('producto_id');
            $table->foreignId('proveedor_id')->nullable();
            $table->integer('cantidad'); 

            $table->foreign('usuario_id')
            ->on('usuarios')
            ->references('usuario_id');

            $table->foreign('producto_id')
            ->on('productos')
            ->references('producto_id');

            $table->foreign('proveedor_id')
            ->on('proveedores')
            ->references('proveedor_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('lineas_carrito');
    }
}
