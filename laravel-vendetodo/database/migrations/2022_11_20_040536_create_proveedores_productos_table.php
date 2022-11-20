<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProveedoresProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedores_productos', function (Blueprint $table) {
            //$table->id('proveedor_id');
            //$table->id('producto_id')
            $table->foreignId('proveedor_id');
            $table->foreignId('producto_id');
            $table->integer('cantidad');
            $table->primary(['proveedor_id', 'producto_id']);
            $table->timestamps();

            /*dejar nada mas id('proveedor_id') y id('producto_id')
            en lugar de foreignId('proveedor_id') y foreignId('producto_id')
            y se referencia solo con foreign on reference?*/
            //quitar primary si hacemos lo del comentario anterior??

            $table->foreign('proveedor_id')
            ->on('proveedores')
            ->references('proveedor_id');

            $table->foreign('producto_id')
            ->on('productos')
            ->references('producto_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proveedores_productos');
    }
}
