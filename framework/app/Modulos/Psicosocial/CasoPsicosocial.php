<?php

namespace App\Modulos\Psicosocial;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class CasoPsicosocial extends Model
{
    protected $table = 'tb_casos_psicosociales';
    protected $primaryKey= 'pk_id_caso_psicosocial';
    protected $fillable = [
        'vc_nombre_reporta',
        'vc_rol_reporta',
        'vc_numero_identificacion_reporta',
        'vc_correo_reporta',
        'dt_fecha_reporte',
        'vc_rol',
        'vc_nombre_completo',
        'FK_parametro_detalle_tipo_identificacion',
        'vc_numero_identificacion',
        'dt_fecha_nacimiento',
        'vc_direccion',
        'vc_telefono_celular',
        'FK_id_parametro_detalle_linea_estrategica',
        'FK_id_parametro_detalle_area',
        'FK_id_crea',
        'FK_id_colegio',
        'tx_descripcion'
    ];
    public $timestamps = true;

}