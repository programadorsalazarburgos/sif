<?php

namespace General\Persistencia\DAOS;


class TbPersona2017DAO extends GestionDAO
{

	private $db;
	private $dbPDO;

	function __construct()
	{
		$this->db = $this->obtenerBD();
		$this->dbPDO = $this->obtenerPDOBD();
	}

	public function crearObjeto($objeto)
	{

		return;
	}

	public function modificarObjeto($objeto)
	{

		return;
	}

	public function eliminarObjeto($objeto)
	{

		return;
	}

	public function consultarObjeto($objeto)
	{

		$sql = "SELECT P.VC_Identificacion AS 'identificacion',
		CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido) AS 'nombre',
		P.VC_Correo AS 'correo',
		P.VC_Primer_Nombre,
		P.VC_Segundo_Nombre,
		P.VC_Primer_Apellido,
		P.VC_Segundo_Apellido,
		P.VC_Telefono,
		P.VC_Direccion,
		P.FK_Tipo_Persona AS 'TipoPersona',
		P.VC_Cargo as 'VC_Cargo',
		(CASE
		WHEN PR.PK_Id_Parametro = 3 THEN '2'
		ELSE '1'
		END) AS 'sla',
		P.FK_Id_Genero,
		PED.TX_Firma_Escaneada
		FROM tb_persona_2017 AS P 
		JOIN tb_parametro_detalle as PD ON PD.FK_Value=P.FK_Tipo_Persona AND PD.FK_Id_Parametro<5
		JOIN tb_parametro as PR on PR.PK_Id_Parametro=PD.FK_Id_Parametro
		JOIN tb_persona_extra_data PED ON PED.FK_Id_Persona=P.PK_Id_Persona
		WHERE P.PK_Id_Persona=" . $objeto->getPKIdPersona();
		return $this->db->query($sql)->fetchAll();
	}

	public function consultarNombrePersona($id_persona)
	{
		$sql = "SELECT CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido) AS nombre FROM tb_persona_2017 P WHERE P.PK_Id_Persona=:PK_Id_Persona;";
		@$sentencia = $this->dbPDO->prepare($sql);
		@$sentencia->bindParam(':PK_Id_Persona', $id_persona);
		// echo $sql;
		$sentencia->execute();
		$r = $sentencia->fetchAll(\PDO::FETCH_ASSOC);
		return $r[0]["nombre"];
	}

	public function consultarObservacionesPersona($objeto)
	{
		return $this->db->select(
			"tb_persona_observacion",
			[
				"[>]tb_persona_2017" => ["id_quien_hace_observacion" => "PK_Id_Persona"]
			],
			[
				"tb_persona_observacion.observacion",
				"tb_persona_observacion.DT_fecha",
				"tb_persona_2017.VC_Primer_Nombre",
				"tb_persona_2017.VC_Segundo_Nombre",
				"tb_persona_2017.VC_Primer_Apellido",
				"tb_persona_2017.VC_Segundo_Apellido"
			],
			[
				"id_persona" => $objeto["id_usuario"]
			]
		);
	}

	public function consultarExistenciaUsuario($identificacion)
	{
		$sql = "SELECT * from tb_persona_2017 P WHERE P.VC_Identificacion=:identificacion";
		@$sentencia = $this->dbPDO->prepare($sql);
		@$sentencia->bindParam(':identificacion', $identificacion);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function consultarInformacionUsuario($identificacion)
	{
		$sql = "SELECT * from tb_persona_2017 P WHERE P.VC_Identificacion=:identificacion";
		@$sentencia = $this->dbPDO->prepare($sql);
		@$sentencia->bindParam(':identificacion', $identificacion);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function consultarInformacionUsuarioById($id)
	{
		$sql = "SELECT * from tb_persona_2017 P JOIN tb_persona_extra_data PED ON PED.FK_Id_Persona=P.PK_Id_Persona WHERE P.PK_Id_Persona=:id";
		@$sentencia = $this->dbPDO->prepare($sql);
		@$sentencia->bindParam(':id', $id);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function getInfoUsuarioContratoById($id)
	{
		$sql = "SELECT P.*, IPPB.PK_Id_Tabla, IPPB.VC_Numero_Contrato, IPPB.VC_Fecha_Inicio, IPPB.VC_Fecha_Fin, IPPB.VC_Objeto FROM tb_persona_2017 P LEFT JOIN db_informe_pago.tb_informe_pago_persona_basico IPPB ON IPPB.FK_Persona=P.PK_Id_Persona AND IPPB.SM_Activo=1 WHERE P.PK_Id_Persona=:id";
		@$sentencia = $this->dbPDO->prepare($sql);
		@$sentencia->bindParam(':id', $id);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function consultarInformacionEncabezadoReporteArtista($id)
	{
		$sql = "SELECT CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre, ' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido) as nombre_artista ,P.VC_Identificacion,P.VC_Correo from tb_persona_2017 P WHERE P.PK_Id_Persona=:id";
		@$sentencia = $this->dbPDO->prepare($sql);
		@$sentencia->bindParam(':id', $id);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function getPersonas($id)
	{
		$sql = "SELECT * from tb_persona_2017";
		@$sentencia = $this->dbPDO->prepare($sql);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function getUsuariosActivos()
	{
		$sql = "SELECT P.PK_Id_Persona,
		P.VC_Identificacion,
		CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ', P.VC_Primer_Apellido, ' ', P.VC_Segundo_Apellido) AS Nombre,
		P.VC_Cargo from tb_persona_2017 P JOIN tb_acceso_usuario_2017 TA ON TA.FK_Id_Persona = P.PK_Id_Persona AND TA.IN_Estado=1 ORDER BY Nombre";
		@$sentencia = $this->dbPDO->prepare($sql);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function registrarUsuario($persona_object)
	{
		$set_id_usuario = $this->dbPDO->prepare("SET @user_id = '" . $persona_object->getIdUsuarioRegistro() . "';");
		$set_id_usuario->execute();
		//Crea el registro de la persona.
		$sql = "INSERT INTO tb_persona_2017 (VC_Identificacion, FK_Tipo_Identificacion, VC_Primer_Nombre, VC_Segundo_Nombre, VC_Primer_Apellido, VC_Segundo_Apellido, VC_Cargo, FK_Id_Genero, DD_F_Nacimiento, VC_Grupo_Poblacional, VC_NEE, VC_Tipo_Afiliacion, FK_Id_Eps, FK_Grupo_Sanguineo, VC_Enfermedades, VC_Barrio, VC_Direccion, VC_Correo, VC_Telefono, VC_Celular, FK_Tipo_Persona, DA_Fecha_Registro, Id_Usuario_Registro) VALUES (:identificacion,:tdocumento,:pnombre,:snombre,:papellido,:sapellido,:cargo,:sexo,:fnacimiento,'6','1','1','1','9','','','',:correo,'',:celular,:perfil,:fecha,:id_usuario_registro)";
		@$sentencia = $this->dbPDO->prepare($sql);
		@$sentencia->bindParam(':identificacion', $persona_object->getVcIdentificacion());
		@$sentencia->bindParam(':tdocumento', $persona_object->getFkTipoIdentificacion());
		@$sentencia->bindParam(':pnombre', $persona_object->getVcPrimerNombre());
		@$sentencia->bindParam(':snombre', $persona_object->getVcSegundoNombre());
		@$sentencia->bindParam(':papellido', $persona_object->getVcPrimerApellido());
		@$sentencia->bindParam(':sapellido', $persona_object->getVcSegundoApellido());
		@$sentencia->bindParam(':cargo', $persona_object->getVcCargo());
		@$sentencia->bindParam(':sexo', $persona_object->getFkIdGenero());
		@$sentencia->bindParam(':fnacimiento', $persona_object->getDdFNacimiento());
		@$sentencia->bindParam(':correo', $persona_object->getVcCorreo());
		@$sentencia->bindParam(':celular', $persona_object->getVcCelular());
		@$sentencia->bindParam(':perfil', $persona_object->getFkTipoPersona());
		@$sentencia->bindParam(':fecha', $persona_object->getDaFechaRegistro());
		@$sentencia->bindParam(':id_usuario_registro', $persona_object->getIdUsuarioRegistro());
		$sentencia->execute();

		$id_persona = $this->dbPDO->lastInsertId();

		$set_id_usuario = $this->dbPDO->prepare("SET @user_id = '" . $persona_object->getIdUsuarioRegistro() . "';");
		$set_id_usuario->execute();
		$sql = "INSERT INTO tb_persona_extra_data (FK_Id_Persona) VALUES (:id_persona)";
		@$sentencia = $this->dbPDO->prepare($sql);
		@$sentencia->bindParam(':id_persona', $id_persona);
		$sentencia->execute();

		$usuario = $persona_object->getVcPrimerNombre() . '.' . $persona_object->getVcPrimerApellido();
		$pass = sha1(md5($persona_object->getVcIdentificacion()));

		//Crea el Acceso del Usuario.
		$sql = "INSERT INTO tb_acceso_usuario_2017(FK_Id_Persona, VC_Usuario, VC_Password) VALUES (:id_persona,:usuario,:pass)";
		@$sentencia = $this->dbPDO->prepare($sql);
		@$sentencia->bindParam(':id_persona', $id_persona);
		@$sentencia->bindParam(':usuario', $usuario);
		@$sentencia->bindParam(':pass', $pass);
		$sentencia->execute();

		echo ("<strong>Usuario:</strong> " . $usuario . "<br><strong>Contraseña:</strong> " . $persona_object->getVcIdentificacion());
	}

	public function actualizarUsuario($persona_object)
	{
		$set_id_usuario = $this->dbPDO->prepare("SET @user_id = '" . $persona_object->getIdUsuarioRegistro() . "';");
		$set_id_usuario->execute();
		//Actualiza el registro de la persona.
		$sql = "UPDATE tb_persona_2017 SET FK_Tipo_Identificacion = :tdocumento, VC_Primer_Nombre = :pnombre, VC_Segundo_Nombre = :snombre, VC_Primer_Apellido = :papellido, VC_Segundo_Apellido = :sapellido, VC_Cargo = :cargo, FK_Id_Genero = :sexo, DD_F_Nacimiento = :fnacimiento, VC_Correo = :correo, VC_Celular = :celular, FK_Tipo_Persona = :perfil, Id_Usuario_Registro = :id_usuario_registro WHERE PK_Id_Persona = :id_persona;";

		@$sentencia = $this->dbPDO->prepare($sql);
		@$sentencia->bindParam(':tdocumento', $persona_object->getFkTipoIdentificacion());
		@$sentencia->bindParam(':pnombre', $persona_object->getVcPrimerNombre());
		@$sentencia->bindParam(':snombre', $persona_object->getVcSegundoNombre());
		@$sentencia->bindParam(':papellido', $persona_object->getVcPrimerApellido());
		@$sentencia->bindParam(':sapellido', $persona_object->getVcSegundoApellido());
		@$sentencia->bindParam(':cargo', $persona_object->getVcCargo());
		@$sentencia->bindParam(':sexo', $persona_object->getFkIdGenero());
		@$sentencia->bindParam(':fnacimiento', $persona_object->getDdFNacimiento());
		@$sentencia->bindParam(':correo', $persona_object->getVcCorreo());
		@$sentencia->bindParam(':celular', $persona_object->getVcCelular());
		@$sentencia->bindParam(':perfil', $persona_object->getFkTipoPersona());
		@$sentencia->bindParam(':id_usuario_registro', $persona_object->getIdUsuarioRegistro());
		@$sentencia->bindParam(':id_persona', $persona_object->getPkIdPersona());
		$sentencia->execute();

		$id_persona = $persona_object->getPkIdPersona();
		$usuario = $persona_object->getVcPrimerNombre() . '.' . $persona_object->getVcPrimerApellido();
		$pass = sha1(md5($persona_object->getVcIdentificacion()));

		//Actualiza el Acceso del Usuario.
		$sql = "UPDATE tb_acceso_usuario_2017 SET VC_Usuario=:usuario WHERE FK_Id_Persona = :id_persona";
		@$sentencia = $this->dbPDO->prepare($sql);
		@$sentencia->bindParam(':id_persona', $id_persona);
		@$sentencia->bindParam(':usuario', $usuario);
		$sentencia->execute();

		echo ("<strong>Usuario:</strong> " . $usuario . "<br><strong>Contraseña:</strong> " . $persona_object->getVcIdentificacion());
	}

	public function actualizarDatosPerfilUsuario($persona_object)
	{
		$set_id_usuario = $this->dbPDO->prepare("SET @user_id = '" . $persona_object->getIdUsuarioRegistro() . "';");
		$set_id_usuario->execute();
		//Actualiza el registro de la persona.
		$sql = "UPDATE tb_persona_2017 P SET P.FK_Tipo_Identificacion = :tdocumento, P.VC_Primer_Nombre = :pnombre, P.VC_Segundo_Nombre = :snombre, P.VC_Primer_Apellido = :papellido, P.VC_Segundo_Apellido = :sapellido, P.FK_Id_Genero = :sexo, P.DD_F_Nacimiento = :fnacimiento, P.VC_Correo = :correo, P.VC_Celular = :celular WHERE P.PK_Id_Persona = :id_persona;";

		@$sentencia = $this->dbPDO->prepare($sql);
		@$sentencia->bindParam(':tdocumento', $persona_object->getFkTipoIdentificacion());
		@$sentencia->bindParam(':pnombre', $persona_object->getVcPrimerNombre());
		@$sentencia->bindParam(':snombre', $persona_object->getVcSegundoNombre());
		@$sentencia->bindParam(':papellido', $persona_object->getVcPrimerApellido());
		@$sentencia->bindParam(':sapellido', $persona_object->getVcSegundoApellido());
		@$sentencia->bindParam(':sexo', $persona_object->getFkIdGenero());
		@$sentencia->bindParam(':fnacimiento', $persona_object->getDdFNacimiento());
		@$sentencia->bindParam(':correo', $persona_object->getVcCorreo());
		@$sentencia->bindParam(':celular', $persona_object->getVcCelular());
		@$sentencia->bindParam(':id_persona', $persona_object->getPkIdPersona());
		$result = $sentencia->execute();

		$set_id_usuario = $this->dbPDO->prepare("SET @user_id = '" . $persona_object->getIdUsuarioRegistro() . "';");
		$set_id_usuario->execute();

		$sql = "UPDATE tb_persona_extra_data PED SET PED.TX_Foto_Perfil = :foto WHERE PED.FK_Id_Persona = :id_persona;";

		@$sentencia = $this->dbPDO->prepare($sql);
		@$sentencia->bindParam(':foto', $persona_object->getTxFotoPerfil());
		@$sentencia->bindParam(':id_persona', $persona_object->getPkIdPersona());
		$result = $sentencia->execute();

		return $result;
	}

	public function registrarAreasOrganizaciones($areas, $organizaciones, $tipo_artista, $identificacion, $fecha)
	{
		$areas = explode(";", $areas);
		$organizaciones = explode(";", $organizaciones);
		$tipo_artista = explode(";", $tipo_artista);

		$sql = "SELECT P.PK_Id_Persona FROM tb_persona_2017 P WHERE P.VC_Identificacion=:identificacion";
		@$sentencia = $this->dbPDO->prepare($sql);
		@$sentencia->bindParam(':identificacion', $identificacion);
		$sentencia->execute();
		$id_persona = $sentencia->fetchAll(\PDO::FETCH_ASSOC);
		$id_persona = $id_persona[0]['PK_Id_Persona'];
		//Guarda la Organizacion del Formador con su respectiva area artistica.
		for ($i = 0; $i < count($areas) - 1; $i++) {
			$sql = "INSERT INTO tb_af_organizacion_area_artistica(FK_Id_Persona, FK_Organizacion, FK_Area_Artistica, FK_Tipo_Artista, VC_Perfil, IN_Estado, DT_Fecha_Asignacion) VALUES (:id_persona,:organizacion,:area,:tipo_artista, '',1,NOW())";
			@$sentencia = $this->dbPDO->prepare($sql);
			@$sentencia->bindParam(':id_persona', $id_persona);
			@$sentencia->bindParam(':organizacion', $organizaciones[$i]);
			@$sentencia->bindParam(':tipo_artista', $tipo_artista[$i]);
			@$sentencia->bindParam(':area', $areas[$i]);
			$sentencia->execute();
		}
	}

	public function desactivarAreasOrganizaciones($identificacion)
	{
		//Obtiene el Id de la persona
		$sql = "SELECT P.PK_Id_Persona FROM tb_persona_2017 P WHERE P.VC_Identificacion=:identificacion";
		@$sentencia = $this->dbPDO->prepare($sql);
		@$sentencia->bindParam(':identificacion', $identificacion);
		$sentencia->execute();
		$id_persona = $sentencia->fetchAll(\PDO::FETCH_ASSOC);
		$id_persona = $id_persona[0]['PK_Id_Persona'];
		//Desactiva las areas_organizaciones que esten al momento activas para determinado usuario.
		$sql = "UPDATE tb_af_organizacion_area_artistica SET IN_Estado=0 WHERE FK_Id_Persona=:id_persona AND IN_Estado=1;";
		@$sentencia = $this->dbPDO->prepare($sql);
		@$sentencia->bindParam(':id_persona', $id_persona);
		$sentencia->execute();
	}

	public function consultarAreasOrganizaciones($persona_object)
	{
		$sql = "SELECT * FROM tb_af_organizacion_area_artistica WHERE FK_Id_Persona=:id_persona AND IN_Estado=1;";
		@$sentencia = $this->dbPDO->prepare($sql);
		@$sentencia->bindParam(':id_persona', $persona_object->getPkIdPersona());
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function verificaPasswordActual($id, $password)
	{
		$pass = sha1(md5($password));
		$sql = "SELECT PK_Id_Acceso FROM tb_acceso_usuario_2017 WHERE FK_Id_Persona=:id_persona AND VC_Password=:password;";
		@$sentencia = $this->dbPDO->prepare($sql);
		@$sentencia->bindParam(':id_persona', $id);
		@$sentencia->bindParam(':password', $pass);
		$sentencia->execute();
		$rowCount = $sentencia->rowCount();
		return $rowCount;
	}

	public function actualizarPassword($new_pass, $id_persona, $id_session)
	{
		$set_id_usuario = $this->dbPDO->prepare("SET @user_id = '" . $id_session . "';");
		$set_id_usuario->execute();
		$pass = sha1(md5($new_pass));
		$coincidencias = 0;

		//Verificar si la contraseña nueva es distinta a la actual.
		$sql = "SELECT * FROM tb_acceso_usuario_2017 A WHERE A.FK_Id_Persona = :id_persona AND A.VC_Password = :pass;";
		@$consulta = $this->dbPDO->prepare($sql);
		@$consulta->bindParam(':pass', $pass);
		@$consulta->bindParam(':id_persona', $id_persona);
		$consulta->execute();
		$coincidencias = $consulta->rowCount();

		if ($coincidencias != 0) {
			return -1;
		} else {
			$sql = "UPDATE tb_acceso_usuario_2017 SET VC_Password = :password WHERE FK_Id_Persona = :id_persona;";
			@$sentencia = $this->dbPDO->prepare($sql);
			@$sentencia->bindParam(':password', $pass);
			@$sentencia->bindParam(':id_persona', $id_persona);
			$sentencia->execute();
			$rowCount = $sentencia->rowCount();
			return $rowCount;
		}
	}

	public function consultarUsuariosOrganizacion($id_organizacion)
	{
		if ($id_organizacion == "") {
			$sql = "SELECT P.PK_Id_Persona,
			P.VC_Identificacion,
			CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ', P.VC_Primer_Apellido, ' ', P.VC_Segundo_Apellido) AS Nombre,
			A.VC_Usuario,
			A.IN_Estado,
			PD.VC_Descripcion FROM tb_acceso_usuario_2017 A
			JOIN tb_persona_2017 P ON A.FK_Id_Persona=P.PK_Id_Persona
			JOIN tb_parametro_detalle PD ON P.FK_Tipo_Persona=PD.FK_Value AND PD.FK_Id_Parametro IN(2,3,4)
			GROUP BY P.PK_Id_Persona";
			@$sentencia = $this->dbPDO->prepare($sql);
		} else {
			$sql = "SELECT P.PK_Id_Persona,
			P.VC_Identificacion,
			CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ', P.VC_Primer_Apellido, ' ', P.VC_Segundo_Apellido) AS Nombre,
			A.VC_Usuario,
			A.IN_Estado,
			PD.VC_Descripcion FROM tb_acceso_usuario_2017 A
			JOIN tb_persona_2017 P ON A.FK_Id_Persona=P.PK_Id_Persona
			JOIN tb_parametro_detalle PD ON P.FK_Tipo_Persona=PD.FK_Value AND PD.FK_Id_Parametro IN(2,3,4)
			JOIN tb_af_organizacion_area_artistica AF ON P.PK_Id_Persona=AF.FK_Id_Persona AND AF.IN_Estado=1 
			WHERE AF.FK_Organizacion=:id_organizacion GROUP BY P.PK_Id_Persona";
			@$sentencia = $this->dbPDO->prepare($sql);
			@$sentencia->bindParam(':id_organizacion', $id_organizacion);
		}

		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function actualizarEstado($estado, $id_persona, $id_usuario_administrador)
	{
		$set_id_usuario = $this->dbPDO->prepare("SET @user_id = '" . $id_usuario_administrador . "';");
		$set_id_usuario->execute();
		$sql = "UPDATE tb_acceso_usuario_2017 SET IN_Estado = :estado WHERE FK_Id_Persona = :id_persona;";

		@$sentencia = $this->dbPDO->prepare($sql);
		@$sentencia->bindParam(':estado', $estado);
		@$sentencia->bindParam(':id_persona', $id_persona);
		$sentencia->execute();
		$rowCount = $sentencia->rowCount();
		return $rowCount;
	}

	public function registrarObservacionPersona($id_usuario, $justificacion, $id_usuario_administrador, $fecha)
	{
		$sql = "INSERT INTO tb_persona_observacion(id_persona,observacion,id_quien_hace_observacion,DT_fecha) VALUES (:id_usuario,:justificacion,:id_usuario_administrador,:fecha);";
		@$sentencia = $this->dbPDO->prepare($sql);
		@$sentencia->bindParam(':id_usuario', $id_usuario);
		@$sentencia->bindParam(':justificacion', $justificacion);
		@$sentencia->bindParam(':id_usuario_administrador', $id_usuario_administrador);
		@$sentencia->bindParam(':fecha', $fecha);
		$sentencia->execute();

		$rowCount = $sentencia->rowCount();
		return $rowCount;
	}

	/***************************************************************************
	/* getOrganizacionesUsuario() retorna las organizaciones que tiene asociadas una persona
	 ***************************************************************************/
	public function getOrganizacionesUsuario($id_usuario)
	{
		$sql = "SELECT
		AO.PK_Id_Tabla,
		O.VC_Nom_Organizacion,
		PD.VC_Descripcion,
		AO.VC_Perfil
		FROM tb_af_organizacion_area_artistica AO
		JOIN tb_organizaciones_2017 O ON AO.FK_Organizacion=O.PK_Id_Organizacion
		JOIN tb_parametro_detalle PD ON PD.FK_Value=AO.FK_Area_Artistica AND PD.FK_Id_Parametro=6
		WHERE AO.FK_Id_Persona=:id_usuario AND AO.IN_Estado=1;";
		@$sentencia = $this->dbPDO->prepare($sql);
		@$sentencia->bindParam(':id_usuario', $id_usuario);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function actualizarPerfilDeFormador($id_registro, $perfil)
	{
		$sql = "UPDATE tb_af_organizacion_area_artistica SET VC_Perfil=:perfil WHERE PK_Id_Tabla=:id_registro;";

		@$sentencia = $this->dbPDO->prepare($sql);
		@$sentencia->bindParam(':perfil', $perfil);
		@$sentencia->bindParam(':id_registro', $id_registro);
		$sentencia->execute();
		$rowCount = $sentencia->rowCount();
		return $rowCount;
	}

	public function consultarIDUltimoTipoArtistaUsuario($id_usuario)
	{
		$sql = "SELECT OAA.FK_Tipo_Artista,PD.VC_Descripcion AS 'tipo_artista'
		FROM tb_af_organizacion_area_artistica OAA
		LEFT JOIN tb_parametro_detalle PD ON OAA.FK_Tipo_Artista = PD.FK_Value AND PD.FK_Id_Parametro = 32
		WHERE OAA.FK_Id_Persona = :FK_Id_Persona AND OAA.IN_estado = 1 
		ORDER BY OAA.DT_Fecha_Asignacion DESC LIMIT 1;";
		@$sentencia = $this->dbPDO->prepare($sql);
		@$sentencia->bindParam(':FK_Id_Persona', $id_usuario);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function subirFirmaUsuario($objeto)
	{
		$set_id_usuario = $this->dbPDO->prepare("SET @user_id = '" . $objeto->getPkIdPersona() . "';");
		$set_id_usuario->execute();

		$sql = "UPDATE tb_persona_extra_data SET TX_Firma_Escaneada = :Firma WHERE FK_Id_Persona = :idPersona";
		@$sentencia = $this->dbPDO->prepare($sql);
		@$sentencia->bindParam(':idPersona', $objeto->getPkIdPersona());
		@$sentencia->bindParam(':Firma', $objeto->getTxFirmaEscaneada());
		$sentencia->execute();
		return $sentencia->rowCount();
	}

	public function consultarListadoCargos()
	{
		$sql = "SELECT DISTINCT P.VC_Cargo FROM tb_persona_2017 P WHERE P.VC_Cargo IS NOT NULL;";
		@$sentencia = $this->dbPDO->prepare($sql);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function infoCompletaUsuarios()
	{
		$sql = "SELECT
		GROUP_CONCAT(CONCAT('<tr>',
		'<td>', p.VC_Identificacion, '</td>'
		'<td>', pdd.VC_Descripcion, '</td>'
		'<td>', CONCAT(p.VC_Primer_Nombre,' ',p.VC_Segundo_Nombre), '</td>'
		'<td>', CONCAT(p.VC_Primer_Apellido,' ',p.VC_Segundo_Apellido), '</td>'
		'<td>', CASE
		WHEN p.FK_Id_Genero = 1 THEN 'Masculino'
		ELSE 'Femenino'
		END, '</td>'
		'<td>', DATE_FORMAT(p.DD_F_Nacimiento, '%d/%m/%Y'), '</td>'
		'<td>', p.VC_Correo, '</td>'
		'<td>', p.VC_Celular, '</td>'
		'<td>', pd.VC_Descripcion, '</td>',
		'</tr>')) AS REGISTRO
		FROM tb_persona_2017 p
		JOIN tb_parametro_detalle pd on pd.FK_Value=p.FK_Tipo_Persona AND pd.FK_Id_Parametro IN(2,3,4)
		JOIN tb_parametro_detalle pdd ON pdd.FK_Value=p.FK_Tipo_Identificacion AND pdd.FK_Id_Parametro=13
		JOIN tb_acceso_usuario_2017 au ON au.FK_Id_Persona=p.PK_Id_Persona";
		@$sentencia = $this->dbPDO->prepare($sql);
		@$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function consultarCedulaUsuarioById($id)
	{
		$sql = "SELECT VC_Identificacion from tb_persona_2017 P  WHERE P.PK_Id_Persona=:id";
		@$sentencia = $this->dbPDO->prepare($sql);
		@$sentencia->bindParam(':id', $id);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}
}
