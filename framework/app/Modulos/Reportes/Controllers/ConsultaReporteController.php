<?php

namespace App\Modulos\Reportes\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Validator;
use App\Modulos\Reportes\Interfaces\ConsultaReporteInterface;
use App\Modulos\Grupos\GrupoLaboratorioClan;
use App\Modulos\Grupos\GrupoLaboratorioClanClase;
use App\Modulos\Grupos\GrupoArteEscuela;
use App\Modulos\Grupos\GrupoArteEscuelaSesionClase;
use App\Modulos\Grupos\GrupoEmprendeClan;
use App\Modulos\Grupos\GrupoEmprendeClanSesionClase;
use App\Modulos\Grupos\GrupoLaboratorioClanSesionClase;
use App\Modulos\Reportes\ReporteLineaAtencion;
use App\Modulos\Parametros\ParametroDetalles;
use App\Models\Colegio;

class ConsultaReporteController  extends Controller
{

    public function __construct(
        //ConsultaReporteInterface $consultaReporteRepository
    )
    {
        //  $this->consultaReporteRepository = $consultaReporteRepository;
    }

    public function index()
    {

        return view('Reportes.index_informeGestion');
    }

    /**
     * Medoto para generar reporte en PDF
     *
     * @return void
     */

    public function cargarPDF(Request $request)
    {
        $anio = $request->anio;
        $mes = $request->mes;
        $areasPrograma = DB::select("select A.AREA, B.CANTIDAD
        FROM (select PD.FK_Value AS ID, PD.VC_Descripcion AS AREA 
        FROM tb_parametro_detalle PD WHERE PD.FK_Id_Parametro=6 AND PD.IN_Estado=1) A 
        LEFT JOIN (select
        SC.FK_area_artistica AS AREA,
        COUNT(DISTINCT SC.FK_grupo) AS CANTIDAD
        FROM tb_terr_grupo_laboratorio_clan G
        JOIN tb_terr_grupo_laboratorio_clan_sesion_clase SC ON SC.FK_grupo=G.PK_Grupo
        WHERE
        YEAR(SC.DA_fecha_clase)='$anio'
        AND MONTH(SC.DA_fecha_clase)='$mes'
        GROUP BY AREA) B
        ON A.ID=B.AREA");
        $totalCreadosMesPrograma = GrupoLaboratorioClan::whereYear('tb_terr_grupo_laboratorio_clan.DT_fecha_creacion', $anio)->whereMonth('tb_terr_grupo_laboratorio_clan.DT_fecha_creacion', $mes)->count();
        $totalCerradosMesPrograma = GrupoLaboratorioClan::whereYear('tb_terr_grupo_laboratorio_clan.DT_fecha_cierre', $anio)->whereMonth('tb_terr_grupo_laboratorio_clan.DT_fecha_cierre', $mes)->count();
        $totalPrograma = DB::select("select sum(B.CANTIDAD) as cantidad FROM (select PD.FK_Value AS ID, PD.VC_Descripcion AS AREA FROM tb_parametro_detalle PD WHERE PD.FK_Id_Parametro=6 AND PD.IN_Estado=1) A LEFT JOIN (select SC.FK_area_artistica AS AREA, COUNT(DISTINCT SC.FK_grupo) AS CANTIDAD FROM tb_terr_grupo_laboratorio_clan G JOIN tb_terr_grupo_laboratorio_clan_sesion_clase SC ON SC.FK_grupo=G.PK_Grupo WHERE YEAR(SC.DA_fecha_clase)='$anio' AND MONTH(SC.DA_fecha_clase)='$mes' GROUP BY AREA) B ON A.ID=B.AREA");
        $coberturaTotalPrograma = DB::select("select COUNT(DISTINCT SCA.FK_estudiante) COBERTURA FROM tb_terr_grupo_laboratorio_clan_sesion_clase SC JOIN tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia SCA ON SCA.FK_sesion_clase=SC.PK_sesion_clase WHERE YEAR(SC.DA_fecha_clase)='$anio' AND MONTH(SC.DA_fecha_clase)='$mes' AND SCA.IN_estado_asistencia=1");
        $meses = array(
            array('nombre' => 'ENERO', 'codigo' => 1), array('nombre' => 'FEBRERO', 'codigo' => 2), array('nombre' => 'MARZO', 'codigo' => 3), array('nombre' => 'ABRIL', 'codigo' => 4),
            array('nombre' => 'MAYO', 'codigo' => 5), array('nombre' => 'JUNIO', 'codigo' => 6), array('nombre' => 'JULIO', 'codigo' => 7), array('nombre' => 'AGOSTO', 'codigo' => 8),
            array('nombre' => 'SEPTIEMBRE', 'codigo' => 9), array('nombre' => 'OCTUBRE', 'codigo' => 10), array('nombre' => 'NOVIEMBRE', 'codigo' => 11), array('nombre' => 'DICIEMBBRE', 'codigo' => 12)
        );
        foreach ($meses as $key => $temp) {
            $meses[$key]['atendidos'] = $this->atendidos($temp['codigo'], $anio);
            $meses[$key]['inscritos'] = $this->inscritos($temp['codigo'], $anio);
            $meses[$key]['porcentaje'] = $this->atendidos($temp['codigo'], $anio) > 0 ? round(($this->atendidos($temp['codigo'], $anio) / $this->inscritos($temp['codigo'], $anio)) * 100) : 0;
        }

        $acumuladoBeneficiariosAtendidosAnio = GrupoLaboratorioClanSesionClase::select(DB::raw('COUNT(DISTINCT tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia.FK_estudiante) as ATENDIDOS'))
            ->join('tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia', 'tb_terr_grupo_laboratorio_clan_sesion_clase.PK_sesion_clase', '=', 'tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia.FK_sesion_clase')
            ->whereYear('tb_terr_grupo_laboratorio_clan_sesion_clase.DA_fecha_clase', $anio)
            ->where('tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia.IN_estado_asistencia', 1)
            ->get();
        $acumuladoBeneficiariosInscritosAnio = GrupoLaboratorioClanSesionClase::select(DB::raw('COUNT(DISTINCT tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia.FK_estudiante) as INSCRITOS'))
            ->join('tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia', 'tb_terr_grupo_laboratorio_clan_sesion_clase.PK_sesion_clase', '=', 'tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia.FK_sesion_clase')
            ->whereYear('tb_terr_grupo_laboratorio_clan_sesion_clase.DA_fecha_clase', $anio)
            ->get();
        $porcentajeAcumuladoBeneficiarios = round(($acumuladoBeneficiariosAtendidosAnio[0]->ATENDIDOS / $acumuladoBeneficiariosInscritosAnio[0]->INSCRITOS) * 100);
        $porAreas = GrupoLaboratorioClan::select('tb_parametro_detalle.VC_Descripcion', 'tb_terr_grupo_laboratorio_clan.FK_area_artistica')
            ->join('tb_parametro_detalle', 'tb_terr_grupo_laboratorio_clan.FK_area_artistica', '=', 'tb_parametro_detalle.FK_Value')
            ->where('tb_parametro_detalle.FK_Id_Parametro', 6)
            ->groupBy('tb_parametro_detalle.VC_Descripcion', 'tb_terr_grupo_laboratorio_clan.FK_area_artistica')
            ->get();

        foreach ($porAreas as $key => $temp) {
            $porAreas[$key]->atendidos = $this->atendidosArea($temp['FK_area_artistica'], $anio, $mes);
            $porAreas[$key]->registrados = $this->inscritosArea($temp['FK_area_artistica'], $anio, $mes);
            $porAreas[$key]->porcentaje = $this->atendidosArea($temp['FK_area_artistica'], $anio, $mes) > 0 ? round(($this->atendidosArea($temp['FK_area_artistica'], $anio, $mes) / $this->inscritosArea($temp['FK_area_artistica'], $anio, $mes)) * 100) : 0;
            switch (true) {
                case ($temp->porcentaje > 80):
                    $porAreas[$key]->nivel_atencion = "ALTO";
                    break;
                case ($temp->porcentaje > 50 && $temp->porcentaje < 79):
                    $porAreas[$key]->nivel_atencion = "MEDIO";
                    break;
                case ($temp->porcentaje < 50):
                    $porAreas[$key]->nivel_atencion = "BAJO";
                    break;
            }
        }
        $sumaAtendidos = $porAreas->sum('atendidos');
        $sumaRegistrados = $porAreas->sum('registrados');
        $grafico1 = [2012, 2013, 2014, 2015, 2016];
        $observaciones = ReporteLineaAtencion::where('FK_parametro_detalle_linea', 1238)->where('FK_parametro_detalle_anio', $request->anioId)->where('FK_parametro_detalle_mes',  $request->mesId)->get()->last();
        $observacionesAll = ReporteLineaAtencion::where('FK_parametro_detalle_linea', 1238)->where('FK_parametro_detalle_anio', $request->anioId)->where('FK_parametro_detalle_mes',  $request->mesId)->get();
        if ($request->filtro == 1) {
            $pdf = [
                'areas' => $areasPrograma,
                'totalCreadosMesPrograma' => $totalCreadosMesPrograma,
                'totalCerradosMesPrograma' => $totalCerradosMesPrograma,
                'totalPrograma' => $totalPrograma[0]->cantidad,
                'coberturaTotalPrograma' => $coberturaTotalPrograma[0]->COBERTURA,
                'meses' => $meses,
                'acumuladoBeneficiariosAtendidosAnio' => $acumuladoBeneficiariosAtendidosAnio[0]->ATENDIDOS,
                'acumuladoBeneficiariosInscritosAnio' => $acumuladoBeneficiariosInscritosAnio[0]->INSCRITOS,
                'porcentajeAcumuladoBeneficiarios' => $porcentajeAcumuladoBeneficiarios,
                'porAreas' => $porAreas,
                'sumaAtendidos' => $sumaAtendidos,
                'sumaRegistrados' => $sumaRegistrados,
                'grafico1' => $grafico1,
                'observaciones' => $observaciones != null ? $observaciones->tx_observacion : null,
                'fecha_observacion' => $observaciones != null ? date('Y-m-d', strtotime($observaciones->created_at)) : null,
            ];
            return $pdf;
        }
        if ($request->filtro == 2) {
            $pdf = \PDF::loadView('reportes.pdf.report', [
                'areas' => $areasPrograma,
                'totalCreadosMesPrograma' => $totalCreadosMesPrograma,
                'totalCerradosMesPrograma' => $totalCerradosMesPrograma,
                'totalPrograma' => $totalPrograma[0]->cantidad,
                'coberturaTotalPrograma' => $coberturaTotalPrograma[0]->COBERTURA,
                'meses' => $meses,
                'acumuladoBeneficiariosAtendidosAnio' => $acumuladoBeneficiariosAtendidosAnio[0]->ATENDIDOS,
                'acumuladoBeneficiariosInscritosAnio' => $acumuladoBeneficiariosInscritosAnio[0]->INSCRITOS,
                'porcentajeAcumuladoBeneficiarios' => $porcentajeAcumuladoBeneficiarios,
                'porAreas' => $porAreas,
                'sumaAtendidos' => $sumaAtendidos,
                'sumaRegistrados' => $sumaRegistrados,
                'grafico1' => $grafico1,
                'bar' => $request->bar,
                'pie' => $request->pie,
                'nombrePrograma' => 'CONVERGE CREA',
                'nombreMes' => $mes,
                'nombreAnio' => $anio,
                'pie' => $request->pie,
                'observaciones' => $observaciones != null ? $observaciones->tx_observacion : null,
                'fecha_observacion' => $observaciones != null ? date('Y-m-d', strtotime($observaciones->created_at)) : null,
                'observacionesAll' => $observacionesAll

            ])->setPaper('a4', 'landscape');
            return $pdf->stream('report.pdf');
        }
    }
    public function atendidos_inscritos(Request $request)
    {
        $anio = $request->anio;
        $mes = $request->mes;

        $porAreas = GrupoLaboratorioClan::select('tb_parametro_detalle.VC_Descripcion', 'tb_terr_grupo_laboratorio_clan.FK_area_artistica')
            ->join('tb_parametro_detalle', 'tb_terr_grupo_laboratorio_clan.FK_area_artistica', '=', 'tb_parametro_detalle.FK_Value')
            ->where('tb_parametro_detalle.FK_Id_Parametro', 6)
            ->groupBy('tb_parametro_detalle.VC_Descripcion', 'tb_terr_grupo_laboratorio_clan.FK_area_artistica')
            ->get();
        foreach ($porAreas as $key => $temp) {
            $porAreas[$key]->atendidos = $this->atendidosArea($temp['FK_area_artistica'], $anio, $mes);
            $porAreas[$key]->registrados = $this->inscritosArea($temp['FK_area_artistica'], $anio, $mes);
        }
        return ["data" => $porAreas];
    }
    public function cargarPDFImpulso(Request $request)
    {
        $anio = $request->anio;
        $mes = $request->mes;
        $areasImpulso = DB::select("
        select A.AREA, B.CANTIDAD AS MO, D.CANTIDAD AS SE 
        FROM (select PD.FK_Value AS ID, PD.VC_Descripcion AS AREA 
        FROM tb_parametro_detalle PD WHERE PD.FK_Id_Parametro=6 AND PD.IN_Estado=1) A 
        LEFT JOIN (select SC.FK_area_artistica AS AREA, 
        COUNT(DISTINCT SC.FK_grupo) AS CANTIDAD 
        FROM tb_terr_grupo_emprende_clan G
        JOIN tb_terr_grupo_emprende_clan_sesion_clase SC ON SC.FK_grupo=G.PK_Grupo
        WHERE YEAR(SC.DA_fecha_clase)='$anio' 
        AND MONTH(SC.DA_fecha_clase)='$mes' 
        AND (G.tipo_grupo = 2 
        OR G.tipo_grupo = 'Emprende - Subete a la escena'
        OR G.tipo_grupo = 'Súbete a la escena') GROUP BY AREA) B
        ON A.ID=B.AREA LEFT JOIN (SELECT SC.FK_area_artistica AS AREA, 
        COUNT(DISTINCT SC.FK_grupo) AS CANTIDAD 
        FROM tb_terr_grupo_emprende_clan G 
        JOIN tb_terr_grupo_emprende_clan_sesion_clase SC ON SC.FK_grupo=G.PK_Grupo
        WHERE YEAR(SC.DA_fecha_clase)='$anio' 
        AND MONTH(SC.DA_fecha_clase)='$mes' 
        AND (G.tipo_grupo = 1 OR G.tipo_grupo = 'Emprende - Manos a la obra' OR G.tipo_grupo = 'Manos a la obra') GROUP BY AREA) D ON A.ID=D.AREA");

        $totalCreadosMesImpulso = GrupoEmprendeClan::whereYear('tb_terr_grupo_emprende_clan.DT_fecha_creacion', $anio)->whereMonth('tb_terr_grupo_emprende_clan.DT_fecha_creacion', $mes)->count();
        $totalCerradosMesImpulso = GrupoEmprendeClan::whereYear('tb_terr_grupo_emprende_clan.DT_fecha_cierre', $anio)->whereMonth('tb_terr_grupo_emprende_clan.DT_fecha_cierre', $mes)->count();
        $totalImpulso = DB::select("select sum(B.CANTIDAD) + sum(D.CANTIDAD) AS cantidad FROM (select PD.FK_Value AS ID, PD.VC_Descripcion AS AREA FROM tb_parametro_detalle PD WHERE PD.FK_Id_Parametro=6 AND PD.IN_Estado=1) A LEFT JOIN (select SC.FK_area_artistica AS AREA,COUNT(DISTINCT SC.FK_grupo) AS CANTIDAD FROM tb_terr_grupo_emprende_clan G JOIN tb_terr_grupo_emprende_clan_sesion_clase SC ON SC.FK_grupo=G.PK_Grupo WHERE YEAR(SC.DA_fecha_clase)='$anio' AND MONTH(SC.DA_fecha_clase)='$mes' AND (G.tipo_grupo = 2 OR G.tipo_grupo = 'Emprende - Subete a la escena' OR G.tipo_grupo = 'Súbete a la escena') GROUP BY AREA) B ON A.ID=B.AREA LEFT JOIN (SELECT SC.FK_area_artistica AS AREA, COUNT(DISTINCT SC.FK_grupo) AS CANTIDAD FROM tb_terr_grupo_emprende_clan G JOIN tb_terr_grupo_emprende_clan_sesion_clase SC ON SC.FK_grupo=G.PK_Grupo WHERE YEAR(SC.DA_fecha_clase)='$anio' AND MONTH(SC.DA_fecha_clase)='$mes' AND (G.tipo_grupo = 1 OR G.tipo_grupo = 'Emprende - Manos a la obra' OR G.tipo_grupo = 'Manos a la obra') GROUP BY AREA) D ON A.ID=D.AREA");
        $coberturaTotalImpulso = DB::select("select COUNT(DISTINCT SCA.FK_estudiante) COBERTURA FROM tb_terr_grupo_emprende_clan_sesion_clase SC JOIN tb_terr_grupo_emprende_clan_sesion_clase_asistencia SCA ON SCA.FK_sesion_clase=SC.PK_sesion_clase WHERE YEAR(SC.DA_fecha_clase)='$anio' AND MONTH(SC.DA_fecha_clase)='$mes' AND SCA.IN_estado_asistencia=1");
        $meses = array(
            array('nombre' => 'ENERO', 'codigo' => 1), array('nombre' => 'FEBRERO', 'codigo' => 2), array('nombre' => 'MARZO', 'codigo' => 3), array('nombre' => 'ABRIL', 'codigo' => 4),
            array('nombre' => 'MAYO', 'codigo' => 5), array('nombre' => 'JUNIO', 'codigo' => 6), array('nombre' => 'JULIO', 'codigo' => 7), array('nombre' => 'AGOSTO', 'codigo' => 8),
            array('nombre' => 'SEPTIEMBRE', 'codigo' => 9), array('nombre' => 'OCTUBRE', 'codigo' => 10), array('nombre' => 'NOVIEMBRE', 'codigo' => 11), array('nombre' => 'DICIEMBBRE', 'codigo' => 12)
        );
        foreach ($meses as $key => $temp) {
            $meses[$key]['atendidos'] = $this->atendidosImpulso($temp['codigo'], $anio);
            $meses[$key]['inscritos'] = $this->inscritosImpulso($temp['codigo'], $anio);
            $meses[$key]['porcentaje'] = $this->atendidosImpulso($temp['codigo'], $anio) > 0 ? round(($this->atendidosImpulso($temp['codigo'], $anio) / $this->inscritosImpulso($temp['codigo'], $anio)) * 100) : 0;
        }
        $acumuladoBeneficiariosAtendidosAnio = GrupoEmprendeClanSesionClase::select(DB::raw('COUNT(DISTINCT tb_terr_grupo_emprende_clan_sesion_clase_asistencia.FK_estudiante) as ATENDIDOS'))
            ->join('tb_terr_grupo_emprende_clan_sesion_clase_asistencia', 'tb_terr_grupo_emprende_clan_sesion_clase.PK_sesion_clase', '=', 'tb_terr_grupo_emprende_clan_sesion_clase_asistencia.FK_sesion_clase')
            ->whereYear('tb_terr_grupo_emprende_clan_sesion_clase.DA_fecha_clase', $anio)
            ->where('tb_terr_grupo_emprende_clan_sesion_clase_asistencia.IN_estado_asistencia', 1)
            ->get();

        $acumuladoBeneficiariosInscritosAnio = GrupoEmprendeClanSesionClase::select(DB::raw('COUNT(DISTINCT tb_terr_grupo_emprende_clan_sesion_clase_asistencia.FK_estudiante) as INSCRITOS'))
            ->join('tb_terr_grupo_emprende_clan_sesion_clase_asistencia', 'tb_terr_grupo_emprende_clan_sesion_clase.PK_sesion_clase', '=', 'tb_terr_grupo_emprende_clan_sesion_clase_asistencia.FK_sesion_clase')
            ->whereYear('tb_terr_grupo_emprende_clan_sesion_clase.DA_fecha_clase', $anio)
            ->get();
        $porcentajeAcumuladoBeneficiarios = round(($acumuladoBeneficiariosAtendidosAnio[0]->ATENDIDOS / $acumuladoBeneficiariosInscritosAnio[0]->INSCRITOS) * 100);
        $porAreas = GrupoEmprendeClan::select('tb_parametro_detalle.VC_Descripcion', 'tb_terr_grupo_emprende_clan.FK_area_artistica')
            ->join('tb_parametro_detalle', 'tb_terr_grupo_emprende_clan.FK_area_artistica', '=', 'tb_parametro_detalle.FK_Value')
            ->where('tb_parametro_detalle.FK_Id_Parametro', 6)
            ->groupBy('tb_parametro_detalle.VC_Descripcion', 'tb_terr_grupo_emprende_clan.FK_area_artistica')
            ->get();
        foreach ($porAreas as $key => $temp) {
            $porAreas[$key]->atendidos = $this->atendidosAreaImpulso($temp['FK_area_artistica'], $anio, $mes);
            $porAreas[$key]->registrados = $this->inscritosAreaImpulso($temp['FK_area_artistica'], $anio, $mes);
            $porAreas[$key]->porcentaje = $this->atendidosAreaImpulso($temp['FK_area_artistica'], $anio, $mes) > 0 ? round(($this->atendidosAreaImpulso($temp['FK_area_artistica'], $anio, $mes) / $this->inscritosAreaImpulso($temp['FK_area_artistica'], $anio, $mes)) * 100) : 0;
            switch (true) {
                case ($temp->porcentaje > 80):
                    $porAreas[$key]->nivel_atencion = "ALTO";
                    break;
                case ($temp->porcentaje > 50 && $temp->porcentaje < 79):
                    $porAreas[$key]->nivel_atencion = "MEDIO";
                    break;
                case ($temp->porcentaje < 50):
                    $porAreas[$key]->nivel_atencion = "BAJO";
                    break;
            }
        }
        $sumaAtendidos = $porAreas->sum('atendidos');
        $sumaRegistrados = $porAreas->sum('registrados');
        $grafico1 = [2012, 2013, 2014, 2015, 2016];
        $observaciones = ReporteLineaAtencion::where('FK_parametro_detalle_linea', 1237)->where('FK_parametro_detalle_anio', $request->anioId)->where('FK_parametro_detalle_mes', $request->mesId)->get()->last();
        $observacionesAll = ReporteLineaAtencion::where('FK_parametro_detalle_linea', 1237)->where('FK_parametro_detalle_anio', $request->anioId)->where('FK_parametro_detalle_mes', $request->mesId)->get();
        if ($request->filtro == 1) {
            $pdf = [
                'areas' => $areasImpulso,
                'totalCreadosMesImpulso' => $totalCreadosMesImpulso,
                'totalCerradosMesImpulso' => $totalCerradosMesImpulso,
                'totalImpulso' => $totalImpulso[0]->cantidad,
                'coberturaTotalImpulso' => $coberturaTotalImpulso[0]->COBERTURA,
                'meses' => $meses,
                'acumuladoBeneficiariosAtendidosAnio' => $acumuladoBeneficiariosAtendidosAnio[0]->ATENDIDOS,
                'acumuladoBeneficiariosInscritosAnio' => $acumuladoBeneficiariosInscritosAnio[0]->INSCRITOS,
                'porcentajeAcumuladoBeneficiarios' => $porcentajeAcumuladoBeneficiarios,
                'porAreas' => $porAreas,
                'sumaAtendidos' => $sumaAtendidos,
                'sumaRegistrados' => $sumaRegistrados,
                'grafico1' => $grafico1,
                'observaciones' => $observaciones != null ? $observaciones->tx_observacion : null,
                'fecha_observacion' => $observaciones != null ? date('Y-m-d', strtotime($observaciones->created_at)) : null,
            ];
            return $pdf;
        }
        if ($request->filtro == 2) {
            $pdf = \PDF::loadView('reportes.pdf.reportImpulso', [
                'areas' => $areasImpulso,
                'totalCreadosMesImpulso' => $totalCreadosMesImpulso,
                'totalCerradosMesImpulso' => $totalCerradosMesImpulso,
                'totalImpulso' => $totalImpulso[0]->cantidad,
                'coberturaTotalImpulso' => $coberturaTotalImpulso[0]->COBERTURA,
                'meses' => $meses,
                'acumuladoBeneficiariosAtendidosAnio' => $acumuladoBeneficiariosAtendidosAnio[0]->ATENDIDOS,
                'acumuladoBeneficiariosInscritosAnio' => $acumuladoBeneficiariosInscritosAnio[0]->INSCRITOS,
                'porcentajeAcumuladoBeneficiarios' => $porcentajeAcumuladoBeneficiarios,
                'porAreas' => $porAreas,
                'sumaAtendidos' => $sumaAtendidos,
                'sumaRegistrados' => $sumaRegistrados,
                'grafico1' => $grafico1,
                'bar' => $request->bar,
                'pie' => $request->pie,
                'nombrePrograma' => 'IMPULSO COLECTIVO',
                'nombreMes' => $mes,
                'nombreAnio' => $anio,
                'observaciones' => $observaciones != null ? $observaciones->tx_observacion : null,
                'fecha_observacion' => $observaciones != null ? date('Y-m-d', strtotime($observaciones->created_at)) : null,
                'observacionesAll' => $observacionesAll
            ])->setPaper('a4', 'landscape');
            return $pdf->stream('reportImpulso.pdf');
        }
    }
    public function atendidos($mes, $anio)
    {
        $data = GrupoLaboratorioClanSesionClase::select('tb_terr_grupo_laboratorio_clan_sesion_clase.FK_area_artistica', DB::raw('COUNT(DISTINCT tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia.FK_estudiante) as ATENDIDOS'))
            ->join('tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia', 'tb_terr_grupo_laboratorio_clan_sesion_clase.PK_sesion_clase', '=', 'tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia.FK_sesion_clase')
            ->whereYear('tb_terr_grupo_laboratorio_clan_sesion_clase.DA_fecha_clase', $anio)
            ->whereMonth('tb_terr_grupo_laboratorio_clan_sesion_clase.DA_fecha_clase', $mes)
            ->where('tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia.IN_estado_asistencia', 1)
            ->groupBy('tb_terr_grupo_laboratorio_clan_sesion_clase.FK_area_artistica')
            ->get();
        $resultado = count($data) > 0 ? $data->sum('ATENDIDOS') : 0;
        return $resultado;
    }
    public function inscritos($mes, $anio)
    {
        $data = GrupoLaboratorioClanSesionClase::select('tb_terr_grupo_laboratorio_clan_sesion_clase.FK_area_artistica', DB::raw('COUNT(DISTINCT tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia.FK_estudiante) as INSCRITOS'))
            ->join('tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia', 'tb_terr_grupo_laboratorio_clan_sesion_clase.PK_sesion_clase', '=', 'tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia.FK_sesion_clase')
            ->whereYear('tb_terr_grupo_laboratorio_clan_sesion_clase.DA_fecha_clase', $anio)
            ->whereMonth('tb_terr_grupo_laboratorio_clan_sesion_clase.DA_fecha_clase', $mes)
            ->groupBy('tb_terr_grupo_laboratorio_clan_sesion_clase.FK_area_artistica')
            ->get();
        $resultado = count($data) > 0 ? $data->sum('INSCRITOS') : 0;
        return $resultado;
    }
    public function atendidosArea($area, $anio, $mes)
    {
        $data = GrupoLaboratorioClanSesionClase::select('tb_terr_grupo_laboratorio_clan_sesion_clase.FK_area_artistica', DB::raw('COUNT(DISTINCT tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia.FK_estudiante) as ATENDIDOS'))
            ->join('tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia', 'tb_terr_grupo_laboratorio_clan_sesion_clase.PK_sesion_clase', '=', 'tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia.FK_sesion_clase')
            ->whereYear('tb_terr_grupo_laboratorio_clan_sesion_clase.DA_fecha_clase', $anio)
            ->whereMonth('tb_terr_grupo_laboratorio_clan_sesion_clase.DA_fecha_clase', $mes)
            ->where('tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia.IN_estado_asistencia', 1)
            ->where('tb_terr_grupo_laboratorio_clan_sesion_clase.FK_area_artistica', $area)
            ->groupBy('tb_terr_grupo_laboratorio_clan_sesion_clase.FK_area_artistica')
            ->get();
        $resultado = count($data) > 0 ? $data->sum('ATENDIDOS') : 0;
        return $resultado;
    }
    public function inscritosArea($area, $anio, $mes)
    {
        $data = GrupoLaboratorioClanSesionClase::select('tb_terr_grupo_laboratorio_clan_sesion_clase.FK_area_artistica', DB::raw('COUNT(DISTINCT tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia.FK_estudiante) as INSCRITOS'))
            ->join('tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia', 'tb_terr_grupo_laboratorio_clan_sesion_clase.PK_sesion_clase', '=', 'tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia.FK_sesion_clase')
            ->whereYear('tb_terr_grupo_laboratorio_clan_sesion_clase.DA_fecha_clase', $anio)
            ->whereMonth('tb_terr_grupo_laboratorio_clan_sesion_clase.DA_fecha_clase', $mes)
            ->where('tb_terr_grupo_laboratorio_clan_sesion_clase.FK_area_artistica', $area)
            ->groupBy('tb_terr_grupo_laboratorio_clan_sesion_clase.FK_area_artistica')
            ->get();
        $resultado = count($data) > 0 ? $data->sum('INSCRITOS') : 0;
        return $resultado;
    }

    public function atendidosImpulso($mes, $anio)
    {
        $data = GrupoEmprendeClanSesionClase::select('tb_terr_grupo_emprende_clan_sesion_clase.FK_area_artistica', DB::raw('COUNT(DISTINCT tb_terr_grupo_emprende_clan_sesion_clase_asistencia.FK_estudiante) as ATENDIDOS'))
            ->join('tb_terr_grupo_emprende_clan_sesion_clase_asistencia', 'tb_terr_grupo_emprende_clan_sesion_clase.PK_sesion_clase', '=', 'tb_terr_grupo_emprende_clan_sesion_clase_asistencia.FK_sesion_clase')
            ->whereYear('tb_terr_grupo_emprende_clan_sesion_clase.DA_fecha_clase', $anio)
            ->whereMonth('tb_terr_grupo_emprende_clan_sesion_clase.DA_fecha_clase', $mes)
            ->where('tb_terr_grupo_emprende_clan_sesion_clase_asistencia.IN_estado_asistencia', 1)
            ->groupBy('tb_terr_grupo_emprende_clan_sesion_clase.FK_area_artistica')
            ->get();
        $resultado = count($data) > 0 ? $data->sum('ATENDIDOS') : 0;
        return $resultado;
    }
    public function inscritosImpulso($mes, $anio)
    {
        $data = GrupoEmprendeClanSesionClase::select('tb_terr_grupo_emprende_clan_sesion_clase.FK_area_artistica', DB::raw('COUNT(DISTINCT tb_terr_grupo_emprende_clan_sesion_clase_asistencia.FK_estudiante) as INSCRITOS'))
            ->join('tb_terr_grupo_emprende_clan_sesion_clase_asistencia', 'tb_terr_grupo_emprende_clan_sesion_clase.PK_sesion_clase', '=', 'tb_terr_grupo_emprende_clan_sesion_clase_asistencia.FK_sesion_clase')
            ->whereYear('tb_terr_grupo_emprende_clan_sesion_clase.DA_fecha_clase', $anio)
            ->whereMonth('tb_terr_grupo_emprende_clan_sesion_clase.DA_fecha_clase', $mes)
            ->groupBy('tb_terr_grupo_emprende_clan_sesion_clase.FK_area_artistica')
            ->get();
        $resultado = count($data) > 0 ? $data->sum('INSCRITOS') : 0;
        return $resultado;
    }

    public function atendidosAreaImpulso($area, $anio, $mes)
    {
        $data = GrupoEmprendeClanSesionClase::select('tb_terr_grupo_emprende_clan_sesion_clase.FK_area_artistica', DB::raw('COUNT(DISTINCT tb_terr_grupo_emprende_clan_sesion_clase_asistencia.FK_estudiante) as ATENDIDOS'))
            ->leftjoin('tb_terr_grupo_emprende_clan_sesion_clase_asistencia', 'tb_terr_grupo_emprende_clan_sesion_clase.PK_sesion_clase', '=', 'tb_terr_grupo_emprende_clan_sesion_clase_asistencia.FK_sesion_clase')
            ->whereYear('tb_terr_grupo_emprende_clan_sesion_clase.DA_fecha_clase', $anio)
            ->whereMonth('tb_terr_grupo_emprende_clan_sesion_clase.DA_fecha_clase', $mes)
            ->where('tb_terr_grupo_emprende_clan_sesion_clase_asistencia.IN_estado_asistencia', 1)
            ->where('tb_terr_grupo_emprende_clan_sesion_clase.FK_area_artistica', $area)
            ->groupBy('tb_terr_grupo_emprende_clan_sesion_clase.FK_area_artistica')
            ->get();
        $resultado = count($data) > 0 ? $data->sum('ATENDIDOS') : 0;
        return $resultado;
    }
    public function inscritosAreaImpulso($area, $anio, $mes)
    {
        $data = GrupoEmprendeClanSesionClase::select('tb_terr_grupo_emprende_clan_sesion_clase.FK_area_artistica', DB::raw('COUNT(DISTINCT tb_terr_grupo_emprende_clan_sesion_clase_asistencia.FK_estudiante) as INSCRITOS'))
            ->join('tb_terr_grupo_emprende_clan_sesion_clase_asistencia', 'tb_terr_grupo_emprende_clan_sesion_clase.PK_sesion_clase', '=', 'tb_terr_grupo_emprende_clan_sesion_clase_asistencia.FK_sesion_clase')
            ->whereYear('tb_terr_grupo_emprende_clan_sesion_clase.DA_fecha_clase', $anio)
            ->whereMonth('tb_terr_grupo_emprende_clan_sesion_clase.DA_fecha_clase', $mes)
            ->where('tb_terr_grupo_emprende_clan_sesion_clase.FK_area_artistica', $area)
            ->groupBy('tb_terr_grupo_emprende_clan_sesion_clase.FK_area_artistica')
            ->get();
        $resultado = count($data) > 0 ? $data->sum('INSCRITOS') : 0;
        return $resultado;
    }

    public function atendidos_inscritos_impulso(Request $request)
    {
        $anio = $request->anio;
        $mes = $request->mes;
        $porAreas = GrupoEmprendeClan::select('tb_parametro_detalle.VC_Descripcion', 'tb_terr_grupo_emprende_clan.FK_area_artistica')
            ->join('tb_parametro_detalle', 'tb_terr_grupo_emprende_clan.FK_area_artistica', '=', 'tb_parametro_detalle.FK_Value')
            ->where('tb_parametro_detalle.FK_Id_Parametro', 6)
            ->groupBy('tb_parametro_detalle.VC_Descripcion', 'tb_terr_grupo_emprende_clan.FK_area_artistica')
            ->get();

        foreach ($porAreas as $key => $temp) {
            $porAreas[$key]->atendidos = $this->atendidosAreaImpulso($temp['FK_area_artistica'], $anio, $mes);
            $porAreas[$key]->registrados = $this->inscritosAreaImpulso($temp['FK_area_artistica'], $anio, $mes);
        }
        return ["data" => $porAreas];
    }

    public function cargarPDFEscuela(Request $request)
    {
        $anio = $request->anio;
        $mes = $request->mes;
        $colegio = $request->colegio;
        $areasPrograma = DB::select("select A.AREA, B.CANTIDAD 
        FROM (select PD.FK_Value AS ID, PD.VC_Descripcion AS AREA 
        FROM tb_parametro_detalle PD WHERE PD.FK_Id_Parametro=6 AND PD.IN_Estado=1) A 
        LEFT JOIN (select
        SC.FK_area_artistica AS AREA,
        COUNT(DISTINCT SC.FK_grupo) AS CANTIDAD
        FROM tb_terr_grupo_arte_escuela G
        JOIN tb_terr_grupo_arte_escuela_sesion_clase SC ON SC.FK_grupo=G.PK_Grupo
        WHERE
        YEAR(SC.DA_fecha_clase)='$anio'
        AND MONTH(SC.DA_fecha_clase)='$mes'
        AND SC.FK_colegio = '$request->colegio'
        GROUP BY AREA) B
        ON A.ID=B.AREA");  
        $totalCreadosMesPrograma = GrupoArteEscuela::whereYear('tb_terr_grupo_arte_escuela.DT_fecha_creacion', $anio)->whereMonth('tb_terr_grupo_arte_escuela.DT_fecha_creacion', $mes)->where('tb_terr_grupo_arte_escuela.FK_colegio', $colegio)->count();
        $totalCerradosMesPrograma = GrupoArteEscuela::whereYear('tb_terr_grupo_arte_escuela.DT_fecha_cierre', $anio)->whereMonth('tb_terr_grupo_arte_escuela.DT_fecha_cierre', $mes)->where('tb_terr_grupo_arte_escuela.FK_colegio', $colegio)->count();
        $totalPrograma = DB::select("select sum(B.CANTIDAD) as cantidad FROM (select PD.FK_Value AS ID, PD.VC_Descripcion AS AREA FROM tb_parametro_detalle PD WHERE PD.FK_Id_Parametro=6 AND PD.IN_Estado=1) A LEFT JOIN (select SC.FK_area_artistica AS AREA, COUNT(DISTINCT SC.FK_grupo) AS CANTIDAD FROM tb_terr_grupo_arte_escuela G JOIN tb_terr_grupo_arte_escuela_sesion_clase SC ON SC.FK_grupo=G.PK_Grupo WHERE YEAR(SC.DA_fecha_clase)='$anio' AND MONTH(SC.DA_fecha_clase)='$mes' AND SC.FK_colegio = '$request->colegio' GROUP BY AREA) B ON A.ID=B.AREA");
        $coberturaTotalPrograma = DB::select("select COUNT(DISTINCT SCA.FK_estudiante) COBERTURA FROM tb_terr_grupo_arte_escuela_sesion_clase SC JOIN tb_terr_grupo_arte_escuela_sesion_clase_asistencia SCA ON SCA.FK_sesion_clase=SC.PK_sesion_clase WHERE YEAR(SC.DA_fecha_clase)='$anio' AND MONTH(SC.DA_fecha_clase)='$mes' AND SC.FK_colegio = '$request->colegio' AND SCA.IN_estado_asistencia=1");
        $meses = array(
            array('nombre' => 'ENERO', 'codigo' => 1), array('nombre' => 'FEBRERO', 'codigo' => 2), array('nombre' => 'MARZO', 'codigo' => 3), array('nombre' => 'ABRIL', 'codigo' => 4),
            array('nombre' => 'MAYO', 'codigo' => 5), array('nombre' => 'JUNIO', 'codigo' => 6), array('nombre' => 'JULIO', 'codigo' => 7), array('nombre' => 'AGOSTO', 'codigo' => 8),
            array('nombre' => 'SEPTIEMBRE', 'codigo' => 9), array('nombre' => 'OCTUBRE', 'codigo' => 10), array('nombre' => 'NOVIEMBRE', 'codigo' => 11), array('nombre' => 'DICIEMBBRE', 'codigo' => 12)
        );
        foreach ($meses as $key => $temp) {
            $meses[$key]['atendidos'] = $this->atendidosEscuela($temp['codigo'], $anio, $request->colegio);
            $meses[$key]['inscritos'] = $this->inscritosEscuela($temp['codigo'], $anio, $request->colegio);
            $meses[$key]['porcentaje'] = $this->atendidosEscuela($temp['codigo'], $anio, $request->colegio) > 0 ? round(($this->atendidosEscuela($temp['codigo'], $anio, $request->colegio) / $this->inscritosEscuela($temp['codigo'], $anio, $request->colegio)) * 100) : 0;
        }

        $acumuladoBeneficiariosAtendidosAnio = GrupoArteEscuelaSesionClase::select(DB::raw('COUNT(DISTINCT tb_terr_grupo_arte_escuela_sesion_clase_asistencia.FK_estudiante) as ATENDIDOS'))
            ->join('tb_terr_grupo_arte_escuela_sesion_clase_asistencia', 'tb_terr_grupo_arte_escuela_sesion_clase.PK_sesion_clase', '=', 'tb_terr_grupo_arte_escuela_sesion_clase_asistencia.FK_sesion_clase')
            ->whereYear('tb_terr_grupo_arte_escuela_sesion_clase.DA_fecha_clase', $anio)
            ->where('tb_terr_grupo_arte_escuela_sesion_clase_asistencia.IN_estado_asistencia', 1)
            ->where('tb_terr_grupo_arte_escuela_sesion_clase.FK_colegio', $request->colegio)
            ->get();
        $acumuladoBeneficiariosInscritosAnio = GrupoArteEscuelaSesionClase::select(DB::raw('COUNT(DISTINCT tb_terr_grupo_arte_escuela_sesion_clase_asistencia.FK_estudiante) as INSCRITOS'))
            ->join('tb_terr_grupo_arte_escuela_sesion_clase_asistencia', 'tb_terr_grupo_arte_escuela_sesion_clase.PK_sesion_clase', '=', 'tb_terr_grupo_arte_escuela_sesion_clase_asistencia.FK_sesion_clase')
            ->whereYear('tb_terr_grupo_arte_escuela_sesion_clase.DA_fecha_clase', $anio)
            ->where('tb_terr_grupo_arte_escuela_sesion_clase.FK_colegio', $request->colegio)
            ->get();
        $porcentajeAcumuladoBeneficiarios = round(($acumuladoBeneficiariosAtendidosAnio[0]->ATENDIDOS / $acumuladoBeneficiariosInscritosAnio[0]->INSCRITOS) * 100);
        $porAreas = GrupoArteEscuela::select('tb_parametro_detalle.VC_Descripcion', 'tb_terr_grupo_arte_escuela.FK_area_artistica')
            ->join('tb_parametro_detalle', 'tb_terr_grupo_arte_escuela.FK_area_artistica', '=', 'tb_parametro_detalle.FK_Value')
            ->where('tb_parametro_detalle.FK_Id_Parametro', 6)
            ->groupBy('tb_parametro_detalle.VC_Descripcion', 'tb_terr_grupo_arte_escuela.FK_area_artistica')
            ->get();
        foreach ($porAreas as $key => $temp) {
            $porAreas[$key]->atendidos = $this->atendidosAreaEscuela($temp['FK_area_artistica'], $anio, $mes, $request->colegio);
            $porAreas[$key]->registrados = $this->inscritosAreaEscuela($temp['FK_area_artistica'], $anio, $mes, $request->colegio);
            $porAreas[$key]->porcentaje = $this->atendidosAreaEscuela($temp['FK_area_artistica'], $anio, $mes, $request->colegio) > 0 ? round(($this->atendidosAreaEscuela($temp['FK_area_artistica'], $anio, $mes, $request->colegio) / $this->inscritosAreaEscuela($temp['FK_area_artistica'], $anio, $mes, $request->colegio)) * 100) : 0;
            switch (true) {
                case ($temp->porcentaje > 80):
                    $porAreas[$key]->nivel_atencion = "ALTO";
                    break;
                case ($temp->porcentaje > 50 && $temp->porcentaje < 79):
                    $porAreas[$key]->nivel_atencion = "MEDIO";
                    break;
                case ($temp->porcentaje < 50):
                    $porAreas[$key]->nivel_atencion = "BAJO";
                    break;
            }
        }
        $sumaAtendidos = $porAreas->sum('atendidos');
        $sumaRegistrados = $porAreas->sum('registrados');
        $grafico1 = [2012, 2013, 2014, 2015, 2016];
        $observaciones = ReporteLineaAtencion::where('FK_colegio', $request->colegio)->where('FK_parametro_detalle_linea', 1236)->where('FK_parametro_detalle_anio', $request->anioId)->where('FK_parametro_detalle_mes', $request->mesId)->get()->last();
        $observacionesAll = ReporteLineaAtencion::where('FK_colegio', $request->colegio)->where('FK_parametro_detalle_linea', 1236)->where('FK_parametro_detalle_anio', $request->anioId)->where('FK_parametro_detalle_mes', $request->mesId)->get();
        if ($request->filtro === "1") {
            $pdf = [
                'areas' => $areasPrograma,
                'totalCreadosMesPrograma' => $totalCreadosMesPrograma,
                'totalCerradosMesPrograma' => $totalCerradosMesPrograma,
                'totalPrograma' => $totalPrograma[0]->cantidad,
                'coberturaTotalPrograma' => $coberturaTotalPrograma[0]->COBERTURA,
                'meses' => $meses,
                'acumuladoBeneficiariosAtendidosAnio' => $acumuladoBeneficiariosAtendidosAnio[0]->ATENDIDOS,
                'acumuladoBeneficiariosInscritosAnio' => $acumuladoBeneficiariosInscritosAnio[0]->INSCRITOS,
                'porcentajeAcumuladoBeneficiarios' => $porcentajeAcumuladoBeneficiarios,
                'porAreas' => $porAreas,
                'sumaAtendidos' => $sumaAtendidos,
                'sumaRegistrados' => $sumaRegistrados,
                'grafico1' => $grafico1,
                'observaciones' => $observaciones != null ? $observaciones->tx_observacion : null,
                'fecha_observacion' => $observaciones != null ? date('Y-m-d', strtotime($observaciones->created_at)) : null,
            ];
            return $pdf;
        }
        if ($request->filtro === "2") {
            $pdf = \PDF::loadView('reportes.pdf.report', [
                'areas' => $areasPrograma,
                'totalCreadosMesPrograma' => $totalCreadosMesPrograma,
                'totalCerradosMesPrograma' => $totalCerradosMesPrograma,
                'totalPrograma' => $totalPrograma[0]->cantidad,
                'coberturaTotalPrograma' => $coberturaTotalPrograma[0]->COBERTURA,
                'meses' => $meses,
                'acumuladoBeneficiariosAtendidosAnio' => $acumuladoBeneficiariosAtendidosAnio[0]->ATENDIDOS,
                'acumuladoBeneficiariosInscritosAnio' => $acumuladoBeneficiariosInscritosAnio[0]->INSCRITOS,
                'porcentajeAcumuladoBeneficiarios' => $porcentajeAcumuladoBeneficiarios,
                'porAreas' => $porAreas,
                'sumaAtendidos' => $sumaAtendidos,
                'sumaRegistrados' => $sumaRegistrados,
                'grafico1' => $grafico1,
                'bar' => $request->bar,
                'pie' => $request->pie,
                'nombrePrograma' => 'ARTE EN LA ESCUELA',
                'nombreMes' => $mes,
                'nombreAnio' => $anio,
                'nombreColegio' => $request->nombreColegio,
                'observaciones' => $observaciones != null ? $observaciones->tx_observacion : null,
                'fecha_observacion' => $observaciones != null ? date('Y-m-d', strtotime($observaciones->created_at)) : null,
                'observacionesAll' => $observacionesAll

            ])->setPaper('a4', 'landscape');
            return $pdf->stream('report.pdf');
        }
    }
    public function cargarColegios(Request $request)
    {
        $data = Colegio::select(DB::raw('DISTINCT tb_colegios.PK_Id_Colegio'), 'tb_colegios.VC_Nom_Colegio')->join('tb_terr_grupo_arte_escuela_sesion_clase', 'tb_terr_grupo_arte_escuela_sesion_clase.FK_colegio', '=', 'tb_colegios.PK_Id_Colegio')
            ->whereYear('tb_terr_grupo_arte_escuela_sesion_clase.DA_fecha_clase', $request->anio)
            ->whereMonth('tb_terr_grupo_arte_escuela_sesion_clase.DA_fecha_clase', $request->mes)
            ->get();
        return ["datos" => $data];
    }
    public function atendidosEscuela($mes, $anio, $colegio)
    {
        $data = GrupoArteEscuelaSesionClase::select('tb_terr_grupo_arte_escuela_sesion_clase.FK_area_artistica', DB::raw('COUNT(DISTINCT tb_terr_grupo_arte_escuela_sesion_clase_asistencia.FK_estudiante) as ATENDIDOS'))
        ->join('tb_terr_grupo_arte_escuela_sesion_clase_asistencia', 'tb_terr_grupo_arte_escuela_sesion_clase.PK_sesion_clase', '=', 'tb_terr_grupo_arte_escuela_sesion_clase_asistencia.FK_sesion_clase')
        ->whereYear('tb_terr_grupo_arte_escuela_sesion_clase.DA_fecha_clase', $anio)
        ->whereMonth('tb_terr_grupo_arte_escuela_sesion_clase.DA_fecha_clase', $mes)
        ->where('tb_terr_grupo_arte_escuela_sesion_clase_asistencia.IN_estado_asistencia', 1)
        ->where('tb_terr_grupo_arte_escuela_sesion_clase.FK_colegio', $colegio)
        ->get();
        $resultado = count($data) > 0 ? $data->sum('ATENDIDOS') : 0;
        return $resultado;
    }
    public function inscritosEscuela($mes, $anio, $colegio)
    {
        $data = GrupoArteEscuelaSesionClase::select('tb_terr_grupo_arte_escuela_sesion_clase.FK_area_artistica', DB::raw('COUNT(DISTINCT tb_terr_grupo_arte_escuela_sesion_clase_asistencia.FK_estudiante) as INSCRITOS'))
        ->join('tb_terr_grupo_arte_escuela_sesion_clase_asistencia', 'tb_terr_grupo_arte_escuela_sesion_clase.PK_sesion_clase', '=', 'tb_terr_grupo_arte_escuela_sesion_clase_asistencia.FK_sesion_clase')
        ->whereYear('tb_terr_grupo_arte_escuela_sesion_clase.DA_fecha_clase', $anio)
        ->whereMonth('tb_terr_grupo_arte_escuela_sesion_clase.DA_fecha_clase', $mes)
        ->where('tb_terr_grupo_arte_escuela_sesion_clase.FK_colegio', $colegio)
        ->get();
        $resultado = count($data) > 0 ? $data->sum('INSCRITOS') : 0;
        return $resultado;
    }
    public function atendidosAreaEscuela($area, $anio, $mes, $colegio)
    {
        $data = GrupoArteEscuelaSesionClase::select('tb_terr_grupo_arte_escuela_sesion_clase.FK_area_artistica', DB::raw('COUNT(DISTINCT tb_terr_grupo_arte_escuela_sesion_clase_asistencia.FK_estudiante) as ATENDIDOS'))
        ->join('tb_terr_grupo_arte_escuela_sesion_clase_asistencia', 'tb_terr_grupo_arte_escuela_sesion_clase.PK_sesion_clase', '=', 'tb_terr_grupo_arte_escuela_sesion_clase_asistencia.FK_sesion_clase')
        ->whereYear('tb_terr_grupo_arte_escuela_sesion_clase.DA_fecha_clase', $anio)
        ->whereMonth('tb_terr_grupo_arte_escuela_sesion_clase.DA_fecha_clase', $mes)
        ->where('tb_terr_grupo_arte_escuela_sesion_clase_asistencia.IN_estado_asistencia', 1)
        ->where('tb_terr_grupo_arte_escuela_sesion_clase.FK_area_artistica', $area)
        ->where('tb_terr_grupo_arte_escuela_sesion_clase.FK_colegio', $colegio)
        ->get();
        $resultado = count($data) > 0 ? $data->sum('ATENDIDOS') : 0;
        return $resultado;
    }
    public function inscritosAreaEscuela($area, $anio, $mes, $colegio)
    {
        $data = GrupoArteEscuelaSesionClase::select('tb_terr_grupo_arte_escuela_sesion_clase.FK_area_artistica', DB::raw('COUNT(DISTINCT tb_terr_grupo_arte_escuela_sesion_clase_asistencia.FK_estudiante) as INSCRITOS'))
        ->join('tb_terr_grupo_arte_escuela_sesion_clase_asistencia', 'tb_terr_grupo_arte_escuela_sesion_clase.PK_sesion_clase', '=', 'tb_terr_grupo_arte_escuela_sesion_clase_asistencia.FK_sesion_clase')
        ->whereYear('tb_terr_grupo_arte_escuela_sesion_clase.DA_fecha_clase', $anio)
        ->whereMonth('tb_terr_grupo_arte_escuela_sesion_clase.DA_fecha_clase', $mes)
        ->where('tb_terr_grupo_arte_escuela_sesion_clase.FK_area_artistica', $area)
        ->where('tb_terr_grupo_arte_escuela_sesion_clase.FK_colegio', $colegio)
        ->get();
        $resultado = count($data) > 0 ? $data->sum('INSCRITOS') : 0;
        return $resultado;
    }
    public function atendidos_inscritos_escuela(Request $request)
    {
        $anio = $request->anio;
        $mes = $request->mes;
        $porAreas = GrupoArteEscuela::select('tb_parametro_detalle.VC_Descripcion', 'tb_terr_grupo_arte_escuela.FK_area_artistica')
        ->join('tb_parametro_detalle', 'tb_terr_grupo_arte_escuela.FK_area_artistica', '=', 'tb_parametro_detalle.FK_Value')
        ->where('tb_parametro_detalle.FK_Id_Parametro', 6)
        ->groupBy('tb_parametro_detalle.VC_Descripcion', 'tb_terr_grupo_arte_escuela.FK_area_artistica')
        ->get();
        foreach ($porAreas as $key => $temp) {
            $porAreas[$key]->atendidos = $this->atendidosAreaEscuela($temp['FK_area_artistica'], $anio, $mes, $request->colegio);
            $porAreas[$key]->registrados = $this->inscritosAreaEscuela($temp['FK_area_artistica'], $anio, $mes, $request->colegio);
        }
        return ["data" => $porAreas];
    }
    
    public function guardarObservacion(Request $request) {
        
        $data = new ReporteLineaAtencion();
        $data->FK_parametro_detalle_linea = $request->FK_parametro_detalle_linea;
        $data->FK_colegio = $request->FK_colegio;
        $data->FK_parametro_detalle_anio = $request->FK_parametro_detalle_anio;
        $data->FK_parametro_detalle_mes = $request->FK_parametro_detalle_mes;
        $data->tx_observacion = $request->tx_observacion;
        $data->save();
        return ['almacenado' => true];
        
    }
    
    public function observaciones_linea(Request $request) {
        
        if($request->lineaAtencion == 1236)
        {
            $data = ReporteLineaAtencion::where('FK_colegio', $request->colegio)->where('FK_parametro_detalle_linea', $request->lineaAtencion)->where('FK_parametro_detalle_anio', $request->anio)->where('FK_parametro_detalle_mes', $request->mes)->get();
            return ['data' => $data];
        }
        else
        {
            $data = ReporteLineaAtencion::where('FK_parametro_detalle_linea', $request->lineaAtencion)->where('FK_parametro_detalle_anio', $request->anio)->where('FK_parametro_detalle_mes', $request->mes)->get();
            return ['data' => $data];
        }
    }
    public function cargarAniosMeses()
    {
        $anios = ParametroDetalles::select('tb_parametro_detalle.PK_Id_Tabla', 'tb_parametro_detalle.VC_Descripcion')
            ->where('tb_parametro_detalle.FK_Id_Parametro',7)
            ->get();
        $meses = ParametroDetalles::select('tb_parametro_detalle.PK_Id_Tabla', 'tb_parametro_detalle.VC_Descripcion', 'tb_parametro_detalle.FK_Value')
            ->where('tb_parametro_detalle.FK_Id_Parametro',8)
            ->get();
        return ["anios" => $anios, "meses" => $meses];
    }
    public function getConvenios() {
        dd(33);
    }
}
