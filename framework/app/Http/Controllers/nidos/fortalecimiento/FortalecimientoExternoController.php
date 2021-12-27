<?php

namespace App\Http\Controllers\nidos\fortalecimiento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\nidos\territorial\Dupla;
use App\Models\nidos\fortalecimiento\OfertaFortalecimientoExterno;
use App\Models\nidos\fortalecimiento\GrupoFortalecimientoExterno;
use App\Models\nidos\fortalecimiento\ParticipanteFortalecimientoExterno;
use App\Models\nidos\fortalecimiento\ParticipanteGrupoFortalecimientoExterno;
use App\Models\nidos\fortalecimiento\SesionFortalecimientoExterno;
use App\Models\nidos\fortalecimiento\AsistenciaFortalecimientoExterno;
use App\Models\Persona;


class FortalecimientoExternoController extends Controller
{
    public function viewRegistroFortalecimientoExterno(){
    	return view('nidos/fortalecimiento.registro_fortalecimiento_externo');
    }
    public function procesarOferta(Request $request){
        $datos = json_decode($request["form"]);

        if($request->proceso == "crear"){
            $oferta = new OfertaFortalecimientoExterno;
            $oferta->modulo = $datos->modulo;
            $oferta->descripcion = $datos->descripcion;
            $oferta->fecha_creacion = date("Y-m-d H:i:s");
            $oferta->save();
        }else{
            $oferta = new OfertaFortalecimientoExterno;
            $oferta->where('id', $request->id_oferta)->update(["modulo" => $datos->modulo,"descripcion" => $datos->descripcion]);
        }
    }
    public function getOfertaFortalecimientoExterno(Request $request){
        $oferta = OfertaFortalecimientoExterno::all();
        return response()->json(json_decode($oferta), 200);
    }
    public function cambiarEstadoOferta(Request $request){
        $oferta = new OfertaFortalecimientoExterno;
        $oferta->where('id', $request->id_oferta)->update(["estado" => $request->estado_cambio]);
    }
    public function getOfertaActivaFortalecimientoExterno(Request $request){
        $oferta = OfertaFortalecimientoExterno::select("modulo as text", "id as value")
        ->where("estado", 1)
        ->get();

        return response()->json($oferta, 200);
    }
    public function guardarSolicitud(Request $request){
        $datos = json_decode($request["form"]);

        $grupos = GrupoFortalecimientoExterno::select("id")
        ->withCount("participantes")
        ->where([
            ["fk_oferta", $datos->modulo_fortalecimiento->value],
            ["jornada_oferta", $datos->jornada_fortalecimiento->value],
        ])
        ->groupBy("id")
        ->orderBy("id", "desc")
        ->limit(1)
        ->get();

        if($grupos->isEmpty() || $grupos[0]["participantes_count"] >= 25){

            $nuevo_grupo = new GrupoFortalecimientoExterno;

            $nuevo_grupo->fk_oferta = $datos->modulo_fortalecimiento->value;
            $nuevo_grupo->modulo_oferta = $datos->modulo_fortalecimiento->text;
            $nuevo_grupo->jornada_oferta = $datos->jornada_fortalecimiento->value;
            $nuevo_grupo->fecha_creacion = date("Y-m-d H:i:s");
            $nuevo_grupo->save();

            $last_id_grupo = $nuevo_grupo->id;

        }else{
            $last_id_grupo = $grupos[0]["id"];
        }

        $participante = new ParticipanteFortalecimientoExterno;

        $participante->primer_nombre = $datos->primer_nombre;
        $participante->segundo_nombre = $datos->segundo_nombre;
        $participante->primer_apellido = $datos->primer_apellido;
        $participante->segundo_apellido = $datos->segundo_apellido;
        $participante->tipo_documento = $datos->tipo_documento->value;
        $participante->numero_documento = $datos->numero_documento;
        $participante->correo = $datos->correo;
        $participante->fecha_nacimiento = $datos->fecha_nacimiento;
        $participante->celular = $datos->celular;
        $participante->genero = $datos->genero->value;
        $participante->otro_genero = $datos->otro_genero;
        $participante->sector_social = $datos->sector_social->value;
        $participante->grupo_etnico = $datos->grupo_etnico->value;
        $participante->entidad = "SECRETARIA DE EDUCACIÓN (SED)";
        $participante->localidad_trabajo = $datos->localidad_trabajo->value;
        $participante->barrio_trabajo = $datos->barrio_trabajo->value;
        $participante->sitio_trabajo = $datos->sitio_trabajo;
        $participante->nivel_trabajo = $datos->nivel->value;
        $participante->otro_nivel_trabajo = $datos->otro_nivel;
        $participante->ocupacion = $datos->ocupacion->value;
        $participante->otra_ocupacion = $datos->otra_ocupacion;
        $participante->id_modulo_fortalecimiento = $datos->modulo_fortalecimiento->value;
        $participante->modulo_fortalecimiento = $datos->modulo_fortalecimiento->text;
        $participante->jornada_fortalecimiento = $datos->jornada_fortalecimiento->value;
        $participante->fecha_registro = date("Y-m-d H:i:s");
        $participante->save();

        $last_id_participante = $participante->id;

        $participante_grupo = new ParticipanteGrupoFortalecimientoExterno;
        $participante_grupo->fk_grupo = $last_id_grupo;
        $participante_grupo->fk_participante = $last_id_participante;
        $participante_grupo->fecha_ingreso = date("Y-m-d H:i:s");
        $participante_grupo->save();
    }
    public function getGruposOferta(Request $request){
        $grupos = GrupoFortalecimientoExterno::select("id as value", GrupoFortalecimientoExterno::raw("CONCAT(modulo_oferta, ' ', jornada_oferta, ' Grupo ', id) as text"));
        if(isset($request->id_dupla)){
            $grupos = $grupos->where("fk_dupla", $request->id_dupla);
        }
        $grupos = $grupos->get();
        return response()->json($grupos, 200);
    }
    public function getParticipantesGrupo(Request $request){
        $participantes = ParticipanteGrupoFortalecimientoExterno::select("fk_participante")
        ->with("participantes")
        ->where("fk_grupo", $request->id_grupo)
        ->get();

        return response()->json($participantes, 200);
    }
    public function getDuplas(Request $request){

        $duplas = Dupla::select("Pk_Id_Dupla", "VC_Codigo_Dupla")
        ->with("artistas")
        ->where([
            ["Fk_Id_Tipo_Dupla", 4],
            ["IN_Estado", 1]
        ])
        ->get();

        foreach ($duplas as $key => $dupla) {
            $texto = $dupla->VC_Codigo_Dupla . ' (' ;
            foreach($dupla->artistas as $artista){
                $texto .= $artista->full_name . ' - ';
            }
            $texto = substr($texto, 0, -3);
            $texto .= ')';

            $data[] = [
                'value' => $dupla->Pk_Id_Dupla,
                'text' => $texto,
            ]; 
        }
        
        return response()->json($data);
    }
    public function getDuplaAsignada(Request $request){
        $id_grupo = $request->id_grupo;

        $dupla = Dupla::select("Pk_Id_Dupla", "VC_Codigo_Dupla")
        ->whereHas("gruposFortalecimientoExterno", function($query) use ($id_grupo){
            $query->where("id", $id_grupo); 
        })
        ->with("artistas")
        ->get();

        if($dupla->isEmpty()){
            return response()->json("", 200);
        }else{
            foreach ($dupla as $key => $du) {
                $texto = $du->VC_Codigo_Dupla . ' (' ;
                foreach($du->artistas as $artista){
                    $texto .= $artista->full_name . ' - ';
                }
                $texto = substr($texto, 0, -3);
                $texto .= ')';

                $data[] = [
                    'value' => $du->Pk_Id_Dupla,
                    'text' => $texto
                ]; 
            }
            return response()->json($data[0], 200);            
        }
    }
    public function asignarDuplaGrupo(Request $request){
        $grupo = new GrupoFortalecimientoExterno;
        $grupo->where("id", $request->id_grupo)->update(["fk_dupla" => $request->id_dupla]);
    }
    public function getSesionesGrupo(Request $request){
        if($request->tipo_consulta == "count"){
            $sesiones = SesionFortalecimientoExterno::select("id")
            ->where("fk_grupo", $request->id_grupo)
            ->count();
        }else{
            $resultado = SesionFortalecimientoExterno::select("id", "fecha_sesion")
            ->where("fk_grupo", $request->id_grupo)
            ->get();

            foreach ($resultado as $key => $r) {
                $sesiones[] = [
                    'value' => $r->id,
                    'text' => $r->fecha_sesion
                ];
            }
        }

        return response()->json($sesiones, 200);
    }
    public function validarFechaSesion(Request $request){
        $fecha_sesion_existente = SesionFortalecimientoExterno::where([
            ["fk_grupo", $request->id_grupo],
            ["fecha_sesion", $request->fecha_sesion]
        ])
        ->first()
        ->getRawOriginal("fecha_sesion");

        return response()->json($fecha_sesion_existente, 200);
    }
    public function guardarAsistencia(Request $request){
        $datos = json_decode($request["form"]);

        if($request["accion"] == "guardar"){
            $sesion = new SesionFortalecimientoExterno;
            $sesion->fk_dupla = $datos->id_dupla;
            $sesion->fk_grupo = $datos->grupo->value;
            $sesion->fecha_sesion = $datos->fecha_sesion;
            $sesion->fecha_registro = date("Y-m-d H:i:s");
            $sesion->quien_registro = $datos->id_persona;
            $sesion->save();

            $id_insertado_sesion = $sesion->id;

            foreach ($datos->participantes as $participante) {
                $asistencia = new AsistenciaFortalecimientoExterno;
                $asistencia->fk_participante = $participante->id;
                $asistencia->fk_sesion = $id_insertado_sesion;
                $asistencia->asistencia = $participante->asistencia;
                $asistencia->fechas_classroom = $participante->fechas_classroom;
                $asistencia->save();
            }
        }else{
            foreach ($datos->participantes as $participante) {
                $asistencia = AsistenciaFortalecimientoExterno::where([["fk_participante", $participante->id],["fk_sesion", $datos->fecha_sesion->value]])->first();
                $asistencia->asistencia = $participante->asistencia;
                $asistencia->fechas_classroom = $participante->fechas_classroom;
                $asistencia->save();
            }
        }
    }

    public function consultaEdicionAsistencia(Request $request){
        $asistencia = AsistenciaFortalecimientoExterno::select("*")
        ->with("participantes")
        ->where("fk_sesion", $request->id_sesion)
        ->get();

        return response()->json($asistencia, 200);
    }
}
