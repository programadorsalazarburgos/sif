<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbConveniosOrganizacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_convenios_organizaciones', function (Blueprint $table) {
            $table->increments('pk_id_tabla');
            $table->integer('fk_id_tipo_contrato')->unsigned();
            $table->string('vc_numero_contrato');
            $table->date('dt_acta_ini');
            $table->date('dt_term');
            $table->string('vc_areas');
            $table->string('vc_proyecto');
            $table->integer('fk_id_organizacion')->unsigned();
            $table->string('vc_representante');
            $table->integer('fk_id_supervisor')->unsigned();
            $table->integer('fk_id_apoyo')->unsigned()->nullable();
            $table->string('vc_objeto');
            $table->string('vc_email');
            $table->integer('in_estado');
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
        Schema::dropIfExists('tb_convenios_organizaciones');
    }
}
