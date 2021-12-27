<?php

namespace App\Modulos\TalentoHumano;

use Illuminate\Database\Eloquent\Model;
use App\Modulos\Parametros\ParametroDetalles;

class HojadeVida extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'tb_hoja_vida';
    public $timestamps = false;

    protected $fillable = [
        'fecha_solicitud',
        'numero_documento',
        'tipo_documento',
        'primer_nombre',
        'segundo_nombre',
        'primer_apellido',
        'segundo_apellido',
        'correo',
        'telefono',
        'localidad',
        'municipio',
        'area_experiencia',
        'otra_area_experiencia',
        'experiencia_nidos',
        'periodo_nidos',
        'experiencia_infancia',
        'periodo_infancia',
        'codigo',
        'archivo_hoja_vida',
        'estado',
        'obsevaciones'
    ];

    /**
    * Accesores
    */
    public function getFechaSolicitudAttribute($value){
    	return date("d/m/Y", strtotime($value));
    }

    public function localidad(){
        return $this->hasOne(ParametroDetalles::class, "FK_Value", "localidad")->where("FK_Id_Parametro",19);
    }

    public function area_experiencia(){
        return $this->hasOne(ParametroDetalles::class, "FK_Value", "area_experiencia")->where("FK_Id_Parametro",101);
    }
}