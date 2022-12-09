<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallesReportesOrdenEstantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles_reportes_orden_estantes', function (Blueprint $table) {
            $table->uuid('reporte_uuid');
            $table->uuid('reporte_detalle_uuid');
            $table->unsignedInteger('estante_id');
            $table->unsignedInteger('seccion_id');
            $table->foreignId('lote_id');
            $table->tinyInteger('esta_en_almacen');
            $table->unsignedInteger('estante_origen_id');
            $table->unsignedInteger('seccion_origen_id');
            $table->integer('cantidad');
            $table->primary(['reporte_uuid', 'reporte_detalle_uuid'], 'pk_reporte_detalle');
            
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalles_reportes_orden_estantes');
    }
}
