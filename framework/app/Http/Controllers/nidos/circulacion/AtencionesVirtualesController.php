<?php

namespace App\Http\Controllers\nidos\circulacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\nidos\circulacion\AtencionVirtual;
use App\Models\nidos\territorial\Beneficiario;

class AtencionesVirtualesController extends Controller
{
	public function guardarSolicitud(Request $request){
		$datos = json_decode($request["form"]);

		$numero_documento_provisional = "";

		$beneficiario = new Beneficiario;

		if(($datos->potestad == "" || $datos->potestad == 0) && ($datos->acepta_politicas == 0 || $datos->acepta_politicas == 1)){
			$miliseconds = substr(microtime(), 2, 3);
			$date = strtotime(date("D M d Y H:i:s"));
			$value_time = $date.$miliseconds;
			$numero_documento_provisional = "SIFPROV".$value_time;
			if($datos->acepta_politicas == 0 && $datos->dirigido == 1){
				$beneficiario->VC_Primer_Nombre = $datos->primer_nombre_cuidador;
				$beneficiario->VC_Segundo_Nombre = $datos->segundo_nombre_cuidador;
				$beneficiario->VC_Primer_Apellido = $datos->primer_apellido_cuidador;
				$beneficiario->VC_Segundo_Apellido = $datos->segundo_apellido_cuidador;
			}else{
				$primer_nombre_provisional = "PN".$value_time;
				$primer_apellido_provisional = "PA".$value_time;
				$beneficiario->VC_Primer_Nombre = $primer_nombre_provisional;
				$beneficiario->VC_Primer_Apellido = $primer_apellido_provisional;
			}
			$beneficiario->VC_Identificacion = $numero_documento_provisional;
			$beneficiario->FK_Tipo_Identificacion = 8;
		}

		if($datos->potestad == 1){
			$beneficiario->VC_Identificacion = $datos->numero_documento_beneficiario;
			$beneficiario->FK_Tipo_Identificacion = $datos->tipo_documento_beneficiario->value;
			$beneficiario->VC_Primer_Nombre = $datos->primer_nombre_beneficiario;
			$beneficiario->VC_Segundo_Nombre = $datos->segundo_nombre_beneficiario;
			$beneficiario->VC_Primer_Apellido = $datos->primer_apellido_beneficiario;
			$beneficiario->VC_Segundo_Apellido = $datos->segundo_apellido_beneficiario;
		}

		if($datos->acepta_politicas == 1 && $datos->dirigido == 1){
			$numero_documento_provisional = "";
			$beneficiario->VC_Identificacion = $datos->numero_documento_cuidador;
			$beneficiario->FK_Tipo_Identificacion = $datos->tipo_documento_cuidador->value;
			$beneficiario->VC_Primer_Nombre = $datos->primer_nombre_cuidador;
			$beneficiario->VC_Segundo_Nombre = $datos->segundo_nombre_cuidador;
			$beneficiario->VC_Primer_Apellido = $datos->primer_apellido_cuidador;
			$beneficiario->VC_Segundo_Apellido = $datos->segundo_apellido_cuidador;
		}

		$beneficiario->DD_F_Nacimiento = $datos->fecha_nacimiento_beneficiario;
		$beneficiario->FK_Id_Genero = ($datos->dirigido == 1 || $datos->dirigido == 3) ? 2 : 1;
		$beneficiario->IN_Grupo_Poblacional = $datos->enfoque_beneficiario == "" ? $datos->enfoque_beneficiario : $datos->enfoque_beneficiario->value;
		$beneficiario->IN_Estrato = $datos->estrato_beneficiario == "" ? $datos->estrato_beneficiario : $datos->estrato_beneficiario->value;
		$beneficiario->DT_Fecha_Registro = date("Y-m-d H:i:s");
		$beneficiario->VC_Linea_Atendido = "Formulario ARN";
		$beneficiario->save();
		
		$atencion = new AtencionVirtual;
		$atencion->VC_Primer_Nombre_Cuidador = $datos->primer_nombre_cuidador;
		$atencion->VC_Segundo_Nombre_Cuidador = $datos->segundo_nombre_cuidador;
		$atencion->VC_Primer_Apellido_Cuidador = $datos->primer_apellido_cuidador;
		$atencion->VC_Segundo_Apellido_Cuidador = $datos->segundo_apellido_cuidador;
		$atencion->IN_Tipo_Doc_Cuidador = $datos->tipo_documento_cuidador ==  "" ? $datos->tipo_documento_cuidador : $datos->tipo_documento_cuidador->value;
		$atencion->IN_Identificacion_Cuidador = $datos->numero_documento_cuidador;
		$atencion->VC_Correo = $datos->correo_cuidador;
		$atencion->VC_Telefono = $datos->numero_cuidador;
		$atencion->IN_Parentesco = $datos->parentesco == "" ? $datos->parentesco : $datos->parentesco->value;
		$atencion->VC_Otro_Parentesco = $datos->otro_parentesco;
		$atencion->IN_Potestad = $datos->potestad;
		$atencion->IN_Dirigida_Atencion = $datos->dirigido;
		$atencion->VC_Autorizacion = $datos->acepta_politicas;

		$atencion->VC_Primer_Nombre_Beneficiario = $datos->primer_nombre_beneficiario;
		$atencion->VC_Segundo_Nombre_Beneficiario = $datos->segundo_nombre_beneficiario;
		$atencion->VC_Primer_Apellido_beneficiario = $datos->primer_apellido_beneficiario;
		$atencion->VC_Segundo_Apellido_Beneficiario = $datos->segundo_apellido_beneficiario;
		$atencion->FK_Tipo_Identificacion = $datos->tipo_documento_beneficiario == "" ? $datos->tipo_documento_beneficiario : $datos->tipo_documento_beneficiario->value;

		if($datos->acepta_politicas == 1 && $datos->dirigido == 1){
			$atencion->VC_Identificacion =$datos->numero_documento_cuidador;
		}else{
			$atencion->VC_Identificacion = $numero_documento_provisional == "" ? $datos->numero_documento_beneficiario : $numero_documento_provisional;
		}
		$atencion->DD_F_Nacimiento = $datos->fecha_nacimiento_beneficiario;
		$atencion->VC_Direccion = $datos->direccion_beneficiario;
		$atencion->IN_Localidad = $datos->localidad_beneficiario->value;
		$atencion->VC_Barrio = $datos->barrio_beneficiario->text;
		$atencion->IN_Upz = $datos->upz_beneficiario;
		$atencion->IN_Estrato = $datos->estrato_beneficiario == "" ? $datos->estrato_beneficiario : $datos->estrato_beneficiario->value;
		$atencion->VC_Grupo_Poblacional = $datos->enfoque_beneficiario == "" ? $datos->enfoque_beneficiario : $datos->enfoque_beneficiario->value;
		$atencion->VC_Comentarios = $datos->informacion_adicional;
		$atencion->VC_Whatsapp = $datos->whatsapp;
		$atencion->DD_Fecha_Solicitud = date("Y-m-d H:i:s");
		$atencion->IN_Formulario = 4;
		$atencion->save();
	}
	public function guardarSolicitudAulaHospitalaria(Request $request){
		$datos = json_decode($request["form"]);

		$numero_documento_provisional = "";

		$beneficiario = new Beneficiario;

		if($datos->acepta_politicas == 1 && $datos->potestad == 1){
			$beneficiario->VC_Identificacion = $datos->numero_documento_beneficiario;
			$beneficiario->FK_Tipo_Identificacion = $datos->tipo_documento_beneficiario->value;
			$beneficiario->VC_Primer_Nombre = $datos->primer_nombre_beneficiario;
			$beneficiario->VC_Primer_Apellido = $datos->primer_apellido_beneficiario;
		}else{
			$miliseconds = substr(microtime(), 2, 3);
			$date = strtotime(date("D M d Y H:i:s"));
			$value_time = $date.$miliseconds;
			$numero_documento_provisional = "SIFPROV".$value_time;
			$primer_nombre_provisional = "PN".$value_time;
			$primer_apellido_provisional = "PA".$value_time;
			$beneficiario->VC_Primer_Nombre = $primer_nombre_provisional;
			$beneficiario->VC_Primer_Apellido = $primer_apellido_provisional;
			$beneficiario->VC_Identificacion = $numero_documento_provisional;
			$beneficiario->FK_Tipo_Identificacion = 8;
		}

		$beneficiario->VC_Segundo_Nombre = $datos->segundo_nombre_beneficiario;
		$beneficiario->VC_Segundo_Apellido = $datos->segundo_apellido_beneficiario;
		$beneficiario->DD_F_Nacimiento = $datos->fecha_nacimiento_beneficiario;
		$beneficiario->FK_Id_Genero = $datos->dirigido == 3 ? 2 : 1;
		$beneficiario->IN_Grupo_Poblacional = (is_null($datos->enfoque_beneficiario) || $datos->enfoque_beneficiario == "") ? 0 : $datos->enfoque_beneficiario->value;
		$beneficiario->IN_Estrato = (is_null($datos->estrato_beneficiario) || $datos->estrato_beneficiario == "")  ? 0 : $datos->estrato_beneficiario->value;
		$beneficiario->DT_Fecha_Registro = date("Y-m-d H:i:s");
		$beneficiario->VC_Linea_Atendido = "Formulario Aulas hospitalarias";
		$beneficiario->save();

		$atencion = new AtencionVirtual;

		$atencion->IN_Tipo_Doc_Cuidador = (is_null($datos->tipo_documento_cuidador) || $datos->tipo_documento_cuidador == "") ? null : $datos->tipo_documento_cuidador->value;
		$atencion->IN_Identificacion_Cuidador = (is_null($datos->numero_documento_cuidador) || $datos->numero_documento_cuidador == "") ? null : $datos->numero_documento_cuidador;
		$atencion->VC_Correo = (is_null($datos->correo_cuidador) || $datos->correo_cuidador == "") ? null : $datos->correo_cuidador;
		$atencion->VC_Telefono = $datos->numero_cuidador;
		$atencion->IN_Parentesco = (is_null($datos->parentesco) || $datos->parentesco == "") ? null : $datos->parentesco->value;
		$atencion->VC_Otro_Parentesco = $datos->otro_parentesco;
		$atencion->IN_Potestad = (is_null($datos->potestad) || $datos->potestad == "") ? 0 : $datos->potestad;
		$atencion->IN_Dirigida_Atencion = $datos->dirigido;
		$atencion->VC_Autorizacion = $datos->acepta_politicas;
		$atencion->VC_Primer_Nombre_Beneficiario = (is_null($datos->primer_nombre_beneficiario) || $datos->primer_nombre_beneficiario == "") ? null : $datos->primer_nombre_beneficiario;
		$atencion->VC_Primer_Apellido_beneficiario = (is_null($datos->primer_apellido_beneficiario) || $datos->primer_apellido_beneficiario == "") ? null : $datos->primer_apellido_beneficiario;
		$atencion->VC_Segundo_Nombre_Beneficiario = $datos->segundo_nombre_beneficiario;
		$atencion->VC_Segundo_Apellido_Beneficiario = $datos->segundo_apellido_beneficiario;
		$atencion->FK_Tipo_Identificacion = (is_null($datos->tipo_documento_beneficiario) || $datos->tipo_documento_beneficiario == "") ? 8 : $datos->tipo_documento_beneficiario->value;
		$atencion->VC_Identificacion = (is_null($datos->numero_documento_beneficiario) || $datos->numero_documento_beneficiario == "") ? $numero_documento_provisional : $datos->numero_documento_beneficiario;
		$atencion->DD_F_Nacimiento = $datos->fecha_nacimiento_beneficiario;
		$atencion->VC_Direccion = $datos->direccion_beneficiario;
		$atencion->IN_Localidad = $datos->localidad_beneficiario->value;
		$atencion->VC_Barrio = $datos->barrio_beneficiario->text;
		$atencion->IN_Upz = $datos->upz_beneficiario;
		$atencion->IN_Estrato = (is_null($datos->estrato_beneficiario) || $datos->estrato_beneficiario == "") ? null : $datos->estrato_beneficiario->value;
		$atencion->VC_Grupo_Poblacional = (is_null($datos->enfoque_beneficiario) || $datos->enfoque_beneficiario == "") ? null : $datos->enfoque_beneficiario->value;
		$atencion->VC_Condicion_Salud = $datos->condicion_salud;
		$atencion->VC_Dificultad_Movilidad_Fisica = $datos->dificultades_movilidad;
		$atencion->VC_Discapacidad = $datos->discapacidad;
		$atencion->VC_Disminucion_Sentidos = $datos->disminucion_sentidos;
		$atencion->VC_Hospitalizado = $datos->hospitalizado;
		$atencion->VC_Veces_Hospitalizado = $datos->veces_hospitalizado;
		$atencion->VC_Recuperacion = $datos->tiempo_recuperacion;
		$atencion->VC_Computador_Wifi = $datos->computador_internet;
		$atencion->IN_Edad_Mental = $datos->edad_mental;
		$atencion->VC_Gustaria_Escuchar = $datos->gustaria_escuchar;
		$atencion->VC_Temas_Lectura_Libro_Viento = $datos->oferta_libro;
		$atencion->VC_Otros_Temas_Lectura_Libro_Viento = $datos->otra_oferta_libro;
		$atencion->DD_Fecha_Solicitud = date("Y-m-d H:i:s");
		$atencion->IN_Formulario = 5;
		$atencion->save();
	}
}
