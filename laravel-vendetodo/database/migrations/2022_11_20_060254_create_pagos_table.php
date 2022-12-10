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
            $table->string('referencia')->index();
            $table->foreignId('usuario_id');
            $table->decimal('importe');
            $table->enum('status', ['pendiente', 'pagado', 'cancelado'])->default('pendiente');
            $table->dateTime('fecha_solicitud');
            $table->dateTime('fecha_pago')->nullable();

            $table->foreign('usuario_id')
                ->on('usuarios')
                ->references('usuario_id');

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
