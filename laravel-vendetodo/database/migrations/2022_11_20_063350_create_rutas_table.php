<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRutasTable extends Migration
{
    public function up()
    {
        Schema::create('rutas', function (Blueprint $table) {
            $table->id('orden_id');
            $table->integer('orden');
            $table->foreignId('estante_id')->nullable()->default(null);
            $table->foreignId('seccion_id')->nullable()->default(null);
            $table->foreignId('lote_id');
            $table->tinyInteger('esta_en_bodega')->default(0);
            $table->dateTime('fecha_recogido')->nullable()->default(null);
            $table->primary('orden_id','orden');
            $table->timestamps();

            $table->foreign('orden_id')
            ->on('orden')
            ->references('orden_id');

            $table->foreign('estante_id')
            ->on('almacen')
            ->references('estante_id');

            $table->foreign('seccion_id')
            ->on('almacen')
            ->references('seccion_id');

            $table->foreign('lote_id')
            ->on('lotes')
            ->references('lote_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('rutas');
    }

}
