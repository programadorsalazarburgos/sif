<?php

namespace App\Modulos\FortalecimientoExterno;

use Illuminate\Database\Eloquent\Model;
use App\Modulos\Parametros\ParametroDetalles;

class ParticipanteFortalecimientoExterno extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'tb_nidos_participantes_fortalecimiento_externo';
    public $timestamps = false;

    protected $fillable = [
        'primer_nombre',
        'segundo_nombre',
        'primer_apellido',
        'segundo_apellido',
        'tipo_documento',
        'numero_documento',
        'correo',
        'fecha_nacimiento',
        'celular',
        'genero',
        'otro_genero',
        'sector_social',
        'grupo_etnico',
        'entidad',
        'tipo_vinculacion',
        'otro_tipo_vinculacion',
        'localidad_trabajo',
        'fk_barrio',
        'barrio_trabajo',
        'sitio_trabajo',
        'nivel_trabajo',
        'otro_nivel_trabajo',
        'ocupacion',
        'otra_ocupacion',
        'id_modulo_fortalecimiento',
        'modulo_fortalecimiento',
        'jornada_fortalecimiento',
        'fecha_registro'
    ];
    
    protected $appends = ['full_name'];

    protected $casts = [
        'nivel_trabajo' => 'array'
    ];

    /**
    * Accesores
    */
    public function getFechaNacimientoAttribute($value){
        return date("d/m/Y", strtotime($value));
    }

    public function getGeneroAttribute(){
        return $this->attributes["genero"] = $this->attributes["genero"] == 1 ? "Masculino" : "Femenino";
    }

    public function getFullNameAttribute(){
        return trim($this->primer_nombre) . ' ' . trim($this->segundo_nombre) . ' ' . trim($this->primer_apellido). ' ' . trim($this->segundo_apellido);
    }

    /**
    * Relaciones
    */

    public function tipoDocumento(){
        return $this->hasOne(ParametroDetalles::class, "FK_Value", "tipo_documento")->where([["FK_Id_Parametro", 5], ["IN_Estado_Nidos", 1]]);
    }

    public function sectorSocial(){
        return $this->hasOne(ParametroDetalles::class, "FK_Value", "sector_social")->where([["FK_Id_Parametro", 14], ["IN_Estado_Nidos", 1]]);
    }

    public function grupoEtnico(){
        return $this->hasOne(ParametroDetalles::class, "FK_Value", "sector_social")->where([["FK_Id_Parametro", 14], ["IN_Estado_Nidos", 1]]);
    }

    public function localidadTrabajo(){
        return $this->hasOne(ParametroDetalles::class, "FK_Value", "localidad_trabajo")->where([["FK_Id_Parametro", 19], ["IN_Estado_Nidos", 1]]);
    }
}
