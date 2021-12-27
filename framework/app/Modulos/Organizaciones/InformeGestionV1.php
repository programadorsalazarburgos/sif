<?php

namespace App\Modulos\Organizaciones;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modulos\Organizaciones\Convenios;
use Carbon\Carbon;

class InformeGestionV1 extends Model
{
    use SoftDeletes;
    protected $table = 'tb_organizacion_informe_gestion_v1';
    protected $primaryKey= 'pk_id_tabla';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'fk_convenio',
        'vc_ini_info',
        'vc_fin_info',
        'dt_periodo_ini',
        'dt_periodo_fin',
        'tx_detalle_actividad',
        'tx_detalle_producto',
        'vc_concluciones',
        'tx_detalle_link',
        'tx_observacion',
        'in_aprobacion',
        'in_estado_final',
        'fk_persona_revisa'
    ];
    public $timestamps = true;

    public function getCreatedAtAttribute($value){
        $date = Carbon::parse($value)->setTimezone(config('app.timezone'));
        return $date->format('Y-m-d H:i');
    }
    
    public function getUpdatedAtAttribute($value){
        $date = Carbon::parse($value)->setTimezone(config('app.timezone'));
        return $date->format('Y-m-d H:i');
    }

    public function convenio()
    {
        return $this->belongsTo(Convenios::class, 'fk_convenio', 'pk_id_tabla');
    }

    
}