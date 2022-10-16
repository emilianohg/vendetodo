<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyDescripcionToProductosTable extends Migration
{

    public function up()
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->text('descripcion')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->text('descripcion')->change();
        });
    }
}
