<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInscriptionPriceToCategoriasCompetenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categorias_competencias', function (Blueprint $table) {
            $table->float('valor_inscripcion')->default(1);
            $table->string('moneda')->nullable()->default('es-AR');
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
            $table->dropColumn('valor_inscripcion');
            $table->dropColumn('moneda');
        });
    }
}
