<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Gado', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cliente')->nullable();
            $table->dateTime('data_venda')->nullable();
            $table->string('valor_venda')->nullable();
            $table->string('comissao')->nullable();
            $table->string('valor_frete')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Gado');
    }
}
