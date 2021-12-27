<?php

namespace App\Modulos\Psicosocial;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class DocumentoInteres extends Model
{
    protected $table = 'tb_documentos_interes';
    protected $primaryKey= 'pk_id_documento_interes';
    protected $fillable = [
        'vc_categoria',
        'vc_anexo',
        'tx_descripcion',
        'vc_extension'
      
    ];
    public $timestamps = true;

}