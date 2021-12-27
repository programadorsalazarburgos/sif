<?php

namespace App\Http\Controllers\nidos\contenidos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\nidos\contenidos\Categoria;
use App\Models\nidos\contenidos\Contenido;
use App\Models\nidos\contenidos\BeneficiarioSinInformacion;
use App\Models\nidos\contenidos\BeneficiarioContenido;
use App\Models\nidos\territorial\Beneficiario;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ContenidosController extends Controller
{
	public function viewEntregaContenidos(){
		return view('nidos/contenidos.entrega_contenidos');
	}
	
	public function viewAdministracionContenidos(){
		return view('nidos/contenidos.administracion_contenidos');
	}

	public function getCategorias(Request $request){
		$categoria = new Categoria;
		$resultado = $categoria->getCategorias($request["tipo_consulta"]);
		return response()->json(json_decode($resultado), 200);
	}

	public function guardarNuevaCategoria(Request $request){
		$categoria = new Categoria;
		$categoria->VC_Nombre_Categoria = $request->nombre_nueva_categoria;
		$categoria->IN_Estado = $request->estado_categoria;
		$categoria->save();
	}

	public function modificarCategoria(Request $request){
		$categoria = new Categoria;	
		$categoria->where('PK_Id_Categoria', $request->id_categoria)->update(array('VC_Nombre_Categoria' => $request->nombre_categoria, 'IN_Estado' => $request->estado_categoria));
	}

	public function getContenidosPorCategoria(Request $request){
		$categoria = new Contenido;
		$resultado = $categoria->getContenidosPorCategoria($request->id_categoria);
		return response()->json(json_decode($resultado), 200);
	}

	public function guardarNuevoContenido(Request $request){
		$contenido = new Contenido;
		$contenido->VC_Nombre_Contenido = $request->nombre_nuevo_contenido;
		$contenido->IN_Estado = $request->estado_contenido;
		$contenido->FK_Id_Categoria = $request->id_categoria;
		$contenido->save();
	}

	public function modificarContenido(Request $request){
		$contenido = new Contenido;	
		$contenido->where('PK_Id_Contenido', $request->id_contenido)->update(array('VC_Nombre_Contenido' => $request->nombre_contenido, 'IN_Estado' => $request->estado_contenido));
	}

	public function getContenidos(Request $request){
		$contenido = new Contenido;
		$resultado = $contenido->getContenidos();
		return response()->json($resultado);
	}

	public function guardarBeneficiariosSinInfo(Request $request){
		$informacion = new BeneficiarioSinInformacion;

		$archivo = $request->archivo;
		$nombre_archivo = $request->archivo->getClientOriginalName();
		$archivo->storeAs("Nidos/Contenidos/Soportes/".date("Y")."/", $nombre_archivo);
		$path = "../../../framework/storage/app/Nidos/Contenidos/Soportes/".date("Y")."/".$nombre_archivo;

		$datos = json_decode($request["data"]);

		$informacion->IN_Total_Ninos_0_3 = $datos->in_ninos_cero_tres;
		$informacion->IN_Total_Ninas_0_3 = $datos->in_ninas_cero_tres;
		$informacion->IN_Total_Ninos_3_6 = $datos->in_ninos_cuatro_seis;
		$informacion->IN_Total_Ninas_3_6 = $datos->in_ninas_cuatro_seis;
		$informacion->IN_Total_Ninos_6 = $datos->in_ninos_seis_seis;
		$informacion->IN_Total_Ninas_6 = $datos->in_ninas_seis_seis;
		$informacion->IN_Mujeres_Gestantes = $datos->in_gestantes;
		$informacion->IN_Total_Ninos = $datos->in_ninos_cero_tres + $datos->in_ninos_cuatro_seis + $datos->in_ninos_seis_seis;
		$informacion->IN_Total_Ninas = $datos->in_ninas_cero_tres + $datos->in_ninas_cuatro_seis + $datos->in_ninas_seis_seis;
		$informacion->IN_Total_Beneficiarios = $datos->in_total;
		$informacion->IN_Afrodescendiente = $datos->in_afro;
		$informacion->IN_Campesina = $datos->in_rural;
		$informacion->IN_Discapacidad = $datos->in_discapacidad;
		$informacion->IN_Conflicto = $datos->in_conflicto;
		$informacion->IN_Indigena = $datos->in_indigena;
		$informacion->IN_Privados = $datos->in_libertad;
		$informacion->IN_Victimas = $datos->in_violencia;
		$informacion->IN_Raizal = $datos->in_raizal;
		$informacion->IN_Rom = $datos->in_rom;
		$informacion->IN_Discapacidad_7_10 = $datos->in_ninos_siete_diez;

		$informacion->IN_Total_Ninos_0_3_Nuevos = $datos->in_ninos_cero_tres_nuevos;
		$informacion->IN_Total_Ninas_0_3_Nuevos = $datos->in_ninas_cero_tres_nuevos;
		$informacion->IN_Total_Ninos_3_6_Nuevos = $datos->in_ninos_cuatro_seis_nuevos;
		$informacion->IN_Total_Ninas_3_6_Nuevos = $datos->in_ninas_cuatro_seis_nuevos;
		$informacion->IN_Total_Ninos_6_Nuevos = $datos->in_ninos_seis_seis_nuevos;
		$informacion->IN_Total_Ninas_6_Nuevos = $datos->in_ninas_seis_seis_nuevos;
		$informacion->IN_Mujeres_Gestantes_Nuevos = $datos->in_gestantes_nuevos;
		$informacion->IN_Total_Ninos_Nuevos = $datos->in_ninos_cero_tres_nuevos + $datos->in_ninos_cuatro_seis_nuevos + $datos->in_ninos_seis_seis_nuevos;
		$informacion->IN_Total_Ninas_Nuevos = $datos->in_ninas_cero_tres_nuevos + $datos->in_ninas_cuatro_seis_nuevos + $datos->in_ninas_seis_seis_nuevos;
		$informacion->IN_Total_Beneficiarios_Nuevos = $datos->in_total_nuevos;
		$informacion->IN_Afrodescendiente_Nuevo = $datos->in_afro_nuevos;
		$informacion->IN_Campesina_Nuevo = $datos->in_rural_nuevos;
		$informacion->IN_Discapacidad_Nuevo = $datos->in_discapacidad_nuevos;
		$informacion->IN_Conflicto_Nuevo = $datos->in_conflicto_nuevos;
		$informacion->IN_Indigena_Nuevo = $datos->in_indigena_nuevos;
		$informacion->IN_Privados_Nuevo = $datos->in_libertad_nuevos;
		$informacion->IN_Victimas_Nuevo = $datos->in_violencia_nuevos;
		$informacion->IN_Raizal_Nuevo = $datos->in_raizal_nuevos;
		$informacion->IN_Rom_Nuevo = $datos->in_rom_nuevos;
		$informacion->IN_Discapacidad_7_10_Nuevo = $datos->in_ninos_siete_diez_nuevos;

		$informacion->Fk_Id_Lugar_Atencion = $datos->id_lugar;
		$informacion->Fk_Id_Grupo = $datos->id_grupo;
		$informacion->VC_Contenido = $datos->ids_contenido;

		$informacion->DT_Fecha_Entrega = $datos->tx_fecha_entrega;
		$informacion->VC_Documento_Soporte = $path;
		$informacion->Fk_Id_Usuario_Registro = $datos->id_persona;
		$informacion->DT_Fecha_Registro = date("Y-m-d H:i:s");

		$informacion->save();
	}

	public function modificarBeneficiariosSinInfo(Request $request){
		$datos = json_decode($request["data"]);
		$array_update = array();

		$archivo = $request->archivo;
		if($archivo != ""){
			
			$informacion = BeneficiarioSinInformacion::select("VC_Documento_Soporte")->where("Pk_Id_Registro", $datos->id_cifra)->get();
			$path_archivo = explode("/", $informacion[0]["VC_Documento_Soporte"]);
			$nombre_archivo = $path_archivo[10];
			
			$borrar_path_documento_soporte = BeneficiarioSinInformacion::where('Pk_Id_Registro', $datos->id_cifra)
			->update(array("VC_Documento_Soporte" => ""));
			if($borrar_path_documento_soporte){
				Storage::delete("Nidos/Contenidos/Soportes/".date("Y")."/". $nombre_archivo);
				$nombre_archivo_nuevo = $request->archivo->getClientOriginalName();
				$archivo->storeAs("Nidos/Contenidos/Soportes/".date("Y")."/", $nombre_archivo_nuevo);
				$path = "../../../framework/storage/app/Nidos/Contenidos/Soportes/".date("Y")."/".$nombre_archivo_nuevo;
				$array_update["VC_Documento_Soporte"] = $path;
			}
		}
		$array_update["IN_Total_Ninos_0_3"] = $datos->in_ninos_cero_tres_s_m;
		$array_update["IN_Total_Ninas_0_3"] = $datos->in_ninas_cero_tres_s_m;
		$array_update["IN_Total_Ninos_3_6"] = $datos->in_ninos_cuatro_seis_s_m;
		$array_update["IN_Total_Ninas_3_6"] = $datos->in_ninas_cuatro_seis_s_m;
		$array_update["IN_Total_Ninos_6"] = $datos->in_ninos_seis_seis_s_m;
		$array_update["IN_Total_Ninas_6"] = $datos->in_ninas_seis_seis_s_m;
		$array_update["IN_Mujeres_Gestantes"] = $datos->in_gestantes_s_m;
		$array_update["IN_Total_Ninos"] = $datos->in_ninos_cero_tres_s_m + $datos->in_ninos_cuatro_seis_s_m + $datos->in_ninos_seis_seis_s_m;
		$array_update["IN_Total_Ninas"] = $datos->in_ninas_cero_tres_s_m + $datos->in_ninas_cuatro_seis_s_m + $datos->in_ninas_seis_seis_s_m;
		$array_update["IN_Total_Beneficiarios"] = $datos->in_total_s_m;
		$array_update["IN_Afrodescendiente"] = $datos->in_afro_s_m;
		$array_update["IN_Campesina"] = $datos->in_rural_s_m;
		$array_update["IN_Discapacidad"] = $datos->in_discapacidad_s_m;
		$array_update["IN_Conflicto"] = $datos->in_conflicto_s_m;
		$array_update["IN_Indigena"] = $datos->in_indigena_s_m;
		$array_update["IN_Privados"] = $datos->in_libertad_s_m;
		$array_update["IN_Victimas"] = $datos->in_violencia_s_m;
		$array_update["IN_Raizal"] = $datos->in_raizal_s_m;
		$array_update["IN_Rom"] = $datos->in_rom_s_m;
		$array_update["IN_Discapacidad_7_10"] = $datos->in_ninos_siete_diez_s_m;
		$array_update["IN_Total_Ninos_0_3_Nuevos"] = $datos->in_ninos_cero_tres_nuevos_s_m;
		$array_update["IN_Total_Ninas_0_3_Nuevos"] = $datos->in_ninas_cero_tres_nuevos_s_m;
		$array_update["IN_Total_Ninos_3_6_Nuevos"] = $datos->in_ninos_cuatro_seis_nuevos_s_m;
		$array_update["IN_Total_Ninas_3_6_Nuevos"] = $datos->in_ninas_cuatro_seis_nuevos_s_m;
		$array_update["IN_Total_Ninos_6_Nuevos"] = $datos->in_ninos_seis_seis_nuevos_s_m;
		$array_update["IN_Total_Ninas_6_Nuevos"] = $datos->in_ninas_seis_seis_nuevos_s_m;
		$array_update["IN_Mujeres_Gestantes_Nuevos"] = $datos->in_gestantes_nuevos_s_m;
		$array_update["IN_Total_Ninos_Nuevos"] = $datos->in_ninos_cero_tres_nuevos_s_m + $datos->in_ninos_cuatro_seis_nuevos_s_m + $datos->in_ninos_seis_seis_nuevos_s_m;
		$array_update["IN_Total_Ninas_Nuevos"] = $datos->in_ninas_cero_tres_nuevos_s_m + $datos->in_ninas_cuatro_seis_nuevos_s_m + $datos->in_ninas_seis_seis_nuevos_s_m;
		$array_update["IN_Total_Beneficiarios_Nuevos"] = $datos->in_total_nuevos_s_m;
		$array_update["IN_Afrodescendiente_Nuevo"] = $datos->in_afro_nuevos_s_m;
		$array_update["IN_Campesina_Nuevo"] = $datos->in_rural_nuevos_s_m;
		$array_update["IN_Discapacidad_Nuevo"] = $datos->in_discapacidad_nuevos_s_m;
		$array_update["IN_Conflicto_Nuevo"] = $datos->in_conflicto_nuevos_s_m;
		$array_update["IN_Indigena_Nuevo"] = $datos->in_indigena_nuevos_s_m;
		$array_update["IN_Privados_Nuevo"] = $datos->in_libertad_nuevos_s_m;
		$array_update["IN_Victimas_Nuevo"] = $datos->in_violencia_nuevos_s_m;
		$array_update["IN_Raizal_Nuevo"] = $datos->in_raizal_nuevos_s_m;
		$array_update["IN_Rom_Nuevo"] = $datos->in_rom_nuevos_s_m;
		$array_update["IN_Discapacidad_7_10_Nuevo"] = $datos->in_ninos_siete_diez_nuevos_s_m;
		$array_update["Fk_Id_Lugar_Atencion"] = $datos->id_lugar_s_m;
		$array_update["Fk_Id_Grupo"] = $datos->id_grupo_s_m;
		$array_update["VC_Contenido"] = $datos->ids_contenido_s_m;
		$array_update["DT_Fecha_Entrega"] = $datos->tx_fecha_entrega_s_m;

		$informacion = BeneficiarioSinInformacion::where('Pk_Id_Registro', $datos->id_cifra)
		->update($array_update); 
		return $informacion;
	}

	public function guardarBeneficiariosConInfo(Request $request){
		$beneficiario = new Beneficiario;

		foreach ($request["beneficiarios"] as $b) {
			$beneficiario->VC_Identificacion = $b["identificacion"];
			$beneficiario->FK_Tipo_Identificacion = $b["tipo_documento"]["value"];
			$beneficiario->VC_Primer_Nombre = $b["primer_nombre"];
			$beneficiario->VC_Segundo_Nombre = $b["segundo_nombre"];
			$beneficiario->VC_Primer_Apellido = $b["primer_apellido"];
			$beneficiario->VC_Segundo_Apellido = $b["segundo_apellido"];
			$beneficiario->DD_F_Nacimiento = $b["fecha_nacimiento"];
			$beneficiario->FK_Id_Genero = $b["genero"]["value"];
			$beneficiario->IN_Grupo_Poblacional = $b["enfoque"]["value"];
			$beneficiario->IN_Estrato = $b["estrato"]["value"];
			$beneficiario->Fk_Id_Usuario_Registra = $request["id_persona"];
			$beneficiario->DT_Fecha_Registro = date("Y-m-d H:i:s");
			$beneficiario->VC_Linea_Atendido = 3;
			if($b["existe"] == 0){
				$beneficiario->save();
			}else{
				$beneficiario->where('VC_Identificacion', $b["identificacion"])
				->update(array("FK_Tipo_Identificacion" => $b["tipo_documento"]["value"],
					"VC_Primer_Nombre" => $b["primer_nombre"],
					"VC_Segundo_Nombre" => $b["segundo_nombre"],
					"VC_Primer_Apellido" => $b["primer_apellido"],
					"VC_Segundo_Apellido" => $b["segundo_apellido"],
					"DD_F_Nacimiento" => $b["fecha_nacimiento"],
					"FK_Id_Genero" => $b["genero"]["value"],
					"IN_Grupo_Poblacional" => $b["enfoque"]["value"],
					"IN_Estrato" => $b["estrato"]["value"],
					"VC_Linea_Atendido" => DB::raw("IF(VC_Linea_Atendido IS NULL, 3, CONCAT(VC_Linea_Atendido, ',3'))") ));
			}
		}

		$contenidos = explode(",", $request->ids_contenido);

		foreach ($request["beneficiarios"] as $b) {
			foreach ($contenidos as $c) {
				$select = Beneficiario::select("Pk_Id_Beneficiario")
				->where("VC_Identificacion", $b["identificacion"])
				->get();

				$beneficiario_contenido = new BeneficiarioContenido;
				$beneficiario_contenido->Fk_Id_Contenido = $c;
				$beneficiario_contenido->Fk_Id_Beneficiario = $select[0]["Pk_Id_Beneficiario"];
				$beneficiario_contenido->Fk_Id_Lugar_atencion = $request->id_lugar;
				$beneficiario_contenido->Fk_Id_Grupo = $request->id_grupo;
				$beneficiario_contenido->DT_Fecha_Entrega_Contenido = $request->fecha_entrega_contenido;
				$beneficiario_contenido->Fk_Id_Usuario_Registro = $request->id_persona;
				$beneficiario_contenido->DT_Fecha_Registro = date("Y-m-d H:i:s");
				$beneficiario_contenido->save();
			}
		}

	}

	public function getInformeBeneficiariosSinInfo(Request $request){
		$informacion = new BeneficiarioSinInformacion;
		$resultado = $informacion->getInformeBeneficiariosSinInfo($request->id_mes, $request->tipo_consulta);
		return response()->json(json_decode($resultado), 200);
	}

	public function getInformeBeneficiariosConInfo(Request $request){
		$informacion = new BeneficiarioContenido;
		$resultado = $informacion->getInformeBeneficiariosConInfo($request->id_mes, $request->tipo_consulta);
		return response()->json($resultado, 200);
	}

	public function getListadoCifras(Request $request){
		$listado = BeneficiarioSinInformacion::select("Pk_Id_Registro AS value", BeneficiarioSinInformacion::raw("CONCAT(la.VC_Nombre_Lugar, ' - ', g.VC_Nombre_Grupo) AS text"))
		->join("tb_nidos_lugar_atencion as la", "la.Pk_Id_lugar_atencion", "=", "Fk_Id_Lugar_Atencion")
		->join("tb_nidos_grupos as g", "g.Pk_Id_Grupo", "=", "Fk_Id_Grupo")
		->where("Fk_Id_Usuario_Registro", $request->id_persona)
		->get();
		return response()->json(json_decode($listado), 200);
	}

	public function getInfoCifras(Request $request){
		$info = BeneficiarioSinInformacion::select(
			"Pk_Id_Registro",
			"IN_Total_Beneficiarios",
			"IN_Total_Ninos_0_3",
			"IN_Total_Ninas_0_3",
			"IN_Total_Ninos_3_6",
			"IN_Total_Ninas_3_6",
			"IN_Total_Ninos_6",
			"IN_Total_Ninas_6",
			"IN_Mujeres_Gestantes",
			"IN_Afrodescendiente",
			"IN_Campesina",
			"IN_Discapacidad",
			"IN_Conflicto",
			"IN_Indigena",
			"IN_Privados",
			"IN_Victimas",
			"IN_Raizal",
			"IN_Rom",
			"IN_Discapacidad_7_10",
			"IN_Total_Beneficiarios_Nuevos",
			"IN_Total_Ninos_0_3_Nuevos",
			"IN_Total_Ninas_0_3_Nuevos",
			"IN_Total_Ninos_3_6_Nuevos",
			"IN_Total_Ninas_3_6_Nuevos",
			"IN_Total_Ninos_6_Nuevos",
			"IN_Total_Ninas_6_Nuevos",
			"IN_Mujeres_Gestantes_Nuevos",
			"IN_Afrodescendiente_Nuevo",
			"IN_Campesina_Nuevo",
			"IN_Discapacidad_Nuevo",
			"IN_Conflicto_Nuevo",
			"IN_Indigena_Nuevo",
			"IN_Privados_Nuevo",
			"IN_Victimas_Nuevo",
			"IN_Raizal_Nuevo",
			"IN_Rom_Nuevo",
			"IN_Discapacidad_7_10_Nuevo",
			BeneficiarioSinInformacion::raw("CONCAT('{\"value\":\"', tb_nidos_beneficiario_sin_informacion.Fk_Id_Lugar_Atencion, '\",\"text\":\"', la.VC_Nombre_Lugar, '\"}') AS lugar"),
			BeneficiarioSinInformacion::raw("CONCAT('{\"value\":\"', Fk_Id_Grupo, '\",\"text\":\"', g.VC_Nombre_Grupo, '\"}') AS grupo"),
			BeneficiarioSinInformacion::raw("CONCAT('[',GROUP_CONCAT(CONCAT('{\"value\":\"', c.PK_Id_Contenido, '\",\"name\":\"', c.VC_Nombre_Contenido, '\"}')), ']') AS contenidos"),
			"DT_Fecha_Entrega",
			"VC_Documento_Soporte")
		->join("tb_nidos_lugar_atencion as la", "la.Pk_Id_lugar_atencion", "=", "tb_nidos_beneficiario_sin_informacion.Fk_Id_Lugar_Atencion")
		->join("tb_nidos_grupos as g", "g.Pk_Id_Grupo", "=", "Fk_Id_Grupo")
		->join("tb_nidos_contenido as c", function($join){
			$join->on(DB::Raw("FIND_IN_SET(c.PK_Id_Contenido, VC_Contenido)"), ">", \DB::raw("'0'"));
		})
		->where("Pk_Id_Registro", $request->id_cifra)
		->groupBy("Pk_Id_Registro")
		->get();
		return response()->json(json_decode($info), 200);
	}
}
