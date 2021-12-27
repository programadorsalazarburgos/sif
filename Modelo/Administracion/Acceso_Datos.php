<?php
//header ('Content-type: text/html; charset=utf-8');
	// Incluir libreria de acceso a base de datos
	// se valida el directorio actual ya que al hacer inclucion para el menú arroja error por que este archivo se encuentra sobre la carpeta raiz de la capa vista "public" mientras que los archivos de la capa vista para las actividades se encuentran en una subcarpeta ubicada dentro la carpeta public "public/subcarpeta"
$directorio_actual = getcwd();
	$directorio_actual = explode("\\", $directorio_actual);  // OJO: En windows es "\\" y en linux es "/"
	if (sizeof($directorio_actual) == 1)
		$directorio_actual = explode("/", $directorio_actual[0]);  // OJO: En windows es "\\" y en linux es "/"
	$directorio_actual = $directorio_actual[sizeof($directorio_actual) - 1];
	if ($directorio_actual == 'public'){
		require_once('../Modelo/medoo/medoo.php');
		require_once('../Modelo/medoo/parametros_conexion.php');
	}else
	{
		require_once('../../Modelo/medoo/medoo.php');
		require_once('../../Modelo/medoo/parametros_conexion.php');
	}

	date_default_timezone_set('America/Bogota');

	/***************************************************************************
	/* getIdPersonaByLogin() consulta el id de una persona según su nombre de usuario y contraseña
	***************************************************************************/
	function getIdPersonaByLogin($usuario, $contrasenia){
		global $db_siclan;
		$id_persona = $db_siclan->select("tb_acceso_usuario_2017",["[>]tb_persona_2017"=>["FK_Id_Persona"=>"PK_Id_Persona"]],"*",[
			"AND"=>[
				"VC_Usuario" => $usuario,
				"VC_Password" => $contrasenia,
				"IN_Estado" => 1
			]
		]);
		return $id_persona;
	}

	/***************************************************************************
	/* saveLogInicioSesion() guarda el log de inicio de sesión de un usuario en la fecha dada.
	***************************************************************************/
	function saveLogInicioSesion($id_persona,$dispositivo,$ip,$mac){
		global $db_siclan;
		$log = $db_siclan->insert("tb_log_login",[
			"FK_persona" => $id_persona,
			"DT_fecha_ingreso" => date('Y-m-d H:i:s'),
			"TX_dispositivo" => $dispositivo,
			"TX_IP" => $ip,
			"TX_MAC" => $mac
		]);
		return $log;
	}

	/***************************************************************************
	/* getModulos() selecciona los modulos del sistema.
	***************************************************************************/
	function getModulos(){
		global $db_siclan;
		$modulo = $db_siclan->select("tb_menu_modulo","*");
		return $modulo;
	}

	/***************************************************************************
	/* getGruposByClanArteEscuela() obtiene todos los grupos de un clan que pertenecen a la línea de atención de arte en la escuela
	***************************************************************************/
	function getGruposByClanArteEscuela($id_clan){
		global $db_siclan;
		$grupo = $db_siclan->select("tb_terr_grupo_arte_escuela",["PK_Grupo"],["FK_clan"=>$id_clan]);
		return $grupo;
	}

	/***************************************************************************
	/* getGruposByClanArteEscuela() obtiene todos los grupos de un clan que pertenecen a la línea de atención de emprende clan
	***************************************************************************/
	function getGruposByClanEmprendeClan($id_clan){
		global $db_siclan;
		$grupo = $db_siclan->select("tb_terr_grupo_emprende_clan",["PK_Grupo"],["FK_clan"=>$id_clan]);
		return $grupo;
	}

	/***************************************************************************
	/* getTiposUsuarioData() retorna todos los tipos de usuario existentes
	***************************************************************************/
	function getTiposUsuarioData(){
		global $db_siclan;
		$tiposUsuario = $db_siclan->select("tb_tipo_persona","*");
		return $tiposUsuario;
	}

	/***************************************************************************
	/* getActividades() retorna todas las actividades y estado asignadas a una persona
	***************************************************************************/
	function getActividades(){
		global $db_siclan;
		$actividad = $db_siclan->select("tb_menu_actividad","*");
		return $actividad;
	}

	/***************************************************************************
	/* getDatosActividad() retorna todos los datos de una actividad especifica.
	***************************************************************************/
	function getDatosActividad($id_actividad){
		global $db_siclan;
		$actividad = $db_siclan->select("tb_menu_actividad","*",
			["PK_Id_Actividad" => $id_actividad]);
		return $actividad;
	}

	/***************************************************************************
	/* updateDatosActividad() actualiza todos los datos de una actividad especifica.
	***************************************************************************/
	function updateDatosActividad($id_actividad,$nombre,$pagina,$id_modulo){
		global $db_siclan;
		$update = $db_siclan->update("tb_menu_actividad",[
			"VC_Nom_Actividad"=>$nombre,
			"VC_Page"=>$pagina,
			"FK_Modulo"=>$id_modulo
		],[
			"PK_Id_Actividad"=>$id_actividad
		]);
		return $update;
	}

	/***************************************************************************
	/* deleteActividad() borra una actividad especifica.
	***************************************************************************/
	function deleteActividad($id_actividad){
		global $db_siclan;
		$delete = $db_siclan->delete("tb_menu_actividad",["PK_Id_Actividad"=>$id_actividad]);
		return $delete;
	}

	/***************************************************************************
	/* getActividadesUsuario() retorna las actividades que tiene asociado un usuario en un modulo especifico.
	***************************************************************************/
	function getActividadesUsuario($id_modulo,$id_usuario){
		global $db_siclan;
		$actividad = $db_siclan->query("SELECT A.VC_Nom_Actividad,AU.FK_Actividad,A.PK_Id_Actividad
			FROM tb_menu_modulo M
			LEFT JOIN tb_menu_actividad A ON M.PK_Id_Modulo = A.FK_Modulo
			LEFT JOIN tb_menu_actividad_usuario AU ON A.PK_Id_Actividad = AU.FK_Actividad AND AU.FK_Persona = ".$id_usuario."
			WHERE (A.estado = 1 OR A.estado = 2) AND M.PK_Id_Modulo = ".$id_modulo.";")->fetchAll(PDO::FETCH_ASSOC);
		return $actividad;
	}

	/***************************************************************************
	/* getDatosUsuario() retorna los usuarios según un texto de busqueda
	***************************************************************************/
	function getDatosUsuario($texto){
		global $db_siclan;
		$persona = $db_siclan->query(
			"SELECT P.PK_Id_Persona,P.VC_Identificacion,
			CONCAT(P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido,' ',P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre) AS VC_Nombre,
			P.VC_Correo,P.VC_Celular,TP.VC_Nom_Tipo
			FROM tb_persona_2017 P
			LEFT JOIN tb_tipo_persona TP ON P.FK_Tipo_Persona = TP.PK_Id_Tipo_Persona
			WHERE P.FK_Tipo_Persona NOT IN (7,9) AND (CONCAT(P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido,' ',P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre) LIKE '%".$texto."%' OR P.VC_Identificacion LIKE '%".$texto."%')"
		)->fetchAll(PDO::FETCH_ASSOC);
		return $persona;
	}

	/***************************************************************************
	/* insertUsuarioActividad() inserta el acceso de un usuario a una actividad especifica.
	***************************************************************************/
	function insertUsuarioActividad($id_actividad,$id_usuario){
		global $db_siclan;
		$actividad = $db_siclan->insert("tb_menu_actividad_usuario",[
			"FK_Actividad"=>$id_actividad,
			"FK_Persona"=>$id_usuario
		]);
		return $actividad;
	}

	/***************************************************************************
	/* deleteUsuarioActividad() borra el acceso de un usuario a una actividad especifica.
	***************************************************************************/
	function deleteUsuarioActividad($id_actividad,$id_usuario){
		global $db_siclan;
		$actividad = $db_siclan->delete("tb_menu_actividad_usuario",["AND"=>[
			"FK_Actividad"=>$id_actividad,
			"FK_Persona"=>$id_usuario
		]]);
	}

	/***************************************************************************
	/* getModulosUsuario() retorna el id, nombre e icono de los modulos en los cuales tiene permisos un usuario.
	***************************************************************************/
	function getModulosUsuario($id_usuario){
		global $db_siclan;
		$modulo = $db_siclan->query(
			"SELECT DISTINCT(tmm.PK_Id_Modulo), tmm.VC_Nom_Modulo, tmm.VC_Icono
			FROM tb_menu_modulo tmm
			LEFT JOIN tb_menu_actividad tma ON tma.FK_Modulo = tmm.PK_Id_Modulo
			LEFT JOIN tb_tipo_persona_actividad ttpa ON ttpa.FK_Actividad = tma.PK_Id_Actividad
			LEFT JOIN tb_menu_actividad_usuario tmau ON tmau.FK_Actividad = tma.PK_Id_Actividad
			JOIN tb_persona_2017 tp2 ON (tp2.FK_Tipo_Persona = ttpa.FK_Tipo_Persona OR tmau.FK_Persona = tp2.PK_Id_Persona) AND tp2.PK_Id_Persona = ".$id_usuario.";"
		)->fetchAll(PDO::FETCH_ASSOC);
		return $modulo;
	}

	/***************************************************************************
	/* getActividadesUsuarioModulo() retorna los datos permisos sobre las actividades de un usuario especifico.
	***************************************************************************/
	function getActividadesUsuarioModulo($id_usuario,$id_modulo){
		global $db_siclan;
		$modulo = $db_siclan->query(
			"SELECT tma.*
			FROM tb_menu_actividad tma
			LEFT JOIN tb_tipo_persona_actividad ttpa ON ttpa.FK_Actividad = tma.PK_Id_Actividad
			LEFT JOIN tb_menu_actividad_usuario tmau ON tmau.FK_Actividad = tma.PK_Id_Actividad
			JOIN tb_persona_2017 tp2 ON (tp2.FK_Tipo_Persona = ttpa.FK_Tipo_Persona OR tp2.PK_Id_Persona = tmau.FK_Persona) AND tp2.PK_Id_Persona = ".$id_usuario."
			WHERE tma.FK_Modulo = ".$id_modulo." AND (tma.estado = 1 OR tma.estado = 2)
			GROUP BY tma.PK_Id_Actividad;"
		)->fetchAll(PDO::FETCH_ASSOC);
		return $modulo;
	}

	/***************************************************************************
	/* validarAsignacionActividades() retorna el número de actividades que tiene relacionadas un usuario.
	***************************************************************************/
	function validarAsignacionActividades ($id_usuario){
		global $db_siclan;
		$total_actividades = $db_siclan->count("tb_menu_actividad_usuario",["FK_Persona" => $id_usuario]
	);
		return $total_actividades;
	}

	/***************************************************************************
	/* asignarActividades() hace un llamado al store procedure encargado de relacionar las actividades a un usuario.
	***************************************************************************/
	function asignarActividades($id_usuario){
		global $db_siclan;
		$insert = $db_siclan->query("CALL SP_ADM_Relacionar_Actividades(".$id_usuario.")");
		return $insert;
	}

	/***************************************************************************
	/* addActividad() agrega una nueva actividad a la tabla tb_menu_actividad
	***************************************************************************/
	function addActividad($nombre,$page,$id_modulo){
		global $db_siclan;
		$ultimo_id = $db_siclan->max("tb_menu_actividad","PK_Id_Actividad");
		$ultimo_id++;
		$insert = $db_siclan->insert("tb_menu_actividad",[
			"PK_Id_Actividad"=> $ultimo_id,
			"VC_Nom_Actividad" => $nombre,
			"VC_Page" => $page,
			"FK_Modulo" => $id_modulo
		]);
		return $ultimo_id;
	}

	/***************************************************************************
	/* getActividadesModulo() selecciona las actividades que estan relacionadas a un módulo
	***************************************************************************/
	function getActividadesModulo($id_modulo){
		global $db_siclan;
		$actividad = $db_siclan->select("tb_menu_actividad",["PK_Id_Actividad","VC_Nom_Actividad"],["FK_Modulo"=>$id_modulo]);
		return $actividad;
	}

	/***************************************************************************
	/* getUsuariosActividadAsignada() consulta los datos de todas las personas que tienen asignada una actividad especifica.
	***************************************************************************/
	function getUsuariosActividadAsignada($id_actividad){
		global $db_siclan;
		$usuario = $db_siclan->select("tb_menu_actividad_usuario",["[>]tb_persona_2017"=>["FK_Persona"=>"PK_Id_Persona"]],[
			"tb_persona_2017.VC_Identificacion",
			"tb_persona_2017.VC_Primer_Apellido",
			"tb_persona_2017.VC_Segundo_Apellido",
			"tb_persona_2017.VC_Primer_Nombre",
			"tb_persona_2017.VC_Segundo_Nombre"
		],[
			"AND"=>[
				"tb_menu_actividad_usuario.FK_Actividad"=>$id_actividad
			]
		]);
		return $usuario;
	}
	/***************************************************************************
	/* getNotifiacionesData($idUsuario) consulta los datos de todas notificaciones sin visualizar de un usuario.
	***************************************************************************/
	function getNotifiacionesData($idUsuario){
		global $db_siclan;
		$notificaciones = $db_siclan->select("tb_notificacion_persona",["[>]tb_notificacion"=>["FK_Notificacion"=>"PK_Notificacion_Id"]],
			'*'
			,[
				"AND"=>[
					"tb_notificacion_persona.FK_Persona"=>$idUsuario,
					"tb_notificacion_persona.IN_Visto"=>0	],
					"ORDER" => "tb_notificacion.DT_Fecha ASC"
				]
			);
		return $notificaciones;
	}
	/***************************************************************************
	/* getAllNotificationsData($idUsuario) consulta los datos de todas notificaciones de un usuario.
	***************************************************************************/
	function getAllNotificationsData($idUsuario){
		global $db_siclan;
		$notificaciones = $db_siclan->select("tb_notificacion_persona",["[>]tb_notificacion"=>["FK_Notificacion"=>"PK_Notificacion_Id"]],
			'*'
			,[
				"AND"=>[
					"tb_notificacion_persona.FK_Persona"=>$idUsuario],
					"ORDER" => ["tb_notificacion.DT_Fecha" => "DESC"]
				]
			);
		return $notificaciones;
	}

	/***************************************************************************
	/* saveNewSoporte() guarda un nuevo soporte solicitado por un usuario.
	***************************************************************************/
	function saveNewSoporte($id_usuario,$id_tipo_soporte,$solicitud){
		global $db_siclan;
		$soporte = $db_siclan->insert("tb_soporte_2017",[
			"FK_persona"=>$id_usuario,
			"FK_tipo_soporte"=>$id_tipo_soporte,
			"TX_solicitud"=>$solicitud,
			"DT_fecha_creacion"=>date('Y-m-d H:i:s')
		]);
		return $soporte;
	}

	/***************************************************************************
	/* getTipoSoporte() consulta los tipo soporte que existen en el sistema
	***************************************************************************/
	function getTipoSoporte(){
		global $db_siclan;
		$tipo_soporte = $db_siclan->select("tb_soporte_2017_tipo_soporte","*");
		return $tipo_soporte;
	}

	/***************************************************************************
	/* getHistoricoSoportesByPersona() consulta los soportes que ha enviado una persona especifica.
	***************************************************************************/
	function getHistoricoSoportesByPersona($id_persona){
		global $db_siclan;
		$soporte = $db_siclan->select("tb_soporte_2017",[
			"[>]tb_soporte_2017_tipo_soporte"=>["FK_tipo_soporte"=>"PK_tipo_soporte"]
		],[
			"tb_soporte_2017_tipo_soporte.VC_descripcion",
			"tb_soporte_2017.TX_solicitud",
			"tb_soporte_2017.DT_fecha_creacion",
			"tb_soporte_2017.TX_solucion",
			"tb_soporte_2017.DT_fecha_solucion",
			"tb_soporte_2017.estado"
		],["tb_soporte_2017.FK_persona"=>$id_persona,
		"ORDER"=>"tb_soporte_2017.TX_solicitud"
	]
);
		return $soporte;
	}

	/***************************************************************************
	/* getSoportesSinSolucinar() consulta los soportes que no han sido solucionados.
	***************************************************************************/
	function getSoportesSinSolucinar(){
		global $db_siclan;
		$soporte = $db_siclan->select("tb_soporte_2017",[
			"[>]tb_soporte_2017_tipo_soporte"=>["FK_tipo_soporte"=>"PK_tipo_soporte"],
			"[>]tb_persona_2017"=>["FK_persona"=>"PK_Id_Persona"]
		],[
			"tb_soporte_2017_tipo_soporte.VC_descripcion",
			"tb_soporte_2017.TX_solicitud",
			"tb_soporte_2017.DT_fecha_creacion",
			"tb_soporte_2017.FK_persona",
			"tb_persona_2017.VC_Primer_Apellido",
			"tb_persona_2017.VC_Segundo_Apellido",
			"tb_persona_2017.VC_Primer_Nombre",
			"tb_persona_2017.VC_Segundo_Nombre"
		],
		["estado"=>0]);
		return $soporte;
	}

	/***************************************************************************
	/* saveSolucionSoporte() actualiza un soporte con una solución y su estado lo pone en 1
	***************************************************************************/
	function saveSolucionSoporte($id_persona,$fecha_creacion,$solucion){
		global $db_siclan;
		$update = $db_siclan->update("tb_soporte_2017",[
			"TX_solucion"=>$solucion,
			"DT_fecha_solucion"=>date('Y-m-d H:i:s'),
			"estado"=>1
		],["AND"=>[
			"FK_persona"=>$id_persona,
			"DT_fecha_creacion"=>$fecha_creacion
		]]);
		return $update;
	}

	/***************************************************************************
	/* setNotificationUserView() actualiza un soporte con una solución y su estado lo pone en 1
	***************************************************************************/
	function setNotificationUserView($idUsuario,$notificationId){
		global $db_siclan;
		$update = $db_siclan->update("tb_notificacion_persona",[
			"IN_Visto"=>1,
			"DT_Fecha_Visto"=>date('Y-m-d H:i:s'),
		],["AND"=>[
			"FK_persona"=>$idUsuario,
			"FK_Notificacion"=>$notificationId
		]]);
		return $update;
	}

	/***************************************************************************
	/* getNombreDeUsuario() consulta el nombre del usuario que se encuentra logueado.
	***************************************************************************/
	function getNombreDeUsuario($idUsuario){
		global $db_siclan;
		$usuario = $db_siclan->query("SELECT CONCAT(P.VC_Primer_Nombre,' ',P.VC_Primer_Apellido) AS 'nombre_usuario' FROM tb_persona_2017 P WHERE PK_Id_Persona=".$idUsuario.";")->fetchAll(PDO::FETCH_ASSOC);
		return $usuario[0];
	}

	/***************************************************************************
	/* getInformacionPersona() trae la informacion de un usuario específico.
	***************************************************************************/
	function getInformacionUsuario($identificacion){
		global $db_siclan;
		$informacion = $db_siclan->query("SELECT * from tb_persona_2017 P WHERE P.VC_Identificacion=".$identificacion."");
		return $informacion;
	}

	/***************************************************************************
	/* getDatosPerfil() trae la informacion de un usuario específico por su Id_Persona de la tabla tb_persona_2017.
	***************************************************************************/
	function getDatosPerfil($id_persona){
		global $db_siclan;
		$informacion = $db_siclan->select("tb_persona_2017","*",[
			"PK_Id_Persona" => $id_persona
		]);
		return $informacion;
	}

	/***************************************************************************
	/* getExistenciaUsuario() verifica que un usuario específico exista o no en la base de datos 2017.
	***************************************************************************/
	function getExistenciaUsuario($identificacion){
		global $db_siclan;
		$informacion = $db_siclan->query("SELECT * from tb_persona_2017 P WHERE P.VC_Identificacion=".$identificacion."");
		return $informacion;
	}

	/***************************************************************************
	/* getExistenciaEstudiante() verifica que un estudiante específico exista o no en la tabla_estudiante.
	***************************************************************************/
	function getExistenciaEstudiante($identificacion){
		global $db_siclan;
		$informacion = $db_siclan->query("SELECT * from tb_estudiante E WHERE E.IN_Identificacion=".$identificacion."");
		return $informacion;
	}

	/***************************************************************************
	/* getOrganizacionesUsuario() retorna las organizaciones que tiene asociadas una persona
	***************************************************************************/
	function getOrganizacionesUsuario($id_usuario){
		global $db_siclan;
		$informacion = $db_siclan->query("SELECT
			AO.PK_Id_Tabla,
			O.VC_Nom_Organizacion,
			PD.VC_Descripcion,
			AO.VC_Perfil
			FROM tb_af_organizacion_area_artistica AO
			JOIN tb_organizaciones_2017 O ON AO.FK_Organizacion=O.PK_Id_Organizacion
			JOIN tb_parametro_detalle PD ON PD.FK_Value=AO.FK_Area_Artistica
			WHERE AO.FK_Id_Persona=".$id_usuario." AND AO.IN_Estado=1 AND PD.FK_Id_Parametro=6;");
		return $informacion;
	}

	/***************************************************************************
	/* getUsuariosOrganizacion() retorna los usuarios que tiene asociados una organización.
	***************************************************************************/
	function getUsuariosOrganizacion($organizacion){
		global $db_siclan;
		if($organizacion==""){
			$usuarios = $db_siclan->query("SELECT
				DISTINCT(P.PK_Id_Persona),
				P.VC_Identificacion,
				CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ', P.VC_Primer_Apellido, ' ', P.VC_Segundo_Apellido) AS Nombre,
				A.VC_Usuario,
				A.IN_Estado,
				P.FK_Tipo_Persona
				FROM tb_persona_2017 P
				LEFT JOIN tb_formador_organizacion_2017 FO ON P.PK_Id_Persona=FO.FK_Id_Persona
				JOIN tb_acceso_usuario_2017 A ON P.PK_Id_Persona=A.FK_Id_Persona
				WHERE P.FK_Tipo_Persona!=7 AND P.FK_Tipo_Persona!=9");
			return $usuarios;
		}
		else{
			$usuarios = $db_siclan->query("SELECT
				DISTINCT(P.PK_Id_Persona),
				P.VC_Identificacion,
				CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ', P.VC_Primer_Apellido, ' ', P.VC_Segundo_Apellido) AS Nombre,
				A.VC_Usuario,
				A.IN_Estado,
				P.FK_Tipo_Persona
				FROM tb_persona_2017 P
				LEFT JOIN tb_formador_organizacion_2017 FO ON P.PK_Id_Persona=FO.FK_Id_Persona
				JOIN tb_acceso_usuario_2017 A ON P.PK_Id_Persona=A.FK_Id_Persona
				WHERE P.FK_Tipo_Persona!=7 AND P.FK_Tipo_Persona!=9 AND FO.FK_Id_Organizacion='$organizacion';");
			return $usuarios;
		}
	}

	/***************************************************************************
	/* consultarNombreYCedulaUsuario() consulta el nombre completo y número de cedula de un usuario especifico.
	***************************************************************************/
	function consultarNombreYCedulaUsuario($id_usuario){
		global $db_siclan;
		$dato_usuario = $db_siclan->query("SELECT CONCAT(VC_Primer_Nombre,' ',VC_Segundo_Nombre,' ',VC_Primer_Apellido,' ',VC_Segundo_Apellido) AS nombre,
			VC_Identificacion AS cedula
			FROM tb_persona_2017
			WHERE PK_Id_Persona = $id_usuario")->fetchAll(PDO::FETCH_ASSOC);
		return $dato_usuario;
	}

	/***************************************************************************
	/* updateEstadoAceptacionTerminosUsoSICLAN() actualiza la tabla de acceso datos, indicando que el usuario especifico ha aceptado los terminos de uso del aplicativo.
	***************************************************************************/
	function updateEstadoAceptacionTerminosUsoSICLAN($id_usuario){
		global $db_siclan;
		$update = $db_siclan->update("tb_acceso_usuario_2017",[
			"IN_Acepta_Terminos" => 1,
			"DT_Acepta_Terminos" => date('Y-m-d H:i:s')
		],["FK_Id_Persona"=>$id_usuario]);
		return $update;
	}

	/***************************************************************************
	/* consultarEstadoAceptacionTerminosUsuario() consulta el estado de aceptación de terminos del aplicativo SICLAN de un usuario especifico.
	***************************************************************************/
	function consultarEstadoAceptacionTerminosUsuario($id_usuario){
		global $db_siclan;
		$estado = $db_siclan->select("tb_acceso_usuario_2017","IN_Acepta_Terminos",["FK_Id_Persona" => $id_usuario]);
		return $estado;
	}

	/***************************************************************************
	/* consultarRolesConActividadesAsignadas() consulta los tipo persona que tienen asignadas actividades.
	***************************************************************************/
	function consultarRolesConActividadesAsignadas(){
		global $db_siclan;
		$rol = $db_siclan->query("SELECT DISTINCT TP.PK_Id_Tipo_Persona,TP.VC_Nom_Tipo
			FROM tb_tipo_persona TP
			JOIN tb_persona_2017 P ON TP.PK_Id_Tipo_Persona = P.FK_Tipo_Persona
			JOIN tb_menu_actividad_usuario AU ON P.PK_Id_Persona = AU.FK_Persona
			ORDER BY TP.PK_Id_Tipo_Persona")->fetchAll(PDO::FETCH_ASSOC);
		return $rol;
	}

	/***************************************************************************
	/* getCountUsuariosRolActividad() retorna el total de usuarios que estan asociados a un rol especifico y tienen asignada una actividad dada.
	***************************************************************************/
	function getCountUsuariosRolActividad($id_tipo_usuario,$id_actividad){
		global $db_siclan;
		$total = $db_siclan->query("SELECT COUNT(AU.FK_persona) AS total
			FROM tb_menu_actividad_usuario AU
			LEFT JOIN tb_persona_2017 P ON AU.FK_Persona = P.PK_Id_Persona
			WHERE P.FK_Tipo_Persona = $id_tipo_usuario AND AU.FK_Actividad = $id_actividad")->fetchAll(PDO::FETCH_ASSOC);
		return $total;
	}

	/***************************************************************************
	/* getCountUsuariosRol() retorna el total de usuarios que estan asociados a un rol
	***************************************************************************/
	function getCountUsuariosRol($id_tipo_usuario){
		global $db_siclan;
		$total = $db_siclan->count("tb_persona_2017",["FK_Tipo_Persona"=>$id_tipo_usuario]);
		return $total;
	}

	/***************************************************************************
	/* getAllUsuariosRol() consulta todos los usuarios que tienen un rol especifico asignado.
	***************************************************************************/
	function getAllUsuariosRol($id_tipo_usuario,$id_actividad){
		global $db_siclan;
		$total = $db_siclan->query("SELECT P.PK_Id_Persona,P.VC_Identificacion,P.VC_Primer_Apellido,P.VC_Segundo_Apellido,P.VC_Primer_Nombre,P.VC_Segundo_Nombre
			FROM tb_menu_actividad_usuario AU
			LEFT JOIN tb_persona_2017 P ON AU.FK_Persona = P.PK_Id_Persona
			WHERE P.FK_Tipo_Persona = $id_tipo_usuario AND AU.FK_Actividad = $id_actividad")->fetchAll(PDO::FETCH_ASSOC);
		return $total;
	}

	/***************************************************************************
	/* deleteActividadUsuariosRol() desasocia una actividad especifica de todos los usuarios que tengan un rol especifico asignado.
	***************************************************************************/
	function deleteActividadUsuariosRol($id_tipo_usuario,$id_actividad){
		global $db_siclan;
		$delete = $db_siclan->query("DELETE FROM tb_menu_actividad_usuario WHERE fk_actividad = $id_actividad AND FK_persona IN (SELECT PK_Id_Persona FROM tb_persona_2017 WHERE FK_Tipo_Persona = $id_tipo_usuario);")->fetchAll(PDO::FETCH_ASSOC);
		return $delete;
	}

	/***************************************************************************
	/* saveActividadUsuariosRol() asocia una actividad especifica a todos los usuarios que tengan asociado un rol.
	***************************************************************************/
	function saveActividadUsuariosRol($id_tipo_usuario,$id_actividad){
		deleteActividadUsuariosRol($id_tipo_usuario,$id_actividad);
		global $db_siclan;
		$insert = $db_siclan->query("INSERT INTO tb_menu_actividad_usuario(FK_Actividad,FK_Persona) SELECT $id_actividad, PK_Id_Persona FROM tb_persona_2017 WHERE FK_Tipo_Persona = $id_tipo_usuario;")->fetchAll(PDO::FETCH_ASSOC);
		return $insert;
	}
	function saveNotificationUserData($url,$icon,$contenido,$userId){
		global $db_siclan;
		date_default_timezone_set('America/Bogota');
		$db_siclan->insert("tb_notificacion",[
			"FK_Tipo_Alcance" => 1,
			"FK_Tipo_Notificacion" => 3,
			"VC_Contenido" => $contenido,
			"VC_Url" => $url,
			"DT_Fecha" => date('Y-m-d H:i:s'),
			"VC_Icon" => $icon
		]);
		$notificationId = $db_siclan->max("tb_notificacion","PK_Notificacion_Id");
		$db_siclan->insert("tb_notificacion_persona",[
			"FK_Notificacion" => $notificationId,
			"FK_Persona" => $userId,
			"IN_Visto" => 0
		]);
		return $notificationId;
	}
	function saveNotificationRoleData($url,$icon,$contenido,$roleId){
		global $db_siclan;
		date_default_timezone_set('America/Bogota');
		$db_siclan->insert("tb_notificacion",[
			"FK_Tipo_Alcance" => 2,
			"FK_Tipo_Notificacion" => 3,
			"VC_Contenido" => $contenido,
			"VC_Url" => $url,
			"DT_Fecha" => date('Y-m-d H:i:s'),
			"VC_Icon" => $icon
		]);
		$notificationId = $db_siclan->max("tb_notificacion","PK_Notificacion_Id");
		$personas = $db_siclan->select("tb_persona_2017","*",[
			"FK_Tipo_Persona" => $roleId
		]);
		foreach ($personas as $persona){
			$db_siclan->insert("tb_notificacion_persona",[
				"FK_Notificacion" => $notificationId,
				"FK_Persona" => $persona['PK_Id_Persona'],
				"IN_Visto" => 0
			]);
		}

		return $notificationId;
	}

	/***************************************************************************
	/* getAllUsuarios() retorna el id, cedula y nombres de las personas que existene en el SICLAN
	***************************************************************************/
	function getAllUsuarios(){
		global $db_siclan;
		$usuario = $db_siclan->select("tb_persona_2017",["PK_Id_Persona","VC_Identificacion","VC_Primer_Apellido","VC_Segundo_Apellido","VC_Primer_Nombre","VC_Segundo_Nombre"]);
		return $usuario;
	}

	/***************************************************************************
	/* getLoginsUsuario() retorna los datos de las veces que se ha logueado un usuario especifico en el SICLAN
	***************************************************************************/
	function getLoginsUsuario($id_usuario,$mes_anio){
		global $db_siclan;
		$log = $db_siclan->select("tb_log_login","*",
			["AND"=>[
				"FK_Persona"=>$id_usuario,
				"DT_fecha_ingreso[~]"=>[$mes_anio]
			]]);
		return $log;
	}

	/***************************************************************************
	/* getClanes() retorna el id y nombre de todos los clanes
	***************************************************************************/
	function getClanes(){
		global $db_siclan;
		$clan = $db_siclan->select("tb_clan",["PK_Id_Clan","VC_Nom_Clan"]);
		return ($clan);
	}


	function getLogGrupo($id_grupo,$mes_anio,$tipo_grupo){
		global $db_siclan;
		$log = $db_siclan->select("tb_auditoria_grupo","*",[
			"AND"=>[
				"id_registro"=>$id_grupo,
				"fecha[~]"=>$mes_anio,
				"tabla[~]"=>$tipo_grupo
			]]);
		return $log;
	}
	/***************************************************************************
	/* getNotificacionAnexo(idNotificacion) retorna los anexos de una notificacion
	***************************************************************************/
	function getNotificacionAnexo($idNotificacion){
		global $db_siclan;
		$notificacion = $db_siclan->select("tb_notificacion",["DT_Fecha","TX_Datos_Extra"],[
			"PK_Notificacion_Id" => $idNotificacion
		]);
		return ($notificacion);
	}

	/***************************************************************************
	/* getGruposArteEscuela() consulta los grupos de la base de datos que estan activos en la linea de atención arte en la escuela según un clan.
	***************************************************************************/
	function getGruposArteEscuela($gruposText){
		$gruposArray = explode(',',$gruposText);
		global $db_siclan;
		$grupo = $db_siclan->select("tb_terr_grupo_arte_escuela",
			[
				"[>]tb_areas_artisticas"=>["FK_area_artistica"=>"PK_Area_Artistica"],
				"[>]tb_clan"=>["FK_clan"=>"PK_Id_Clan"],
				"[>]tb_persona_2017"=>["FK_artista_formador"=>"PK_Id_Persona"],
				"[>]tb_organizaciones_2017"=>["FK_organizacion"=>"PK_Id_Organizacion"]
			],
			[
				"tb_terr_grupo_arte_escuela.PK_Grupo",
				"tb_clan.VC_Nom_Clan",
				"tb_areas_artisticas.VC_Nom_Area",
				"tb_organizaciones_2017.VC_Nom_Organizacion",
				"tb_terr_grupo_arte_escuela.FK_artista_formador",
				"tb_terr_grupo_arte_escuela.TX_observaciones",
				"tb_persona_2017.VC_Primer_Nombre",
				"tb_persona_2017.VC_Segundo_Nombre",
				"tb_persona_2017.VC_Primer_Apellido",
				"tb_persona_2017.VC_Segundo_Apellido"
			],

			["PK_Grupo"=>$gruposArray]);
		return $grupo;
	}

	/***************************************************************************
	/* getGruposEmprendeClan() consulta los grupos de la base de datos que estan activos en la linea de atención emprende clan, según un clan.
	***************************************************************************/
	function getGruposEmprendeClan($gruposText){
		$gruposArray = explode(',',$gruposText);
		global $db_siclan;
		$grupo = $db_siclan->select("tb_terr_grupo_emprende_clan",
			[
				"[>]tb_areas_artisticas"=>["FK_area_artistica"=>"PK_Area_Artistica"],
				"[>]tb_clan"=>["FK_clan"=>"PK_Id_Clan"],
				"[>]tb_persona_2017"=>["FK_artista_formador"=>"PK_Id_Persona"],
				"[>]tb_organizaciones_2017"=>["FK_organizacion"=>"PK_Id_Organizacion"]
			],
			[
				"tb_terr_grupo_emprende_clan.PK_Grupo",
				"tb_clan.VC_Nom_Clan",
				"tb_areas_artisticas.VC_Nom_Area",
				"tb_organizaciones_2017.VC_Nom_Organizacion",
				"tb_terr_grupo_emprende_clan.FK_artista_formador",
				"tb_terr_grupo_emprende_clan.TX_observaciones",
				"tb_persona_2017.VC_Primer_Nombre",
				"tb_persona_2017.VC_Segundo_Nombre",
				"tb_persona_2017.VC_Primer_Apellido",
				"tb_persona_2017.VC_Segundo_Apellido",
			],
			["PK_Grupo"=>$gruposArray]);
		return $grupo;
	}
	/***************************************************************************
	/* consultarHorarioGrupoArteEscuela() consulta el (los) día(s) de clases que están habilitados en el sistema para las clases de un grupo de arte en la escuela.
	***************************************************************************/
	function consultarHorarioGrupoArteEscuela($id_grupo){
		global $db_siclan;
		$horario = $db_siclan->select("tb_terr_grupo_arte_escuela_horario_clase","*",["FK_grupo"=>$id_grupo]);
		return $horario;
	}

	/***************************************************************************
	/* consultarHorarioGrupoEmprendeClan() consulta el (los) día(s) de clases que están habilitados en el sistema para las clases de un grupo de emprende clan.
	***************************************************************************/
	function consultarHorarioGrupoEmprendeClan($id_grupo){
		global $db_siclan;
		$horario = $db_siclan->select("tb_terr_grupo_emprende_clan_horario_clase","*",["FK_grupo"=>$id_grupo]);
		return $horario;
	}



	?>
