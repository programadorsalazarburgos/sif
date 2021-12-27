<?php
	header ('Content-type: text/html; charset=utf-8');
	include_once('../../Modelo/Administracion/Acceso_Datos.php');
	if (isset($_POST['opcion'])){
		switch ($_POST['opcion']) {
			case 'buscar_usuario':
				echo showUsuariosByText($_POST['texto']);
				break;
			case 'cargar_modulos':
				echo showModulos();
				break;
			case 'cargar_actividades_modulo':
				echo showActividadesUsuario($_POST['id_modulo'],$_POST['id_usuario']);
				break;
			case 'update_permiso_actividad':
				echo setPermisosActividad($_POST['id_actividad'],$_POST['id_usuario'],$_POST['permiso']);
				break;
			case 'validar_asignacion_actividades':
				$total_actividades = validarAsignacionActividades($_POST['id_usuario']);
				$total_actividades=$total_actividades[0][0];
				echo $total_actividades;
				break;
			case 'asignar_actividades':
				asignarActividades($_POST['id_usuario']);
				break;
			case 'get_option_roles':
				echo getOptionsRoles();
				break;
			case 'get_option_modulos':
				echo getOptionsModulo();
				break;
			case 'get_option_actividades':
				echo getOptionsActividadesByModulo($_POST['id_modulo']);
				break;
			case 'get_total_usuarios_rol_actividad':
				echo getTotalUsuariosRolActividad($_POST['id_tipo_usuario'],$_POST['id_actividad']);
				break;
			case 'get_total_usuarios_rol':
				echo getTotalUsuariosRol($_POST['id_tipo_usuario']);
				break;
			case 'get_usuarios_rol_actividad':
				echo getTableUsuariosRolActividad($_POST['id_tipo_usuario'],$_POST['id_actividad']);
				break;
			case 'asignar_actividades_usuarios_rol':
				echo asignarActividadUsuariosRol($_POST['id_tipo_usuario'],$_POST['id_actividad']);
				break;
			case 'remover_actividades_usuarios_rol':
				echo deleteActividadUsuariosRol($_POST['id_tipo_usuario'],$_POST['id_actividad']);
				break;
			default:
				echo "opcion no valida: (".$_POST['id_modulo'].")";
				break;
		}
	}

	/***************************************************************************
	/* showModulos() retorna un <select> con los módulos que existen en el sistema.
	***************************************************************************/
	function showModulos(){
		$mostrar = "<div class='panel-group' id='accordion'>";

		$modulo = getModulos();
		foreach ($modulo as $m) {
			$mostrar .= "
			<div class='panel panel-success'>
				<div class='panel-heading'>
					<h4 class='panel-title'>
						<a class='cargar_actividades_modulo' data-id_modulo='".$m['PK_Id_Modulo']."' data-toggle='collapse' data-parent='#accordion' href='#content_modulo_".$m['PK_Id_Modulo']."'><span class='glyphicon ".$m['VC_Icono']."'></span>".$m['VC_Nom_Modulo']."</a>
					</h4>
				</div>";
			$mostrar .= "
				<div id='content_modulo_".$m['PK_Id_Modulo']."' class='panel-collapse collapse'>
					<div id='modulo_".$m['PK_Id_Modulo']."' class='panel-body'>si</div>
					</div>
				</div>";
			
		}
		$mostrar .= "</div>";
		return $mostrar;
	}

	/***************************************************************************
	/* showUsuariosByText() muestra una tabla con los datos de los usuarios que han sido encontrados según un parametro de busqueda que recibe la función.
	***************************************************************************/
	function showUsuariosByText($texto){
		$usuario = getDatosUsuario($texto);
		$mostrar = "<table class='table table-hover'>";
		$mostrar .= "<tr>";
		$mostrar .= "<td><center><b>Identificación</b></center></td>";
		$mostrar .= "<td><center><b>Nombre</b></center></td>";
		$mostrar .= "<td><center><b>Tipo Persona</b></center></td>";
		$mostrar .= "<td><center><b>Seleccionar</b></center></td>";
		$mostrar .= "</tr>";
		foreach ($usuario as $u){
			$mostrar .= "<tr><td>".$u['VC_Identificacion']."</td>";
			$mostrar .= "<td>".$u['VC_Nombre']."</td>";
			$mostrar .= "<td>".$u['VC_Nom_Tipo']."</td>";
			$mostrar .= "<td><a class='btn btn-primary seleccionar_usuario' href='#' data-id_usuario='".$u['PK_Id_Persona']."' data-nombre_usuario='".$u['VC_Nombre']."'>Seleccionar</a></td>";
			$mostrar .= "</tr>";
		}
		$mostrar .= "</table>";
		return $mostrar;
	}

	/***************************************************************************
	/* showActividadesUsuario() muestra una tabla con el nombre de las actividades y ademas si tiene permisos sobre estas.
	***************************************************************************/
	function showActividadesUsuario($id_modulo,$id_usuario){
		$actividad = getActividadesUsuario($id_modulo,$id_usuario);
		$mostrar = "<table class='table table-hover'>";
		$mostrar .= "<tr>";
		$mostrar .= "<td><center><b>Actividad</b></center></td>";
		$mostrar .= "<td><center><b>Estado Permiso</b></center></td>";
		$mostrar .= "</tr>";
		foreach ($actividad as $a){
			$mostrar .= "<tr><td>".$a['VC_Nom_Actividad']."</td>";
			$mostrar .= "<td>".showEstadoActividad($a['PK_Id_Actividad'],$id_usuario,$a['FK_Actividad'])."</td></tr>";
		}
		$mostrar .= "</table>";
		return $mostrar;
	}

	/***************************************************************************
	/* showEstadoActividad() retorna un checkbox estilizado mostrando si tiene o no permiso sobre la actividad.
	***************************************************************************/
	function showEstadoActividad($id_actividad,$id_usuario,$estado_actividad){
		return '<center><input '.((!empty($estado_actividad))?'checked':' ').' data-toggle="toggle" data-onstyle="primary" data-offstyle="danger" data-on="SI" data-off="NO" type="checkbox" class="permiso_actividad" data-id_actividad='.$id_actividad.' data-id_usuario='.$id_usuario.'></center>';
	}

	/***************************************************************************
	/* setPermisosActividad() modifica el permiso de acceso a una actividad para un usuario especifico.
	***************************************************************************/
	function setPermisosActividad($id_actividad,$id_usuario,$permiso){
		if($permiso == 1){
			return insertUsuarioActividad($id_actividad,$id_usuario);
		}else if($permiso == 0){
			return deleteUsuarioActividad($id_actividad,$id_usuario);
		}
	}

	/***************************************************************************
	/* getOptionsRoles() retorna un option de los roles que existen.
	***************************************************************************/
	function getOptionsRoles(){
		$option = "";
		$rol = consultarRolesConActividadesAsignadas();
		foreach ($rol as $r) {
			$option .= "<option value='".$r['PK_Id_Tipo_Persona']."'>".$r['VC_Nom_Tipo']."</option>";
		}
		return $option;
	}

	/***************************************************************************
	/* getOptionsModulo() retorna un option de los modulos que existen.
	***************************************************************************/
	function getOptionsModulo(){
		$option = "";
		$modulo = getModulos();
		foreach ($modulo as $m) {
			$option .= "<option value='".$m['PK_Id_Modulo']."'>".$m['VC_Nom_Modulo']."</option>";
		}
		return $option;
	}

	/***************************************************************************
	/* getOptionsActividadesByModulo() retorna un option de las actividades que se encuentran asociadas a un módulo.
	***************************************************************************/
	function getOptionsActividadesByModulo($id_modulo){
		$option = "";
		$actividad = getActividadesModulo($id_modulo);
		foreach ($actividad as $a) {
			$option .= "<option value='".$a['PK_Id_Actividad']."'>".$a['VC_Nom_Actividad']."</option>";
		}
		return $option;
	}

	/***************************************************************************
	/* getTotalUsuariosRolActividad() retorna el número total de usuarios que tienen asignado un rol especifico y estan asociados a una actividad
	***************************************************************************/
	function getTotalUsuariosRolActividad($id_tipo_usuario,$id_actividad){
		return getCountUsuariosRolActividad($id_tipo_usuario,$id_actividad)[0]['total'];
	}

	/***************************************************************************
	/* getTotalUsuariosRol() retorna el número total de usuarios que tienen asignado un rol especifico.
	***************************************************************************/
	function getTotalUsuariosRol($id_tipo_usuario){
		return getCountUsuariosRol($id_tipo_usuario);
	}

	/***************************************************************************
	/* getTableUsuariosRolActividad() retorna en formato de tabla los datos del documento y nombre completo de los usuarios que tienen asignado una actividad, con un rol especifico.
	***************************************************************************/
	function getTableUsuariosRolActividad($id_tipo_usuario,$id_actividad){
		$usuario = getAllUsuariosRol($id_tipo_usuario,$id_actividad);
		$return = "";
		foreach ($usuario as $u) {
			$return .= "<tr>";
			$return .= "<td>".$u['VC_Identificacion']."</td>";
			$return .= "<td>".$u['VC_Primer_Apellido']." ".$u['VC_Segundo_Apellido']." ".$u['VC_Primer_Nombre']." ".$u['VC_Segundo_Nombre']."</td>";
			$return .= "</tr>";
		}
		return $return;
	}

	/***************************************************************************
	/* asignarActividadUsuariosRol() asocia a todos los usuarios de un rol especifico un a actividad.
	***************************************************************************/
	function asignarActividadUsuariosRol($id_tipo_persona,$id_actividad){
		return saveActividadUsuariosRol($id_tipo_persona,$id_actividad);
	}
?>