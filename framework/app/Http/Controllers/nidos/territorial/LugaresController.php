<?php

namespace App\Http\Controllers\nidos\territorial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\nidos\territorial\Lugar;

class LugaresController extends Controller
{
	public function getLugaresTerritorio(Request $request){
		$lugar = new Lugar;
		$resultado = $lugar->getLugaresTerritorio($request->id_territorio);
		return response()->json(json_decode($resultado), 200);
	}

	public function getInfoLugar(Request $request){
		$lugar = new Lugar;
		$resultado = $lugar->getInfoLugar($request->id_lugar);
		return response()->json(json_decode($resultado), 200);
	}
}
