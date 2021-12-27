<?php

namespace App\Modulos\TalentoHumano\Repository;

use App\Modulos\TalentoHumano\Interfaces\TalentoHumanoInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Modulos\TalentoHumano\HojadeVida;
use App\Modulos\TalentoHumano\EvaluacionHojadeVida;
use App\Modulos\TalentoHumano\ParametrosEvaluacionHojadeVida;
use App\Modulos\Personas\Persona;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
//use App\Models\Options;

class TalentoHumanoRepository implements TalentoHumanoInterface
{
	public function __construct(){}

	public function crear($data){}
	public function dataTable($relaciones=[]){}
	public function show($relaciones=[]){}
	public function actualizar($request, $id){}
	public function obtener($id, $relaciones = []){}
	public function eliminar($id){}
	public function obtenerTodo( $relaciones = []){}
	private function procesar($horario, $request){}
	public function obtenerTabla($request){}

	public function guardarHojadeVida($request){
		$datos = json_decode($request["data"]);
		//$datos->notificacion_email = "confirmacion_preinscripcion";

		$archivo_hoja_vida = $request->archivo_hoja_vida;
		$nombre_archivo_hoja_vida = $request->archivo_hoja_vida->getClientOriginalName();
		$archivo_hoja_vida->storeAs("hojasdevida/".date("Y")."/".$datos->numero_documento."/", $nombre_archivo_hoja_vida, 'uploadedfiles');
		$path_archivo_hoja_vida = "../../../uploadedFiles/hojasdevida/".date("Y")."/".$datos->numero_documento."/".$nombre_archivo_hoja_vida;

		$hojadevida = new HojadeVida;

		$hojadevida->fecha_solicitud = date("Y-m-d H:i:s");
		$hojadevida->numero_documento = $datos->numero_documento;
		$hojadevida->tipo_documento = $datos->tipo_documento->value;
		$hojadevida->primer_nombre = $datos->primer_nombre;
		$hojadevida->segundo_nombre = $datos->segundo_nombre;
		$hojadevida->primer_apellido = $datos->primer_apellido;
		$hojadevida->segundo_apellido = $datos->segundo_apellido;
		$hojadevida->correo = $datos->correo;
		$hojadevida->telefono = $datos->telefono;
		$hojadevida->localidad = $datos->localidad->value;	
		$hojadevida->municipio = $datos->municipio;		
		$hojadevida->area_experiencia = $datos->area_experiencia->value;
		$hojadevida->otra_area_experiencia = $datos->otra_area_experiencia;
		$hojadevida->experiencia_nidos = $datos->experiencia_nidos;
		$hojadevida->periodo_nidos = $datos->periodo_nidos;
		$hojadevida->experiencia_infancia = $datos->experiencia_infancia;
		$hojadevida->periodo_infancia = $datos->periodo_infancia;
		$hojadevida->codigo = $datos->codigo;
		$hojadevida->archivo_hoja_vida = $path_archivo_hoja_vida;
		$hojadevida->save();

		//Mail::to($datos->correo)->send(new EmailPreinscripcion($datos));
	}

	public function getHojasVida($request){
		$where = array();
		$parametros_keys = array_keys($request->request->all());
		$i=0;
		foreach ($request->request->all() as $key => $parametro) {
			if($key!="X-CSRF-TOKEN"){
				if($parametro!="-1"){
					$where[] = ["tb_hoja_vida.".$parametros_keys[$i], $parametro];
				}
			}
			$i++;
		}
		$hojadevida = HojadeVida::where($where)
		->with('localidad:FK_Value,VC_Descripcion','area_experiencia:FK_Value,VC_Descripcion')
		->orderBy("fecha_solicitud", "ASC")->get();

		return response()->json(json_decode($hojadevida), 200);
	}

	public function getEvaluacionHojasVida($request){
		$id_usuario = $request->id_usuario_actual;
		$parametros = ParametrosEvaluacionHojadeVida::where("rol","1")->get();
		$persona = Persona::select("PK_Id_Persona as id_usuario","VC_Primer_Nombre","VC_Segundo_Nombre","VC_Primer_Apellido","VC_Segundo_Apellido")
			->where("PK_Id_Persona",$id_usuario);
		$usuarios = EvaluacionHojadeVida::select("id_usuario","VC_Primer_Nombre","VC_Segundo_Nombre","VC_Primer_Apellido","VC_Segundo_Apellido")
			->where([
				["id_hoja_vida",$request->id_hoja_vida],
				["id_usuario","<>",$id_usuario]
			])
			->join('tb_persona_2017', 'PK_Id_Persona', '=', 'id_usuario')
			->groupBy("id_usuario")
			->union($persona)
			->get();
		$evaluacion = array();
		foreach ($parametros as $key => $parametro) {	
			$valores = array();
			foreach ($usuarios as $usuario) {	
				$evaluacionhojadevida = EvaluacionHojadeVida::
					where([
						["id_hoja_vida", $request->id_hoja_vida],
						["id_parametro", $parametro->id],
						["id_usuario", $usuario->id_usuario]
					])->first();
				$valores[] = array(
					'id_usuario'=>$usuario->id_usuario,
					'valor'=>$evaluacionhojadevida["valor"],
				);
			}
			$evaluacion[] = array(
				'id_parametro'=>$parametro->id,
				'parametro'=>$parametro->descripcion,
				'valores'=>$valores,
			);
		}
		return response()->json([$usuarios,$evaluacion], 200);
	}

	public function guardarEvaluacionHojasVida($request){
		$datos = json_decode($request["data"]);

		foreach ($datos->id_parametro as $key => $id) {	
			$evaluacionhojavida = new EvaluacionHojadeVida;
			$evaluacionhojavida->id_hoja_vida = $datos->id_hoja_vida;
			$evaluacionhojavida->id_parametro = $id;
			$evaluacionhojavida->id_usuario = $datos->id_usuario;
			$evaluacionhojavida->valor = $datos->parametro[$key];
			$evaluacionhojavida->save();	
		}

		$hojadevida = HojadeVida::where("id", $datos->id_hoja_vida)->first();
		$hojadevida->estado = $datos->estado_guardar->value;
		$hojadevida->observaciones = $datos->observaciones;
		$hojadevida->save();

	}
}