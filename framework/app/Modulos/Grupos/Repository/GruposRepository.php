<?php

namespace App\Modulos\Grupos\Repository;

use App\Modulos\Grupos\Interfaces\GruposInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Modulos\Grupos\GrupoEmprendeClan;

class GruposRepository implements GruposInterface
{
	public function __construct()
	{
	}

	public function crear($data)
	{
	}
	public function dataTable($relaciones = [])
	{
	}
	public function show($relaciones = [])
	{
	}
	public function actualizar($request, $id)
	{
	}
	public function obtener($id, $relaciones = [])
	{
	}
	public function eliminar($id)
	{
	}
	public function obtenerTodo($relaciones = [])
	{
	}
	private function procesar($horario, $request)
	{
	}
	public function obtenerTabla($request)
	{
	}

	public function getOptionsOfertaDisponible($request)
	{
		$id_localidad = $request->id_localidad;
		$abierto_publico = $request->abierto_publico;

		$grupos = GrupoEmprendeClan::select("PK_Grupo", "FK_clan", "FK_area_artistica", "FK_modalidad", "IN_modalidad_atencion", "TX_observaciones", "IN_cupos")->where([
			["abierto_publico", $abierto_publico],
			["estado", 1]
		])
			->with("areaArtistica:FK_Value,VC_Descripcion")
			->with("horarios")
			->with("modalidadArtistica:PK_Id_Modalidad,VC_Nom_Modalidad")
			->withCount("estudiantesActivos")
			->with("crea:PK_Id_Clan,VC_Nom_Clan,VC_Direccion_Clan,VC_Telefono_Clan,VC_Correo_Administrador")->whereHas("crea", function ($query) use ($id_localidad) {
				$query->where("IN_Estado", 1)->whereRaw("FIND_IN_SET(" . $id_localidad . ", VC_Localidades_Atiende)");
				//$query->where('FK_Id_Localidad', $id_localidad);
			});

		if ($abierto_publico)
			$grupos = $grupos->havingRaw("IN_cupos - estudiantes_activos_count > 0");

		$grupos = $grupos->orderBy("FK_clan", "ASC")->get();
		return response()->json(json_decode($grupos), 200);
	}

	public function getGrupos($request)
	{
		$grupos = GrupoEmprendeClan::select("PK_Grupo as text", "PK_Grupo as value")->where([
			["abierto_publico", 1],
			["estado", 1],
			["FK_clan", $request->id_crea]
		])->get();

		return response()->json(json_decode($grupos), 200);
	}

	public function getCuposGrupo($request)
	{
		$cupos = GrupoEmprendeClan::select("IN_cupos")->where("PK_Grupo", $request->id_grupo)
			->withCount("estudiantesActivos as IN_cupos_disponibles")
			->get();
		return response()->json(json_decode($cupos[0]), 200);
	}
}
