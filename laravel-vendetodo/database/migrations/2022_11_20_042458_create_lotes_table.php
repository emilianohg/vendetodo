<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLotesTable extends Migration
{
    public function up()
    {
        Schema::create('lotes', function (Blueprint $table) {
            $table->id('lote_id');
            $table->foreignId('producto_id');
            $table->foreignId('proveedor_id');
            $table->integer('cantidad');
            $table->dateTime('fecha');
            $table->timestamps();

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
        Schema::dropIfExists('lotes');
    }
}
