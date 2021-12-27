<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbDocumentosInteresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_documentos_interes', function (Blueprint $table) {
            $table->increments('pk_id_documento_interes');
            $table->string('vc_categoria', 200);            
            $table->string('vc_anexo', 200);            
            $table->string('vc_extension', 10);            
            $table->string('tx_descripcion', 500);            
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
        Schema::dropIfExists('tb_documentos_interes');
    }
}
