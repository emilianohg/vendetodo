<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleOrdenTable extends Migration
{
    public function up()
    {
        Schema::create('detalle_orden', function (Blueprint $table) {
            $table->foreignId('orden_id');
            $table->foreignId('producto_id');
            $table->foreignId('proveedor_id');
            $table->integer('cantidad');
            $table->decimal('precio',10,2);
            $table->primary(['orden_id','producto_id','proveedor_id']);

            $table->foreign('orden_id')
            ->on('orden')
            ->references('orden_id');

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
        Schema::dropIfExists('detalle_orden');
    }
}
