<?php

namespace App\Http\Controllers\nidos\territorial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\nidos\territorial\Beneficiario;

class BeneficiariosController extends Controller
{
	public function validarBeneficiarioRegistrado(Request $request){
		$beneficiario = new Beneficiario;
		$resultado = $beneficiario->validarBeneficiarioRegistrado($request->id_beneficiario);
		return response()->json(json_decode($resultado), 200);
	}
}
