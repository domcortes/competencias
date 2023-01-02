<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCantidadParticipantesToCategoriasCompetenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categorias_competencias', function (Blueprint $table) {
            $table->bigInteger('cantidad_participantes')->default(1)->after('nombre_categoria');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categorias_competencias', function (Blueprint $table) {
            $table->dropColumn('cantidad_participantes');
        });
    }
}
