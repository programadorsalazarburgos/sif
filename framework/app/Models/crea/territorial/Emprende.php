<?php

namespace App\Models\crea\territorial;

use Illuminate\Database\Eloquent\Model;
use App\Models\Options;

class Emprende extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'tb_terr_grupo_emprende_clan';
    public $timestamps = false;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = array('IN_modalidad_atencion');

    /**
    * Accesores
    */
    public function getInModalidadAtencionAttribute(){
        if(isset($this->attributes['IN_modalidad_atencion'])){
            switch($this->attributes['IN_modalidad_atencion']){
                case 1:
                $this->attributes['IN_modalidad_atencion'] = "Presencial";
                break;
                case 2:
                $this->attributes['IN_modalidad_atencion'] = "Virtual";
                break;
                case 3:
                $this->attributes['IN_modalidad_atencion'] = "Mixto";
                break;
            }
            return $this->attributes['IN_modalidad_atencion'];
        }
    }

    /**
    * Relaciones
    */
    public function crea(){
    	return $this->hasOne(Crea::class, "PK_Id_Clan", "FK_clan");
    }
    public function areaArtistica(){
    	return $this->hasOne(Options::class, "FK_Value", "FK_area_artistica")->where("FK_Id_Parametro", 6);
    }
    public function horarios(){
    	return $this->hasMany(EmprendeHorarioClase::class, "FK_grupo", "PK_Grupo");
    }
    public function modalidad(){
    	return $this->hasOne(Modalidad::class, "PK_Id_Modalidad", "FK_modalidad");
    }
    public function estudiantesActivos(){
        return $this->hasMany(EmprendeEstudiante::class, "FK_grupo", "PK_Grupo")->where("estado", 1);
    }
}
