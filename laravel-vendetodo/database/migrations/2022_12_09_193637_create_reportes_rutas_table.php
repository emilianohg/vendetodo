<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportesRutasTable extends Migration
{
    public function up()
    {
        Schema::create('reportes_rutas', function (Blueprint $table) {
            $table->id('orden_id');
            $table->dateTime('fecha');
            $table->text('camino');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reportes_rutas');
    }
}
