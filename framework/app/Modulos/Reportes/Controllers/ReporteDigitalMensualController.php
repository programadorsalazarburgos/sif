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
use ZipArchive;

class ReporteDigitalMensualController  extends Controller
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

    public function getConvenios(Request $request)
    {
        $linea_atencion = $request->lineaAtencion == 1 ? 'arte_escuela' : ($request->lineaAtencion == 2 ? 'laboratorio_clan' : 'emprende_clan');
        $sql = DB::select("select PD.VC_Descripcion AS 'text', PD.FK_Value AS 'value'
        FROM tb_terr_grupo_" . $linea_atencion . " G
        JOIN tb_parametro_detalle PD ON PD.FK_Value=G.IN_convenio AND PD.FK_Id_Parametro=68
        WHERE YEAR(G.DT_fecha_creacion)='$request->anio'
        GROUP BY G.IN_convenio");
        echo json_encode($sql);
    }
    public function getColegios(Request $request)
    {
        $sql = DB::select("select COL.VC_Nom_Colegio as 'text', COL.PK_Id_Colegio AS 'value'
        FROM tb_terr_grupo_arte_escuela G
        JOIN tb_colegios COL ON COL.PK_Id_Colegio=G.FK_colegio
        WHERE G.IN_convenio='$request->convenio' AND YEAR(G.DT_fecha_creacion)='$request->anio'
        GROUP BY COL.PK_Id_Colegio
        ORDER BY VC_Nom_Colegio");
        echo json_encode($sql);
    }
    public function getDataReporte(Request $request)
    {
        $parametro = $request->anio . '-' . $request->mes;
        $linea_atencion = $request->lineaAtencion == 1 ? 'arte_escuela' : ($request->lineaAtencion == 2 ? 'laboratorio_clan' : 'emprende_clan');
        $sql = DB::select("select IMG.id,FK_grupo,
        IMG.linea_atencion,
        IMG.VC_fecha_reporte,
        IMG.DT_fecha_creacion,
        IMG.SM_estado,
        JSON_VALUE(TX_json,'$.datos_basicos.nombre_artista') AS nombre_artista,
        JSON_VALUE(TX_json,'$.datos_basicos.nombre_grupo') AS nombre_grupo,
        JSON_VALUE(TX_json,'$.datos_basicos.id_organizacion') AS id_organizacion,
        JSON_VALUE(TX_json,'$.datos_basicos.id_usuario') AS id_usuario,
        IMG.DT_fecha_aprobacion,
        G.FK_colegio
        FROM tb_terr_informe_mensual_grupo IMG
        JOIN tb_terr_grupo_arte_escuela G ON G.PK_Grupo=IMG.FK_grupo
        WHERE IMG.linea_atencion = '$linea_atencion' AND IMG.VC_fecha_reporte LIKE '%$parametro%' AND G.IN_Convenio=$request->convenio AND SM_estado=1 AND G.FK_colegio = $request->colegioId ORDER BY IMG.DT_fecha_creacion DESC");
        if ($request->tipoReporte == 1) {
            return ['data' => $sql];
        }
        if ($request->tipoReporte == 2) {
            if (count($sql) > 0) {
                foreach ($sql as $key => $temp) {
                    $temp->pagos = $this->generarDocumentos($temp->FK_grupo, $temp->id_usuario, $temp->nombre_artista, $request->colegioNombre, $temp->nombre_grupo, $request->anio, $request->mes);
                    $sql[$key] = $temp;
                }
            } else {
                echo json_encode(false);
            }
        }
    }
    public function generarDocumentos($FK_grupo, $idUsuario, $artista, $colegio, $nombre_grupo, $anio, $mes)
    {
        $data = GrupoArteEscuelaSesionClase::select(
            'FK_grupo',
            'DA_fecha_clase',
            'DT_fecha_creacion_registro',
            'IN_horas_clase',
            'FK_usuario',
            'FK_organizacion',
            'TX_observaciones',
            'suplencia',
            'FK_clan',
            'VC_Nom_Clan',
            'FK_colegio',
            'VC_Nom_Colegio',
            'FK_area_artistica',
            'IN_lugar_atencion',
            'IN_Modalidad_Atencion',
            'IN_Tipo_Atencion',
            'IN_Material',
            'tipo_grupo',
            'hora_inicio',
            'hora_fin',
            'FK_salon',
            'VC_anexo'
        )->with("areaArtistica:FK_Value,VC_Descripcion")
            ->where('FK_grupo', $FK_grupo)
            ->where('FK_usuario', $idUsuario)
            ->whereYear("tb_terr_grupo_arte_escuela_sesion_clase.DA_fecha_clase", "=", $anio)
            ->whereMonth('tb_terr_grupo_arte_escuela_sesion_clase.DA_fecha_clase', $mes)
            ->whereNotNull('VC_anexo')->get();
        if (count($data) > 0) {
            $zip = new ZipArchive();
            $zipGrupo = new ZipArchive();
            $archivoGrupo = $idUsuario . "2021.zip";
            $zipColegio = new ZipArchive();
            $zip = new ZipArchive();
            $filename = $colegio . ".zip";

            if ($zip->open($filename, ZipArchive::CREATE) !== TRUE) {
                exit("cannot open <$filename>\n");
            }
            foreach ($data as $row) {
                $anexo = substr($row['VC_anexo'], 35, 500);
                $nombreAnexo = str_replace("/", "_", $anexo);
                if ("AE-" . $row['FK_grupo'] == $nombre_grupo) {
                    $zip->addFile("../uploadedFiles/" . $row['VC_anexo'], $row['areaArtistica']['VC_Descripcion'] . '/' . $row['FK_grupo']  . '/' . $row['DA_fecha_clase']  .  '/'  . $nombreAnexo);
                }
            }
            $zip->close();

            $headers = [
                'Content-Type' => 'application/pdf',
            ];
            return response()->download($filename, 'filename.pdf', $headers);
        } else {
            return ['data' => false];
        }
    }
    public function deleteColegioZip(Request $request)
    {
        $path = "../../sif/framework/".$request->colegio;
        if (unlink($path)) {
        }
    }
    public function consultarJSONReporte(Request $request){
        $sql = DB::select("select IMG.id,IMG.TX_json,IMG.TX_observaciones_json,IMG.SM_estado, ED.TX_Firma_Escaneada FROM tb_terr_informe_mensual_grupo IMG LEFT JOIN tb_persona_extra_data ED ON IMG.FK_persona_reporte=ED.FK_Id_Persona WHERE id='$request->id_informe'");
        echo json_encode($sql);
        
    }
}
