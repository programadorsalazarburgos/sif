<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbSeguimientosPsicosocialesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_seguimientos_psicosociales', function (Blueprint $table) {
            $table->increments('pk_id_seguimiento_psicosocial');
            $table->integer('FK_id_caso_psicosocial');      
            $table->date('dt_fecha_seguimiento');  
            $table->string('tx_descripcion_seguimiento', 500);            
            $table->string('vc_anexo', 200);            
            $table->string('vc_extension', 10);            
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
        Schema::dropIfExists('tb_seguimientos_psicosociales');
    }
}
