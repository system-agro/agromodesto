<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaminhaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Caminhao', function (Blueprint $table) {
            $table->increments('id');
            $table->string('placa')->nullable();
            $table->dateTime('data_frete')->nullable();
            $table->string('valor_combustivel')->nullable();
            $table->string('km_inicial')->nullable();
            $table->string('valor_frete')->nullable();
            $table->string('valor_manutencao')->nullable();
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
        Schema::dropIfExists('Caminhao');
    }
}
