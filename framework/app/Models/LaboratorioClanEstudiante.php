<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LaboratorioClanEstudiante extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tb_terr_grupo_laboratorio_clan_estudiante';

    public function getDataGrupoAnio($id, $anio) {
        $resultado = LaboratorioClanEstudiante::select(DB::raw("DATE_FORMAT(tb_terr_grupo_laboratorio_clan_estudiante.DT_fecha_ingreso, \"%d/%m/%Y %h:%i %p\") AS DT_fecha_ingreso, DATE_FORMAT(tb_terr_grupo_laboratorio_clan_estudiante.DT_fecha_retiro, \"%d/%m/%Y %h:%i %p\") AS DT_fecha_retiro, CONCAT('LC-', G.PK_Grupo) AS grupo, CONCAT(G.FK_clan, ' - ', C.VC_Nom_Clan) AS FK_clan, CONCAT(AF.VC_Primer_Nombre,' ',AF.VC_Segundo_Nombre,' ',AF.VC_Primer_Apellido,' ',AF.VC_Segundo_Apellido) AS Artista_Formador, CONCAT(UI.VC_Primer_Nombre,' ',UI.VC_Segundo_Nombre,' ',UI.VC_Primer_Apellido,' ',UI.VC_Segundo_Apellido) AS Usuario_Ingreso, CONCAT(UR.VC_Primer_Nombre,' ',UR.VC_Segundo_Nombre,' ',UR.VC_Primer_Apellido,' ',UR.VC_Segundo_Apellido) AS Usuario_Retiro"))
        ->leftJoin('tb_terr_grupo_laboratorio_clan AS G','tb_terr_grupo_laboratorio_clan_estudiante.FK_grupo','=','G.PK_Grupo')
        ->leftJoin('tb_clan AS C','G.FK_clan','=','C.PK_Id_Clan')
        ->leftJoin('tb_persona_2017 AS AF','G.FK_artista_formador','=','AF.PK_Id_Persona')
        ->leftJoin('tb_persona_2017 AS UI','tb_terr_grupo_laboratorio_clan_estudiante.FK_usuario_ingreso','=','UI.PK_Id_Persona')
        ->leftJoin('tb_persona_2017 AS UR','tb_terr_grupo_laboratorio_clan_estudiante.FK_usuario_retiro','=','UR.PK_Id_Persona')
        ->where([
            ['tb_terr_grupo_laboratorio_clan_estudiante.FK_estudiante', '=', $id],
            [DB::raw('YEAR(tb_terr_grupo_laboratorio_clan_estudiante.DT_fecha_ingreso)'), '=', $anio]
        ])
        ->get();
        return $resultado;
    }
}
