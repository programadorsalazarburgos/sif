<?php

namespace App\Modulos\Grupos;

use Illuminate\Database\Eloquent\Model;

class GrupoEmprendeClanEstudiante extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'tb_terr_grupo_emprende_clan_estudiante';
    public $timestamps = false;

    protected $fillable = [
       'FK_grupo',
       'FK_estudiante',
       'DT_fecha_ingreso',
       'FK_usuario_ingreso',
       'DT_fecha_retiro',
       'FK_usuario_retiro',
       'estado',
       'TX_observaciones',
       'JSON_bioseguridad'
    ];
}