<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMadeirasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Madeiras', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo_madeira')->nullable();
            $table->date('data_venda')->nullable();
            $table->string('valor_compra')->nullable();
            $table->string('quantida_compra')->nullable();
            $table->string('valor_venda')->nullable();
            $table->string('frete')->nullable();
            $table->string('icms')->nullable();
            $table->string('lucro')->nullable();
            $table->string('cliente')->nullable();
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
        Schema::dropIfExists('Madeiras');
    }
}
