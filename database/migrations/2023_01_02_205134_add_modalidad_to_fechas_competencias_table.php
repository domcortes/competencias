<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddModalidadToFechasCompetenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fechas_competencias', function (Blueprint $table) {
            $table->enum('modalidad',['online','presencial'])->default('online')->after('id_competencia');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fechas_competencias', function (Blueprint $table) {
            $table->dropColumn('modalidad');
        });
    }
}
