<?php

namespace App\Modulos\Grupos;

use App\Models\Colegio;
use Illuminate\Database\Eloquent\Model;
use App\Models\crea\territorial\Crea;
use App\Modulos\Personas\Persona;
use App\Modulos\Parametros\ParametroDetalles;
use App\Modulos\Grupos\GrupoArteEscuelaHorario;

class GrupoArteEscuela extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'tb_terr_grupo_arte_escuela';
    protected $primaryKey= 'PK_Grupo';
    protected $fillable = [
        'FK_clan', 
        'FK_area_artistica', 
        'IN_lugar_atencion', 
        'FK_colegio', 
        'FK_artista_formador', 
        'DT_fecha_creacion', 
        'FK_creador', 
        'FK_organizacion', 
        'estado', 
        'DT_fecha_cierre', 
        'FK_quien_cerro', 
        'TX_observaciones', 
        'tipo_grupo', 
        'modalidad_atencion', 
        'IN_modalidad_atencion', 
        'IN_tipo_atencion', 
        'IN_convenio'
    ];
    public $timestamps = false;

    public function crea(){
    	return $this->hasOne(Crea::class, "PK_Id_Clan", "FK_clan");
    }

    public function artistas(){
        return $this->belongsToMany(Persona::class, 'tb_terr_grupo_arte_escuela_artista_formador', 'FK_grupo', 'FK_artista_formador');
    }
    
    public function areasArtisticas(){
        return $this->hasOne(ParametroDetalles::class, "FK_Value", "FK_area_artistica")->where("FK_Id_Parametro", 6);
    }

    public function horarios(){
        return $this->hasMany(GrupoArteEscuelaHorario::class, "FK_grupo", "PK_Grupo");
    }

    public function lugarAtencion(){
        return $this->hasOne(ParametroDetalles::class, "FK_Value", "IN_lugar_atencion")->where("FK_Id_Parametro", 56);
    }

    public function colegio(){
        return $this->hasOne(Colegio::class, "PK_Id_Colegio", "FK_colegio");
    }

    public function modalidadAtencion(){
        return $this->hasOne(ParametroDetalles::class, "FK_Value", "IN_modalidad_atencion")->where("FK_Id_Parametro", 61);
    }
    
    public function tipoAtencion(){
        return $this->hasOne(ParametroDetalles::class, "FK_Value", "IN_tipo_atencion")->where("FK_Id_Parametro", 62);
    }
    
}
