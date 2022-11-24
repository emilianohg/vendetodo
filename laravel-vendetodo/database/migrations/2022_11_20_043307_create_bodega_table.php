<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBodegaTable extends Migration
{
    public function up()
    {
        Schema::create('bodega', function (Blueprint $table) {
            //$table->foreignId('lote_id');
            $table->id('lote_id');
            $table->integer('cantidad');
            $table->integer('cantidad_disponible');
            //$table->primary(['lote_id']);

            $table->foreign('lote_id')
            ->on('lotes')
            ->references('lote_id');
        });  
    }

    public function down()
    {
        Schema::dropIfExists('bodega');
    }
}
