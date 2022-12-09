<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallesReportesOrdenEstantesTable extends Migration
{
    public function up()
    {
        Schema::create('detalles_reportes_orden_estantes', function (Blueprint $table) {
            $table->uuid('reporte_uuid');
            $table->unsignedInteger('estante_id');
            $table->unsignedInteger('seccion_id');
            $table->foreignId('lote_id');
            $table->tinyInteger('esta_en_almacen');
            $table->unsignedInteger('estante_origen_id')->nullable();
            $table->unsignedInteger('seccion_origen_id')->nullable();
            $table->integer('cantidad');
            $table->primary(['reporte_uuid', 'estante_id', 'seccion_id', 'lote_id', 'esta_en_almacen'], 'pk_reporte_detalle');
            
            $table->foreign(['estante_id', 'seccion_id'])
            ->on('almacen')
            ->references(['estante_id', 'seccion_id']);

            $table->foreign('lote_id')
            ->on('lotes')
            ->references('lote_id');

            $table->foreign(['estante_origen_id', 'seccion_origen_id'], 'estXsec')
            ->on('almacen')
            ->references(['estante_id', 'seccion_id']);

        });
    }

    public function down()
    {
        Schema::dropIfExists('detalles_reportes_orden_estantes');
    }
}
