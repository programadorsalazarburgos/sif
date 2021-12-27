<?php

namespace App\Modulos\FortalecimientoExterno;

use Illuminate\Database\Eloquent\Model;

class AsistenciaFortalecimientoExterno extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'tb_nidos_asistencias_fortalecimiento_externo';
    public $timestamps = false;

    protected $fillable = [
        'fk_participante',
        'fk_sesion',
        'asistencia',
        'fechas_classroom'
    ];

    protected $casts = [
        'fechas_classroom' => 'array'
    ];

    /**
    * Relaciones
    */
    public function participantes(){
        return $this->hasMany(ParticipanteFortalecimientoExterno::class, "id", "fk_participante");
    }

    /**
    * Accesores
    */
    public function getAsistenciaAttribute(){
        switch($this->attributes['asistencia']){
            case 0:
            $this->attributes['asistencia'] = "No";
            break;
            case 1:
            $this->attributes['asistencia'] = "Si";
            break;
        }
        return $this->attributes['asistencia'];
    }
}
