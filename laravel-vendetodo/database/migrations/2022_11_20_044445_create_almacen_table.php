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
            $table->foreignId('producto_id')->nullable();
            $table->primary(['estante_id','seccion_id']);

            $table->foreign('producto_id')
            ->on('productos')
            ->references('producto_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('almacen');
    }
}
