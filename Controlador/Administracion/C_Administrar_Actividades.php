<?php
	header ('Content-type: text/html; charset=utf-8');
	include_once('../../Modelo/Administracion/Acceso_Datos.php');
	if (isset($_POST['opcion'])){
		switch ($_POST['opcion']) {
			case 'cargar_modulos':
				echo getModulosForSelect();
				break;
			case 'crear_actividad':
				echo addActividad($_POST['nombre'],$_POST['page'],$_POST['id_modulo']);
				break;
			case 'cargar_actividades_modulo':
				echo getActividadesModuloForSelect($_POST['id_modulo']);
				break;
			case 'cargar_usuarios_actividad_asignada':
				echo getUsuariosConActividadAsignada($_POST['id_actividad']);
				break;
			case 'get_nombre_cedula_usuario':
				echo json_encode(getNombreCedulaUsuario($_POST['id_usuario']));
				break;
			case 'aceptar_terminos':
				echo aceptarTerminosUsoSICLAN($_POST['id_usuario']);
				break;
			case 'verificar_aceptacion_terminos':
				echo verificarAceptacionTerminos($_POST['id_usuario']);
				break;
			case 'get_option_all_actividades':
				echo getOptionAllActividades();
				break;
			case 'get_datos_actividad_editar':
				echo getDatosActividadEditar($_POST['id_actividad']);
				break;
			case 'editar_actividad':
				echo editarActividad($_POST['SL_actividad_editar'],$_POST['nombre_actividad_editar'],$_POST['page_actividad_editar'],$_POST['SL_modulo_actividad_editar']);
				break;
			case 'eliminar_actividad':
				echo eliminarActividad($_POST['id_actividad']);
				break;
			default:
				echo "Administrar actividades: opción no valida: (".$_POST['opcion'].")";
				break;
		}
	}

	/***************************************************************************
	/* getModulosForSelect() retorna los <option></option> con los modulos que existen en el sistema.
	***************************************************************************/
	function getModulosForSelect(){
		$return = "<option value='0'>Seleccione un módulo</option>";
		$modulo = getModulos();
		foreach ($modulo as $m) {
			$return .= "<option value='".$m['PK_Id_Modulo']."'><span class='glyphicon ".$m['VC_Icono']."'></span> ".$m['VC_Nom_Modulo']."</option>";
		}
		return $return;
	}

	/***************************************************************************
	/* getActividadesModuloForSelect() retorna los <option></option> con las que estan relacionadas a un módulo.
	***************************************************************************/
	function getActividadesModuloForSelect($id_modulo){
		$actividad = getActividadesModulo($id_modulo);
		foreach ($actividad as $a) {
			$return .= "<option value='".$a['PK_Id_Actividad']."'>".$a['VC_Nom_Actividad']."</option>";
		}
		return $return;
	}

	/***************************************************************************
	/* getUsuariosConActividadAsignada() retorna una tabla con los usuarios que tienen asignada una actividad.
	***************************************************************************/
	function getUsuariosConActividadAsignada($id_actividad){
		$return = "<table class='table table-bordered table-hover'>";
		$return .= "<thead><tr><th>Identificación</th><th>Nombre Completo</th></tr></thead><tbody>";
		$usuario = getUsuariosActividadAsignada($id_actividad);
		foreach ($usuario as $u) {
			$return .= "<tr>";
			$return .= "<td>".$u["VC_Identificacion"]."</td>";
			$return .= "<td>".$u["VC_Primer_Apellido"]." ".$u["VC_Segundo_Apellido"]." ".$u["VC_Primer_Nombre"]." ".$u["VC_Segundo_Nombre"]."</td>";
			$return .= "</tr>";
		}
		$return .= "</tbody></table>";
		return $return;
	}

	/***************************************************************************
	/* getNombreCedulaUsuario() consulta el nombre completo y número de cedula de un usuario especifico.
	***************************************************************************/
	function getNombreCedulaUsuario($id_usuario){
		$datos = consultarNombreYCedulaUsuario($id_usuario)[0];
		return $datos;
	}

	/***************************************************************************
	/* aceptarTerminosUsoSICLAN() actualiza la información del usuario, indicando que él ha aceptado los terminos de uso del aplicativo.
	***************************************************************************/
	function aceptarTerminosUsoSICLAN($id_usuario){
		$datos = updateEstadoAceptacionTerminosUsoSICLAN($id_usuario);
		return $datos;
	}

	/***************************************************************************
	/* verificarAceptacionTerminos() consulta si el usuario ya ha aceptado los terminos de uso del aplicativo.
	***************************************************************************/
	function verificarAceptacionTerminos($id_usuario){
		$aceptado = consultarEstadoAceptacionTerminosUsuario($id_usuario);
		return $aceptado[0];
	}

	/***************************************************************************
	/* getOptionAllActividades() retorna en formato option las actividades que existen en el sistema.
	***************************************************************************/
	function getOptionAllActividades(){
		$option = "";
		$actividad = getActividades();
		foreach ($actividad as $a) {
			$option .= "<option value='".$a['PK_Id_Actividad']."'>".$a['VC_Nom_Actividad']."</option>";
		}
		return $option;
	}

	/***************************************************************************
	/* getDatosActividadEditar() retorna los datos de módulo, nombre y página de una actividad especifica
	***************************************************************************/
	function getDatosActividadEditar($id_actividad){
		return json_encode(getDatosActividad($id_actividad)[0]);
	}

	/***************************************************************************
	/* editarActividad() establece los nuevos datos de una actividad.
	***************************************************************************/
	function editarActividad($id_actividad,$nombre,$pagina,$id_modulo){
		return updateDatosActividad($id_actividad,$nombre,$pagina,$id_modulo);
	}

	/***************************************************************************
	/* eliminarActividad() elimina una actividad
	***************************************************************************/
	function eliminarActividad($id_actividad){
		return deleteActividad($id_actividad);
	}
?>