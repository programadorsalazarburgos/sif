<?php

namespace App\Http\Controllers\crea;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Beneficiario;
use App\Models\BeneficiarioAdicionales;
use App\Models\ArteEscuelaEstudiante;
use App\Models\EmprendeClanEstudiante;
use App\Models\LaboratorioClanEstudiante;
use App\Models\BeneficiarioArchivo;
use App\Models\Colegio;

class BeneficiariosController extends Controller
{
    public function getBeneficiarios(Request $request) {    
        set_time_limit(0);
        $model = new Beneficiario;
        $result = $model->getBeneficiariosCirterio($request['criterio_busqueda'], $request['opcion_busqueda']);
        return response()->json(json_decode($result), 200);
    }

    public function getInformacionBeneficiario(Request $request) {
        $model = new Beneficiario;
        $result = $model->getBeneficiario($request['id']);
        $result->DA_Fecha_Registro = date('d/m/Y h:i A', strtotime($result->DA_Fecha_Registro));
        switch($result->CH_Genero) {
            case 'F':
                $result->CH_Genero = "Femenino";
            break;

            case 'M':
                $result->CH_Genero = "Masculino";
            break;
            
            default:
            $result->CH_Genero = "Desconocido";
            break;
        }

        return response()->json(json_decode($result), 200);
    }

    public function getInformacionAniosAdicionalBeneficiario(Request $request) {
        $model = new BeneficiarioAdicionales;
        $result = $model->getAniosAdicional($request['FK_Id_Estudiante']);
        return response()->json(json_decode($result), 200);
    }

    public function getInformacionAdicionalBeneficiario(Request $request) {
        $model = new BeneficiarioAdicionales;
        $result = $model->getDataBeneficiarioxAnio($request['id_estudiante'], $request['anio']);
        return response()->json(json_decode($result), 200);
    }

    public function getInformacionGrupoAnio(Request $request) {
        $modelAE = new ArteEscuelaEstudiante;
        $resultAE = $modelAE->getDataGrupoAnio($request['id_estudiante'], $request['anio']);

        $modelEC = new EmprendeClanEstudiante;
        $resultEC = $modelEC->getDataGrupoAnio($request['id_estudiante'], $request['anio']);

        $modelLC = new LaboratorioClanEstudiante;
        $resultLC = $modelLC->getDataGrupoAnio($request['id_estudiante'], $request['anio']);

        $parcial = $resultAE->mergeRecursive($resultEC);
        $merged = $parcial->mergeRecursive($resultLC);
        return response()->json(json_decode($merged), 200);
    }

    public function getAniosDocumentosBeneficiario(Request $request) {
        $model = new BeneficiarioArchivo;
        $result = $model->getAniosDocumentos($request['FK_Id_Estudiante']);
        return response()->json(json_decode($result), 200);
    }

    public function getDocumentosBeneficiarioAnio(Request $request) {
        $model = new BeneficiarioArchivo;
        $result = $model->getDocumentosBeneficiario($request['id_estudiante'], $request['anio']);
        return response()->json(json_decode($result), 200);
    }

    public function getInformacionAdicionalesActual(Request $request) {
        $model = new BeneficiarioAdicionales;
        $result = $model->getInfoBeneficiarioAnio($request['id_estudiante'], $request['anio']);
        return response()->json(json_decode($result), 200);
    }

    public function GetInfoColegios() {
        $model = new Colegio;
        $result = $model->GetOptionsColegios();
        return response()->json(json_decode($result), 200);
    }

    public function GuardarBeneficiario(Request $request) {
        $model = new Beneficiario;
        $toChange = array(
            'VC_Celular' => $request['celular'],
            'VC_Correo' => strtoupper($request['correo']),
            'VC_Direccion' => strtoupper($request['direccion']),
            'DD_F_Nacimiento' => $request['fecha_nacimiento'],
            'CH_Tipo_Identificacion' => $request['id_tipo_documento'],
            'VC_Primer_Apellido' => strtoupper($request['primer_apellido']),
            'VC_Primer_Nombre' => strtoupper($request['primer_nombre']),
            'VC_Segundo_Apellido' => strtoupper($request['segundo_apellido']),
            'VC_Segundo_Nombre' => strtoupper($request['segundo_nombre']),
            'VC_Telefono' => $request['telefono'],
            'IN_Acepta_Uso_Imagen' => $request['acepta_uso_imagen'],
            'IN_Acepta_Uso_Obras' => $request['acepta_uso_obras'],
            'IN_Acepta_Uso_Datos' => $request['acepta_uso_datos'],
            'IN_Identificacion' => $request['numero_documento'],
        );
        /*if($request['numero_documento'] != $request['old_numero_documento'] && $model->ValidaDocumentoBeneficiario($request['numero_documento'])) {
            $rta = false;
        } else {*/
            $model->actualizarBeneficiario($request['id'], $toChange, $request['id_usuario']);
            $rta = true;
        //}
        return response()->json($rta, 200);
    }

    public function GuardarAdicionalesBeneficiario(Request $request) {
        $model = new BeneficiarioAdicionales;
        $toChange = array();
        foreach($request['datosAdicionales'] as $nombre => $valor) {
            if(!is_array($valor)) {
                $toChange[$nombre] = strtoupper($valor);
            } else {
                $toChange[$nombre] = strtoupper($valor["value"]);
            }
        }
        return response()->json($model->guardarAdicionalesBeneficiario($request['id'], $request['anio'], $toChange, $request['id_persona']), 200);
    }

    public function GuardarArchivosBeneficiario(Request $request) {
        $elements = array();
        if($request->hasFile('documentoIdentificacion'))
            $elements['documento_identificacion'] = $request['documentoIdentificacion'];
        if($request->hasFile('certificadoEPS'))
            $elements['eps'] = $request['certificadoEPS'];
        if($request->hasFile('reciboPublico'))
            $elements['recibo_publico'] = $request['reciboPublico'];
        if($request->hasFile('usoImagen'))
            $elements['permiso_uso_imagen'] = $request['usoImagen'];

        $backtrace = debug_backtrace()[1];
        $rutaBase = substr($backtrace['file'],0, strpos($backtrace['file'],'framework'));
        $carpeta = $rutaBase.'uploadedFiles/documentosEstudiantes/'.$request['anio'].'/'.$request['id'].'/';
        $url_archivo = "documentosEstudiantes/".$request['anio'].'/'.$request['id'];
        $model = new BeneficiarioArchivo;
        if (!is_dir($carpeta) && !mkdir($carpeta, 0777, true)){
            return false;
        }
        try {
            foreach($elements as $dbKey => $file) {
                $nombreArchivo = $dbKey.".".$file->getClientOriginalExtension();
                $model->deleteDocumentoxAnio($request['id'], $request['anio'], $dbKey);
                $file->storeAs($url_archivo, $nombreArchivo, 'uploadedfiles');
                $datos = array(
                    'FK_Id_Estudiante' => $request['id'],
                    'VC_Nombre_Archivo' => $nombreArchivo,
                    'VC_Url' => $url_archivo."/".$nombreArchivo,
                    'DA_Fecha_Subida' => date('Y-m-d H:i:s'),
                    'FK_Usuario_Creacion' => $request['id_persona'],
                    'Anio' => $request['anio']
                );
                $model->saveDocumentoxAnio($datos);
            }
            return true;
        } catch(Exception $e) {
            return false;
        }
    }
}
