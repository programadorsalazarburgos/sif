<?php

namespace App\Modulos\Personas\Repository;

use App\Modulos\Personas\Interfaces\PersonaInterface;
use App\Modulos\Personas\Persona;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PersonaRepository implements PersonaInterface
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

	public function getUsuariosRol($request){

		$usuariosApoyos = Persona::where('FK_Tipo_Persona',$request->FK_Tipo_Persona)->get();
		
		foreach ($usuariosApoyos as $key => $usuarioApoyo) {

			$data[] = [
				'value' => $usuarioApoyo->PK_Id_Persona,
				'text' => $usuarioApoyo->full_name,
			];
			
		}
		
		return response()->json($data);

	}

	public function getRolPersona($request){
		
		$rol = Persona::select("FK_Tipo_Persona")
		->where("PK_Id_Persona", $request->id_persona)
		->get();
		
		return response()->json($rol[0]);
	}

	public function getArtistasPorLineaNidos($request){
		$personas = Persona::select("*")
		->where("FK_Tipo_Persona", $request->tipo_persona)
		->whereHas("acceso", function($query){
			$query->where("IN_Estado", 1);
		})
		->get();

		foreach ($personas as $key => $persona) {
			$data[] = [
				'value' => $persona->PK_Id_Persona,
				'text' => $persona->full_name,
			];
		}
		return response()->json($data);
	}

	public function getTerritorioPersonaNidos($request){
		$territorio = Persona::select("*")
		->with("territorioNidos")
		->where("PK_Id_Persona", $request->id_persona)
		->get();

		foreach ($territorio as $key => $t) {
			foreach($t->territorioNidos as $tn){
				$data = [
					"Pk_Id_Territorio" => $tn->Pk_Id_Territorio,
					"Vc_Nom_Territorio" => $tn->Vc_Nom_Territorio
				];
			}
		}
		return response()->json($data);
	}
}
