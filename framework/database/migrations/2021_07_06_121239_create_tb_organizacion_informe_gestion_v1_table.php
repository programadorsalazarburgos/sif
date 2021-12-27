<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbOrganizacionInformeGestionV1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_organizacion_informe_gestion_v1', function (Blueprint $table) {
            $table->increments('pk_id_tabla');
            $table->integer('fk_convenio')->unsigned();
            $table->foreign('fk_convenio')->references('pk_id_tabla')->on('tb_convenios_organizaciones');
            $table->integer('vc_ini_info');
            $table->integer('vc_fin_info');
            $table->date('dt_periodo_ini');
            $table->date('dt_periodo_fin');
            $table->text('tx_detalle_actividad')->nullable();
            $table->text('tx_detalle_producto')->nullable();
            $table->string('vc_concluciones')->nullable();
            $table->text('tx_detalle_link')->nullable();
            $table->text('tx_observacion')->nullable();
            $table->integer('in_aprobacion')->nullable();
            $table->integer('in_estado_final');
            $table->integer('fk_persona_revisa')->unsigned()->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('tb_organizacion_informe_gestion_v1');
    }
}
