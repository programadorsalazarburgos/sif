<?php

namespace App\Http\Controllers\nidos\transicion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\nidos\transicion\AdministracionGrupos;
use App\Models\nidos\transicion\BeneficiariosSimat;
use App\Models\nidos\transicion\BeneficiariosNidos;
use App\Models\nidos\transicion\BeneficiariosGrupoTransicion;
use App\Models\nidos\transicion\ExperienciasNidos;
use App\Models\nidos\transicion\AsistenciaNidos;

class RegistroExperienciasController extends Controller
{
	public function getGruposDuplaAsistencia(Request $request){
		$grupos = new AdministracionGrupos;
		$resultado = $grupos->getGruposDuplaAsistencia($request->personaid);
		//return response()->json(json_decode($resultado), 200);
		return response()->json($resultado, 200);
	}

	public function guardarRegistroExperiencia(Request $request){
		$datos = json_decode($request["form"]);	
		$experiencianidos = new ExperienciasNidos;
		$experiencianidos->Fk_Id_Lugar_Atencion = $datos->lugar;
		$experiencianidos->Fk_Id_Dupla = $request->duplaid;
		$experiencianidos->Fk_Id_Grupo = $datos->grupo->value;
		$experiencianidos->VC_Nombre_Experiencia = $datos->nombre_experiencia;
		$experiencianidos->DT_Fecha_Encuentro = $datos->fecha_experiencia;
		$experiencianidos->HR_Hora_Inicio = $datos->hora_inicio;
		$experiencianidos->HR_Hora_Finalizacion = $datos->hora_finalizacion;
		$experiencianidos->IN_Cuidadores = '0';
		$experiencianidos->DT_Fecha_Registro = date("Y-m-d H:i:s");
		$experiencianidos->IN_Id_Persona = $request->personaid;
		$experiencianidos->IN_Aprobacion = '0';
		$experiencianidos->IN_Componente = '3';
		$experiencianidos->save();	
			
		$idExperiencia = $experiencianidos->id;	
		
		foreach ($datos->beneficiarios as $beneficiario) {
		$asistencia = new AsistenciaNidos;
		$asistencia->Fk_Id_Experiencia = $idExperiencia;
		$asistencia->Fk_Id_Beneficiario = $beneficiario->id;
		$asistencia->Vc_Asistencia = $beneficiario->asistencia;
		
		if($beneficiario->modalidad == ''){
			$asistencia->Fk_Modalidad = 0;
		}else {
			$asistencia->Fk_Modalidad = $beneficiario->modalidad->value;
		}
		$asistencia->DT_Fecha_atencion =  $datos->fecha_experiencia;
		$asistencia->save();
		
		}
	}

	public function getExperienciasRegistradasDupla(Request $request){
		$grupos = new ExperienciasNidos;
		$resultado = $grupos->getExperienciasRegistradasDupla($request->personaid,$request->mes);
		//return response()->json(json_decode($resultado), 200);
		return response()->json($resultado, 200);
	}


}
