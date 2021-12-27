<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class InformeMensualGrupo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tb_terr_informe_mensual_grupo';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function getReporteInicial($id_usuario, $fecha, $linea = null, $estado = null) {
        $result = InformeMensualGrupo::select(DB::raw('COUNT(1) AS conteo, linea_atencion, SM_estado'))
        ->where([
            ['FK_persona_aprueba', '=', $id_usuario],
            ['VC_fecha_reporte', '=', $fecha]
        ]);
        if(!is_null($linea)) {
            $result->where('linea_atencion', "=", $linea);
        }
        if(!is_null($estado)) {
            $result->where('SM_estado', "=", $estado);
        }
        return $result->groupBy('linea_atencion', 'SM_estado')->get();
    }
    
    public function getReporteDetallado($id_usuario, $fecha, $linea = null, $estado = null) {
        $result = InformeMensualGrupo::select(DB::raw('tb_terr_informe_mensual_grupo.id, tb_terr_informe_mensual_grupo.FK_grupo, tb_terr_informe_mensual_grupo.linea_atencion, DATE_FORMAT(tb_terr_informe_mensual_grupo.DT_fecha_creacion, "%d/%m/%Y %l:%i %p") AS DT_fecha_creacion, tb_terr_informe_mensual_grupo.SM_estado, tb_terr_informe_mensual_grupo.TX_observaciones_json, CONCAT(tb_persona_2017.VC_Primer_Nombre, " ", tb_persona_2017.VC_Primer_Apellido) AS artista_formador'))
        ->leftJoin('tb_persona_2017','tb_terr_informe_mensual_grupo.FK_persona_reporte','=','tb_persona_2017.PK_Id_Persona')    
        ->where([
                ['FK_persona_aprueba', '=', $id_usuario],
                ['VC_fecha_reporte', '=', $fecha]
            ]);
        if(!is_null($linea)) {
            $result->where('linea_atencion', "=", $linea);
        }
        if(!is_null($estado)) {
            $result->where('SM_estado', "=", $estado);
        } 
        return $result->orderBy('DT_fecha_creacion')->get();
    }
}
