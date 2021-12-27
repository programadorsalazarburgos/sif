<?php

namespace General\Persistencia\DAOS; 


class PedagogicoDAO extends GestionDAO {

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

	public function consultarObjeto($localidad){

		return;
	}

	public function consultarArtistasFormadoresEvaluadosPorEstudiante($anio){
		$sentencia=$this->db->prepare("SELECT DISTINCT EE.FK_artista_formador,P.VC_Primer_Nombre,P.VC_Segundo_Nombre,P.VC_Primer_Apellido,P.VC_Segundo_Apellido FROM tb_ped_encuesta_estudiantes EE
			JOIN tb_persona_2017 P ON EE.FK_artista_formador = P.PK_Id_Persona
			WHERE EE.anio = :anio");    
		$sentencia->bindParam(':anio',$anio);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function consultarArtistasFormadoresEvaluadosPorFuncionario($anio){
		$sentencia=$this->db->prepare("SELECT DISTINCT EE.FK_artista_formador_evaluado,P.VC_Primer_Nombre,P.VC_Segundo_Nombre,P.VC_Primer_Apellido,P.VC_Segundo_Apellido 
			FROM tb_ped_evaluacion_artista_formador EE
			JOIN tb_persona_2017 P ON EE.FK_artista_formador_evaluado = P.PK_Id_Persona
			WHERE EE.anio = :anio");    
		$sentencia->bindParam(':anio',$anio);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);        
	}

	public function consutarResultadoEvaluacionEstudiante($id_artista_formador,$anio){
		$sentencia=$this->db->prepare("SELECT DT_fecha_registro,VC_nombre_estudiante,RT_1,RT_2,RT_3,RT_4,RT_5,RT_6,RT_7,VC_observaciones,AA.VC_Nom_Area,P.VC_Primer_Nombre,P.VC_Segundo_Nombre,P.VC_Primer_Apellido,P.VC_Segundo_Apellido
			FROM tb_ped_encuesta_estudiantes EE
			LEFT JOIN tb_areas_artisticas AA ON EE.FK_area_artistica = AA.PK_Area_Artistica
			LEFT JOIN tb_persona_2017 P ON EE.FK_artista_formador = P.PK_Id_Persona
			WHERE EE.FK_artista_formador = :id_artista_formador AND EE.anio = :anio");    
		$sentencia->bindParam(':id_artista_formador',$id_artista_formador);
		$sentencia->bindParam(':anio',$anio);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function consultarResultadoEvaluacionEstudianteTodosLosArtistas($anio){
		$sentencia=$this->db->prepare("SELECT DT_fecha_registro,VC_nombre_estudiante,RT_1,RT_2,RT_3,RT_4,RT_5,RT_6,RT_7,VC_observaciones,AA.VC_Nom_Area,P.VC_Primer_Nombre,P.VC_Segundo_Nombre,P.VC_Primer_Apellido,P.VC_Segundo_Apellido
			FROM tb_ped_encuesta_estudiantes EE
			LEFT JOIN tb_areas_artisticas AA ON EE.FK_area_artistica = AA.PK_Area_Artistica
			LEFT JOIN tb_persona_2017 P ON EE.FK_artista_formador = P.PK_Id_Persona
			WHERE EE.anio = :anio");    
		$sentencia->bindParam(':anio',$anio); 
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function consutarResultadoEvaluacionFuncionario($id_artista_formador,$anio){
		$sentencia=$this->db->prepare("SELECT AA.VC_Nom_Area,CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido) AS nombre_artista,
			CONCAT(P1.VC_Primer_Nombre,' ',P1.VC_Segundo_Nombre,' ',P1.VC_Primer_Apellido,' ',P1.VC_Segundo_Apellido) AS nombre_evaluador,EE.DT_fecha_registro,
			EE.IN_cumplimiento_entrega_tareas,EE.VC_cumplimiento_entrega_tareas,
			EE.IN_disposicion_colaboracion_trabajo_equipo,EE.VC_disposicion_colaboracion_trabajo_equipo,
			EE.IN_aportes_area_artistica,EE.VC_aportes_area_artistica,
			EE.IN_evidencia_calidad_procesos_formativos,EE.VC_evidencia_calidad_procesos_formativos,
			EE.IN_evidencia_resultados_desempenio_artistico,EE.VC_evidencia_resultados_desempenio_artistico,EE.IN_puntaje_total
			FROM tb_ped_evaluacion_artista_formador EE
			LEFT JOIN tb_areas_artisticas AA ON EE.FK_area_artistica = AA.PK_Area_Artistica
			LEFT JOIN tb_persona_2017 P ON EE.FK_artista_formador_evaluado = P.PK_Id_Persona
			LEFT JOIN tb_persona_2017 P1 ON EE.FK_evaluador = P1.PK_Id_Persona
			WHERE EE.FK_artista_formador_evaluado = :id_artista_formador AND EE.anio = :anio");
		$sentencia->bindParam(':id_artista_formador',$id_artista_formador);
		$sentencia->bindParam(':anio',$anio);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function consultarResultadoEvaluacionFuncionarioTodosLosArtistas($anio){
		$sentencia=$this->db->prepare("SELECT AA.VC_Nom_Area,CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido) AS nombre_artista,
			CONCAT(P1.VC_Primer_Nombre,' ',P1.VC_Segundo_Nombre,' ',P1.VC_Primer_Apellido,' ',P1.VC_Segundo_Apellido) AS nombre_evaluador,EE.DT_fecha_registro,
			EE.IN_cumplimiento_entrega_tareas,EE.VC_cumplimiento_entrega_tareas,
			EE.IN_disposicion_colaboracion_trabajo_equipo,EE.VC_disposicion_colaboracion_trabajo_equipo,
			EE.IN_aportes_area_artistica,EE.VC_aportes_area_artistica,
			EE.IN_evidencia_calidad_procesos_formativos,EE.VC_evidencia_calidad_procesos_formativos,
			EE.IN_evidencia_resultados_desempenio_artistico,EE.VC_evidencia_resultados_desempenio_artistico,EE.IN_puntaje_total
			FROM tb_ped_evaluacion_artista_formador EE
			LEFT JOIN tb_areas_artisticas AA ON EE.FK_area_artistica = AA.PK_Area_Artistica
			LEFT JOIN tb_persona_2017 P ON EE.FK_artista_formador_evaluado = P.PK_Id_Persona
			LEFT JOIN tb_persona_2017 P1 ON EE.FK_evaluador = P1.PK_Id_Persona
			WHERE EE.anio = :anio");
		$sentencia->bindParam(':anio',$anio);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function consultarInformacionGrupo($id_grupo, $tipo_grupo){
		if($tipo_grupo == 'arte_escuela'){
			$sentencia=$this->db->prepare("SELECT AA.VC_Descripcion as VC_Nom_Area, COL.VC_Nom_Colegio,G.FK_organizacion, C.VC_Nom_Clan, G.IN_lugar_atencion, G.DT_fecha_creacion 
				FROM tb_terr_grupo_arte_escuela G
				JOIN tb_colegios COL ON G.FK_colegio=COL.PK_Id_Colegio
				JOIN tb_parametro_detalle AA ON AA.FK_value = G.FK_area_artistica AND AA.FK_Id_Parametro = 6
				JOIN tb_clan C ON G.FK_clan = C.PK_Id_Clan
				WHERE G.PK_Grupo = :grupo");
		}
		if($tipo_grupo == 'emprende_clan'){
			$sentencia=$this->db->prepare("SELECT AA.VC_Descripcion as VC_Nom_Area, M.VC_Nom_Modalidad,G.FK_organizacion, C.VC_Nom_Clan, G.DT_fecha_creacion 
				FROM tb_terr_grupo_emprende_clan G
				JOIN tb_modalidad M ON G.FK_modalidad = M.PK_Id_Modalidad
				JOIN tb_parametro_detalle AA ON AA.FK_value = G.FK_area_artistica AND AA.FK_Id_Parametro = 6
				JOIN tb_clan C ON G.FK_clan = C.PK_Id_Clan
				WHERE G.PK_Grupo = :grupo");
		}
		if($tipo_grupo == 'laboratorio_clan'){
			$sentencia=$this->db->prepare("SELECT AA.VC_Descripcion as VC_Nom_Area,G.FK_organizacion, C.VC_Nom_Clan, G.IN_lugar_atencion, G.DT_fecha_creacion, G.TX_Sitio, ALIADO.TX_Nombre_Aliado
				FROM tb_terr_grupo_laboratorio_clan G
				JOIN tb_parametro_detalle AA ON AA.FK_value = G.FK_area_artistica AND AA.FK_Id_Parametro = 6
				JOIN tb_clan C ON G.FK_clan = C.PK_Id_Clan
				LEFT JOIN tb_terr_grupo_laboratorio_crea_aliado ALIADO ON G.FK_Aliado=ALIADO.PK_Id_Aliado
				WHERE G.PK_Grupo = :grupo");
		}
		$sentencia->bindParam(':grupo',$id_grupo);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}

	/* consultarInfoCaracterizacion($id_caracterizacion) consulta las caracterizaciones de un grupo.*/
	function consultarInfoCaracterizacion($id_caracterizacion){
		$sql = "SELECT C.*, CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido) AS FORMADOR FROM tb_caracterizacion_grupo C JOIN tb_persona_2017 P ON P.PK_Id_Persona=C.FK_Id_Usuario_Registro WHERE C.PK_Id_Caracterizacion=:id_caracterizacion";
		$sentencia = $this->db->prepare($sql);
		$sentencia->bindParam(':id_caracterizacion',$id_caracterizacion);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function guardarCaracterizacion($objeto, $bandera_edicion){
		$set_id_usuario = $this->db->prepare("SET @user_id = '".$objeto->getFkIdUsuarioRegistro()."';");
		if($bandera_edicion == 0){
			$sentencia = $this->db->prepare("INSERT INTO tb_caracterizacion_grupo (FK_Grupo, FK_Id_Linea_Atencion, FK_Ciclo, TX_Particularidades, TX_Descripcion_Grupo, TX_Descripcion_Intereses, TX_Descripcion_Espacio, TX_Convivencia, TX_Observaciones, FK_Id_Usuario_Registro, DA_Fecha_Registro, IN_Version, VC_Tipo, IN_Finalizado, IN_Estado) VALUES (:FK_Grupo, :FK_Id_Linea_Atencion, :FK_Ciclo, :TX_Particularidades, :TX_Descripcion_Grupo, :TX_Descripcion_Intereses, :TX_Descripcion_Espacio, :TX_Convivencia, :TX_Observaciones, :FK_Id_Usuario_Registro, :DA_Fecha_Registro, :IN_Version, :VC_Tipo, :IN_Finalizado, :IN_Estado)");
		}
		else{
			$sentencia = $this->db->prepare("UPDATE tb_caracterizacion_grupo SET FK_Id_Linea_Atencion=:FK_Id_Linea_Atencion, FK_Ciclo=:FK_Ciclo, TX_Particularidades=:TX_Particularidades, TX_Descripcion_Grupo=:TX_Descripcion_Grupo, TX_Descripcion_Intereses=:TX_Descripcion_Intereses, TX_Descripcion_Espacio=:TX_Descripcion_Espacio, TX_Convivencia=:TX_Convivencia, TX_Observaciones=:TX_Observaciones, FK_Id_Usuario_Registro=:FK_Id_Usuario_Registro, DA_Fecha_Registro=:DA_Fecha_Registro, IN_Version=:IN_Version, VC_Tipo=:VC_Tipo, IN_Finalizado=:IN_Finalizado, IN_Estado=:IN_Estado WHERE PK_Id_Caracterizacion=:PK_Id_Caracterizacion");
		}
		try{
			$fecha = date('Y-m-d H:i:s');
			$this->db->beginTransaction();
			$set_id_usuario->execute();
			if($bandera_edicion == 0){
				$sentencia->bindValue(':FK_Grupo' , $objeto->getFkGrupo());
			}
			else{
				$sentencia->bindValue(':PK_Id_Caracterizacion' , $objeto->getPkIdCaracterizacion());
			}
			$sentencia->bindValue(':FK_Id_Linea_Atencion' , $objeto->getFkIdLineaAtencion());
			$sentencia->bindValue(':FK_Ciclo' , $objeto->getFkCiclo());
			$sentencia->bindValue(':TX_Particularidades' , $objeto->getTxParticularidades());
			$sentencia->bindValue(':TX_Descripcion_Grupo' , $objeto->getTxDescripcionGrupo());
			$sentencia->bindValue(':TX_Descripcion_Intereses' , $objeto->getTxDescripcionIntereses());
			$sentencia->bindValue(':TX_Descripcion_Espacio' , $objeto->getTxDescripcionEspacio());
			$sentencia->bindValue(':TX_Convivencia' , $objeto->getTxConvivencia());
			$sentencia->bindValue(':TX_Observaciones' , $objeto->getTxObservaciones());
			$sentencia->bindValue(':FK_Id_Usuario_Registro' , $objeto->getFkIdUsuarioRegistro());
			$sentencia->bindValue(':DA_Fecha_Registro' , $fecha);
			$sentencia->bindValue(':IN_Version' , $objeto->getInVersion());
			$sentencia->bindValue(':VC_Tipo', $objeto->getVcTipo());
			$sentencia->bindValue(':IN_Finalizado', $objeto->getInFinalizado());
			$sentencia->bindValue(':IN_Estado', $objeto->getInEstado());
			$sentencia->execute();
			$this->db->commit();
			return $sentencia->rowCount();
		}catch(PDOExecption $e) {
			$this->db->rollback();
			return "Error!: " . $e->getMessage() . "</br>";
		}
	}
	public function guardarPlaneacion($objeto,$planeacion_id){
		//var_dump($objeto);
		$set_id_usuario = $this->db->prepare("SET @user_id = '".$objeto->getFkIdUsuarioRegistro()."';");
		if($planeacion_id != "" && $planeacion_id != null ){
			$sentencia = $this->db->prepare("UPDATE tb_planeacion_grupo
				SET 
				FK_Ciclo = :FK_Ciclo,
				VC_Objetivo = :VC_Objetivo,
				VC_Pregunta = :VC_Pregunta,
				VC_Descripcion = :VC_Descripcion,
				VC_Metodologia = :VC_Metodologia,
				VC_Temas = :VC_Temas,
				VC_Recursos = :VC_Recursos,
				VC_Referentes = :VC_Referentes,
				VC_Propuesta_Circulacion = :VC_Propuesta_Circulacion,
				VC_Acciones = :VC_Acciones,
				FK_Id_Usuario_Registro = :FK_Id_Usuario_Registro,
				DA_Fecha_Registro = now(),
				VC_Articulacion = :VC_Articulacion,
				IN_Version = :IN_Version,
				IN_Finalizado = :IN_Finalizado,
				IN_Estado = :IN_Estado
				WHERE PK_Id_Planeacion=:PK_Id_Planeacion
				");
		}
		else {
			$sentencia = $this->db->prepare("INSERT INTO tb_planeacion_grupo
				(FK_grupo, FK_Id_Linea_atencion, FK_Ciclo, VC_Objetivo, VC_Pregunta, VC_Descripcion, VC_Metodologia, VC_Temas, VC_Recursos, VC_Referentes, VC_Propuesta_Circulacion, VC_Acciones, FK_Id_Usuario_Registro, DA_Fecha_Registro, VC_Articulacion, IN_Version, IN_Finalizado, IN_Estado) VALUES (:FK_grupo, :FK_Id_Linea_atencion, :FK_Ciclo, :VC_Objetivo, :VC_Pregunta, :VC_Descripcion, :VC_Metodologia, :VC_Temas, :VC_Recursos, :VC_Referentes, :VC_Propuesta_Circulacion, :VC_Acciones, :FK_Id_Usuario_Registro, now(), :VC_Articulacion, :IN_Version, :IN_Finalizado, :IN_Estado)");
		}
		try{
			$fecha = date('Y-m-d H:i:s');
			$this->db->beginTransaction();
			$set_id_usuario->execute();
			if($planeacion_id == "" || $planeacion_id == null )	
				$sentencia->bindValue(':FK_grupo',$objeto->getFkGrupo());
			if($planeacion_id == "" || $planeacion_id == null )	
				$sentencia->bindValue(':FK_Id_Linea_atencion',$objeto->getFkIdLineaAtencion());
			$sentencia->bindValue(':FK_Ciclo',$objeto->getFkCiclo());
			$sentencia->bindValue(':VC_Objetivo',$objeto->getVcObjetivo());
			$sentencia->bindValue(':VC_Pregunta',$objeto->getVcPregunta());
			$sentencia->bindValue(':VC_Descripcion',$objeto->getVcDescripcion());
			$sentencia->bindValue(':VC_Metodologia',$objeto->getVcMetodologia());
			$sentencia->bindValue(':VC_Temas',$objeto->getVcTemas());
			$sentencia->bindValue(':VC_Recursos',$objeto->getVcRecursos());
			$sentencia->bindValue(':VC_Referentes',$objeto->getVcReferentes());
			$sentencia->bindValue(':VC_Acciones',$objeto->getVcAcciones());
			$sentencia->bindValue(':FK_Id_Usuario_Registro',$objeto->getFkIdUsuarioRegistro());
			$sentencia->bindValue(':VC_Propuesta_Circulacion',$objeto->getVcPropuestaCirculacion());
			$sentencia->bindValue(':VC_Articulacion',$objeto->getVcArticulacion());
			$sentencia->bindValue(':IN_Version','2');
			$sentencia->bindValue(':IN_Finalizado',$objeto->getInFinalizado());
			$sentencia->bindValue(':IN_Estado',$objeto->getInEstado());
			if($planeacion_id != "" && $planeacion_id != null )		
				$sentencia->bindValue(':PK_Id_Planeacion',$planeacion_id);
			$sentencia->execute();
			$this->db->commit();
			return $sentencia->rowCount();
		}catch(PDOExecption $e) {
			$this->db->rollback();
			return "Error!: " . $e->getMessage() . "</br>";
		}
	}
	public function guardarGrupoPropuestaProyecto($objeto,$planeacion_id){
		//var_dump($objeto);
		$set_id_usuario = $this->db->prepare("SET @user_id = '".$objeto->getFkIdUsuarioRegistro()."';");
		if($planeacion_id != "" && $planeacion_id != null ){
			$sentencia = $this->db->prepare("UPDATE tb_grupo_propuesta_proyecto
				SET 
				VC_Nombre_Proyecto = :VC_Nombre_Proyecto,
				VC_Manos = :VC_Manos,
				VC_Tipo_Poblacion = :VC_Tipo_Poblacion,
				VC_Entidad_Aliada = :VC_Entidad_Aliada,
				VC_Proposito = :VC_Proposito,
				VC_Tipo_Proyecto = :VC_Tipo_Proyecto,
				VC_Justificacion = :VC_Justificacion,
				VC_Descripcion = :VC_Descripcion,
				VC_Objetivo_General = :VC_Objetivo_General,
				VC_Objetivos_Especificos = :VC_Objetivos_Especificos,
				VC_Referentes = :VC_Referentes,
				VC_Resultados = :VC_Resultados,
				VC_Criterios = :VC_Criterios,
				VC_Otros_Recursos = :VC_Otros_Recursos,
				VC_Planeador = :VC_Planeador,
				VC_Acciones = :VC_Acciones,
				VC_Recursos = :VC_Recursos,
				VC_Metodologia = :VC_Metodologia,
				FK_Id_Usuario_Registro = :FK_Id_Usuario_Registro,
				DA_Fecha_Registro = NOW(),
				IN_Finalizado = :IN_Finalizado
				WHERE PK_Id_Propuesta_Proyecto=:PK_Id_Propuesta_Proyecto
				");
		}
		else {
			$sentencia = $this->db->prepare("INSERT INTO tb_grupo_propuesta_proyecto (FK_Id_Linea_atencion, VC_Nombre_Proyecto, VC_Manos, VC_Tipo_Poblacion, VC_Entidad_Aliada, VC_Proposito, VC_Tipo_Proyecto, VC_Justificacion, VC_Descripcion, VC_Objetivo_General, VC_Objetivos_Especificos, VC_Referentes, VC_Resultados, VC_Criterios, VC_Otros_Recursos, VC_Planeador, VC_Metodologia, VC_Acciones, FK_grupo, VC_Recursos, FK_Id_Usuario_Registro, DA_Fecha_Registro, IN_Finalizado) 
				VALUES (:FK_Id_Linea_atencion, :VC_Nombre_Proyecto, :VC_Manos, :VC_Tipo_Poblacion, :VC_Entidad_Aliada, :VC_Proposito, :VC_Tipo_Proyecto, :VC_Justificacion, :VC_Descripcion, :VC_Objetivo_General, :VC_Objetivos_Especificos, :VC_Referentes, :VC_Resultados, :VC_Criterios, :VC_Otros_Recursos, :VC_Planeador,:VC_Metodologia , :VC_Acciones, :FK_grupo, :VC_Recursos, :FK_Id_Usuario_Registro, NOW(), :IN_Finalizado);");
		}
		try{
			$fecha = date('Y-m-d H:i:s');
			$this->db->beginTransaction();
			$set_id_usuario->execute();
			if($planeacion_id == "" || $planeacion_id == null )	
				$sentencia->bindValue(':FK_grupo',$objeto->getFkGrupo());
			if($planeacion_id == "" || $planeacion_id == null )	
				$sentencia->bindValue(':FK_Id_Linea_atencion',$objeto->getFkIdLineaAtencion());
			$sentencia->bindValue(':VC_Nombre_Proyecto',$objeto->getVcNombreProyecto());
			$sentencia->bindValue(':VC_Manos',$objeto->getVcManos());
			$sentencia->bindValue(':VC_Tipo_Poblacion',$objeto->getVcTipoPoblacion());
			$sentencia->bindValue(':VC_Entidad_Aliada',$objeto->getVcEntidadAliada());
			$sentencia->bindValue(':VC_Proposito',$objeto->getVcProposito());
			$sentencia->bindValue(':VC_Tipo_Proyecto',$objeto->getVcTipoProyecto());
			$sentencia->bindValue(':VC_Justificacion',$objeto->getVcJustificacion());
			$sentencia->bindValue(':VC_Descripcion',$objeto->getVcDescripcion());
			$sentencia->bindValue(':VC_Objetivo_General',$objeto->getVcObjetivoGeneral());
			$sentencia->bindValue(':VC_Objetivos_Especificos',$objeto->getVcObjetivosEspecificos());
			$sentencia->bindValue(':VC_Referentes',$objeto->getVcReferentes());
			$sentencia->bindValue(':VC_Resultados',$objeto->getVcResultados());
			$sentencia->bindValue(':VC_Criterios',$objeto->getVcCriterios());
			$sentencia->bindValue(':VC_Otros_Recursos',$objeto->getVcOtrosRecursos());
			$sentencia->bindValue(':VC_Planeador',$objeto->getVcPlaneador());
			$sentencia->bindValue(':VC_Metodologia',$objeto->getVcMetodologia());
			$sentencia->bindValue(':VC_Acciones',$objeto->getVcAcciones());
			$sentencia->bindValue(':FK_Id_Usuario_Registro',$objeto->getFkIdUsuarioRegistro());
			$sentencia->bindValue(':VC_Recursos',$objeto->getVcRecursos());
			$sentencia->bindValue(':IN_Finalizado',$objeto->getInFinalizado());
			if($planeacion_id != "" && $planeacion_id != null )		
				$sentencia->bindValue(':PK_Id_Propuesta_Proyecto',$planeacion_id);
			$sentencia->execute();
			$this->db->commit();
			return $sentencia->rowCount();
		}catch(PDOExecption $e) {
			$this->db->rollback();
			return "Error!: " . $e->getMessage() . "</br>";
		}
	}

	public function consultarCaracterizacionesFormador($formador){
		$sql = "SELECT * FROM tb_caracterizacion_grupo WHERE FK_Id_Usuario_Registro=:FK_Id_Usuario_Registro AND YEAR(DA_Fecha_Registro)>=2019";
		$sentencia = $this->db->prepare($sql);
		$sentencia->bindParam(':FK_Id_Usuario_Registro',$formador);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}/*
	public function consultarPlaneacion($formador){
		$sql = "SELECT * FROM tb_caracterizacion_grupo WHERE FK_Id_Usuario_Registro=:FK_Id_Usuario_Registro AND YEAR(DA_Fecha_Registro)>=2019";
		$sentencia = $this->db->prepare($sql);
		$sentencia->bindParam(':FK_Id_Usuario_Registro',$formador);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}*/
	public function consultarPlaneacionesFormador($formador){
		$sql = "
		SELECT 
		tpc.FK_Id_Usuario_Registro,
		tpc.IN_Estado,
		tpc.IN_Finalizado,
		tpc.FK_Id_Linea_atencion,
		tpc.PK_Id_Planeacion AS PK_Id,
		tpc.FK_grupo,
		tpc.DA_Fecha_Registro
		FROM tb_planeacion_grupo tpc
		WHERE FK_Id_Usuario_Registro = :FK_Id_Usuario_Registro AND YEAR(DA_Fecha_Registro)>=2019 AND FK_Id_Linea_atencion = 'arte_escuela'
		UNION 
		SELECT 
		tgpp.FK_Id_Usuario_Registro,
		tgpp.IN_Estado,
		tgpp.IN_Finalizado,
		tgpp.FK_Id_Linea_atencion,
		tgpp.PK_Id_Propuesta_Proyecto AS PK_Id,
		tgpp.FK_grupo,
		tgpp.DA_Fecha_Registro
		FROM tb_grupo_propuesta_proyecto tgpp
		WHERE tgpp.FK_Id_Usuario_Registro = :FK_Id_Usuario_Registro AND YEAR(tgpp.DA_Fecha_Registro)>=2019";
		$sentencia = $this->db->prepare($sql);
		$sentencia->bindParam(':FK_Id_Usuario_Registro',$formador);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}
	/* consultarPlaneacionId($id_grupo,$tipo_grupo) consulta las caracterizaciones de un grupo.*/
	function consultarPlaneacionId($id_planeacion){
		$sql = "SELECT * FROM tb_planeacion_grupo WHERE PK_Id_Planeacion=:id_planeacion";
		$sentencia = $this->db->prepare($sql);
		$sentencia->bindParam(':id_planeacion',$id_planeacion);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}
	/* consultarGrupoPropuestaProyectoId($id_grupo,$tipo_grupo) consulta las caracterizaciones de un grupo.*/
	function consultarGrupoPropuestaProyectoId($id_propuesta){
		$sql = "SELECT * FROM tb_grupo_propuesta_proyecto WHERE PK_Id_Propuesta_Proyecto=:id_propuesta";
		$sentencia = $this->db->prepare($sql);
		$sentencia->bindParam(':id_propuesta',$id_propuesta);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function getRecursos(){
		$sql = "SELECT PK_Id_Recurso AS FK_Value, VC_Nombre AS VC_Descripcion FROM tb_recurso;";
		$sentencia = $this->db->prepare($sql);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}
	public function getRecursosText($recursos){
		$sql = "SELECT PK_Id_Recurso, VC_Nombre FROM tb_recurso WHERE FIND_IN_SET(PK_Id_Recurso,:recursos);";
		$sentencia = $this->db->prepare($sql);
		$sentencia->bindParam(':recursos',$recursos);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function validarExistenciaCaracterizacion($grupo, $linea_atencion, $usuario){
		$sql = "SELECT * FROM tb_caracterizacion_grupo WHERE FK_Grupo=:grupo AND FK_Id_Linea_Atencion=:linea_atencion AND FK_Id_Usuario_Registro=:usuario AND IN_Finalizado=0;";
		$sentencia = $this->db->prepare($sql);
		$sentencia->bindParam(':grupo',$grupo);
		$sentencia->bindParam(':linea_atencion',$linea_atencion);
		$sentencia->bindParam(':usuario',$usuario);
		$sentencia->execute();
		return $sentencia->rowCount();
	}

	public function consultarFormatosPegagogicos($anio, $linea, $formato){
		switch ($formato) {
			case "CARACTERIZACION":
			$sql = "SELECT C.PK_Id_Caracterizacion AS PK, C.FK_Grupo AS GRUPO, C.FK_Id_Linea_Atencion AS LINEA, C.IN_Estado AS ESTADO, C.IN_Finalizado AS FINALIZADO, C.VC_Tipo AS TIPO, C.DA_Fecha_Registro AS FECHA, 'CARACTERIZACION' AS FORMATO, CONCAT(F.VC_Primer_Nombre,' ',F.VC_Segundo_Nombre,' ',F.VC_Primer_Apellido,' ',F.VC_Segundo_Apellido) AS FORMADOR, F.PK_Id_Persona AS ID_FORMADOR, PD.VC_Descripcion AS AREA_ARTISTICA FROM tb_caracterizacion_grupo C JOIN tb_persona_2017 F ON C.FK_Id_Usuario_Registro = F.PK_Id_Persona JOIN tb_terr_grupo_".$linea." G ON G.PK_Grupo=C.FK_Grupo JOIN tb_parametro_detalle PD ON PD.FK_Value=G.FK_area_artistica AND PD.FK_Id_Parametro=6 WHERE C.FK_Id_Linea_Atencion=:linea_atencion AND YEAR(C.DA_Fecha_Registro)>=:anio AND IN_Finalizado=1";
			break;
			case "PLANEACION":
			if ($linea == "arte_escuela") {
				$sql = "SELECT P.PK_Id_Planeacion AS PK, P.FK_grupo AS GRUPO, P.FK_Id_Linea_atencion AS LINEA, P.IN_Estado AS ESTADO, P.IN_Finalizado AS FINALIZADO, 'N/A' AS TIPO, P.DA_Fecha_Registro AS FECHA, 'PLANEACION' AS FORMATO, CONCAT(F.VC_Primer_Nombre,' ',F.VC_Segundo_Nombre,' ',F.VC_Primer_Apellido,' ',F.VC_Segundo_Apellido) AS FORMADOR, F.PK_Id_Persona AS ID_FORMADOR, PD.VC_Descripcion AS AREA_ARTISTICA FROM tb_planeacion_grupo P JOIN tb_persona_2017 F ON P.FK_Id_Usuario_Registro = F.PK_Id_Persona JOIN tb_terr_grupo_".$linea." G ON G.PK_Grupo=P.FK_grupo JOIN tb_parametro_detalle PD ON PD.FK_Value=G.FK_area_artistica AND PD.FK_Id_Parametro=6 WHERE P.FK_Id_Linea_Atencion=:linea_atencion AND YEAR(P.DA_Fecha_Registro)>=:anio AND IN_Finalizado=1";
			}
			else
			{
				$sql = "SELECT P.PK_Id_Propuesta_Proyecto AS PK, P.FK_grupo AS GRUPO, P.FK_Id_Linea_atencion AS LINEA, P.IN_Estado AS ESTADO, P.IN_Finalizado AS FINALIZADO, 'N/A' AS TIPO, P.DA_Fecha_Registro AS FECHA, 'PLANEACION' AS FORMATO, CONCAT(F.VC_Primer_Nombre,' ',F.VC_Segundo_Nombre,' ',F.VC_Primer_Apellido,' ',F.VC_Segundo_Apellido) AS FORMADOR, F.PK_Id_Persona AS ID_FORMADOR, PD.VC_Descripcion AS AREA_ARTISTICA FROM tb_grupo_propuesta_proyecto P JOIN tb_persona_2017 F ON P.FK_Id_Usuario_Registro = F.PK_Id_Persona JOIN tb_terr_grupo_".$linea." G ON G.PK_Grupo=P.FK_grupo JOIN tb_parametro_detalle PD ON PD.FK_Value=G.FK_area_artistica AND PD.FK_Id_Parametro=6 WHERE P.FK_Id_Linea_Atencion=:linea_atencion AND YEAR(P.DA_Fecha_Registro)>=:anio AND IN_Finalizado=1"; 
			}			
			break;
			case "VALORACION":
			$sql = "SELECT V.PK_Id_Valoracion AS PK, V.FK_Grupo AS GRUPO, V.FK_Linea_Atencion AS LINEA, V.IN_Estado AS ESTADO, V.IN_Finalizado AS FINALIZADO, 'N/A' AS TIPO, V.DA_Fecha AS FECHA, 'VALORACION' AS FORMATO, CONCAT(F.VC_Primer_Nombre,' ',F.VC_Segundo_Nombre,' ',F.VC_Primer_Apellido,' ',F.VC_Segundo_Apellido) AS FORMADOR, F.PK_Id_Persona AS ID_FORMADOR, PD.VC_Descripcion AS AREA_ARTISTICA FROM tb_valoracion_grupo V JOIN tb_persona_2017 F ON V.FK_Formador = F.PK_Id_Persona JOIN tb_terr_grupo_".$linea." G ON G.PK_Grupo=C.FK_Grupo JOIN tb_parametro_detalle PD ON PD.FK_Value=G.FK_area_artistica AND PD.FK_Id_Parametro=6 WHERE V.FK_Linea_Atencion=:linea_atencion AND YEAR(V.DA_Fecha)>=:anio AND IN_Finalizado=1";
			break;
		}

		$sentencia = $this->db->prepare($sql);
		$sentencia->bindParam(':linea_atencion',$linea);
		$sentencia->bindParam(':anio',$anio);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function guardarRevisionFormatoPedagogico($id_tabla, $observacion, $formato, $aprobacion, $usuario, $linea_atencion){
		$set_id_usuario = $this->db->prepare("SET @user_id = '".$usuario."';");
		$set_id_usuario->execute();
		$extraUpdate = "";
		if($aprobacion == 0){
			$extraUpdate = ', IN_Finalizado = 0';
		}
		switch ($formato) {
			case "CARACTERIZACION":
			$sql = "UPDATE tb_caracterizacion_grupo C SET C.TX_Observacion=:observacion, C.IN_Estado=:aprobacion, C.FK_Id_AFA_Cambio=:usuario, C.DT_AFA_Cambio=now()".$extraUpdate." WHERE C.PK_Id_Caracterizacion=:id_tabla;";
			break;
			case "PLANEACION":
			if ($linea_atencion == 'arte_escuela') {
				$sql = "UPDATE tb_planeacion_grupo P SET P.VC_Observacion=:observacion, P.IN_Estado=:aprobacion, P.FK_Id_AFA_Cambio=:usuario, P.DT_AFA_Cambio=now()".$extraUpdate." WHERE P.PK_Id_Planeacion=:id_tabla;";
			}
			else
			{
				$sql = "UPDATE tb_grupo_propuesta_proyecto P SET P.VC_Observacion=:observacion, P.IN_Estado=:aprobacion, P.FK_Id_AFA_Cambio=:usuario, P.DT_AFA_Cambio=now()".$extraUpdate." WHERE P.PK_Id_Propuesta_Proyecto=:id_tabla;";
			}
			break;
			case "VALORACION":
			$sql = "";
			break;
		}

		$sentencia = $this->db->prepare($sql);
		$sentencia->bindParam(':observacion',$observacion);
		$sentencia->bindParam(':aprobacion',$aprobacion);
		$sentencia->bindParam(':usuario',$usuario);
		$sentencia->bindParam(':id_tabla',$id_tabla);
		$sentencia->execute();
		return $sentencia->rowCount();
	}

	public function consultarEstadoRegistroAsistencias($organizacion, $fecha, $linea_atencion, $crea){
		$where = $organizacion != 1 ? "WHERE A.PK_Id_Organizacion = :organizacion":"";
		$where_union = $organizacion != 1 ? " AND G.FK_organizacion = :organizacion":"";
		$sql = "SELECT
		A.*,
		SC.PK_sesion_clase,
		:fecha AS DA_fecha_clase,
		AG.fecha AS DT_fecha_creacion_registro,
		CASE 
		WHEN N.id IS NULL THEN ''
		WHEN N.id IS NOT NULL THEN PD.VC_Descripcion
		END AS 'Novedad'
		FROM (
		SELECT
		G.PK_Grupo,
		CASE 
		WHEN O.PK_Id_Organizacion IS NOT NULL AND O.VC_Nom_Organizacion != '' THEN O.VC_Nom_Organizacion
		ELSE 'SIN ASIGNAR'
		END AS 'VC_Nom_Organizacion',
		O.PK_Id_Organizacion,
		CASE 
		WHEN P.PK_Id_Persona IS NOT NULL THEN UPPER(CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido))
		WHEN P.PK_Id_Persona IS NULL THEN 'SIN ASIGNAR'
		END AS 'Formador'
		FROM tb_terr_grupo_".$linea_atencion." G
		JOIN tb_terr_grupo_".$linea_atencion."_horario_clase H ON H.FK_grupo=G.PK_Grupo
		LEFT JOIN tb_organizaciones_2017 O ON O.PK_Id_Organizacion=G.FK_organizacion
		LEFT JOIN tb_persona_2017 P ON G.FK_artista_formador=P.PK_Id_Persona
		WHERE G.estado=1 AND WEEKDAY(:fecha)+1=H.IN_dia AND G.FK_clan IN (".$crea.")) A
		LEFT JOIN tb_terr_grupo_".$linea_atencion."_sesion_clase SC ON SC.FK_grupo=A.PK_Grupo AND SC.DA_fecha_clase=:fecha
		LEFT JOIN tb_terr_grupo_".$linea_atencion."_sesion_clase_novedad N ON N.FK_grupo=A.PK_Grupo AND SC.DA_fecha_clase=N.DA_fecha_sesion_clase
		LEFT JOIN tb_auditoria_grupo AG ON SC.PK_sesion_clase = JSON_EXTRACT(replace(AG.ahora,'\n',' '), '$.PK_sesion_clase') AND AG.antes = '' AND AG.tabla='tb_terr_grupo_".$linea_atencion."_sesion_clase'
		LEFT JOIN tb_parametro_detalle PD ON PD.FK_Value=N.IN_novedad AND PD.FK_Id_Parametro='25'".$where."
		UNION
		SELECT
		G.PK_Grupo,
		CASE 
		WHEN O.PK_Id_Organizacion IS NOT NULL AND O.VC_Nom_Organizacion != '' THEN O.VC_Nom_Organizacion
		ELSE 'SIN ASIGNAR'
		END AS 'VC_Nom_Organizacion',
		O.PK_Id_Organizacion,
		CASE 
		WHEN P.PK_Id_Persona IS NOT NULL THEN UPPER(CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido))
		WHEN P.PK_Id_Persona IS NULL THEN 'SIN ASIGNAR'
		END AS 'Formador',
		SC.PK_sesion_clase,
		:fecha AS DA_fecha_clase,
		AG.fecha AS DT_fecha_creacion_registro,
		'' AS 'Novedad'
		FROM tb_terr_grupo_".$linea_atencion." G
		JOIN tb_terr_grupo_".$linea_atencion."_sesion_clase SC ON SC.FK_grupo=G.PK_Grupo
		LEFT JOIN tb_organizaciones_2017 O ON O.PK_Id_Organizacion=G.FK_organizacion
		LEFT JOIN tb_persona_2017 P ON G.FK_artista_formador=P.PK_Id_Persona
		LEFT JOIN tb_auditoria_grupo AG ON SC.PK_sesion_clase = JSON_EXTRACT(replace(AG.ahora,'\n',' '), '$.PK_sesion_clase') AND AG.antes = '' AND AG.tabla='tb_terr_grupo_".$linea_atencion."_sesion_clase'
		WHERE SC.DA_fecha_clase = :fecha AND SC.FK_clan IN (".$crea.")".$where_union.";";
		$sentencia = $this->db->prepare($sql);
		$sentencia->bindParam(':fecha',$fecha);
		$sentencia->bindParam(':organizacion',$organizacion);
		$sentencia->bindParam(':crea',$crea);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function consultarUltimaCaracterizacionAprobada($grupo, $linea_atencion, $usuario){
		$sql = "SELECT * FROM tb_caracterizacion_grupo C WHERE C.FK_Grupo=:grupo AND C.FK_Id_Linea_Atencion=:linea_atencion AND C.FK_Id_Usuario_Registro=:usuario AND C.IN_Estado=1 ORDER BY C.PK_Id_Caracterizacion DESC LIMIT 1;";
		$sentencia = $this->db->prepare($sql);
		$sentencia->bindParam(':grupo',$grupo);
		$sentencia->bindParam(':linea_atencion',$linea_atencion);
		$sentencia->bindParam(':usuario',$usuario);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function consultarUltimaPlaneacionAprobada($grupo, $linea_atencion, $usuario){
		$sql = "SELECT * FROM tb_planeacion_grupo P WHERE P.FK_grupo=:grupo AND P.FK_Id_Linea_atencion=:linea_atencion AND P.FK_Id_Usuario_Registro=:usuario AND P.IN_Estado=1 ORDER BY P.PK_Id_Planeacion DESC LIMIT 1;";
		$sentencia = $this->db->prepare($sql);
		$sentencia->bindParam(':grupo',$grupo);
		$sentencia->bindParam(':linea_atencion',$linea_atencion);
		$sentencia->bindParam(':usuario',$usuario);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function consultarUltimaPropuestaProyectoAprobada($grupo, $linea_atencion, $usuario){
		$sql = "SELECT * FROM tb_grupo_propuesta_proyecto GPP WHERE GPP.FK_grupo=:grupo AND GPP.FK_Id_Linea_atencion=:linea_atencion AND GPP.FK_Id_Usuario_Registro=:usuario AND GPP.IN_Estado=1 ORDER BY GPP.PK_Id_Propuesta_Proyecto DESC LIMIT 1;";
		$sentencia = $this->db->prepare($sql);
		$sentencia->bindParam(':grupo',$grupo);
		$sentencia->bindParam(':linea_atencion',$linea_atencion);
		$sentencia->bindParam(':usuario',$usuario);
		$sentencia->execute();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
	}
}