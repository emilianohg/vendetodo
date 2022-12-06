<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRutasTable extends Migration
{
    public function up()
    {
        Schema::create('rutas', function (Blueprint $table) {
            $table->unsignedBigInteger('orden_id');
            $table->integer('orden');
            $table->unsignedInteger('estante_id')->nullable();
            $table->unsignedInteger('seccion_id')->nullable();
            $table->foreignId('lote_id');
            $table->tinyInteger('esta_en_bodega')->default(0);
            $table->dateTime('fecha_recogido')->nullable();
            $table->primary(['orden_id','orden']);

            $table->foreign('orden_id')
            ->on('ordenes')
            ->references('orden_id');

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
