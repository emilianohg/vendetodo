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
            $table->foreignId('proveedor_id');
            $table->foreignId('producto_id');
            $table->integer('cantidad_disponible'); 
            $table->primary(['proveedor_id', 'producto_id']);
            $table->timestamps();

            $table->foreign('proveedor_id')
            ->on('proveedores')
            ->references('proveedor_id');

            $table->foreign('producto_id')
            ->on('productos')
            ->references('producto_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('proveedores_productos');
    }
}
