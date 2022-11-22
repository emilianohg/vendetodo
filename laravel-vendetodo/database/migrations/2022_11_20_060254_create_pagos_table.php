<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagosTable extends Migration
{
    public function up()
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id('pago_id');
            $table->foreignId('metodo_pago_id');
            $table->string('referencia');
            $table->dateTime('fecha');
            $table->timestamps();

            $table->foreign('metodo_pago_id')
            ->on('metodos_pago')
            ->references('metodo_pago_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pagos');
    }
}
