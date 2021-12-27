<?php

namespace App\Modulos\Oferta;

use Illuminate\Database\Eloquent\Model;

class Preinscripcion extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'tb_preinscripcion';
    public $timestamps = false;

    protected $fillable = [
        'numero_documento',
        'tipo_documento',
        'primer_nombre',
        'segundo_nombre',
        'primer_apellido',
        'segundo_apellido',
        'fecha_nacimiento',
        'direccion',
        'correo',
        'telefono_fijo',
        'celular',
        'localidad',
        'barrio',
        'genero',
        'estrato',
        'grupo_poblacional',
        'archivo_documento_identidad',
        'archivo_eps',
        'archivo_recibo_publico',
        'autorizacion_imagen',
        'autorizacion_datos',
        'fecha_solicitud',
        'grupo',
        'modalidad',
        'estado',
        'fecha_revision',
        'persona_revision',
        'razon_rechazo',
        'justificacion_rechazo'
    ];

    /**
    * Accesores
    */
    public function getFechaSolicitudAttribute($value){
    	return date("d/m/Y", strtotime($value));
    }
}
