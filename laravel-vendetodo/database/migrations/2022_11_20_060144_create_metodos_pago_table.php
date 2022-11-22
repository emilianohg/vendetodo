<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetodosPagoTable extends Migration
{
    public function up()
    {
        Schema::create('metodos_pago', function (Blueprint $table) {
            $table->id('metodo_pago_id');
            $table->string('nombre');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('metodo_pago');
    }
}
