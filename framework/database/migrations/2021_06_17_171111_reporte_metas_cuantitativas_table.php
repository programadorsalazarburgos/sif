<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReporteMetasCuantitativasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_culturas_reporte_metas_cuantitativas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('in_mes');
            $table->string('tx_nombre_actividad',500);
            $table->string('tx_descripcion_actividad',500);
            $table->date('da_fecha_inicio', $precision = 0);
            $table->date('da_fecha_fin', $precision = 0);
            $table->json('json_formulario');
            $table->json('json_observaciones')->nullable();
            $table->string('url_anexos',1000);
            $table->smallInteger('fk_usuario');
            $table->tinyInteger('in_estado')->nullable();
            $table->smallInteger('fk_usuario_revisa')->nullable();
            $table->dateTime('da_fecha_revision', $precision = 0)->nullable();
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
        Schema::dropIfExists('tb_culturas_reporte_metas_cuantitativas');
    }
}
