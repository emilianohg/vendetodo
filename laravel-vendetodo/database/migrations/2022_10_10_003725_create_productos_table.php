<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion');
            $table->decimal('precio');
            $table->foreignId('marca_id');
            $table->decimal('largo');
            $table->decimal('ancho');
            $table->decimal('alto');
            $table->string('imagen_url')->nullable();
            $table->timestamps();
            
            $table->foreign('marca_id')
                ->on('marcas')
                ->references('id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
