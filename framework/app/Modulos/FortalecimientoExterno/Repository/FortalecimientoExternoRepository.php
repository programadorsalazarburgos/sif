<?php

namespace App\Modulos\FortalecimientoExterno\Repository;

use App\Modulos\FortalecimientoExterno\Interfaces\FortalecimientoExternoInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Modulos\Duplas\Dupla;
use App\Modulos\FortalecimientoExterno\OfertaFortalecimientoExterno;
use App\Modulos\FortalecimientoExterno\GrupoFortalecimientoExterno;
use App\Modulos\FortalecimientoExterno\SesionFortalecimientoExterno;
use App\Modulos\FortalecimientoExterno\ParticipanteGrupoFortalecimientoExterno;
use App\Modulos\FortalecimientoExterno\ParticipanteFortalecimientoExterno;
use App\Modulos\FortalecimientoExterno\AsistenciaFortalecimientoExterno;


class FortalecimientoExternoRepository implements FortalecimientoExternoInterface
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

	public function getOfertaFortalecimientoExterno()
	{
		$oferta = OfertaFortalecimientoExterno::all();
		return response()->json(json_decode($oferta), 200);
	}

	public function cambiarEstadoOferta($request)
	{
		$oferta = new OfertaFortalecimientoExterno;
		$oferta->where('id', $request->id_oferta)->update(["estado" => $request->estado_cambio]);
	}

	public function procesarOferta($request)
	{
		$datos = json_decode($request["form"]);

		if ($request->proceso == "crear") {
			$oferta = new OfertaFortalecimientoExterno;
			$oferta->modulo = $datos->modulo;
			$oferta->descripcion = $datos->descripcion;
			$oferta->fecha_creacion = date("Y-m-d H:i:s");
			$oferta->save();
		} else {
			$oferta = new OfertaFortalecimientoExterno;
			$oferta->where('id', $request->id_oferta)->update(["modulo" => $datos->modulo, "descripcion" => $datos->descripcion]);
		}
	}

	public function getGruposOferta($request)
	{
		$grupos = GrupoFortalecimientoExterno::select("id as value", GrupoFortalecimientoExterno::raw("CONCAT(modulo_oferta, ' ', jornada_oferta, ' Grupo ', id) as text"));
		if (isset($request->id_dupla)) {
			$grupos = $grupos->where("fk_dupla", $request->id_dupla);
		}
		$grupos = $grupos->get();
		return response()->json($grupos, 200);
	}

	public function getDuplas()
	{
		$duplas = Dupla::select("Pk_Id_Dupla", "VC_Codigo_Dupla")
			->with("artistas")
			->where([
				["Fk_Id_Tipo_Dupla", 4],
				["IN_Estado", 1]
			])
			->get();

		foreach ($duplas as $key => $dupla) {
			$texto = $dupla->VC_Codigo_Dupla . ' (';
			foreach ($dupla->artistas as $artista) {
				$texto .= $artista->full_name . ' - ';
			}
			$texto = substr($texto, 0, -3);
			$texto .= ')';

			$data[] = [
				'value' => $dupla->Pk_Id_Dupla,
				'text' => $texto,
			];
		}
		return response()->json($data);
	}

	public function asignarDuplaGrupo($request)
	{
		$grupo = new GrupoFortalecimientoExterno;
		$grupo->where("id", $request->id_grupo)->update(["fk_dupla" => $request->id_dupla]);
	}

	public function getSesionesGrupo($request)
	{
		if ($request->tipo_consulta == "count") {
			$sesiones = SesionFortalecimientoExterno::select("id")
				->where("fk_grupo", $request->id_grupo)
				->count();
		} else {
			$resultado = SesionFortalecimientoExterno::select("id", "fecha_sesion")
				->where("fk_grupo", $request->id_grupo)
				->get();

			foreach ($resultado as $key => $r) {
				$sesiones[] = [
					'value' => $r->id,
					'text' => $r->fecha_sesion
				];
			}
		}
		return response()->json($sesiones, 200);
	}

	public function validarFechaSesion($request)
	{
		$fecha_sesion_existente = SesionFortalecimientoExterno::where([
			["fk_grupo", $request->id_grupo],
			["fecha_sesion", $request->fecha_sesion]
		])
			->first();

		if ($fecha_sesion_existente == null) {
			return response()->json("", 200);
		} else {
			$fecha_sesion_existente = $fecha_sesion_existente->getRawOriginal("fecha_sesion");
			return response()->json($fecha_sesion_existente, 200);
		}
	}

	public function getParticipantesGrupo($request)
	{
		$participantes = GrupoFortalecimientoExterno::with("participantes")
			->where("id", $request->id_grupo)
			->get();

		return response()->json($participantes[0], 200);
	}

	public function consultaEdicionAsistencia($request)
	{
		$asistencia = AsistenciaFortalecimientoExterno::select("*")
			->with("participantes")
			->where("fk_sesion", $request->id_sesion)
			->get();

		return response()->json($asistencia, 200);
	}

	public function guardarAsistencia($request)
	{
		$datos = json_decode($request["form"]);

		if ($request["accion"] == "guardar") {
			$sesion = new SesionFortalecimientoExterno;
			$sesion->fk_dupla = $datos->id_dupla;
			$sesion->fk_grupo = $datos->grupo->value;
			$sesion->fecha_sesion = $datos->fecha_sesion;
			$sesion->fecha_registro = date("Y-m-d H:i:s");
			$sesion->quien_registro = $datos->id_persona;
			$sesion->save();

			$id_insertado_sesion = $sesion->id;

			foreach ($datos->participantes as $participante) {
				$asistencia = new AsistenciaFortalecimientoExterno;
				$asistencia->fk_participante = $participante->id;
				$asistencia->fk_sesion = $id_insertado_sesion;
				$asistencia->asistencia = $participante->asistencia;
				$asistencia->fechas_classroom = $participante->fechas_classroom;
				$asistencia->save();
			}
		} else {
			foreach ($datos->participantes as $participante) {
				$asistencia = AsistenciaFortalecimientoExterno::where([["fk_participante", $participante->id], ["fk_sesion", $datos->fecha_sesion->value]])->first();
				$asistencia->asistencia = $participante->asistencia;
				$asistencia->fechas_classroom = $participante->fechas_classroom;
				$asistencia->save();
			}
		}
	}

	public function getOfertaActivaFortalecimientoExterno()
	{
		$oferta = OfertaFortalecimientoExterno::where("estado", 1)
			->get();

		foreach ($oferta as $key => $o) {
			$data[] = [
				'value' => $o->id,
				'text' => $o->modulo
			];
		}
		return response()->json($data, 200);
	}

	public function guardarSolicitud($request)
	{
		$datos = json_decode($request["form"]);

		$grupos = GrupoFortalecimientoExterno::select("id")
			->withCount("participantes")
			->where([
				["fk_oferta", $datos->modulo_fortalecimiento->value],
				["jornada_oferta", $datos->jornada_fortalecimiento->value],
			])
			->groupBy("id")
			->orderBy("id", "desc")
			->limit(1)
			->get();

		if ($grupos->isEmpty() || $grupos[0]["participantes_count"] >= 30) {

			$nuevo_grupo = new GrupoFortalecimientoExterno;

			$nuevo_grupo->fk_oferta = $datos->modulo_fortalecimiento->value;
			$nuevo_grupo->modulo_oferta = $datos->modulo_fortalecimiento->text;
			$nuevo_grupo->jornada_oferta = $datos->jornada_fortalecimiento->value;
			$nuevo_grupo->fecha_creacion = date("Y-m-d H:i:s");
			$nuevo_grupo->save();

			$last_id_grupo = $nuevo_grupo->id;
		} else {
			$last_id_grupo = $grupos[0]["id"];
		}

		$participante = new ParticipanteFortalecimientoExterno;

		$participante->primer_nombre = $datos->primer_nombre;
		$participante->segundo_nombre = $datos->segundo_nombre;
		$participante->primer_apellido = $datos->primer_apellido;
		$participante->segundo_apellido = $datos->segundo_apellido;
		$participante->tipo_documento = $datos->tipo_documento->value;
		$participante->numero_documento = $datos->numero_documento;
		$participante->correo = $datos->correo;
		$participante->fecha_nacimiento = $datos->fecha_nacimiento;
		$participante->celular = $datos->celular;
		$participante->genero = $datos->genero->value;
		$participante->otro_genero = $datos->otro_genero;
		$participante->sector_social = $datos->sector_social->value;
		$participante->grupo_etnico = $datos->grupo_etnico->value;
		$participante->entidad = "SECRETARIA DE EDUCACIÓN (SED)";
		$participante->tipo_vinculacion = $datos->tipo_vinculacion->value;
		$participante->otro_tipo_vinculacion = $datos->otro_tipo_vinculacion;
		$participante->localidad_trabajo = $datos->localidad_trabajo->value;
		$participante->fk_barrio = $datos->barrio_trabajo->value;
		$participante->barrio_trabajo = $datos->barrio_trabajo->text;
		$participante->sitio_trabajo = $datos->sitio_trabajo;

		$array_nivel = [];
		foreach ($datos->nivel as $key => $value) {
			array_push($array_nivel, $value->value);
		}

		$participante->nivel_trabajo = $array_nivel;
		$participante->otro_nivel_trabajo = $datos->otro_nivel;
		$participante->ocupacion = $datos->ocupacion->value;
		$participante->otra_ocupacion = $datos->otra_ocupacion;
		$participante->id_modulo_fortalecimiento = $datos->modulo_fortalecimiento->value;
		$participante->modulo_fortalecimiento = $datos->modulo_fortalecimiento->text;
		$participante->jornada_fortalecimiento = $datos->jornada_fortalecimiento->value;
		$participante->fecha_registro = date("Y-m-d H:i:s");
		$participante->save();

		$last_id_participante = $participante->id;

		$participante_grupo = new ParticipanteGrupoFortalecimientoExterno;
		$participante_grupo->fk_grupo = $last_id_grupo;
		$participante_grupo->fk_participante = $last_id_participante;
		$participante_grupo->fecha_ingreso = date("Y-m-d H:i:s");
		$participante_grupo->save();
	}

	public function getInformacionParticipantes($request)
	{
		$data = GrupoFortalecimientoExterno::with("participantes.tipoDocumento:FK_Value,VC_Descripcion", "participantes.sectorSocial:FK_Value,VC_Descripcion", "participantes.grupoEtnico:FK_Value,VC_Descripcion", "participantes.localidadTrabajo:FK_Value,VC_Descripcion");

		if ($request->id_grupo != "") {
			$data = $data->where("id", $request->id_grupo);
		}

		$data = $data->get();

		return response()->json($data, 200);
	}

	public function getCuposGruposOferta($request)
	{
		$data = GrupoFortalecimientoExterno::select("id", "jornada_oferta", "modulo_oferta")
			->withCount(["participantes" => function ($query) {
				$query->where("estado", 1)->groupBy("fk_grupo");
			}])
			->where("estado", 1)
			->get();

		return response()->json($data, 200);
	}

	public function getReportePandora($request)
	{
		$mes = $request->mes;
		$id_dupla = $request->id_dupla;

		$sql = "SELECT
		(SELECT
		COUNT(pgfe.id)	
		FROM tb_nidos_participantes_grupos_fortalecimiento_externo pgfe
		JOIN tb_nidos_participantes_fortalecimiento_externo p ON p.id=pgfe.fk_participante
		WHERE pfe.localidad_trabajo=p.localidad_trabajo) AS TOTAL_INSCRITOS,
		sfe.id AS ID_SESION,
		sfe.fecha_sesion,
		pdl.FK_Value,
		pdl.VC_Descripcion,
		COUNT(CASE WHEN pfe.genero = 1 AND (
			SELECT COALESCE(MIN(s.fecha_sesion), '2100-12-31')
			FROM tb_nidos_asistencias_fortalecimiento_externo a
			JOIN tb_nidos_sesiones_fortalecimiento_externo s ON s.id = a.fk_sesion
			WHERE a.fk_participante = afe.fk_participante AND a.asistencia = 1) BETWEEN '2021-$mes-01' AND '2021-$mes-31' THEN 1 END) AS HOMBRES,
		COUNT(CASE WHEN pfe.genero = 2 AND (
			SELECT COALESCE(MIN(s.fecha_sesion), '2100-12-31')
			FROM tb_nidos_asistencias_fortalecimiento_externo a
			JOIN tb_nidos_sesiones_fortalecimiento_externo s ON s.id = a.fk_sesion
			WHERE a.fk_participante = afe.fk_participante AND a.asistencia = 1) BETWEEN '2021-$mes-01' AND '2021-$mes-31' THEN 1 END) AS MUJERES,
		COUNT(CASE WHEN (
			SELECT COALESCE(MIN(s.fecha_sesion), '2100-12-31')
			FROM tb_nidos_asistencias_fortalecimiento_externo a
			JOIN tb_nidos_sesiones_fortalecimiento_externo s ON s.id = a.fk_sesion
			WHERE a.fk_participante = afe.fk_participante AND a.asistencia = 1) BETWEEN '2021-$mes-01' AND '2021-$mes-31' THEN 1 END) AS TOTAL,
		COUNT(CASE WHEN TIMESTAMPDIFF(YEAR, pfe.fecha_nacimiento, sfe.fecha_sesion) >= 18 AND TIMESTAMPDIFF(YEAR, pfe.fecha_nacimiento, sfe.fecha_sesion) <= 28 AND (
			SELECT COALESCE(MIN(s.fecha_sesion), '2100-12-31')
			FROM tb_nidos_asistencias_fortalecimiento_externo a
			JOIN tb_nidos_sesiones_fortalecimiento_externo s ON s.id = a.fk_sesion
			WHERE a.fk_participante = afe.fk_participante AND a.asistencia = 1) BETWEEN '2021-$mes-01' AND '2021-$mes-31' THEN 1 END) AS JUVENTUD,
		COUNT(CASE WHEN TIMESTAMPDIFF(YEAR, pfe.fecha_nacimiento, sfe.fecha_sesion) >= 29 AND TIMESTAMPDIFF(YEAR, pfe.fecha_nacimiento, sfe.fecha_sesion) <= 59 AND (
			SELECT COALESCE(MIN(s.fecha_sesion), '2100-12-31')
			FROM tb_nidos_asistencias_fortalecimiento_externo a
			JOIN tb_nidos_sesiones_fortalecimiento_externo s ON s.id = a.fk_sesion
			WHERE a.fk_participante = afe.fk_participante AND a.asistencia = 1) BETWEEN '2021-$mes-01' AND '2021-$mes-31' THEN 1 END) AS PERSONAS_ADULTAS,
		COUNT(CASE WHEN TIMESTAMPDIFF(YEAR, pfe.fecha_nacimiento, sfe.fecha_sesion) >= 60 AND (
			SELECT COALESCE(MIN(s.fecha_sesion), '2100-12-31')
			FROM tb_nidos_asistencias_fortalecimiento_externo a
			JOIN tb_nidos_sesiones_fortalecimiento_externo s ON s.id = a.fk_sesion
			WHERE a.fk_participante = afe.fk_participante AND a.asistencia = 1) BETWEEN '2021-$mes-01' AND '2021-$mes-31' THEN 1 END) AS MAYORES,
		COUNT(CASE WHEN pfe.sector_social = 14 AND (
			SELECT COALESCE(MIN(s.fecha_sesion), '2100-12-31')
			FROM tb_nidos_asistencias_fortalecimiento_externo a
			JOIN tb_nidos_sesiones_fortalecimiento_externo s ON s.id = a.fk_sesion
			WHERE a.fk_participante = afe.fk_participante AND a.asistencia = 1) BETWEEN '2021-$mes-01' AND '2021-$mes-31' THEN 1 END) AS COMUNIDAD_RURAL,
		COUNT(CASE WHEN pfe.sector_social = 27 AND (
			SELECT COALESCE(MIN(s.fecha_sesion), '2100-12-31')
			FROM tb_nidos_asistencias_fortalecimiento_externo a
			JOIN tb_nidos_sesiones_fortalecimiento_externo s ON s.id = a.fk_sesion
			WHERE a.fk_participante = afe.fk_participante AND a.asistencia = 1) BETWEEN '2021-$mes-01' AND '2021-$mes-31' THEN 1 END) AS MUJERES_GESTANTES,
		COUNT(CASE WHEN pfe.sector_social = 18 AND (
			SELECT COALESCE(MIN(s.fecha_sesion), '2100-12-31')
			FROM tb_nidos_asistencias_fortalecimiento_externo a
			JOIN tb_nidos_sesiones_fortalecimiento_externo s ON s.id = a.fk_sesion
			WHERE a.fk_participante = afe.fk_participante AND a.asistencia = 1) BETWEEN '2021-$mes-01' AND '2021-$mes-31' THEN 1 END) AS ACTIVIDADES_SEXUALES,
		COUNT(CASE WHEN pfe.sector_social = 12 AND (
			SELECT COALESCE(MIN(s.fecha_sesion), '2100-12-31')
			FROM tb_nidos_asistencias_fortalecimiento_externo a
			JOIN tb_nidos_sesiones_fortalecimiento_externo s ON s.id = a.fk_sesion
			WHERE a.fk_participante = afe.fk_participante AND a.asistencia = 1) BETWEEN '2021-$mes-01' AND '2021-$mes-31' THEN 1 END) AS HABITANTES_CALLE,
		COUNT(CASE WHEN pfe.sector_social = 5 AND (
			SELECT COALESCE(MIN(s.fecha_sesion), '2100-12-31')
			FROM tb_nidos_asistencias_fortalecimiento_externo a
			JOIN tb_nidos_sesiones_fortalecimiento_externo s ON s.id = a.fk_sesion
			WHERE a.fk_participante = afe.fk_participante AND a.asistencia = 1) BETWEEN '2021-$mes-01' AND '2021-$mes-31' THEN 1 END) AS DISCAPACIDAD,
		COUNT(CASE WHEN pfe.sector_social = 10 AND (
			SELECT COALESCE(MIN(s.fecha_sesion), '2100-12-31')
			FROM tb_nidos_asistencias_fortalecimiento_externo a
			JOIN tb_nidos_sesiones_fortalecimiento_externo s ON s.id = a.fk_sesion
			WHERE a.fk_participante = afe.fk_participante AND a.asistencia = 1) BETWEEN '2021-$mes-01' AND '2021-$mes-31' THEN 1 END) AS PRIVADOS_LIBERTAD,
		COUNT(CASE WHEN pfe.sector_social = 28 AND (
			SELECT COALESCE(MIN(s.fecha_sesion), '2100-12-31')
			FROM tb_nidos_asistencias_fortalecimiento_externo a
			JOIN tb_nidos_sesiones_fortalecimiento_externo s ON s.id = a.fk_sesion
			WHERE a.fk_participante = afe.fk_participante AND a.asistencia = 1) BETWEEN '2021-$mes-01' AND '2021-$mes-31' THEN 1 END) AS PROFESIONALES,
		COUNT(CASE WHEN pfe.sector_social = 22 AND (
			SELECT COALESCE(MIN(s.fecha_sesion), '2100-12-31')
			FROM tb_nidos_asistencias_fortalecimiento_externo a
			JOIN tb_nidos_sesiones_fortalecimiento_externo s ON s.id = a.fk_sesion
			WHERE a.fk_participante = afe.fk_participante AND a.asistencia = 1) BETWEEN '2021-$mes-01' AND '2021-$mes-31' THEN 1 END) AS LGTBIQ,
		COUNT(CASE WHEN pfe.sector_social = 4 AND (
			SELECT COALESCE(MIN(s.fecha_sesion), '2100-12-31')
			FROM tb_nidos_asistencias_fortalecimiento_externo a
			JOIN tb_nidos_sesiones_fortalecimiento_externo s ON s.id = a.fk_sesion
			WHERE a.fk_participante = afe.fk_participante AND a.asistencia = 1) BETWEEN '2021-$mes-01' AND '2021-$mes-31' THEN 1 END) AS VICTIMAS_CONFLICTO,
		COUNT(CASE WHEN pfe.sector_social = 19 AND (
			SELECT COALESCE(MIN(s.fecha_sesion), '2100-12-31')
			FROM tb_nidos_asistencias_fortalecimiento_externo a
			JOIN tb_nidos_sesiones_fortalecimiento_externo s ON s.id = a.fk_sesion
			WHERE a.fk_participante = afe.fk_participante AND a.asistencia = 1) BETWEEN '2021-$mes-01' AND '2021-$mes-31' THEN 1 END) AS POBLACION_MIGRANTE,
		COUNT(CASE WHEN pfe.sector_social = 29 AND (
			SELECT COALESCE(MIN(s.fecha_sesion), '2100-12-31')
			FROM tb_nidos_asistencias_fortalecimiento_externo a
			JOIN tb_nidos_sesiones_fortalecimiento_externo s ON s.id = a.fk_sesion
			WHERE a.fk_participante = afe.fk_participante AND a.asistencia = 1) BETWEEN '2021-$mes-01' AND '2021-$mes-31' THEN 1 END) AS VICTIMAS_TRATA,
		COUNT(CASE WHEN pfe.sector_social = 23 AND (
			SELECT COALESCE(MIN(s.fecha_sesion), '2100-12-31')
			FROM tb_nidos_asistencias_fortalecimiento_externo a
			JOIN tb_nidos_sesiones_fortalecimiento_externo s ON s.id = a.fk_sesion
			WHERE a.fk_participante = afe.fk_participante AND a.asistencia = 1) BETWEEN '2021-$mes-01' AND '2021-$mes-31' THEN 1 END) AS EMERGENCIA_SOCIAL,
		COUNT(CASE WHEN pfe.sector_social = 20 AND (
			SELECT COALESCE(MIN(s.fecha_sesion), '2100-12-31')
			FROM tb_nidos_asistencias_fortalecimiento_externo a
			JOIN tb_nidos_sesiones_fortalecimiento_externo s ON s.id = a.fk_sesion
			WHERE a.fk_participante = afe.fk_participante AND a.asistencia = 1) BETWEEN '2021-$mes-01' AND '2021-$mes-31' THEN 1 END) AS DETERIORO,
		COUNT(CASE WHEN pfe.sector_social = 30 AND (
			SELECT COALESCE(MIN(s.fecha_sesion), '2100-12-31')
			FROM tb_nidos_asistencias_fortalecimiento_externo a
			JOIN tb_nidos_sesiones_fortalecimiento_externo s ON s.id = a.fk_sesion
			WHERE a.fk_participante = afe.fk_participante AND a.asistencia = 1) BETWEEN '2021-$mes-01' AND '2021-$mes-31' THEN 1 END) AS VULNERABILIDAD,
		COUNT(CASE WHEN pfe.sector_social = 26 AND (
			SELECT COALESCE(MIN(s.fecha_sesion), '2100-12-31')
			FROM tb_nidos_asistencias_fortalecimiento_externo a
			JOIN tb_nidos_sesiones_fortalecimiento_externo s ON s.id = a.fk_sesion
			WHERE a.fk_participante = afe.fk_participante AND a.asistencia = 1) BETWEEN '2021-$mes-01' AND '2021-$mes-31' THEN 1 END) AS DESPLAZAMIENTO,
		COUNT(CASE WHEN pfe.sector_social = 24 AND (
			SELECT COALESCE(MIN(s.fecha_sesion), '2100-12-31')
			FROM tb_nidos_asistencias_fortalecimiento_externo a
			JOIN tb_nidos_sesiones_fortalecimiento_externo s ON s.id = a.fk_sesion
			WHERE a.fk_participante = afe.fk_participante AND a.asistencia = 1) BETWEEN '2021-$mes-01' AND '2021-$mes-31' THEN 1 END) AS CONSUMIDORAS,
		COUNT(CASE WHEN pfe.sector_social = 2 AND (
			SELECT COALESCE(MIN(s.fecha_sesion), '2100-12-31')
			FROM tb_nidos_asistencias_fortalecimiento_externo a
			JOIN tb_nidos_sesiones_fortalecimiento_externo s ON s.id = a.fk_sesion
			WHERE a.fk_participante = afe.fk_participante AND a.asistencia = 1) BETWEEN '2021-$mes-01' AND '2021-$mes-31' THEN 1 END) AS ROM,
		COUNT(CASE WHEN pfe.sector_social = 31 AND (
			SELECT COALESCE(MIN(s.fecha_sesion), '2100-12-31')
			FROM tb_nidos_asistencias_fortalecimiento_externo a
			JOIN tb_nidos_sesiones_fortalecimiento_externo s ON s.id = a.fk_sesion
			WHERE a.fk_participante = afe.fk_participante AND a.asistencia = 1) BETWEEN '2021-$mes-01' AND '2021-$mes-31' THEN 1 END) AS PROM,
		COUNT(CASE WHEN pfe.sector_social = 3 AND (
			SELECT COALESCE(MIN(s.fecha_sesion), '2100-12-31')
			FROM tb_nidos_asistencias_fortalecimiento_externo a
			JOIN tb_nidos_sesiones_fortalecimiento_externo s ON s.id = a.fk_sesion
			WHERE a.fk_participante = afe.fk_participante AND a.asistencia = 1) BETWEEN '2021-$mes-01' AND '2021-$mes-31' THEN 1 END) AS INDIGENA,
		COUNT(CASE WHEN pfe.sector_social = 25 AND (
			SELECT COALESCE(MIN(s.fecha_sesion), '2100-12-31')
			FROM tb_nidos_asistencias_fortalecimiento_externo a
			JOIN tb_nidos_sesiones_fortalecimiento_externo s ON s.id = a.fk_sesion
			WHERE a.fk_participante = afe.fk_participante AND a.asistencia = 1) BETWEEN '2021-$mes-01' AND '2021-$mes-31' THEN 1 END) AS COMUNIDADES_NEGRAS,
		COUNT(CASE WHEN pfe.sector_social = 1 AND (
			SELECT COALESCE(MIN(s.fecha_sesion), '2100-12-31')
			FROM tb_nidos_asistencias_fortalecimiento_externo a
			JOIN tb_nidos_sesiones_fortalecimiento_externo s ON s.id = a.fk_sesion
			WHERE a.fk_participante = afe.fk_participante AND a.asistencia = 1) BETWEEN '2021-$mes-01' AND '2021-$mes-31' THEN 1 END) AS AFRO,
		COUNT(CASE WHEN pfe.sector_social = 21 AND (
			SELECT COALESCE(MIN(s.fecha_sesion), '2100-12-31')
			FROM tb_nidos_asistencias_fortalecimiento_externo a
			JOIN tb_nidos_sesiones_fortalecimiento_externo s ON s.id = a.fk_sesion
			WHERE a.fk_participante = afe.fk_participante AND a.asistencia = 1) BETWEEN '2021-$mes-01' AND '2021-$mes-31' THEN 1 END) AS PALENQUERAS,
		COUNT(CASE WHEN pfe.sector_social = 13 AND (
			SELECT COALESCE(MIN(s.fecha_sesion), '2100-12-31')
			FROM tb_nidos_asistencias_fortalecimiento_externo a
			JOIN tb_nidos_sesiones_fortalecimiento_externo s ON s.id = a.fk_sesion
			WHERE a.fk_participante = afe.fk_participante AND a.asistencia = 1) BETWEEN '2021-$mes-01' AND '2021-$mes-31' THEN 1 END) AS RAIZAL
			FROM tb_nidos_asistencias_fortalecimiento_externo afe
			JOIN tb_nidos_participantes_fortalecimiento_externo pfe ON pfe.id = afe.fk_participante
			JOIN tb_nidos_sesiones_fortalecimiento_externo sfe ON sfe.id = afe.fk_sesion
			JOIN tb_parametro_detalle pdl ON pdl.FK_Value = pfe.localidad_trabajo AND pdl.FK_Id_Parametro = 19 AND pdl.IN_Estado_Nidos = 1
			WHERE afe.asistencia = 1 AND sfe.fecha_sesion BETWEEN '2021-$mes-01' AND '2021-$mes-31'";

		if ($request->id_dupla != "") {
			$sql .= " AND sfe.fk_dupla=$id_dupla";
		}

		$sql .= " GROUP	BY pfe.localidad_trabajo";

		$data = DB::select($sql);

		return response()->json($data, 200);
	}
}
