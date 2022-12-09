<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportesOrdenEstantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reportes_orden_estantes', function (Blueprint $table) {
            $table->uuid('reporte_uuid');
            $table->dateTime('fecha');
            $table->unsignedInteger('estante_id');

            $table->foreign('estante_id')
            ->on('almacen')
            ->references('estante_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reportes_orden_estantes');
    }
}
