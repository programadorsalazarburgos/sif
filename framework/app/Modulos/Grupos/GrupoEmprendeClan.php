<?php

namespace App\Modulos\Grupos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Modulos\Parametros\ParametroDetalles;
use App\Modulos\Personas\Persona;
use App\Modulos\Organizaciones\Organizacion;
use App\Modulos\Crea\Crea;
use App\Modulos\Grupos\GrupoEmprendeClanHorarioClase;


use App\Modulos\Grupos\GrupoEmprendeClanHorario;
use App\Modulos\Grupos\GrupoEmprendeClanEstudiante;

class GrupoEmprendeClan extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tb_terr_grupo_emprende_clan';

    protected $primaryKey = 'PK_Grupo';
    protected $fillable = [
        'FK_clan',
        'FK_area_artistica',
        'FK_modalidad',
        'FK_artista_formador',
        'DT_fecha_creacion',
        'FK_creador',
        'FK_organizacion',
        'estado',
        'DT_fecha_cierre',
        'FK_quien_cerro',
        'TX_observaciones',
        'tipo_grupo',
        'abierto_publico',
        'modalidad_atencion',
        'IN_lugar_atencion',
        'IN_modalidad_atencion',
        'IN_tipo_atencion',
        'IN_convenio',
        'IN_cupos'
    ];
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
    public function getInModalidadAtencionAttribute()
    {
        if (isset($this->attributes['IN_modalidad_atencion'])) {
            switch ($this->attributes['IN_modalidad_atencion']) {
                case 1:
                    $this->attributes['IN_modalidad_atencion'] = "Presencial";
                    break;
                $this->attributes['IN_modalidad_atencion'] = 1;
                break;
                case 2:
                    $this->attributes['IN_modalidad_atencion'] = "Virtual";
                    break;
                $this->attributes['IN_modalidad_atencion'] = 2;
                break;
                case 3:
                    $this->attributes['IN_modalidad_atencion'] = "Mixto";
                    break;
                $this->attributes['IN_modalidad_atencion'] = 3;
                break;
            }
            return $this->attributes['IN_modalidad_atencion'];
        }
    }

    public function getListaGrupos($idUsuario)
    {
        return GrupoEmprendeClan::select(DB::raw('PK_Grupo AS value, CONCAT("IC-", PK_Grupo) AS text'))
            ->whereNull('DT_fecha_cierre')
            ->where([
                ['FK_artista_formador', '=', $idUsuario],
                ['estado', '=', '1'],
            ])
            ->get();
    }

    public function areaArtistica()
    {
        return $this->hasOne(ParametroDetalles::class, "FK_Value", "FK_area_artistica")->where("FK_Id_Parametro", 6);
    }

    public function modalidad()
    {
        return $this->hasOne(ParametroDetalles::class, "FK_Value", "FK_modalidad")->where("FK_Id_Parametro", 61);
    }

    public function modalidadArtistica()
    {
        return $this->hasOne(Modalidad::class, "PK_Id_Modalidad", "FK_modalidad");
    }

    public function artistas()
    {
        return $this->belongsToMany(Persona::class, 'tb_terr_grupo_emprende_clan_artista_formador', 'FK_grupo', 'FK_artista_formador');
    }

    public function creador()
    {
        return $this->hasOne(Persona::class, "PK_Id_Persona", "FK_creador");
    }

    public function organizacion()
    {
        return $this->hasOne(Organizacion::class, 'PK_Id_Organizacion', 'FK_organizacion');
    }

    public function userAction()
    {
        return $this->hasOne(Persona::class, "PK_Id_Persona", "FK_quien_cerro");
    }

    public function crea()
    {
        return $this->hasOne(Crea::class, "PK_Id_Clan", "FK_clan");
    }

    public function horarios()
    {
        return $this->hasMany(GrupoEmprendeClanHorarioClase::class, "FK_grupo", "PK_Grupo");
    }

    public function lugarAtencion()
    {
        return $this->hasOne(Crea::class, "PK_Id_Clan", "FK_clan");
    }

    public function modalidadAtencion()
    {
        return $this->hasOne(ParametroDetalles::class, "FK_Value", "IN_modalidad_atencion")->where("FK_Id_Parametro", 61);
    }

    public function tipoAtencion()
    {
        return $this->hasOne(ParametroDetalles::class, "FK_Value", "IN_tipo_atencion")->where("FK_Id_Parametro", 62);
    }

    public function estudiantesActivos()
    {
        return $this->hasMany(GrupoEmprendeClanEstudiante::class, "FK_grupo", "PK_Grupo")->where("estado", 1);
    }

}
