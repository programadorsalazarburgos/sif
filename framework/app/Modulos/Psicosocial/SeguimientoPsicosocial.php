<?php

namespace App\Modulos\Psicosocial;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class SeguimientoPsicosocial extends Model
{
    protected $table = 'tb_seguimientos_psicosociales';
    protected $primaryKey= 'pk_id_seguimiento_psicosocial';
    protected $fillable = [
        'FK_id_caso_psicosocial',
        'dt_fecha_seguimiento',
        'tx_descripcion_seguimiento'
      
    ];
    public $timestamps = true;

}