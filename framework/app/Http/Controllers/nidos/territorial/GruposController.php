<?php

namespace App\Http\Controllers\nidos\territorial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\nidos\territorial\Grupo;

class GruposController extends Controller
{
	public function getGruposLugar(Request $request){
		$grupo = new Grupo;
		$resultado = $grupo->getGruposLugar($request->id_lugar);
		return response()->json(json_decode($resultado), 200);
	}
}
