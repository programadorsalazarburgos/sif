<?php

namespace App\Http\Controllers\culturas\territorial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\culturas\territorial\ReporteMetasCuantitativas;
use App\Models\Persona;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailTemplateCulturas;

class TerritorialController extends Controller
{
    public function viewReporteMetasCuantitativas(){
    	return view('culturas/territorial.reporteMetasCuantitativas');
    }
    public function saveReporteMetasCuantitativas(Request $request){
        $reporte = new ReporteMetasCuantitativas;
        $objeto = json_decode($request->formulario);
        $reporte->in_mes = $objeto->SL_MES->value;
        $reporte->tx_nombre_actividad = $objeto->TX_NOMBRE_ACTIVIDAD;
        $reporte->tx_descripcion_actividad = $objeto->TX_DESCRIPCION_ACTIVIDAD;
        $reporte->da_fecha_inicio = $objeto->TX_FECHA_INICIO;
        $reporte->da_fecha_fin = $objeto->TX_FECHA_FIN;
        $reporte->fk_usuario = $objeto->id_persona;
        $elements = array();
        if($request->hasFile('anexos')){
            $elements['anexos'] = $request['anexos'];
        }
        foreach($objeto as $key => $val) {
            if($key == "SL_MES" || $key == "TX_NOMBRE_ACTIVIDAD" || $key == "TX_DESCRIPCION_ACTIVIDAD" || $key == "TX_FECHA_INICIO" || $key == "TX_FECHA_FIN" || $key == "id_persona")
            {
                unset($objeto->$key);
            }
          }
        $reporte->json_formulario = json_encode($objeto);
        $backtrace = debug_backtrace()[1];
        $rutaBase = substr($backtrace['file'],0, strpos($backtrace['file'],'framework'));
        $anio = substr($reporte->da_fecha_inicio,0,4);
        $id_reporte = $reporte->getAutoIncrementId();
        $carpeta = $rutaBase.'uploadedFiles/documentosCulturas/Territorial/ReporteCuantitativodeMetas/'.$anio.'/'.$id_reporte.'/';
        $url_archivo = "documentosCulturas/Territorial/ReporteCuantitativodeMetas/".$anio.'/'.$id_reporte;
        if (!is_dir($carpeta) && !mkdir($carpeta, 0777, true)){
            return false;
        }
        try {
            foreach($elements as $dbKey => $file) {
                $nombreArchivo = $file->getClientOriginalName();
                //$model->deleteDocumentoxAnio($id, $anio, $nombreArchivo);
                $file->storeAs($url_archivo, $nombreArchivo, 'uploadedfiles');
                $reporte->url_anexos = $url_archivo."/".$nombreArchivo;
                $reporte->save();
                if(!$reporte){
                    App::abort(500, 'Error');
                }
                else{
                    $usuariosRol = Persona::where('FK_Tipo_Persona',42)->get();
                    foreach($usuariosRol as $usuario) {
                        $datosUsuario = Persona::find($usuario->PK_Id_Persona);
                        $datos = new \stdClass();
                        $datos->nombre = $datosUsuario->VC_Primer_Nombre." ".$datosUsuario->VC_Primer_Apellido;
                        $datos->correo = $datosUsuario->VC_Correo;
                        $datos->subject = "Nuevo Reporte Cuantitativo de Metas";
                        $datos->contenido_html = "<p>Se ha registrado un nuevo Reporte Cuantitativo de Metas.<br><br><strong>Actividad: </strong>".$reporte->tx_nombre_actividad.".<br><strong>Descripción: </strong>".$reporte->tx_descripcion_actividad.".<br><strong>Fecha Inicio: </strong>".$reporte->da_fecha_inicio."<br><strong>Fecha Fin: </strong>".$reporte->da_fecha_fin.". <br><br>Acceda al SIF para revisarlo.</p>";
                        Mail::to($datos->correo)->send(new EmailTemplateCulturas($datos));
                    }
                    return response()->json($reporte, 200);
                }
            }
        } catch(Exception $e) {
            return false;
        }
    }

    public function updateReporteMetasCuantitativas(Request $request){
        $reporte = ReporteMetasCuantitativas::find($request->id_reporte);

        $objeto = json_decode($request->formulario);
        $reporte->in_mes = $objeto->SL_MES->value;
        $reporte->tx_nombre_actividad = $objeto->TX_NOMBRE_ACTIVIDAD;
        $reporte->tx_descripcion_actividad = $objeto->TX_DESCRIPCION_ACTIVIDAD;
        $reporte->da_fecha_inicio = $objeto->TX_FECHA_INICIO;
        $reporte->da_fecha_fin = $objeto->TX_FECHA_FIN;
        $reporte->fk_usuario = $objeto->id_persona;
        $reporte->in_estado = null;
        $elements = array();
        if($request->hasFile('anexos')){
            $elements['anexos'] = $request['anexos'];
        }
        foreach($objeto as $key => $val) {
            if($key == "SL_MES" || $key == "TX_NOMBRE_ACTIVIDAD" || $key == "TX_DESCRIPCION_ACTIVIDAD" || $key == "TX_FECHA_INICIO" || $key == "TX_FECHA_FIN" || $key == "id_persona")
            {
                unset($objeto->$key);
            }
          }
        $reporte->json_formulario = json_encode($objeto);
        $backtrace = debug_backtrace()[1];
        $rutaBase = substr($backtrace['file'],0, strpos($backtrace['file'],'framework'));
        $anio = substr($reporte->da_fecha_inicio,0,4);
        $id_reporte = $request->id_reporte;
        $carpeta = $rutaBase.'uploadedFiles/documentosCulturas/Territorial/ReporteCuantitativodeMetas/'.$anio.'/'.$id_reporte.'/';
        $url_archivo = "documentosCulturas/Territorial/ReporteCuantitativodeMetas/".$anio.'/'.$id_reporte;
        if (!is_dir($carpeta) && !mkdir($carpeta, 0777, true)){
            return false;
        }
        try {
            foreach($elements as $dbKey => $file) {
                $nombreArchivo = $file->getClientOriginalName();
                //$model->deleteDocumentoxAnio($id, $anio, $nombreArchivo);
                $file->storeAs($url_archivo, $nombreArchivo, 'uploadedfiles');
                $reporte->url_anexos = $url_archivo."/".$nombreArchivo;
            }
            $reporte->save();
            if(!$reporte){
                App::abort(500, 'Error');
            }
            else{
                $usuariosRol = Persona::where('FK_Tipo_Persona',42)->get();
                foreach($usuariosRol as $usuario) {
                    $datosUsuario = Persona::find($usuario->PK_Id_Persona);
                    $datos = new \stdClass();
                    $datos->nombre = $datosUsuario->VC_Primer_Nombre." ".$datosUsuario->VC_Primer_Apellido;
                    $datos->correo = $datosUsuario->VC_Correo;
                    $datos->subject = "Reporte Cuantitativo corregido";
                    $datos->contenido_html = "<p>Se ha corregido el siguiente Reporte Cuantitativo de Metas:<br><br><strong>Actividad: </strong>".$reporte->tx_nombre_actividad.".<br><strong>Descripción: </strong>".$reporte->tx_descripcion_actividad.".<br><strong>Fecha Inicio: </strong>".$reporte->da_fecha_inicio."<br><strong>Fecha Fin: </strong>".$reporte->da_fecha_fin.". <br><br>Acceda al SIF para revisarlo.</p>";
                    Mail::to($datos->correo)->send(new EmailTemplateCulturas($datos));
                }
                return response()->json($reporte, 200);
            }
        } catch(Exception $e) {
            return false;
        }
    }

    public function saveRevisionReporteMetasCuantitativas(Request $request){
        $reporte = ReporteMetasCuantitativas::find($request->id_reporte);
        $reporte->json_observaciones = $request->observaciones;
        $reporte->in_estado = $request->estado;
        $reporte->fk_usuario_revisa = $request->id_usuario;
        $reporte->da_fecha_revision = Carbon::now();
        $reporte->save();
        
        if(!$reporte){
            App::abort(500, 'Error');
        }
        else{
            $persona = Persona::find($reporte->fk_usuario);
            $datos = new \stdClass();
            $datos->nombre = $persona->VC_Primer_Nombre." ".$persona->VC_Primer_Apellido;
            $datos->correo = $persona->VC_Correo;
            if($request->estado == 0){
                $datos->subject = "Reporte rechazado";
                $datos->contenido_html = "<p>El Reporte Cuantitativo de Metas de la actividad <strong>".$reporte->tx_nombre_actividad."</strong> registrado en la fecha y hora <strong>".$reporte->created_at."</strong>, fue revisado y tiene algunas correcciones.<br><br>Acceda al SIF, busque el reporte y dé clic en el icono de editar para realizarlas.</p>";
            }
            if($request->estado == 1){
                $datos->subject = "Reporte aprobado";
                $datos->contenido_html = "<p><strong>¡Enhorabuena!</strong><br><br>El Reporte Cuantitativo de Metas de la actividad <strong>".$reporte->tx_nombre_actividad."</strong> registrado en la fecha y hora <strong>".$reporte->created_at."</strong> fue aprobado.</p>";
            }
            Mail::to($datos->correo)->send(new EmailTemplateCulturas($datos));
            return response()->json($reporte, 200);
        }
    }

    public function getAllReportesMetasCuantitativas(){
        $reporte = new ReporteMetasCuantitativas;
        $resultado = $reporte->getAllReportesMetasCuantitativas();
        return response()->json($resultado, 200);
    }

    public function getAllReportesMetasCuantitativasByUser(Request $request){
        $reporte = new ReporteMetasCuantitativas;
        $resultado = $reporte->getAllReportesMetasCuantitativasByUser($request->id_usuario);
        return response()->json($resultado, 200);
    }

    public function getReporteMetasCuantitativas(Request $request){
        $reporte = new ReporteMetasCuantitativas;
        $resultado = $reporte->getReporteMetasCuantitativas($request->id);
        return response()->json($resultado, 200);
    }

    public function getReportesMetasCuantitativasByFilters(Request $request){
        $reporte = new ReporteMetasCuantitativas;
        $resultado = $reporte->getReportesMetasCuantitativasByFilters($request->componente_meta, $request->mes);
        return response()->json($resultado, 200);
    }
    
}
