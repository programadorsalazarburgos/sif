<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbCasosPsicosocialesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_casos_psicosociales', function (Blueprint $table) {
            $table->increments('pk_id_caso_psicosocial');
            $table->string('vc_nombre_reporta', 500);  
            $table->string('vc_numero_contacto_reporta', 11);  
            $table->string('vc_correo_reporta', 200);  
            $table->date('dt_fecha_reporte', 200);  
            $table->string('vc_rol', 50);  
            $table->string('vc_nombre_completo', 200);          
            $table->integer('FK_parametro_detalle_tipo_identificacion');
            $table->string('vc_numero_identificacion', 200);   
            $table->date('dt_fecha_nacimiento', 200);  
            $table->string('vc_direccion', 200);      
            $table->string('vc_telefono_celular', 11);   
            $table->integer('FK_id_parametro_detalle_linea_estrategica');   
            $table->integer('FK_id_parametro_detalle_area');   
            $table->integer('FK_id_crea');   
            $table->integer('FK_id_colegio')->nullable(); 
            $table->string('vc_institucion_aliado', 200)->nullable();          
            $table->string('vc_nombre_completo_acudiente', 200);          
            $table->integer('FK_parametro_detalle_tipo_identificacion_acudiente');
            $table->string('vc_numero_identificacion_acudiente', 200); 
            $table->string('vc_telefono_celular_acudiente', 11);   
            $table->string('tx_descripcion', 500);    
            $table->boolean('estado')->default(true);
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
        Schema::dropIfExists('tb_casos_psicosociales');
    }
}
