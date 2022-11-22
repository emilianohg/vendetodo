<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlmacenTable extends Migration
{
    public function up()
    {
        Schema::create('almacen', function (Blueprint $table) {
            $table->unsignedInteger('estante_id');
            $table->unsignedInteger('seccion_id');
            $table->foreignId('lote_id');
            $table->integer('cantidad');
            $table->integer('cantidad_disponible');
            $table->enum('status', ['libre','recolectando','ordenando'])->default('libre');
            $table->primary(['estante_id','seccion_id','lote_id']);
            $table->timestamps();

            $table->foreign('lote_id')
            ->on('lotes')
            ->references('lote_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('almacen');
    }
}
