<?php

namespace App\Modulos\Organizaciones;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InformeGestion extends Model
{
    //use SoftDeletes;
    protected $table = 'tb_organizacion_informe_gestion';
    protected $primaryKey= 'PK_Id_Tabla';
    //protected $dates = ['deleted_at'];
    protected $fillable = [
        'FK_Id_Organizacion',
        'VC_Informe',
        'VC_Periodo',
        'IN_Anio',
        'VC_Correo',
        'TX_Detalle_Actividades',
        'DA_Registro',
        'TX_Observaciones',
        'IN_Aprobacion',
        'FK_Persona_Revisa',
        'DA_Cambio',
        'IN_Estado_Final',
        'FK_Id_Info_Contractual'
    ];
    public $timestamps = false;
    
}
