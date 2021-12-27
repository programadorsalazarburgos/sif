<?php

namespace App\Modulos\Parametros\Repository;

use App\Modulos\Parametros\Interfaces\ParametrosInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Modulos\Parametros\ParametroDetalles;

class ParametrosRepository implements ParametrosInterface
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

	public function getParametroDetalle($request){
		$programa;
		switch($request->programa){
			case "crea":
			$programa = "IN_Estado";
			break;
			case "nidos":
			$programa = "IN_Estado_Nidos";
			break;
			case "culturas":
			$programa = "IN_Estado_Culturas";
			break;
		}
		
		$parametros = ParametroDetalles::where([
			["FK_Id_Parametro", $request->FK_Id_Parametro],
			[$programa, 1]
		])
		->get();

		foreach ($parametros as $key => $parametro) {
			$data[] = [
				'value' => $parametro->FK_Value,
				'text' => $parametro->VC_Descripcion,
			]; 
		}
		return response()->json($data);
	}

	public function obtenerParametro($parametro){
		
        $parametroDetalles = ParametroDetalles::where('FK_Id_Parametro',$parametro) 
                				->where('IN_Estado',1)->get();

		foreach ($parametroDetalles as $key => $parametroDetalle) {
			
			$data[] = [
				'value' => $parametroDetalle->PK_Id_Tabla,
				'text' => $parametroDetalle->VC_Descripcion,
			];
			
		}
		
		return response()->json($data);
		
    }

	static function obtenerMomento($parametro){

		return ParametroDetalles::where('PK_Id_Tabla',$parametro) 
                				->where('IN_Estado',1)->first();    
		
    }

}