<?php

namespace App\Http\Controllers\nidos\transicion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\nidos\transicion\AdministracionGrupos;
use App\Models\nidos\transicion\BeneficiariosSimat;
use App\Models\nidos\transicion\BeneficiariosNidos;
use App\Models\nidos\transicion\BeneficiariosGrupoTransicion;
;

class AdministracionGruposController extends Controller
{
	public function getGruposDupla(Request $request){
		$grupos = new AdministracionGrupos;
		$resultado = $grupos->getGruposDupla($request->personaid);
		//return response()->json(json_decode($resultado), 200);
		return response()->json($resultado, 200);
	}


	public function guardarGrupoDupla(Request $request){ 
        $datos = json_decode($request["form"]);

        if($request->proceso == "crear"){
            $grupo = new AdministracionGrupos;
			$grupo->fk_id_lugar_atencion = $datos->institucion->value;
			$grupo->nombre_grupo = $datos->grupo;					
			$grupo->fk_id_nivel_escolaridad = $datos->nivel->value;
			$grupo->responsable_grupo = $datos->responsable;
			$grupo->fk_id_dupla = $request->id_dupla;
			$grupo->in_estado = '1';
			$grupo->dt_fecha_creacion = date("Y-m-d H:i:s");
			$grupo->fk_id_usuario_creacion = $request->id_persona;
            $grupo->save();
        }else{
            $grupo = new AdministracionGrupos;
            $grupo->where('id_grupo_transicion', $request->id_grupo)->update(["fk_id_nivel_escolaridad" => $datos->nivel->value, "nombre_grupo" => $datos->grupo, "responsable_grupo" => $datos->responsable]);
        }
    } 

	public function getBeneficiariosSimat(Request $request){
        $resultado = BeneficiariosSimat::select("NRO_DOCUMENTO AS Identificacion", "NOMBRE1 AS PNombre", "NOMBRE2 AS SNombre", "APELLIDO1 AS PApellido", "APELLIDO2 AS SApellido", "FECHA_NACIMIENTO AS Nacimiento", "GENERO AS Genero", "ESTRATO AS Estrato")
        ->where([
            ["NRO_DOCUMENTO", $request->identificacion]
        ])
        ->get();
        return response()->json(json_decode($resultado[0]), 200);
    }

	public function guardarBeneficiarioGrupo(Request $request)	{

		$datos = json_decode($request["formbeneficiario"]);		
		$beneficiarionidos = new BeneficiariosNidos;
		$beneficiarionidos = BeneficiariosNidos::where('VC_Identificacion', '=', $datos->identificacion)->first();

		if ($beneficiarionidos === null) {
			$beneficiarionidos = new BeneficiariosNidos;
			
			$beneficiarionidos->VC_Identificacion = $datos->identificacion;
			$beneficiarionidos->FK_Tipo_Identificacion = '1';
			$beneficiarionidos->VC_Primer_Nombre = $datos->primer_nombre;
			$beneficiarionidos->VC_Segundo_Nombre = $datos->segundo_nombre;
			$beneficiarionidos->VC_Primer_Apellido = $datos->primer_apellido;
			$beneficiarionidos->VC_Segundo_Apellido = $datos->segundo_apellido;
			$beneficiarionidos->DD_F_Nacimiento = $datos->fecha_nacimiento;
			$beneficiarionidos->FK_Id_Genero = $datos->genero->value;

			$beneficiarionidos->IN_Grupo_Poblacional = $datos->enfoque_diferencial->value;
			$beneficiarionidos->IN_Estrato = $datos->enfoque_social->value;			
			$beneficiarionidos->Fk_Id_Usuario_Registra = '1390';
			$beneficiarionidos->DT_Fecha_Registro =  date("Y-m-d H:i:s");
			$beneficiarionidos->VC_Linea_Atendido = '3';

			//$user_id = auth()->user()->id;
			//$beneficiarionidos->FK_Usuario_Registro = $user_id;
			//$beneficiarionidos->DT_Created_at = date("Y-m-d H:i:s");
			
			if ($beneficiarionidos->save())			
			$idBeneficiarioGuardado = $beneficiarionidos->id;			
			$beneficiariogrupo = new BeneficiariosGrupoTransicion;

			$estudiante = BeneficiariosGrupoTransicion::where('Fk_Id_Beneficiario', '=', $request->idBeneficiarioGuardado, 'AND', 'Fk_Id_Grupo', '=', $request->id_grupo)->first();
			if ($estudiante === null) {
				$beneficiariogrupo->Fk_Id_Grupo = $request->id_grupo;
				$beneficiariogrupo->Fk_Id_Beneficiario = $idBeneficiarioGuardado;
				$beneficiariogrupo->DT_Fecha_Ingreso = date("Y-m-d H:i:s");
				//$user_id = auth()->user()->id;
				$beneficiariogrupo->Fk_Usuario_Ingreso = '1390';
				$beneficiariogrupo->IN_Estado = '1';
				if ($beneficiariogrupo->save())
					return 200;
			} else {
				return 211;
			}

		} else {			
			$estudianteexite = BeneficiariosNidos::where('VC_Identificacion', '=', $datos->identificacion)->first();
			$id_beneficiario = $estudianteexite["Pk_Id_Beneficiario"];			

			$estudiante = BeneficiariosGrupoTransicion::where('Fk_Id_Beneficiario', '=', $id_beneficiario)->where('Fk_Id_Grupo', '=', $request->id_grupo)->first();
			$beneficiariogrupo = new BeneficiariosGrupoTransicion;
			if ($estudiante === null) {
				$beneficiariogrupo->Fk_Id_Grupo = $request->id_grupo;
				$beneficiariogrupo->Fk_Id_Beneficiario = $id_beneficiario;
				$beneficiariogrupo->DT_Fecha_Ingreso = date("Y-m-d H:i:s");
				//$user_id = auth()->user()->id;
				$beneficiariogrupo->Fk_Usuario_Ingreso = '1390';
				$beneficiariogrupo->IN_Estado = '1';
				if ($beneficiariogrupo->save())
					return 200;
			}else{
				return 211;
			}
		} 

	}
	public function getBeneficiariosGrupo(Request $request){
		$grupos = new BeneficiariosGrupoTransicion;
		$resultado = $grupos->getBeneficiariosGrupo($request->id_grupo);
		//return response()->json(json_decode($resultado), 200);
		return response()->json($resultado, 200);
	}

	public function getLugarAtencionGrupo(Request $request){
        $resultado = AdministracionGrupos::select("fk_id_lugar_atencion")
        ->where("id_grupo_transicion", $request->id_grupo)
        ->get();
        return response()->json($resultado[0], 200);
    }

	

}
