<?php

namespace App\Modulos\Grupos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Modulos\Parametros\ParametroDetalles;
use App\Modulos\Personas\Persona;
use App\Models\crea\territorial\Crea;
use App\Modulos\Organizaciones\Organizacion;
use App\Models\Colegio;

class GrupoLaboratorioClan extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tb_terr_grupo_laboratorio_clan';
    
    protected $primaryKey = 'PK_Grupo';
    protected $fillable = [
        'FK_clan', 
        'FK_area_artistica', 
        'FK_lugar_atencion', 
        'tipo_poblacion', 
        'FK_artista_formador', 
        'DT_fecha_creacion', 
        'FK_creador', 
        'FK_organizacion', 
        'estado', 
        'DT_fecha_cierre', 
        'FK_quien_cerro', 
        'TX_observaciones', 
        'tipo_grupo', 
        'FK_Institucion', 
        'FK_Aliado', 
        'IN_Tipo_Ubicacion', 
        'TX_Sitio',
        'attr',
        'modalidad_atencion',
        'IN_lugar_atencion',
        'IN_modalidad_atencion',
        'IN_tipo_atencion',
        'IN_convenio',
        'IN_espacio_alterno'
    ];
    public $timestamps = false;

    public function getListaGrupos($idUsuario) {
        return GrupoLaboratorioClan::select(DB::raw('PK_Grupo AS value, CONCAT("CV-", PK_Grupo) AS text'))
        ->whereNull('DT_fecha_cierre')
        ->where([
            ['FK_artista_formador', '=', $idUsuario],
            ['estado', '=', '1'],
        ])
        ->get();
    }

    public function crea(){
    	return $this->hasOne(Crea::class, "PK_Id_Clan", "FK_clan");
    }

    public function areasArtisticas(){
        return $this->hasOne(ParametroDetalles::class, "FK_Value", "FK_area_artistica")->where("FK_Id_Parametro", 6);
    }

    public function artistas(){
        return $this->belongsToMany(Persona::class, 'tb_terr_grupo_laboratorio_clan_artista_formador', 'FK_grupo', 'FK_artista_formador');
    }

    public function creador(){
        return $this->hasOne(Persona::class, "PK_Id_Persona", "FK_creador");
    }

    public function organizacion()
    {
         return $this->hasOne(Organizacion::class, 'PK_Id_Organizacion', 'FK_organizacion');
    }

    public function quienCerro(){
        return $this->hasOne(Persona::class, "PK_Id_Persona", "FK_quien_cerro");
    }

    public function colegio(){
        return $this->hasOne(Colegio::class, "PK_Id_Colegio", "FK_Institucion");
    }

    public function horarios(){
        return $this->hasMany(GrupoLaboratorioClanHorario::class, "FK_grupo", "PK_Grupo");
    }

    public function lugarAtencion(){
        return $this->hasOne(ParametroDetalles::class, "FK_Value", "IN_lugar_atencion")->where("FK_Id_Parametro", 39);
    }

    public function lugarComplementario(){
        return $this->hasOne(ParametroDetalles::class, "FK_Value", "IN_espacio_alterno")->where("FK_Id_Parametro", 69);
    }

    public function modalidadAtencion(){
        return $this->hasOne(ParametroDetalles::class, "FK_Value", "IN_modalidad_atencion")->where("FK_Id_Parametro", 61);
    }
    
    public function tipoAtencion(){
        return $this->hasOne(ParametroDetalles::class, "FK_Value", "IN_tipo_atencion")->where("FK_Id_Parametro", 62);
    }

}
