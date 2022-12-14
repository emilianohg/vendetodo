<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('usuario_id');
            $table->string('nombre');
            $table->string('email');
            $table->string('password');
            $table->foreignId('rol_id');
            $table->foreignId('metodo_pago_id')->nullable();
            $table->foreignId('direccion_id')->nullable();
            $table->timestamps();

            $table->index('email');

            $table->foreign('rol_id')
            ->on('roles')
            ->references('rol_id');
        });

    }

    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
