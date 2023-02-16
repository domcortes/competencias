<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_competencia');
            $table->bigInteger('id_usuario');
            $table->bigInteger('id_categoria');
            $table->boolean('status_pago')->default(false);
            $table->date('fecha_inscripcion');
            $table->date('fecha_pago')->nullable();
            $table->string('medio_pago')->nullable();
            $table->longText('payment_data')->nullable();
            $table->float('monto_pagado')->default(0);
            $table->string('moneda_pago')->nullable();
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
        Schema::dropIfExists('teams');
    }
}
