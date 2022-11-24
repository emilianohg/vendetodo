<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstadosTable extends Migration
{
    public function up()
    {
        Schema::create('estados', function (Blueprint $table) {
            $table->id('estado_id');
            $table->string('nombre');
        });
    }

    public function down()
    {
        Schema::dropIfExists('estados');
    }
}
