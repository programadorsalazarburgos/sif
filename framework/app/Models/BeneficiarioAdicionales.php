<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BeneficiarioAdicionales extends Model
{
   /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tb_estudiante_detalle_anio';
    //protected $primaryKey = 'FK_estudiante';
    public $timestamps = false;
    protected $fillable = ["anio", "FK_estudiante", "TX_Barrio", "FK_Localidad", "TELEFONO_ACUDIENTE", "IDENTIFICACION_ACUDIENTE", "NOMBRE_ACUDIENTE", "FK_grado", "jornada", "FK_colegio", "FK_clan", "TX_Enfermedades", "FK_RH", "FK_Eps", "TX_Tipo_Afiliacion", "FK_tipo_discapacidad", "IN_estrato", "FK_tipo_poblacion_victima", "TX_etnia", "FK_Grupo_Poblacional", "TX_observaciones", "DA_fecha_creacion", "FK_usuario_creacion"];

    public function getAniosAdicional($id) {
        return BeneficiarioAdicionales::select('anio')
        ->where('FK_estudiante', $id)
        ->orderBy('anio', 'asc')
        ->get();
    }

    public function getInfoBeneficiarioAnio($id, $anio) {
        return BeneficiarioAdicionales::where([
            ['FK_Estudiante', '=', $id],
            ['anio', '=', $anio]
        ])->first();
    }
    
    public function getDataBeneficiarioxAnio($id, $anio) {
        $resultado = BeneficiarioAdicionales::select(DB::raw("tb_estudiante_detalle_anio.FK_estudiante, tb_estudiante_detalle_anio.anio, tb_estudiante_detalle_anio.nombre_acudiente, tb_estudiante_detalle_anio.identificacion_acudiente, tb_estudiante_detalle_anio.telefono_acudiente, tb_estudiante_detalle_anio.TX_Enfermedades, tb_estudiante_detalle_anio.TX_Barrio, tb_estudiante_detalle_anio.TX_etnia, tb_estudiante_detalle_anio.IN_estrato, tb_estudiante_detalle_anio.TX_observaciones, tb_clan.VC_Nom_Clan AS crea, tb_colegios.VC_Nom_Colegio as colegio, GR.VC_Descripcion AS grado, J.VC_Descripcion AS jornada, GP.VC_Descripcion AS grupo_poblacional, EPS.VC_Descripcion AS eps,  L.VC_Descripcion AS localidad, PV.VC_Descripcion AS poblacion_victima, D.VC_Descripcion AS tipo_discapacidad, E.VC_Descripcion AS etnia, RH.VC_Descripcion AS rh, tb_areas_artisticas.VC_Nom_Area, TA.VC_Descripcion AS TX_Tipo_Afiliacion"))
        ->leftJoin('tb_clan','tb_estudiante_detalle_anio.FK_clan','=','tb_clan.PK_Id_Clan')
        ->leftJoin('tb_colegios','tb_estudiante_detalle_anio.FK_colegio','=','tb_colegios.PK_Id_Colegio')
        ->leftJoin('tb_parametro_detalle AS GR', function($join){
            $join->on('tb_estudiante_detalle_anio.FK_grado','=','GR.FK_Value');
            $join->on('GR.FK_Id_Parametro','=', DB::raw(18));
        })
        ->leftJoin('tb_parametro_detalle AS J', function($join){
            $join->on('tb_estudiante_detalle_anio.jornada','=','J.FK_Value');
            $join->on('J.FK_Id_Parametro','=', DB::raw(11));
        })                   
        ->leftJoin('tb_parametro_detalle AS GP', function($join){
            $join->on('tb_estudiante_detalle_anio.FK_Grupo_Poblacional','=','GP.FK_Value');
            $join->on('GP.FK_Id_Parametro','=', DB::raw(14));
        })

        ->leftJoin('tb_parametro_detalle AS EPS', function($join){
            $join->on('tb_estudiante_detalle_anio.FK_Eps','=','EPS.FK_Value');
            $join->on('EPS.FK_Id_Parametro','=', DB::raw(16));
        })
        ->leftJoin('tb_parametro_detalle AS L', function($join){
            $join->on('tb_estudiante_detalle_anio.FK_Localidad','=','L.FK_Value');
            $join->on('L.FK_Id_Parametro','=', DB::raw(19));
        })
        ->leftJoin('tb_parametro_detalle AS PV', function($join){
            $join->on('tb_estudiante_detalle_anio.FK_tipo_poblacion_victima','=','PV.FK_Value');
            $join->on('PV.FK_Id_Parametro','=', DB::raw(9));
        })
        ->leftJoin('tb_parametro_detalle AS D', function($join){
            $join->on('tb_estudiante_detalle_anio.FK_tipo_discapacidad','=','D.FK_Value');
            $join->on('D.FK_Id_Parametro','=', DB::raw(10));
        })
        ->leftJoin('tb_parametro_detalle AS E', function($join){
            $join->on('tb_estudiante_detalle_anio.TX_etnia','=','E.FK_Value');
            $join->on('E.FK_Id_Parametro','=', DB::raw(33));
        })
        ->leftJoin('tb_parametro_detalle AS RH', function($join){
            $join->on('tb_estudiante_detalle_anio.FK_RH','=','RH.FK_Value');
            $join->on('RH.FK_Id_Parametro','=', DB::raw(15));
        })
        ->leftJoin('tb_parametro_detalle AS TA', function($join){
            $join->on('tb_estudiante_detalle_anio.TX_Tipo_Afiliacion','=','TA.FK_Value');
            $join->on('TA.FK_Id_Parametro','=', DB::raw(70));
        })
        ->leftJoin('tb_areas_artisticas','tb_estudiante_detalle_anio.FK_area_artistica_interes','=','tb_areas_artisticas.PK_Area_Artistica')
        ->where([
            ['tb_estudiante_detalle_anio.FK_estudiante', '=', $id],
            ['tb_estudiante_detalle_anio.anio', '=', $anio]
        ])
        ->first();
        return $resultado;
    }

    public function guardarAdicionalesBeneficiario($id, $anio, $cambios, $usuario = null) {
        DB::statement('SET @user_id = '.$usuario);
        if(BeneficiarioAdicionales::getInfoBeneficiarioAnio($id, $anio)) {
            return BeneficiarioAdicionales::where([
                ['FK_estudiante', '=', $id],
                ['anio', '=', $anio]
            ])
            ->update($cambios);
        } else {    
            $cambios['FK_estudiante'] = $id;     
            $cambios['anio'] = $anio;
            $cambios['DA_fecha_creacion'] = date('Y-m-d H:i:s');
            $cambios['FK_usuario_creacion'] = $usuario;
            return BeneficiarioAdicionales::create($cambios);
        }
    }
}
