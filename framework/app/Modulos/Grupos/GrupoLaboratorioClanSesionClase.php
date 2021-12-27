<?php

namespace App\Modulos\Grupos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GrupoLaboratorioClanSesionClase extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tb_terr_grupo_laboratorio_clan_sesion_clase';
    protected $primaryKey = 'PK_sesion_clase';
    public $timestamps = false;

}
