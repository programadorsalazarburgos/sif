<?php

namespace App\Http\Controllers\cdm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CDM;
use App\Models\tb_proyectos;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Else_;

class CDMController extends Controller
{
    public function cdmCrea()
    {
        return view('cdm.crea');
    }

    public function cdmNidos()
    {
        return view('cdm.nidos');
    }

    public function viewAnalyticsNavegadores()
    {
        return view('cdm.navegadores');
    }

    public function viewAnalyticsPaginas()
    {
        return view('cdm.paginas');
    }

    public function viewAnalyticsSesiones()
    {
        return view('cdm.sesiones');
    }

    public function viewAnalyticsCiudades()
    {
        return view('cdm.ciudades');
    }
    
    public function viewAnalyticsActivos()
    {
        return view('cdm.activos');
    }

    public function executeSQLIndicador(Request $request)
    {
        set_time_limit(0);
        $model = new CDM;
        $indicador = $request['indicador'];
        $filtros = $request['filtros'];
        $sql = $model->getSql($indicador)[0]['TX_sql'];
        /* SET de filtros a aplicar */
        $sqlSET = "";
        if($filtros != ""){
            foreach ($filtros as $clave => $valor) {
                if ($valor != "") {
                    $sqlSET = "SET @" . $clave . "=" . $valor . ";";
                    DB::statement($sqlSET);
                }
            }
        }
        $resultado = DB::select($sql);
        return response()->json($resultado, 200);
    }

    public function executeSectionQueries(Request $request)
    {
        set_time_limit(0);
        $model = new CDM;
        $filtros_aplicados = $request['filtros_aplicados'];
        $indicadores = $request['indicadores'];
        $sql = null;
        $resultado = [];
        
        for ($i = 0; $i < count($indicadores); $i++) {
            if($indicadores[$i]['sql'] != null){
            $sql = $indicadores[$i]['sql'];
            $sqlSET = "";
            /* SET de filtros a aplicar */
            foreach ($filtros_aplicados as $clave => $valor) {
                if ($valor != "") {
                    $sqlSET = "SET @" . $clave . "=" . $valor . ";";
                    DB::statement($sqlSET);
                }
            }
            $resultado[$i] = DB::select($sql);
            }
            else{
                if($indicadores[$i]['avance'] != null){
                    $resultado[$i] = DB::select("SELECT JSON_EXTRACT('".$indicadores[$i]['avance']."', '$.".$filtros_aplicados["SL_ANIO"]."') AS 'result'");
                    $resultado[$i] = json_decode(json_encode($resultado[$i][0]), true);
                    $array_asociativo = json_decode($resultado[$i]["result"], true);
                    $temp_array = [];
                    $k=0;
                    foreach ($array_asociativo as $clave => $valor) {
                        $temp_array[$k]["X"] = $clave;
                        $temp_array[$k]["Y"] = $valor;
                        $temp_array[$k]["color"] = "#".substr(md5(rand()), 0, 6);
                        $k++;
                    }
                    $resultado[$i] = $temp_array;
                }
                else{
                    $resultado[$i] = '';
                }
            }
        }

        return response()->json($resultado, 200);
    }

    public function getEstadisticasAnioActual(Request $request)
    {
        $fecha = $request['year'];
        $array_fecha = explode("-", $fecha);
        $year = isset($array_fecha[0]) ? $array_fecha[0] : $fecha;
        $periodo = isset($array_fecha[1]) ? $array_fecha[1] : null;
        $start_month = 1;
        $end_month = 12;

        if ($periodo == 'I') {
            $end_month = 5;
        } elseif ($periodo == 'II') {
            $start_month = 6;
        }

        $sql = "SELECT
		T.PROGRAMA,
		T.LINEA,
		COUNT(DISTINCT BENEFICIARIO) AS CANTIDAD
		FROM(
			SELECT
        'CREA' AS 'PROGRAMA',
        'ARTE EN LA ESCUELA' AS 'LINEA',
        SCA.FK_estudiante AS 'BENEFICIARIO',
  		  COUNT(SCA.IN_estado_asistencia) AS 'ASISTENCIAS'
        FROM tb_terr_grupo_arte_escuela_sesion_clase SC
        JOIN tb_terr_grupo_arte_escuela_sesion_clase_asistencia SCA ON SCA.FK_sesion_clase=SC.PK_sesion_clase
        WHERE SCA.IN_estado_asistencia=1 AND YEAR(SC.DA_fecha_clase)=:anio1 AND MONTH(SC.DA_fecha_clase)>=:start_month1 AND MONTH(SC.DA_fecha_clase)<=:end_month1
        GROUP BY SCA.FK_estudiante) T
        WHERE T.ASISTENCIAS >=1
        UNION
		  SELECT
		T.PROGRAMA,
		T.LINEA,
		COUNT(DISTINCT BENEFICIARIO) AS CANTIDAD
		FROM(
			SELECT
        'CREA' AS 'PROGRAMA',
        'IMPULSO COLECTIVO (4+ Asistencias)' AS 'LINEA',
        SCA.FK_estudiante AS 'BENEFICIARIO',
  		  COUNT(SCA.IN_estado_asistencia) AS 'ASISTENCIAS'
        FROM tb_terr_grupo_emprende_clan_sesion_clase SC
        JOIN tb_terr_grupo_emprende_clan_sesion_clase_asistencia SCA ON SCA.FK_sesion_clase=SC.PK_sesion_clase
        WHERE SCA.IN_estado_asistencia=1 AND YEAR(SC.DA_fecha_clase)=:anio2 AND MONTH(SC.DA_fecha_clase)>=:start_month2 AND MONTH(SC.DA_fecha_clase)<=:end_month2
        GROUP BY SCA.FK_estudiante) T
        WHERE T.ASISTENCIAS >=4
        UNION
        SELECT
  		T.PROGRAMA,
		T.LINEA,
		COUNT(DISTINCT BENEFICIARIO) AS CANTIDAD
		FROM(
        SELECT
        'CREA' AS 'PROGRAMA',
        'CONVERGE' AS 'LINEA',
        SCA.FK_estudiante AS 'BENEFICIARIO',
  		  COUNT(SCA.IN_estado_asistencia) AS 'ASISTENCIAS'
        FROM tb_terr_grupo_laboratorio_clan_sesion_clase SC
        JOIN tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia SCA ON SCA.FK_sesion_clase=SC.PK_sesion_clase
        WHERE SCA.IN_estado_asistencia=1 AND YEAR(SC.DA_fecha_clase)=:anio3 AND MONTH(SC.DA_fecha_clase)>=:start_month3 AND MONTH(SC.DA_fecha_clase)<=:end_month3
			GROUP BY SCA.FK_estudiante) T
        WHERE T.ASISTENCIAS >=1
        UNION
        SELECT
        'NIDOS' AS 'PROGRAMA',
        TL.Vc_Descripcion COLLATE utf8_general_ci AS 'LINEA', 
        COUNT(DISTINCT NA.Fk_Id_Beneficiario)  AS 'CANTIDAD'
        FROM tb_nidos_asistencia AS NA 
        JOIN tb_nidos_experiencia AS EX ON NA.Fk_Id_Experiencia = EX.Pk_Id_Experiencia 
        JOIN tb_nidos_lugar_atencion AS LA ON EX.Fk_Id_Lugar_Atencion = LA.Pk_Id_lugar_atencion 
        JOIN tb_nidos_tipo_lugar AS TL ON LA.VC_Tipo_Lugar = TL.Pk_Id_Lugar 
        JOIN tb_nidos_terri_locali AS TE ON LA.Fk_Id_Localidad = TE.Fk_Id_Localidad 
        WHERE NA.Vc_Asistencia = 1 AND EX.IN_Aprobacion=1 AND YEAR(EX.DT_Fecha_Encuentro)=:anio4 AND MONTH(EX.DT_Fecha_Encuentro)>=:start_month4 AND MONTH(EX.DT_Fecha_Encuentro)<=:end_month4
        GROUP BY LA.VC_Tipo_Lugar HAVING LA.VC_Tipo_Lugar;";
        $resultado = DB::select($sql, ['anio1' => $year, 'start_month1' => $start_month, 'end_month1' => $end_month, 'anio2' => $year, 'start_month2' => $start_month, 'end_month2' => $end_month, 'anio3' => $year, 'start_month3' => $start_month, 'end_month3' => $end_month, 'anio4' => $year, 'start_month4' => $start_month, 'end_month4' => $end_month]);
        return response()->json($resultado, 200);
    }

    public function getEstadisticasAnioAnterior(Request $request)
    {
        $model = new CDM;
        $year = $request['year'];
        $resultado = $model->getEstadisticasAnioAnterior($year);
        return response()->json(json_decode($resultado[0]['TX_Cobertura_Anual']), 200);
    }

    public function getListadoTipoIndicadores()
    {
        $model = new CDM;
        $resultado = $model->getListadoTipoIndicadores();
        return response()->json($resultado, 200);
    }

    public function getEstadisticasLocalidades(Request $request)
    {
        $fecha = $request['year'];
        $array_fecha = explode("-", $fecha);
        $year = isset($array_fecha[0]) ? $array_fecha[0] : $fecha;
        $periodo = isset($array_fecha[1]) ? $array_fecha[1] : null;
        $start_month = 1;
        $end_month = 12;

        if ($periodo == 'I') {
            $end_month = 5;
        } elseif ($periodo == 'II') {
            $start_month = 6;
        }
        $current_year = date('Y');
        if ($year == $current_year) {
            $sql = "SELECT 
            T.LOCALIDAD_LUGAR_ATENCION AS LOCALIDAD,
            COUNT(DISTINCT T.BENEFICIARIOS) AS BENEFICIARIOS,
            T.LINEA AS LINEA
            FROM
            (
            SELECT 
            SCA.FK_estudiante AS BENEFICIARIOS,
            'AE' AS LINEA,
            'CREA' AS PROGRAMA,
            CASE
            WHEN SC.IN_lugar_atencion=1 THEN PDCOL.VC_Descripcion
            WHEN SC.IN_lugar_atencion=2 THEN PDCREA.VC_Descripcion
            WHEN SC.IN_lugar_atencion=3 THEN PDCREA.VC_Descripcion
            WHEN SC.IN_lugar_atencion=4 THEN PDCREA.VC_Descripcion
            END AS LOCALIDAD_LUGAR_ATENCION
            FROM tb_terr_grupo_arte_escuela_sesion_clase SC
            JOIN tb_terr_grupo_arte_escuela_sesion_clase_asistencia SCA ON SC.PK_sesion_clase=SCA.FK_sesion_clase
            JOIN tb_colegios C ON SC.FK_colegio=C.PK_Id_Colegio
            JOIN tb_parametro_detalle PDCOL ON C.FK_Id_Localidad=PDCOL.FK_Value AND PDCOL.FK_Id_Parametro=19
            JOIN tb_clan CREA ON SC.FK_clan=CREA.PK_Id_Clan
            JOIN tb_parametro_detalle PDCREA ON CREA.FK_Id_Localidad=PDCREA.FK_Value AND PDCREA.FK_Id_Parametro=19
            WHERE SCA.IN_estado_asistencia=1 AND YEAR(SC.DA_fecha_clase)=:anio1 AND MONTH(SC.DA_fecha_clase)>=:start_month1 AND MONTH(SC.DA_fecha_clase)<=:end_month1 GROUP BY SCA.FK_estudiante
            UNION
            SELECT 
            SCA.FK_estudiante AS BENEFICIARIOS,
            'EC' AS LINEA,
            'CREA' AS PROGRAMA,
            PD.VC_Descripcion AS LOCALIDAD_LUGAR_ATENCION
            FROM tb_terr_grupo_emprende_clan_sesion_clase SC
            JOIN tb_terr_grupo_emprende_clan_sesion_clase_asistencia SCA ON SC.PK_sesion_clase=SCA.FK_sesion_clase
            JOIN tb_clan C ON SC.FK_clan=C.PK_Id_Clan
            JOIN tb_parametro_detalle PD ON C.FK_Id_Localidad=PD.FK_Value AND PD.FK_Id_Parametro=19
            WHERE SCA.IN_estado_asistencia=1 AND YEAR(SC.DA_fecha_clase)=:anio2 AND MONTH(SC.DA_fecha_clase)>=:start_month2 AND MONTH(SC.DA_fecha_clase)<=:end_month2 GROUP BY SCA.FK_estudiante
            UNION
            SELECT
            SCA.FK_estudiante AS BENEFICIARIOS,
            'LC' AS LINEA,
            'CREA' AS PROGRAMA,
            CASE
            WHEN SC.IN_Tipo_Ubicacion=1 THEN PDCREA.VC_Descripcion
            WHEN SC.IN_Tipo_Ubicacion=2 THEN PDALIADO.VC_Descripcion
            WHEN SC.IN_Tipo_Ubicacion=3 THEN PDCREA.VC_Descripcion
            WHEN SC.IN_Tipo_Ubicacion=4 THEN PDCREA.VC_Descripcion
            END AS LOCALIDAD_LUGAR_ATENCION
            FROM tb_terr_grupo_laboratorio_clan_sesion_clase SC
            JOIN tb_terr_grupo_laboratorio_clan GLC ON SC.FK_grupo=GLC.PK_Grupo
            JOIN tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia SCA ON SC.PK_sesion_clase=SCA.FK_sesion_clase
            JOIN tb_clan C ON SC.FK_clan=C.PK_Id_Clan
            JOIN tb_parametro_detalle PDCREA ON C.FK_Id_Localidad=PDCREA.FK_Value AND PDCREA.FK_Id_Parametro=19
            LEFT JOIN tb_terr_grupo_laboratorio_crea_aliado ALIADO ON GLC.FK_Aliado=ALIADO.PK_Id_Aliado
            LEFT JOIN tb_parametro_detalle PDALIADO ON ALIADO.FK_Localidad=PDALIADO.FK_Value AND PDALIADO.FK_Id_Parametro=19
            WHERE SCA.IN_estado_asistencia=1 AND YEAR(SC.DA_fecha_clase)=:anio3 AND MONTH(SC.DA_fecha_clase)>=:start_month3 AND MONTH(SC.DA_fecha_clase)<=:end_month3 GROUP BY SCA.FK_estudiante
            UNION
            SELECT 
            A.Fk_Id_Beneficiario AS BENEFICIARIOS,
            'NIDOS' AS LINEA,
            'NIDOS' AS PROGRAMA,
            PD.VC_Descripcion AS LOCALIDAD_LUGAR_ATENCION
            FROM tb_nidos_asistencia AS A
            JOIN tb_nidos_experiencia AS E ON E.Pk_Id_Experiencia=A.Fk_Id_Experiencia
            JOIN tb_nidos_lugar_atencion AS LA ON LA.Pk_Id_lugar_atencion=E.Fk_Id_Lugar_Atencion
            JOIN tb_parametro_detalle AS PD ON PD.FK_Value=LA.Fk_Id_Localidad AND PD.FK_Id_Parametro=19
            WHERE A.Vc_Asistencia=1 AND YEAR(E.DT_Fecha_Encuentro)=:anio4 AND MONTH(E.DT_Fecha_Encuentro)>=:start_month4 AND MONTH(E.DT_Fecha_Encuentro)<=:end_month4 GROUP BY A.Fk_Id_Beneficiario
            ) AS T GROUP BY T.LOCALIDAD_LUGAR_ATENCION, T.LINEA";
            $resultado = DB::select($sql, ['anio1' => $year,'start_month1' => $start_month,'end_month1' => $end_month,'anio2' => $year,'start_month2' => $start_month,'end_month2' => $end_month,'anio3' => $year,'start_month3' => $start_month,'end_month3' => $end_month,'anio4' => $year,'start_month4' => $start_month,'end_month4' => $end_month]);
            return response()->json($resultado, 200);
        } else {
            $model = new CDM;
            $resultado = $model->getEstadisticasAnioAnterior($fecha);
            return response()->json(json_decode($resultado[0]['TX_Cobertura_Localidad']), 200);
        }
    }

    public function getAlcanceCoberturaAnualCREA(Request $request){
        $fecha = $request['year'];
        $array_fecha = explode("-", $fecha);
        $year = isset($array_fecha[0]) ? $array_fecha[0] : $fecha;
        $periodo = isset($array_fecha[1]) ? $array_fecha[1] : null;
        $start_month = 1;
        $end_month = 12;

        if ($periodo == 'I') {
            $end_month = 5;
        } elseif ($periodo == 'II') {
            $start_month = 6;
        }
        $current_year = date('Y');
        if ($year == $current_year) {
            $sql = "SELECT
            SUM(T.INDICADOR) AS X, 
            JSON_UNQUOTE(JSON_EXTRACT(EA.TX_Meta_Cobertura_Anual_CREA, '$.Y')) AS Y
            FROM
            (
            SELECT 
            COUNT(DISTINCT(SCA.FK_estudiante)) AS 'INDICADOR'
            FROM tb_terr_grupo_arte_escuela_sesion_clase_asistencia AS SCA
            JOIN tb_terr_grupo_arte_escuela_sesion_clase AS SC ON SC.PK_sesion_clase=SCA.FK_sesion_clase
            WHERE YEAR(SC.DA_fecha_clase)=:anio1 AND MONTH(SC.DA_fecha_clase)>=:start_month1 AND MONTH(SC.DA_fecha_clase)<=:end_month1 AND SCA.IN_estado_asistencia=1
            UNION 
            SELECT 
            COUNT(DISTINCT(SCA.FK_estudiante)) AS 'INDICADOR'
            FROM tb_terr_grupo_emprende_clan_sesion_clase_asistencia AS SCA
            JOIN tb_terr_grupo_emprende_clan_sesion_clase AS SC ON SC.PK_sesion_clase=SCA.FK_sesion_clase
            WHERE YEAR(SC.DA_fecha_clase)=:anio2 AND MONTH(SC.DA_fecha_clase)>=:start_month2 AND MONTH(SC.DA_fecha_clase)<=:end_month2 AND SCA.IN_estado_asistencia=1
            UNION 
            SELECT 
            COUNT(DISTINCT(SCA.FK_estudiante)) AS 'INDICADOR'
            FROM tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia AS SCA
            JOIN tb_terr_grupo_laboratorio_clan_sesion_clase AS SC ON SC.PK_sesion_clase=SCA.FK_sesion_clase
            WHERE YEAR(SC.DA_fecha_clase)=:anio3 AND MONTH(SC.DA_fecha_clase)>=:start_month3 AND MONTH(SC.DA_fecha_clase)<=:end_month3 AND SCA.IN_estado_asistencia=1
            ) AS T
            JOIN tb_estadistica_anio EA ON EA.PK_Anio=:anio4;";
            $resultado = DB::select($sql, ['anio1' => $year,'start_month1' => $start_month,'end_month1' => $end_month,'anio2' => $year,'start_month2' => $start_month,'end_month2' => $end_month,'anio3' => $year,'start_month3' => $start_month,'end_month3' => $end_month, 'anio4' => "".$fecha]);
            return response()->json($resultado[0], 200);
        }
        else {
            $model = new CDM;
            $resultado = $model->getEstadisticasAnioAnterior($fecha);
            return response()->json(json_decode($resultado[0]['TX_Meta_Cobertura_Anual_CREA']), 200);
        }
    }
    
    public function getAlcanceCoberturaAnualNIDOS(Request $request){
        $fecha = $request['year'];
        $array_fecha = explode("-", $fecha);
        $year = isset($array_fecha[0]) ? $array_fecha[0] : $fecha;
        $periodo = isset($array_fecha[1]) ? $array_fecha[1] : null;
        $start_month = 1;
        $end_month = 12;

        if ($periodo == 'I') {
            $end_month = 5;
        } elseif ($periodo == 'II') {
            $start_month = 6;
        }
        $current_year = date('Y');
        if ($year == $current_year) {
            $sql = "SELECT 
            COUNT(DISTINCT Fk_Id_Beneficiario) AS 'X',
            JSON_UNQUOTE(JSON_EXTRACT(EA.TX_Meta_Cobertura_Anual_NIDOS, '$.Y')) AS Y
            FROM tb_nidos_experiencia EX
            JOIN tb_nidos_asistencia A ON A.Fk_Id_Experiencia=EX.Pk_Id_Experiencia
            JOIN tb_estadistica_anio EA ON EA.PK_Anio=:anio1
            WHERE Vc_Asistencia = 1 AND EX.IN_Aprobacion = 1 AND YEAR(EX.DT_Fecha_Encuentro)=:anio2 AND MONTH(EX.DT_Fecha_Encuentro)>=:start_month1 AND MONTH(EX.DT_Fecha_Encuentro)<=:end_month1;";
            $resultado = DB::select($sql, ['anio1' => "".$fecha,'start_month1' => $start_month,'end_month1' => $end_month,'anio2' => $year]);
            return response()->json($resultado[0], 200);
        }
        else {
            $model = new CDM;
            $resultado = $model->getEstadisticasAnioAnterior($fecha);
            return response()->json(json_decode($resultado[0]['TX_Meta_Cobertura_Anual_NIDOS']), 200);
        }
    }

    public function getVistaIndicadores()
    {
        return view("cdm.indicadores");
    }

    public function getIndicadores(Request $request){
        $model = new CDM;
        $seccion = $request['seccion'];
        $id_tipo_indicador = $request['id_tipo_indicador'];
        $year = $request['year'];
        $resultado = $model->getIndicadores($seccion, $id_tipo_indicador, $year);
        // return view('cdm.indicadores', compact('resultado'));
        return response()->json($resultado, 200);
        //return view("cdm.indicadores");
    }

    public function getFiltrosIndicadores(Request $request){
        $model = new CDM;
        $seccion = $request['seccion'];
        $id_tipo_indicador = $request['id_tipo_indicador'];
        $year = $request['year'];
        $resultado = $model->getFiltrosIndicadores($seccion, $id_tipo_indicador, $year);
        return response()->json($resultado, 200);
    }

    public function getProyectos(){
        $model = new tb_proyectos;
        $resultado = $model->all();
        return response()->json($resultado, 200);
    }

    public function saveProyecto(Request $request){
        $model = new tb_proyectos;
        $model->nombre = $request->nombre;
        $model->descripcion = $request->descripcion;
        $resultado = $model->save();
        return response()->json($resultado, 200);
    }

    public function updateProyecto(Request $request)
    {
        $model = new tb_proyectos;
        $resultado = $model->find($request->id);
        $resultado->nombre = $request->nombre;
        $resultado->descripcion = $request->descripcion;
        $result = $resultado->save();
        return response()->json($result, 200);
    }

    public function deleteProyecto(Request $request)
    {
        $indicadores = $this->getIndicadoresProyecto($request);
        if($indicadores == null){
            $model = new tb_proyectos;
            $resultado = $model->find($request->id);
            $result = $resultado->delete();
            return response()->json($result, 200);
        }
        else{
            return 0;
        }
    }

    public function saveIndicador(Request $request){
        $model = new CDM;
        $model->IN_seccion = $request->proyecto;
        $model->VC_titulo = $request->nombre;
        $model->FK_tipo_indicador = 8;
        $model->IN_Magnitud = $request->magnitud;
        $model->FK_unidad = $request->unidad;
        $model->VC_Tipo_Avance = $request->tipo_avance;
        $model->VC_tipo_grafico = $request->grafico;
        $model->TX_descripcion = $request->descripcion;
        $model->IN_estado = 1;
        $resultado = $model->save();
        return response()->json($resultado, 200);
    }

    public function updateIndicador(Request $request)
    {
        $model = new CDM;
        $resultado = $model->find($request->id);
        $resultado->VC_titulo = $request->nombre;
        $resultado->IN_magnitud = $request->magnitud;
        $resultado->FK_unidad = $request->unidad;
        $resultado->VC_Tipo_Avance = $request->tipo_avance;
        $resultado->VC_tipo_grafico = $request->grafico;
        $resultado->TX_descripcion = $request->descripcion;
        $result = $resultado->save();
        return response()->json($result, 200);
    }

    public function updateAvanceIndicador(Request $request)
    {
        $model = new CDM;
        $resultado = $model->find($request->id);
        $json_avance = null;
        if($resultado->TX_Avance != null){
            $json_avance = json_decode($resultado->TX_Avance, true);
        }
        $json_avance[$request->year][$request->mes] = $request->valor;
        $resultado->TX_Avance = json_encode($json_avance);
        //$request->year.'-'.$request->mes.'-'.$request->valor;
        $result = $resultado->save();
        return response()->json($result, 200);
    }

    public function deleteIndicador(Request $request)
    {
        $model = new CDM;
        $resultado = $model->find($request->id);
        $result = $resultado->delete();
        return response()->json($result, 200);
    }

    public function getIndicadoresProyecto(Request $request){
        $model = new CDM;
        $seccion = $request->seccion;
        $resultado = $model->getIndicadoresProyecto($seccion);
        return response()->json($resultado, 200);
    }

    public function getAvancesIndicador(Request $request){
        $model = new CDM;
        $indicador = $request->id_indicador;
        $resultado = $model::select('TX_Avance')->where('PK_id_centro_monitoreo',$indicador)->get();
        return response()->json($resultado[0], 200);
    }

    public function deleteAvanceIndicador(Request $request){
        $model = new CDM;
        $indicador = $request->id_indicador;
        $year = $request->year;
        $mes = $request->mes;
        $sqlSET = "UPDATE tb_centro_monitoreo SET TX_Avance = JSON_REMOVE(TX_Avance, '$.$year.$mes') WHERE PK_id_centro_monitoreo=$indicador;";
        $resultado = DB::statement($sqlSET);
        return response()->json($resultado, 200);
    }
}
