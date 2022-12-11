<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportesOrdenEstantesTable extends Migration
{
  public function up()
  {
    Schema::create('reportes_orden_estantes', function (Blueprint $table) {
      $table->uuid('reporte_uuid');
      $table->dateTime('fecha');
      $table->unsignedInteger('estante_id');
      $table->boolean('comenzado')->default(false);
      $table->foreign('estante_id')
        ->on('almacen')
        ->references('estante_id');
    });
  }

  public function down()
  {
    Schema::dropIfExists('reportes_orden_estantes');
  }
}
