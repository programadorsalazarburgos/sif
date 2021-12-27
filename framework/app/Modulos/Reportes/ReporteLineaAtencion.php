<?php

namespace App\Modulos\Reportes;

use Illuminate\Database\Eloquent\Model;

class ReporteLineaAtencion extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */


    protected $table = 'tb_reporte_linea_atencion';
    protected $primaryKey= 'pk_id_reporte_linea';
    protected $fillable = [
        'FK_parametro_detalle_linea',
        'FK_colegio',
        'FK_parametro_detalle_anio',
        'FK_parametro_detalle_mes',
        'tx_observacion',
        'fk_usuario'
    ];
    public $timestamps = true;

}
