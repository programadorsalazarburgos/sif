<?php

namespace App\Modulos\Duplas\Repository;

use App\Modulos\Duplas\Interfaces\DuplasInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Modulos\Duplas\Dupla;
use App\Modulos\Duplas\DuplaArtista;

class DuplasRepository implements DuplasInterface
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

	public function getDuplas($tipo_dupla){
		$duplas = Dupla::select("Pk_Id_Dupla", "VC_Codigo_Dupla")
		->with("artistas")
		->where([
			["Fk_Id_Tipo_Dupla", $tipo_dupla],
			["IN_Estado", 1]
		])
		->get();

		foreach ($duplas as $key => $dupla) {
			$texto = $dupla->VC_Codigo_Dupla . ' (' ;
			foreach($dupla->artistas as $artista){
				if($artista->pivot->IN_Estado == 1)
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

	public function getDuplaAsignada($id_grupo){
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

	public function getDuplaPersona($request){
		$id_persona = $request->id_persona;

		$resultado = Dupla::select("Pk_Id_Dupla")
		->whereHas("artistas", function($query) use ($id_persona){
			$query->where([
				["Fk_Id_Persona", $id_persona],
				["IN_Estado", 1]
			]);
		})
		->get();
		return response()->json($resultado[0], 200);
	}

	public function getDuplasGestor($request){

		$duplas = Dupla::select("Pk_Id_Dupla", "VC_Codigo_Dupla", "Fk_Id_Tipo_Dupla")
		->where([
			["Fk_Id_Gestor", $request->id_persona],
			["IN_Estado", 1]
		])
		->with(["artistas" => function($query){
			$query->select("PK_Id_Persona","VC_Primer_Apellido","VC_Primer_Nombre","VC_Segundo_Apellido","VC_Segundo_Nombre")
			->where("IN_Estado", 1);
		}])
		->get();
		return response()->json($duplas, 200);
	}

	public function crearDupla($request){
		$datos = json_decode($request["form_crear_dupla"]);

		$dupla = new Dupla;
		$dupla->Fk_Id_Tipo_Dupla = $datos->tipo_dupla->value;
		$dupla->VC_Codigo_Dupla = $datos->nombre_dupla;
		$dupla->Fk_Id_Territorio = $datos->id_territorio_persona;
		$dupla->Fk_Id_Gestor = $datos->id_persona;
		$dupla->IN_Estado = 1;
		$dupla->DT_Fecha_Creacion = date("Y-m-d H:i:s");
		$dupla->save();

		$id_dupla_creada = $dupla->Pk_Id_Dupla;

		foreach($datos->artistas as $artista){

			$dupla_artista = new DuplaArtista;
			$dupla_artista->Fk_Id_Dupla = $id_dupla_creada;
			$dupla_artista->Fk_Id_Persona = $artista->value;
			$dupla_artista->IN_Estado = 1;
			$dupla_artista->DT_Fecha_Ingreso = date("Y-m-d H:i:s");
			$dupla_artista->save();
		}
	}

	public function actualizarDupla($request){
		$datos = json_decode($request["form_actualizar_dupla"]);

		$dupla = Dupla::where("Pk_Id_Dupla", $datos->id_dupla)
		->first();
		
		$dupla->Fk_Id_Tipo_Dupla = $datos->tipo_dupla->value;
		$dupla->VC_Codigo_Dupla = $datos->nombre_dupla;
		$dupla->save();

		$artistas = DuplaArtista::where("Fk_Id_Dupla", $datos->id_dupla)
		->update(["IN_Estado" => 0]);

		foreach($datos->artistas_actuales as $artista){

			$resultado = DuplaArtista::where([
				["Fk_Id_Dupla", $datos->id_dupla],
				["Fk_Id_Persona", $artista->value]
			])
			->first();

			if($resultado == ""){
				$resultado = new DuplaArtista;
				$resultado->Fk_Id_Dupla = $datos->id_dupla;
				$resultado->Fk_Id_Persona = $artista->value;
				$resultado->IN_Estado = 1;
				$resultado->DT_Fecha_Ingreso = date("Y-m-d H:i:s");
			}else{
				$resultado->IN_Estado = 1;
			}
			$resultado->save();
		}
	}

	public function inactivarDupla($request){
		$dupla = Dupla::where("Pk_Id_Dupla", $request->id_dupla)
		->update(["IN_Estado" => 0]);

		$dupla_artista = DuplaArtista::where("Fk_Id_Dupla", $request->id_dupla)
		->update(["IN_Estado" => 0]);
	}
}