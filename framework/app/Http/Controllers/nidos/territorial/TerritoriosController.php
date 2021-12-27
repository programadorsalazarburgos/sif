<?php

namespace App\Http\Controllers\nidos\territorial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\nidos\territorial\Territorio;

class TerritoriosController extends Controller
{
    public function getTerritorioPersona(Request $request){
		$territorio = new Territorio;
		$resultado = $territorio->getTerritorioPersona($request->id_persona);
		return response()->json(json_decode($resultado), 200);
	}
}
