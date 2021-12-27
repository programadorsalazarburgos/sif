<?php

namespace General\Persistencia\DAOS;


class InfraestructuraDAO extends GestionDAO {

	private $db;

	function __construct()
	{
		$this->db=$this->obtenerPDOBD();
	}

	public function crearObjeto($objeto) {
		return;
	}

	public function modificarObjeto($objeto) {
		return;
	}

	public function eliminarObjeto($objeto) {
		return;
	}

	public function consultarObjeto($texto) {
		return;
	}

	public function getInfoLugarInventario($lugarInventario){
		$sql = "SELECT CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido) AS Coordinador, C.VC_Direccion_Clan, C.VC_Telefono_Clan FROM tb_clan C JOIN tb_persona_2017 P ON C.FK_Persona_Administrador=P.PK_Id_Persona WHERE C.VC_Nom_Clan = '".$lugarInventario."'";
		$sentencia=$this->db->prepare($sql);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function registrarInventario($inventario_object){
		@$set_id_usuario = $this->db->prepare("SET @user_id = :usuario;");
		@$set_id_usuario->bindParam(':usuario',$inventario_object->getFkUsuario());
		$set_id_usuario->execute();

		$sql = "CALL sp_inf_insertar_inventario(:id_clan,:cantidad,:tipo_bien,:placa,:elemento,:descripcion,:estado,:valor_unitario,:donante,:valor_total,:numero_traslado,:fecha_registro,:usuario, :proyecto)";
		@$sentencia=$this->db->prepare($sql);
		@$sentencia->bindParam(':id_clan',$inventario_object->getFkIdClan());
		@$sentencia->bindParam(':cantidad',$inventario_object->getInCantidad());
		@$sentencia->bindParam(':tipo_bien',$inventario_object->getFkIdTipoBien());
		@$sentencia->bindParam(':placa',$inventario_object->getVcPlaca());
		@$sentencia->bindParam(':elemento',$inventario_object->getFkIdElemento());
		@$sentencia->bindParam(':descripcion',$inventario_object->getVcDescripcion());
		@$sentencia->bindParam(':estado',$inventario_object->getFkIdEstado());
		@$sentencia->bindParam(':numero_traslado',$inventario_object->getVcNumeroTraslado());
		@$sentencia->bindParam(':valor_unitario',$inventario_object->getFlValorUnitarioInicial());
		@$sentencia->bindParam(':donante',$inventario_object->getVcDonante());
		@$sentencia->bindParam(':valor_total',$inventario_object->getFlValorTotal());
		@$sentencia->bindParam(':fecha_registro',$inventario_object->getDaFechaRegistro());
		@$sentencia->bindParam(':usuario',$inventario_object->getFkUsuario());
		@$sentencia->bindParam(':proyecto',$inventario_object->getFkProyecto());
		$result = $sentencia->execute();
		if ($result == 1){
			$sql = "SELECT MAX(INV.PK_Id_Inventario) as id_insertado FROM tb_inf_inventario_clan INV";
			@$sentencia=$this->db->prepare($sql);
			$sentencia->execute();
			return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
		}
		else{
			return 0;
		}
	}

	public function actualizarInventario($inventario_object){
		@$set_id_usuario = $this->db->prepare("SET @user_id = :usuario;");
		@$set_id_usuario->bindParam(':usuario',$inventario_object->getFkUsuario());
		$set_id_usuario->execute();

		$sql = "CALL sp_inf_actualizar_inventario(:id_inventario,:id_clan,:cantidad,:tipo_bien,:placa,:elemento,:descripcion,:estado,:valor_unitario,:donante,:valor_total,:numero_traslado)";
		@$sentencia=$this->db->prepare($sql);
		@$sentencia->bindParam(':id_inventario',$inventario_object->getPkIdInventario());
		@$sentencia->bindParam(':id_clan',$inventario_object->getFkIdClan());
		@$sentencia->bindParam(':cantidad',$inventario_object->getInCantidad());
		@$sentencia->bindParam(':tipo_bien',$inventario_object->getFkIdTipoBien());
		@$sentencia->bindParam(':placa',$inventario_object->getVcPlaca());
		@$sentencia->bindParam(':elemento',$inventario_object->getFkIdElemento());
		@$sentencia->bindParam(':descripcion',$inventario_object->getVcDescripcion());
		@$sentencia->bindParam(':estado',$inventario_object->getFkIdEstado());
		@$sentencia->bindParam(':valor_unitario',$inventario_object->getFlValorUnitarioInicial());
		@$sentencia->bindParam(':donante',$inventario_object->getVcDonante());
		@$sentencia->bindParam(':valor_total',$inventario_object->getFlValorTotal());
		@$sentencia->bindParam(':numero_traslado',$inventario_object->getVcNumeroTraslado());
		$result = $sentencia->execute();
		return $result;
	}

	public function consultarInventarioExcel($id_lugar_inventario)
	{
		$sql = "CALL sp_inf_consultar_inventario('NULL',:id_lugar_inventario,'NULL','NULL','NULL','1');";
		@$sentencia=$this->db->prepare($sql);
		@$sentencia->bindParam(':id_lugar_inventario',$id_lugar_inventario);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function consultarInventario($inventario_object)
	{
		$sql = "CALL sp_inf_consultar_inventario(:placa,:id_lugar_inventario,:elemento,:descripcion,:tipo_bien,:estado_baja);";
		@$sentencia=$this->db->prepare($sql);

		@$sentencia->bindParam(':placa',$inventario_object->getVcPlaca());
		@$sentencia->bindParam(':id_lugar_inventario',$inventario_object->getFkIdClan());
		@$sentencia->bindParam(':elemento',$inventario_object->getFkIdElemento());
		@$sentencia->bindParam(':descripcion',$inventario_object->getVcDescripcion());
		@$sentencia->bindParam(':tipo_bien',$inventario_object->getFkIdTipoBien());
		@$sentencia->bindParam(':estado_baja',$inventario_object->getInEstadoBaja());
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function guardarSolicitudTraslado($traslado_object)
	{
		@$set_id_usuario = $this->db->prepare("SET @user_id = :usuario;");
		@$set_id_usuario->bindParam(':usuario', $id_usuario);
		$set_id_usuario->execute();

		$sql = "INSERT INTO tb_inf_traslado (FK_Id_Inventario, DA_Fecha_solicitud, FK_Persona_Solicita, FK_Origen, FK_Destino, IN_Cantidad, VC_Tipo_Traslado, TX_Argumento) VALUES (:id_inventario, :fecha, :id_usuario, :origen, :destino, :cantidad, :tipo_traslado, :argumento)";
		@$sentencia=$this->db->prepare($sql);
		@$sentencia->bindParam(':id_inventario',$traslado_object->getFkIdInventario());
		@$sentencia->bindParam(':tipo_traslado',$traslado_object->getVcTipoTraslado());
		@$sentencia->bindParam(':fecha',$traslado_object->getDaFechaSolicitud($fecha));
		@$sentencia->bindParam(':id_usuario',$traslado_object->getFkPersonaSolicita());
		@$sentencia->bindParam(':origen',$traslado_object->getFkOrigen());
		@$sentencia->bindParam(':destino',$traslado_object->getFkDestino());
		@$sentencia->bindParam(':cantidad',$traslado_object->getInCantidad());
		@$sentencia->bindParam(':argumento',$traslado_object->getTxArgumento());
		$result = $sentencia->execute();
		return $result;
	}

	public function darDeBajaEnInventario($id_inventario, $usuario)
	{
		@$set_id_usuario = $this->db->prepare("SET @user_id = :usuario;");
		@$set_id_usuario->bindParam(':usuario',$usuario);
		$set_id_usuario->execute();

		$sql = "UPDATE tb_inf_inventario_clan SET IN_Estado_Baja=2, FK_Id_Clan=28 WHERE PK_Id_Inventario=:id_inventario";
		@$sentencia=$this->db->prepare($sql);
		@$sentencia->bindParam(':id_inventario',$id_inventario);
		$sentencia->execute();
		return $sentencia->rowCount();
	}

	public function guardarObservacion($fecha, $id_inventario, $usuario, $observacion, $estado)
	{
		$set_id = $db_siclan->pdo->prepare('SET @user_id = ?');
		$set_id->execute([$usuario]);
		$db_siclan->query("INSERT INTO tb_inf_control_inventario (DA_Fecha, FK_Id_Inventario, FK_Id_Persona, VC_Observacion, IN_Estado) VALUES ('".$fecha."', '".$id_inventario."', '".$usuario."', '".$observacion."', '".$estado."')");
		$db_siclan->query("UPDATE tb_inf_inventario_clan SET FK_Id_Estado = '".$estado."' WHERE PK_Id_Inventario='".$id_inventario."';");
	}

	public function listarUsuariosActivos()
	{
		$sql = "SELECT CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido) AS 'Nombre', P.VC_Identificacion AS Identificacion, P.PK_Id_Persona AS 'Id_Persona' FROM tb_persona_2017 P JOIN tb_acceso_usuario_2017 AU ON AU.FK_Id_Persona = P.PK_Id_Persona WHERE AU.IN_Estado = 1";
		@$sentencia=$this->db->prepare($sql);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function asignarInventarioContratista($id_contratista, $id_inventario, $fecha_recibe, $fecha, $usuario)
	{
		@$set_id_usuario = $this->db->prepare("SET @user_id = :usuario;");
		@$set_id_usuario->bindParam(':usuario',$usuario);
		$set_id_usuario->execute();

		$sql = "INSERT INTO tb_inf_inventario_contratista (FK_Id_Inventario, FK_Id_Persona, DA_Fecha_Recibe, DT_Fecha, FK_Id_Usuario) VALUES (:id_inventario, :id_contratista, :fecha_recibe, :fecha, :usuario)";
		@$sentencia=$this->db->prepare($sql);
		@$sentencia->bindParam(':id_inventario',$id_inventario);
		@$sentencia->bindParam(':id_contratista',$id_contratista);
		@$sentencia->bindParam(':fecha_recibe',$fecha_recibe);
		@$sentencia->bindParam(':fecha',$fecha);
		@$sentencia->bindParam(':usuario',$usuario);
		$result = $sentencia->execute();
		$id_insertado = $this->db->lastInsertId();
		$sql = "UPDATE tb_inf_inventario_contratista SET DA_Fecha_Entrega=:fecha_recibe WHERE FK_Id_Inventario=:id_inventario AND DA_Fecha_Entrega IS NULL AND PK_Id_Tabla != :id_insertado;";
		@$sentencia=$this->db->prepare($sql);
		@$sentencia->bindParam(':id_inventario',$id_inventario);
		@$sentencia->bindParam(':fecha_recibe',$fecha_recibe);
		@$sentencia->bindParam(':id_insertado',$id_insertado);
		$result = $sentencia->execute();
		return $result;
	}

	public function consultarHistorialAsignacionesBien($id_inventario)
	{
		$sql = "SELECT CONCAT(PC.VC_Primer_Nombre,' ',PC.VC_Segundo_Nombre,' ',PC.VC_Primer_Apellido,' ',PC.VC_Segundo_Apellido) AS 'Contratista', IC.*,CONCAT(PU.VC_Primer_Nombre,' ',PU.VC_Segundo_Nombre,' ',PU.VC_Primer_Apellido,' ',PU.VC_Segundo_Apellido) AS 'Usuario' FROM tb_inf_inventario_contratista IC JOIN tb_persona_2017 PC ON IC.FK_Id_Persona=PC.PK_Id_Persona JOIN tb_persona_2017 PU ON IC.FK_Id_Usuario=PU.PK_Id_Persona WHERE IC.FK_Id_Inventario=:id_inventario ORDER BY IC.PK_Id_Tabla DESC";
		@$sentencia=$this->db->prepare($sql);
		@$sentencia->bindParam(':id_inventario',$id_inventario);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function eliminarAsignacionInventario($id_asignacion, $usuario)
	{
		@$set_id_usuario = $this->db->prepare("SET @user_id = :usuario;");
		@$set_id_usuario->bindParam(':usuario',$usuario);
		$set_id_usuario->execute();

		$sql = "DELETE FROM tb_inf_inventario_contratista WHERE PK_Id_Tabla=:id_asignacion";
		@$sentencia=$this->db->prepare($sql);
		@$sentencia->bindParam(':id_asignacion',$id_asignacion);
		$sentencia->execute();
		return $sentencia->rowCount();
	}

	public function guardarEspacioCREA($id_crea, $nombre_espacio, $nivel, $fecha, $usuario)
	{
		@$set_id_usuario = $this->db->prepare("SET @user_id = :usuario;");
		@$set_id_usuario->bindParam(':usuario',$usuario);
		$set_id_usuario->execute();
		$sql = "INSERT INTO tb_salones(FK_Id_Crea, VC_Nombre, IN_Nivel, DT_Fecha_Creacion, FK_Usuario) VALUES (:id_crea, :nombre_espacio, :nivel, :fecha, :usuario)";
		@$sentencia=$this->db->prepare($sql);
		@$sentencia->bindParam(':id_crea',$id_crea);
		@$sentencia->bindParam(':nombre_espacio',$nombre_espacio);
		@$sentencia->bindParam(':nivel',$nivel);
		@$sentencia->bindParam(':fecha',$fecha);
		@$sentencia->bindParam(':usuario',$usuario);
		$result = $sentencia->execute();
		return $result;
	}

	public function getEspaciosCrea($id_crea)
	{
		$sql = "SELECT * FROM tb_salones WHERE FK_Id_Crea=:id_crea ORDER BY PK_Id_Salon ASC";
		@$sentencia=$this->db->prepare($sql);

		@$sentencia->bindParam(':id_crea',$id_crea);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function eliminarEspacioCREA($id_espacio, $usuario)
	{
		@$set_id_usuario = $this->db->prepare("SET @user_id = :usuario;");
		@$set_id_usuario->bindParam(':usuario',$usuario);
		$set_id_usuario->execute();
		
		$sql = "SELECT ((SELECT COUNT(*) FROM tb_terr_grupo_arte_escuela_sesion_clase AESC WHERE AESC.FK_salon=:id_espacio)+(SELECT COUNT(*) FROM tb_terr_grupo_emprende_clan_sesion_clase ECSC WHERE ECSC.FK_salon=:id_espacio)+(SELECT COUNT(*) FROM tb_terr_grupo_laboratorio_clan_sesion_clase LCSC WHERE LCSC.FK_salon=:id_espacio)) AS TOTAL";
		@$sentencia=$this->db->prepare($sql);
		@$sentencia->bindParam(':id_espacio',$id_espacio);
		$sentencia->execute();
		$total = $sentencia->fetchAll(\PDO::FETCH_ASSOC);
		$total = $total[0]['TOTAL'];
		if($total==0){
			$sql = "DELETE FROM tb_salones WHERE PK_Id_Salon=:id_espacio";
			@$sentencia=$this->db->prepare($sql);
			@$sentencia->bindParam(':id_espacio',$id_espacio);
			$sentencia->execute();
			return $sentencia->rowCount();	
		}
		else{
			$sql = "UPDATE tb_salones SET IN_Estado=0 WHERE PK_Id_Salon=:id_espacio";
			@$sentencia=$this->db->prepare($sql);
			@$sentencia->bindParam(':id_espacio',$id_espacio);
			$sentencia->execute();
			if($sentencia->rowCount()==1){
				return 2;
			}
		}
	}

	public function getCantidadRegistroInventarioMes($anio, $mes){
		$sql="SELECT
				INV.FK_Usuario as ID_USUARIO,
				CONCAT (P.VC_Primer_Nombre,' ', P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido) AS NOMBRE,
				COUNT(INV.PK_Id_Inventario) AS CANTIDAD
			FROM tb_inf_inventario_clan INV
			JOIN tb_persona_2017 P ON INV.FK_Usuario = P.PK_Id_Persona
			WHERE
				YEAR(INV.DA_Fecha_Registro)=:anio AND
				MONTH(INV.DA_Fecha_Registro)=:mes
				GROUP BY INV.FK_Usuario";
		@$sentencia=$this->db->prepare($sql);
		@$sentencia->bindParam(':anio',$anio);
		@$sentencia->bindParam(':mes',$mes);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}
	
	public function getListadoInventarioRegistradoUsuario($anio, $mes, $id_persona){
		$sql="SELECT
			C.VC_Descripcion AS LUGAR,
			TB.VC_Descripcion AS TIPOBIEN,
			INV.IN_Cantidad AS CANTIDAD,
			INV.VC_Placa AS PLACA,
			E.VC_Descripcion AS ELEMENTO,
			INV.VC_Descripcion AS DESCRIPCION,
			INV.DA_Fecha_Registro AS REGISTRO
			FROM tb_inf_inventario_clan INV
			JOIN tb_parametro_detalle C ON C.FK_Value=INV.FK_Id_Clan AND C.FK_Id_Parametro=27
			JOIN tb_parametro_detalle E ON E.FK_Value=INV.FK_Id_Elemento AND E.FK_Id_Parametro=22
			JOIN tb_parametro_detalle TB ON TB.FK_Value=INV.FK_Id_Tipo_Bien AND TB.FK_Id_Parametro=24
			WHERE
				YEAR(INV.DA_Fecha_Registro)=:anio AND
				MONTH(INV.DA_Fecha_Registro)=:mes AND
				INV.FK_Usuario=:id_persona
				ORDER BY INV.DA_Fecha_Registro ASC";
		@$sentencia=$this->db->prepare($sql);
		@$sentencia->bindParam(':anio',$anio);
		@$sentencia->bindParam(':mes',$mes);
		@$sentencia->bindParam(':id_persona',$id_persona);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}
	
	public function getCantidadTrasladosInventarioMes($anio, $mes){
		$sql="SELECT
				T.FK_Persona_Solicita as ID_USUARIO,
				CONCAT (P.VC_Primer_Nombre,' ', P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido) AS NOMBRE,
				COUNT(T.PK_Id_Traslado) AS CANTIDAD
			FROM tb_inf_traslado T
			JOIN tb_persona_2017 P ON T.FK_Persona_Solicita = P.PK_Id_Persona
			WHERE
				YEAR(T.DA_Fecha_Solicitud)=:anio AND
				MONTH(T.DA_Fecha_Solicitud)=:mes
				GROUP BY T.FK_Persona_Solicita";
		@$sentencia=$this->db->prepare($sql);
		@$sentencia->bindParam(':anio',$anio);
		@$sentencia->bindParam(':mes',$mes);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}
	
	public function getListadoTrasladoInventarioUsuario($anio, $mes, $id_persona){
		$sql="SELECT
			INV.VC_Placa AS PLACA,
			INV.VC_Descripcion AS DESCRIPCION,
			T.IN_Cantidad AS CANTIDAD,
	      T.TX_Argumento AS ARGUMENTO,
			ORIGEN.VC_Descripcion AS ORIGEN,
			DESTINO.VC_Descripcion AS DESTINO,
			T.VC_Tipo_Traslado AS TIPO,
			T.DA_Fecha_Solicitud AS SOLICITUD,
			CASE
			WHEN T.IN_Estado=1 THEN 'REALIZADO'
			WHEN T.IN_Estado=2 THEN 'CANCELADO'
			ELSE 'SIN ACCIÓN'
			END AS 'ESTADO',
			T.DA_Fecha_Revision AS 'TRASLADO SIF',
			T.DA_Fecha_Traslado AS 'TRASLADO FÍSICO'
			FROM tb_inf_traslado T
			JOIN tb_inf_inventario_clan INV ON INV.PK_Id_Inventario=T.FK_Id_Inventario
			JOIN tb_parametro_detalle ORIGEN ON ORIGEN.FK_Value=T.FK_Origen AND ORIGEN.FK_Id_Parametro=27
			JOIN tb_parametro_detalle DESTINO ON DESTINO.FK_Value=T.FK_Destino AND DESTINO.FK_Id_Parametro=27
			WHERE
				YEAR(T.DA_Fecha_Solicitud)=:anio AND
				MONTH(T.DA_Fecha_Solicitud)=:mes AND
				T.FK_Persona_Solicita=:id_persona
				ORDER BY T.DA_Fecha_Solicitud ASC";
		@$sentencia=$this->db->prepare($sql);
		@$sentencia->bindParam(':anio',$anio);
		@$sentencia->bindParam(':mes',$mes);
		@$sentencia->bindParam(':id_persona',$id_persona);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}
	
	public function getCantidadObservacionesInventarioMes($anio, $mes){
		$sql="SELECT
				CI.FK_Id_Persona as ID_USUARIO,
				CONCAT (P.VC_Primer_Nombre,' ', P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido) AS NOMBRE,
				COUNT(CI.PK_Id_Control_Inventario) AS CANTIDAD
			FROM tb_inf_control_inventario CI
			JOIN tb_persona_2017 P ON CI.FK_Id_Persona = P.PK_Id_Persona
			WHERE
				YEAR(CI.DA_Fecha)=:anio AND
				MONTH(CI.DA_Fecha)=:mes
				GROUP BY CI.FK_Id_Persona";
		@$sentencia=$this->db->prepare($sql);
		@$sentencia->bindParam(':anio',$anio);
		@$sentencia->bindParam(':mes',$mes);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}
	
	public function getListadoObservacionesInventarioUsuario($anio, $mes, $id_persona){
		$sql="SELECT
			C.VC_Descripcion AS CREA,
			INV.VC_Placa AS PLACA,
			E.VC_Descripcion AS ELEMENTO,
			INV.VC_Descripcion AS DESCRIPCION,
			CI.VC_Observacion AS OBSERVACION,
			CI.DA_Fecha AS FECHA,
			CASE
			WHEN CI.IN_Estado=1 THEN 'BUENO'
			WHEN CI.IN_Estado=2 THEN 'FUNCIONAL'
			WHEN CI.IN_Estado=3 THEN 'PENDIENTE PARA BAJA'
			END AS 'ESTADO'
			FROM tb_inf_control_inventario CI
			JOIN tb_inf_inventario_clan INV ON INV.PK_Id_Inventario=CI.FK_Id_Inventario
			JOIN tb_parametro_detalle C ON C.FK_Value=INV.FK_Id_Clan AND C.FK_Id_Parametro=27
			JOIN tb_parametro_detalle E ON E.FK_Value=INV.FK_Id_Elemento AND E.FK_Id_Parametro=22
			WHERE
				YEAR(CI.DA_Fecha)=:anio AND
				MONTH(CI.DA_Fecha)=:mes AND
				CI.FK_Id_Persona=:id_persona
				ORDER BY CI.DA_Fecha ASC";
		@$sentencia=$this->db->prepare($sql);
		@$sentencia->bindParam(':anio',$anio);
		@$sentencia->bindParam(':mes',$mes);
		@$sentencia->bindParam(':id_persona',$id_persona);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function validarPlaca($placa, $id)
  	{
  		$sql = "CALL sp_inf_existencia_placa(:placa,:id)";
  		@$sentencia=$this->db->prepare($sql);
		@$sentencia->bindParam(':placa',$placa);
		@$sentencia->bindParam(':id',$id);
		$sentencia->execute();
		return $sentencia->rowCount();
  	}

  	public function registrarRegistroFotografico($id_elemento, $url_archivos, $id_usuario_registro)
	{
		@$set_id_usuario = $this->db->prepare("SET @user_id = :id_usuario;");
		@$set_id_usuario->bindParam(':id_usuario', $id_usuario_registro);
		$set_id_usuario->execute();

		$sql = "INSERT INTO tb_inf_inventario_registro_fotografico(FK_Id_Inventario, VC_Url, FK_Persona, DA_Registro) VALUES (:id_inventario, :vc_url, :id_usuario, :fecha_registro)";
		@$sentencia=$this->db->prepare($sql);
		@$sentencia->bindParam(':id_inventario',$id_elemento);
		@$sentencia->bindParam(':vc_url',$url_archivos);
		@$sentencia->bindParam(':id_usuario',$id_usuario_registro);
		@$sentencia->bindParam(':fecha_registro',date("Y-m-d H:i:s"));
		$result = $sentencia->execute();
		return $result;
	}

	public function actualizarRegistroFotografico($id_inventario, $url_archivos, $id_usuario){
		@$set_id_usuario = $this->db->prepare("SET @user_id = :id_usuario;");
		@$set_id_usuario->bindParam(':id_usuario', $id_usuario);
		$set_id_usuario->execute();

		$sql = "UPDATE tb_inf_inventario_registro_fotografico SET VC_Url=:vc_url, FK_Persona=:id_usuario, DA_Registro=:fecha WHERE FK_Id_Inventario=:id_inventario";
		@$sentencia=$this->db->prepare($sql);
		@$sentencia->bindParam(':id_inventario',$id_inventario);
		@$sentencia->bindParam(':vc_url',$url_archivos);
		@$sentencia->bindParam(':id_usuario',$id_usuario);
		@$sentencia->bindParam(':fecha',date("Y-m-d H:i:s"));
		$result = $sentencia->execute();
		return $result;
	}

	public function getRegistroFotografico($id_inventario){
		$sql = "SELECT VC_Url FROM tb_inf_inventario_registro_fotografico RF WHERE RF.FK_Id_Inventario=:id_inventario;";
		@$sentencia=$this->db->prepare($sql);
		@$sentencia->bindParam(':id_inventario',$id_inventario);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}
}
