<?php

namespace App\Modulos\Oferta\Repository;

use App\Modulos\Oferta\Interfaces\OfertaInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Modulos\Oferta\Preinscripcion;
use App\Modulos\Estudiantes\Estudiante;
use App\Modulos\Estudiantes\EstudianteDetalleAnio;
use App\Modulos\Estudiantes\EstudianteArchivo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailPreinscripcion;
use App\Modulos\Grupos\GrupoEmprendeClan;
use App\Modulos\Grupos\GrupoEmprendeClanEstudiante;
//use App\Models\Options;

class OfertaRepository implements OfertaInterface
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

	// public function getLocalidadesOfertaDisponible($request){

	// 	$localidades = options::select("VC_Descripcion as text", "FK_Value as value")
	// 	->where("FK_Id_Parametro", 19)
	// 	->whereHas("gruposOfertaDisponible", function($query){
	// 		$query->where([
	// 			['estado', 1],
	// 			["abierto_publico", 1]
	// 		]);
	// 	})
	// 	->get();
	// 	return response()->json(json_decode($localidades), 200);
	// }

	public function guardarPreinscripcion($request)
	{
		$datos = json_decode($request["data"]);
		$datos->notificacion_email = "confirmacion_preinscripcion";

		$archivo_documento_identidad = $request->archivo_documento_identidad;
		$nombre_archivo_documento_identidad = $request->archivo_documento_identidad->getClientOriginalName();
		$archivo_documento_identidad->storeAs("documentosEstudiantes/" . date("Y") . "/" . $datos->numero_documento . "/", $nombre_archivo_documento_identidad, 'uploadedfiles');
		$path_archivo_documento_identidad = "../../../../uploadedFiles/documentosEstudiantes/" . date("Y") . "/" . $datos->numero_documento . "/" . $nombre_archivo_documento_identidad;

		$archivo_eps = $request->archivo_eps;
		$nombre_archivo_eps = $request->archivo_eps->getClientOriginalName();
		$archivo_eps->storeAs("documentosEstudiantes/" . date("Y") . "/" . $datos->numero_documento . "/", $nombre_archivo_eps, 'uploadedfiles');
		$path_archivo_eps = "../../../../uploadedFiles/documentosEstudiantes/" . date("Y") . "/" . $datos->numero_documento . "/" . $nombre_archivo_eps;

		$archivo_recibo_publico = $request->archivo_recibo_publico;
		$nombre_archivo_recibo_publico = $request->archivo_recibo_publico->getClientOriginalName();
		$archivo_recibo_publico->storeAs("documentosEstudiantes/" . date("Y") . "/" . $datos->numero_documento . "/", $nombre_archivo_recibo_publico, 'uploadedfiles');
		$path_recibo_publico = "../../../../uploadedFiles/documentosEstudiantes/" . date("Y") . "/" . $datos->numero_documento . "/" . $nombre_archivo_recibo_publico;

		$preinscripcion = new Preinscripcion;

		$preinscripcion->numero_documento = $datos->numero_documento;
		$preinscripcion->tipo_documento = $datos->tipo_documento->value;
		$preinscripcion->primer_nombre = $datos->primer_nombre;
		$preinscripcion->segundo_nombre = $datos->segundo_nombre;
		$preinscripcion->primer_apellido = $datos->primer_apellido;
		$preinscripcion->segundo_apellido = $datos->segundo_apellido;
		$preinscripcion->fecha_nacimiento = $datos->fecha_nacimiento;
		$preinscripcion->direccion = $datos->direccion;
		$preinscripcion->correo = $datos->correo;
		$preinscripcion->telefono_fijo = $datos->telefono_fijo;
		$preinscripcion->celular = $datos->celular;
		$preinscripcion->localidad = $datos->localidad->value;
		$preinscripcion->barrio = $datos->barrio;
		$preinscripcion->genero = $datos->genero->value;
		$preinscripcion->estrato = $datos->estrato->value;
		$preinscripcion->grupo_poblacional = $datos->grupo_poblacional->value;
		$preinscripcion->archivo_documento_identidad = $path_archivo_documento_identidad;
		$preinscripcion->archivo_eps = $path_archivo_eps;
		$preinscripcion->archivo_recibo_publico = $path_recibo_publico;
		$preinscripcion->autorizacion_imagen = $datos->autorizacion_imagen;
		$preinscripcion->autorizacion_datos = $datos->autorizacion_datos;
		$preinscripcion->fecha_solicitud = date("Y-m-d H:i:s");
		$preinscripcion->grupo = $datos->id_grupo;
		$preinscripcion->modalidad = $datos->modalidad_area;
		$preinscripcion->save();

		Mail::to($datos->correo)->send(new EmailPreinscripcion($datos));

		$correos_crea = explode(',', $datos->correo_crea);

		$datos->notificacion_email = "crea";

		foreach ($correos_crea as $recipient) {
			Mail::to($recipient)->send(new EmailPreinscripcion($datos));
		}
	}

	public function getPreinscritosGrupo($request)
	{
		$preinscritos = Preinscripcion::select("tb_preinscripcion.*", "IE.FK_grupo as grupo_existente")->where([
			["tb_preinscripcion.grupo", $request->id_grupo],
			["tb_preinscripcion.estado", 0]
		])
			->leftJoin('tb_estudiante as E', 'E.IN_Identificacion', '=', 'numero_documento')
			//->leftJoin('tb_terr_grupo_emprende_clan_estudiante as IE', 'IE.FK_estudiante', '=', 'E.id')
			->leftJoin('tb_terr_grupo_emprende_clan_estudiante as IE', function ($join) {
				$join->on('IE.FK_estudiante', '=', 'E.id');
				$join->on('IE.estado', '=', DB::raw('1'));
			})
			->groupBy('tb_preinscripcion.id')
			->orderBy("fecha_solicitud", "ASC")->get();

		return response()->json(json_decode($preinscritos), 200);
	}

	public function aprobarPreinscripcion($request)
	{

		try {
			$datos = json_decode($request["form_aprobar"]);
			$datos->notificacion_email = "aprobar";

			//Update tabla preinscripción
			$preinscripcion = Preinscripcion::where("id", $request->id)->first();
			$preinscripcion["estado"] = 1;
			$preinscripcion["fecha_revision"] = date("Y-m-d H:i:s");
			$preinscripcion["persona_revision"] = $request->id_persona;
			$preinscripcion->save();

			//Insert o update en tabla estudiante
			$estudiante_existente = Estudiante::where("IN_Identificacion", $datos->numero_documento)->first();

			if (is_null($estudiante_existente)) {
				$estudiante = new Estudiante;

				$estudiante->IN_Identificacion = $datos->numero_documento;
				$estudiante->VC_Tipo_Estudiante = "PREINSCRIPCION";
				$estudiante->DA_Fecha_Registro = date("Y-m-d H:i:s");
				$estudiante->Id_Usuario_Registro = $request->id_persona;
			} else {
				$estudiante = Estudiante::where("id", $estudiante_existente->id)->first();
			}

			$estudiante->CH_Tipo_Identificacion = $datos->tipo_documento->value;
			$estudiante->VC_Primer_Nombre = $datos->primer_nombre;
			$estudiante->VC_Segundo_Nombre = $datos->segundo_nombre;
			$estudiante->VC_Primer_Apellido = $datos->primer_apellido;
			$estudiante->VC_Segundo_Apellido = $datos->segundo_apellido;
			$estudiante->DD_F_Nacimiento = $datos->fecha_nacimiento;
			$estudiante->CH_Genero = $datos->genero->value;
			$estudiante->VC_Direccion = $datos->direccion;
			$estudiante->VC_Correo = $datos->correo;
			$estudiante->VC_Telefono = $datos->telefono_fijo;
			$estudiante->VC_Celular = $datos->celular;
			$estudiante->FK_RH = $datos->grupo_sanguineo->value;
			$estudiante->IN_Acepta_Uso_Imagen = $datos->autorizacion_imagen;
			$estudiante->save();

			$id_estudiante_creado = $estudiante->id;

			//Insert en tabla estudiante detalle año
			$estudiante_detalle_anio = EstudianteDetalleAnio::where([
				["FK_estudiante", $id_estudiante_creado],
				["anio", date("Y")]
			])
				->delete();

			$estudiante_detalle_anio = new EstudianteDetalleAnio;
			$estudiante_detalle_anio->FK_estudiante = $id_estudiante_creado;
			$estudiante_detalle_anio->anio = date("Y");
			$estudiante_detalle_anio->FK_clan = $datos->crea->value;
			$estudiante_detalle_anio->NOMBRE_ACUDIENTE = $datos->nombre_acudiente;
			$estudiante_detalle_anio->IDENTIFICACION_ACUDIENTE = $datos->numero_documento_acudiente;
			$estudiante_detalle_anio->TELEFONO_ACUDIENTE = $datos->celular_acudiente;
			$estudiante_detalle_anio->FK_Grupo_Poblacional = $datos->grupo_poblacional->value;
			$estudiante_detalle_anio->FK_Eps = (is_null($datos->eps) || $datos->eps == "") ? "null" : $datos->eps->value;
			$estudiante_detalle_anio->TX_Tipo_Afiliacion = (is_null($datos->tipo_afiliacion_eps) || $datos->tipo_afiliacion_eps == "") ? null : $datos->tipo_afiliacion_eps->value;
			$estudiante_detalle_anio->FK_RH = $datos->grupo_sanguineo->value;
			$estudiante_detalle_anio->TX_Enfermedades = $datos->enfermedades;
			$estudiante_detalle_anio->FK_Localidad = $datos->localidad->value;
			$estudiante_detalle_anio->TX_Barrio = $datos->barrio;
			$estudiante_detalle_anio->DA_fecha_creacion = date("Y-m-d H:i:s");
			$estudiante_detalle_anio->FK_usuario_creacion = $request->id_persona;
			$estudiante_detalle_anio->IN_estrato = $datos->estrato->value;
			$estudiante_detalle_anio->save();

			//Insert en tabla estudiante archivo
			$estudiante_archivo_existente = EstudianteArchivo::where([
				["FK_Id_Estudiante", $datos->numero_documento],
				["Anio", date("Y")]
			])
				->delete();

			for ($i = 0; $i < 3; $i++) {
				$estudiante_archivo = new EstudianteArchivo;
				$estudiante_archivo->FK_Id_Estudiante = $datos->numero_documento;
				switch ($i) {
					case 0:
						$archivo = substr($datos->archivo_documento_identidad, 26);
						break;
					case 1:
						$archivo = substr($datos->archivo_eps, 26);
						break;
					case 2:
						$archivo = substr($datos->archivo_recibo_publico, 26);
						break;
				}
				$nombre_archivo = explode("/", $archivo)[3];

				$estudiante_archivo->VC_Nombre_Archivo = $nombre_archivo;
				$estudiante_archivo->VC_Url = $archivo;
				$estudiante_archivo->DA_Fecha_Subida = date("Y-m-d H:i:s");
				$estudiante_archivo->FK_Usuario_Creacion = $request->id_persona;
				$estudiante_archivo->Anio = date("Y");
				$estudiante_archivo->save();
			}

			//Insert en tabla emprende estudiante
			$emprende_estudiante = new GrupoEmprendeClanEstudiante;
			$emprende_estudiante->FK_grupo = $datos->grupo;
			$emprende_estudiante->FK_estudiante = $id_estudiante_creado;
			$emprende_estudiante->DT_fecha_ingreso = date("Y-m-d H:i:s");
			$emprende_estudiante->FK_usuario_ingreso = $request->id_persona;
			$emprende_estudiante->estado = 1;
			$emprende_estudiante->save();

			$datos = $this->getDatosCrea($datos, $datos->grupo);

			Mail::to($datos->correo)->send(new EmailPreinscripcion($datos));
		} catch (\Exception $e) {
			// echo $e->getMessage(); 
			// dd($e);
			// return 0;
			//return response()->json($e->getMessage(), 500);
		}
	}

	public function rechazarPreinscripcion($request)
	{
		$preinscripcion = new Preinscripcion;
		$datos = json_decode($request["form_rechazar"]);
		$datos->notificacion_email = "rechazar";

		$datos = $this->getDatosCrea($datos, $datos->grupo);

		$array_update = array();
		$array_update["estado"] = 2;
		$array_update["fecha_revision"] = date("Y-m-d H:i:s");
		$array_update["persona_revision"] = $request->id_persona;
		$array_update["razon_rechazo"] = $datos->razon_rechazo->value;
		$array_update["justificacion_rechazo"] = $datos->justificacion_rechazo;

		$preinscripcion->where('id', $request->id)->update($array_update);

		Mail::to($datos->correo)->send(new EmailPreinscripcion($datos));
	}

	public function getDatosCrea($datos, $id_grupo)
	{

		$datos_crea = GrupoEmprendeClan::select("FK_clan")
			->where("PK_Grupo", $id_grupo)
			->with("crea:PK_Id_Clan,VC_Nom_Clan,VC_Direccion_Clan,VC_Telefono_Clan")
			->get();

		$datos_crea = json_decode($datos_crea[0]);
		$datos->crea = $datos_crea->crea->VC_Nom_Clan;
		$datos->direccion = $datos_crea->crea->VC_Direccion_Clan;
		$datos->telefono = $datos_crea->crea->VC_Telefono_Clan;
		return $datos;
	}
}
