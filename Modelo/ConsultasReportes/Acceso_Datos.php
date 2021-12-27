<?php
// Incluir libreria de acceso a base de datos
require_once('../../Modelo/medoo/medoo.php');
require_once('../../Modelo/medoo/parametros_conexion.php'); 

	/***************************************************************************
	/* getClanes() selecciona los clanes que existen en el sistema.
	***************************************************************************/
	function getClanes(){
		global $db_siclan;
		$clan = $db_siclan->select("tb_clan",["PK_Id_Clan","VC_Nom_Clan"]);
		return ($clan);
	}

	/***************************************************************************
	/* getGruposActivosArteEscuelaByUsuario() consulta los datos de los grupos de arte en la escuela activos que estan asignados a un Artista Formador
	***************************************************************************/
	function getGruposActivosArteEscuelaByUsuario($id_usuario){
		global $db_siclan;
		$grupo = $db_siclan->select("tb_terr_grupo_arte_escuela","*",["AND"=>["FK_artista_formador"=>$id_usuario,"estado"=>1]]);
		return $grupo;
	}

	/***************************************************************************
	/* getGruposActivosEmprendeClanByUsuario() consulta los datos de los grupos de emprende clan activos que estan asignados a un Artista Formador
	***************************************************************************/
	function getGruposActivosEmprendeClanByUsuario($id_usuario){
		global $db_siclan;
		$grupo = $db_siclan->select("tb_terr_grupo_emprende_clan","*",["AND"=>["FK_artista_formador"=>$id_usuario,"estado"=>1]]);
		return $grupo;
	}

	/***************************************************************************
	/* getGruposActivosArteEscuelaByClan() consulta grupos que estan asociados a un grupo de arte en la escuela y se encuentran activos
	***************************************************************************/
	function getGruposActivosArteEscuelaByClan($id_clan){
		global $db_siclan;
		$grupo = $db_siclan->select("tb_terr_grupo_arte_escuela","*",["AND"=>["FK_clan"=>$id_clan,"estado"=>1]]);
		return $grupo;
	}

	function getGruposArteEscuelaByClan($id_clan){
		global $db_siclan;
		$sql = "SELECT DISTINCT(SC.FK_grupo) AS 'PK_Grupo'  FROM tb_terr_grupo_arte_escuela_sesion_clase AS SC WHERE SC.FK_clan=".$id_clan;
		return $db_siclan->query($sql)->fetchAll(\PDO::FETCH_ASSOC); 
	}	

	/***************************************************************************
	/* getGruposActivosEmprendeClanByClan() consulta grupos que estan asociados a un grupo de emprende clan y se encuentran activos
	***************************************************************************/
	function getGruposActivosEmprendeClanByClan($id_clan){
		global $db_siclan;
		$grupo = $db_siclan->select("tb_terr_grupo_emprende_clan","*",["AND"=>["FK_clan"=>$id_clan,"estado"=>1]]);
		return $grupo;
	}

	function getGruposEmprendeClanByClan($id_clan){
		global $db_siclan;
		$sql = "SELECT DISTINCT(SC.FK_grupo) AS 'PK_Grupo'  FROM tb_terr_grupo_emprende_clan_sesion_clase AS SC WHERE SC.FK_clan=".$id_clan;
		return $db_siclan->query($sql)->fetchAll(\PDO::FETCH_ASSOC); 
	}

	/***************************************************************************
	/* getGruposActivosLaboratorioClanByClan() consulta grupos que estan asociados a un grupo de laboratorio clan y se encuentran activos
	***************************************************************************/
	function getGruposActivosLaboratorioClanByClan($id_clan){
		global $db_siclan;
		$grupo = $db_siclan->select("tb_terr_grupo_laboratorio_clan","*",["AND"=>["FK_clan"=>$id_clan,"estado"=>1]]);
		return $grupo;
	}

	function getGruposLaboratorioClanByClan($id_clan){
		global $db_siclan;
		$sql = "SELECT DISTINCT(SC.FK_grupo) AS 'PK_Grupo' FROM tb_terr_grupo_laboratorio_clan_sesion_clase AS SC WHERE SC.FK_clan=".$id_clan;
		return $db_siclan->query($sql)->fetchAll(\PDO::FETCH_ASSOC); 
	}		

	/***************************************************************************
	/* getMesAnioSesionClaseGrupoArteEscuela() consulta los meses en que un grupo de arte en la escuela ha tenido registradas sesiones de clase
	***************************************************************************/
	function getMesAnioSesionClaseGrupoArteEscuela($id_grupo){
		global $db_siclan;
		$mes_sesion_clase = $db_siclan->query("SELECT DISTINCT MONTH(DA_fecha_clase) AS MES, YEAR(DA_fecha_clase) AS ANIO FROM tb_terr_grupo_arte_escuela_sesion_clase WHERE FK_grupo = ".$id_grupo)->fetchAll();
		return $mes_sesion_clase;
	}

	/***************************************************************************
	/* getMesAnioSesionClaseGrupoEmprendeClan() consulta los meses en que un grupo de emprende clan ha tenido registradas sesiones de clase
	***************************************************************************/
	function getMesAnioSesionClaseGrupoEmprendeClan($id_grupo){
		global $db_siclan;
		$mes_sesion_clase = $db_siclan->query("SELECT DISTINCT MONTH(DA_fecha_clase) AS MES, YEAR(DA_fecha_clase) AS ANIO FROM tb_terr_grupo_emprende_clan_sesion_clase WHERE FK_grupo = ".$id_grupo)->fetchAll();
		return $mes_sesion_clase;
	}

	/***************************************************************************
	/* getMesAnioSesionClaseGrupoLaboratorioClan() consulta los meses en que un grupo de laboratorio clan ha tenido registradas sesiones de clase
	***************************************************************************/
	function getMesAnioSesionClaseGrupoLaboratorioClan($id_grupo){
		global $db_siclan;
		$mes_sesion_clase = $db_siclan->query("SELECT DISTINCT MONTH(DA_fecha_clase) AS MES, YEAR(DA_fecha_clase) AS ANIO FROM tb_terr_grupo_laboratorio_clan_sesion_clase WHERE FK_grupo = ".$id_grupo)->fetchAll();
		return $mes_sesion_clase;
	}

	/***************************************************************************
	/* getAllSesionClaseGrupoArteEscuela() consulta todas las sesiones de clase que ha tenido un grupo de arte en la escuela durante un mes especifico
	***************************************************************************/
	function getAllSesionClaseGrupoArteEscuela($id_grupo,$mes_anio,$id_usuario,$id_organizacion){
		global $db_siclan;
		if($id_usuario!=null){
			if($id_organizacion!=null)
				$sesion_clase = $db_siclan->select("tb_terr_grupo_arte_escuela_sesion_clase","*",["AND"=>["FK_grupo"=>$id_grupo,"DA_fecha_clase[~]"=>$mes_anio,"FK_usuario"=>$id_usuario,"FK_organizacion"=>$id_organizacion],"ORDER"=>["DA_fecha_clase"=>"ASC"]]);
			else
				$sesion_clase = $db_siclan->select("tb_terr_grupo_arte_escuela_sesion_clase","*",["AND"=>["FK_grupo"=>$id_grupo,"DA_fecha_clase[~]"=>$mes_anio,"FK_usuario"=>$id_usuario],"ORDER"=>["DA_fecha_clase"=>"ASC"]]);
		}
		else{
			if($id_organizacion!=null)
				$sesion_clase = $db_siclan->select("tb_terr_grupo_arte_escuela_sesion_clase","*",["AND"=>["FK_grupo"=>$id_grupo,"DA_fecha_clase[~]"=>$mes_anio,"FK_organizacion"=>$id_organizacion],"ORDER"=>["DA_fecha_clase"=>"ASC"]]);			
			else
				// $sesion_clase = $db_siclan->select("tb_terr_grupo_arte_escuela_sesion_clase","*",["AND"=>["FK_grupo"=>$id_grupo,"DA_fecha_clase[~]"=>$mes_anio],"ORDER"=>["DA_fecha_clase"=>"ASC"]]);
				$sesion_clase = $db_siclan->query("SELECT SC.*, CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido) AS 'FORMADOR' FROM tb_terr_grupo_arte_escuela_sesion_clase SC LEFT JOIN tb_persona_2017 P ON SC.FK_usuario=P.PK_Id_Persona WHERE SC.FK_Grupo=".$id_grupo." AND SC.DA_fecha_clase LIKE '%".$mes_anio."%' ORDER BY SC.DA_fecha_clase ASC")->fetchAll();
		}
		return $sesion_clase;
	}

	/***************************************************************************
	/* getAllSesionClaseGrupoEmprendeClan() consulta todas las sesiones de clase que ha tenido un grupo de emprende clan durante un mes especifico
	***************************************************************************/
	function getAllSesionClaseGrupoEmprendeClan($id_grupo,$mes_anio,$id_usuario){
		global $db_siclan;
		if($id_usuario!=null)
			$sesion_clase = $db_siclan->select("tb_terr_grupo_emprende_clan_sesion_clase","*",["AND"=>["FK_grupo"=>$id_grupo,"DA_fecha_clase[~]"=>$mes_anio,"FK_usuario"=>$id_usuario],"ORDER"=>["DA_fecha_clase"=>"ASC"]]);
		else
			//$sesion_clase = $db_siclan->select("tb_terr_grupo_emprende_clan_sesion_clase","*",["AND"=>["FK_grupo"=>$id_grupo,"DA_fecha_clase[~]"=>$mes_anio],"ORDER"=>["DA_fecha_clase"=>"ASC"]]);
			$sesion_clase = $db_siclan->query("SELECT SC.*, CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido) AS 'FORMADOR' FROM tb_terr_grupo_emprende_clan_sesion_clase SC LEFT JOIN tb_persona_2017 P ON SC.FK_usuario=P.PK_Id_Persona WHERE SC.FK_Grupo=".$id_grupo." AND SC.DA_fecha_clase LIKE '%".$mes_anio."%' ORDER BY SC.DA_fecha_clase ASC")->fetchAll();

		return $sesion_clase;
	}

	/***************************************************************************
	/* getAllSesionClaseGrupoLaboratorioClan() consulta todas las sesiones de clase que ha tenido un grupo de laboratorio clan durante un mes especifico
	***************************************************************************/
	function getAllSesionClaseGrupoLaboratorioClan($id_grupo,$mes_anio,$id_usuario){
		global $db_siclan;
		$where="";
		if($id_usuario!=null)
			$where=" AND SC.FK_usuario=".$id_usuario;
		$sql="SELECT 
		CONCAT(AF.VC_Primer_Nombre,' ',AF.VC_Segundo_Nombre,' ',AF.VC_Primer_Apellido,' ',AF.VC_Segundo_Apellido) AS 'af',
		PD.VC_Descripcion AS 'lugar_atencion',
		TG.VC_Descripcion AS 'nombre_tipo_grupo',
		SC.*		 
		FROM tb_terr_grupo_laboratorio_clan_sesion_clase AS SC 
		JOIN tb_persona_2017 AS AF on AF.PK_Id_Persona=SC.FK_usuario
		JOIN tb_parametro_detalle as PD ON PD.FK_Id_Parametro=39 AND PD.FK_Value=SC.IN_Tipo_Ubicacion
		JOIN tb_parametro_detalle as TG ON TG.FK_Id_Parametro=38 AND TG.FK_Value=SC.tipo_grupo				
		WHERE SC.FK_grupo = ".$id_grupo." AND SC.DA_fecha_clase LIKE '".$mes_anio."%'".$where." ORDER BY SC.DA_fecha_clase ASC ";
		return $db_siclan->query($sql)->fetchAll(\PDO::FETCH_ASSOC);  	
		/*if($id_usuario!=null)
		$sesion_clase = $db_siclan->select("tb_terr_grupo_laboratorio_clan_sesion_clase","*",["AND"=>["FK_grupo"=>$id_grupo,"DA_fecha_clase[~]"=>$mes_anio,"FK_usuario"=>$id_usuario],"ORDER"=>["DA_fecha_clase"=>"ASC"]]); 
		else
		$sesion_clase = $db_siclan->select("tb_terr_grupo_laboratorio_clan_sesion_clase","*",["AND"=>["FK_grupo"=>$id_grupo,"DA_fecha_clase[~]"=>$mes_anio],"ORDER"=>["DA_fecha_clase"=>"ASC"]]); 			
		return $sesion_clase;*/
	}

	/***************************************************************************
	/* getEstudiantesGrupoArteEscuela() consulta los estudiantes que se encuentran activos en un grupo especifico de arte enla escuela
	***************************************************************************/
	function getEstudiantesGrupoArteEscuela($id_grupo,$mes_anio){
		global $db_siclan;
		//Activos mas los que quedaron registrados en Sesión clase		
		$sql="SELECT
		E.IN_Identificacion,
		E.VC_Primer_Nombre,
		E.VC_Segundo_Nombre,
		E.VC_Primer_Apellido,
		E.VC_Segundo_Apellido,
		SCA.FK_estudiante,
		SC.FK_grupo
		FROM tb_terr_grupo_arte_escuela_sesion_clase_asistencia AS SCA
		JOIN tb_terr_grupo_arte_escuela_sesion_clase AS SC ON SC.`PK_sesion_clase`=SCA.`FK_sesion_clase`
		JOIN tb_estudiante AS E ON E.`id`=SCA.`FK_estudiante`
		WHERE SC.`FK_grupo`=".$id_grupo." AND SC.`DA_fecha_clase` LIKE '".$mes_anio."%' GROUP BY SCA.`FK_estudiante`
		UNION 
		SELECT
		E.IN_Identificacion,
		E.VC_Primer_Nombre,
		E.VC_Segundo_Nombre,
		E.VC_Primer_Apellido,
		E.VC_Segundo_Apellido,
		GAEE.FK_estudiante,
		GAEE.FK_grupo
		FROM tb_terr_grupo_arte_escuela_estudiante AS GAEE
		JOIN tb_estudiante AS E ON E.`id`=GAEE.`FK_estudiante`
		WHERE GAEE.`FK_grupo`=".$id_grupo." AND GAEE.`estado`=1";
		$estudiante = $db_siclan->query($sql)->fetchAll(\PDO::FETCH_ASSOC);  

		return $estudiante;
	}

	function getEstudiantesGrupoArteEscuelaHistorico($id_grupo,$mes_anio)
	{
		global $db_siclan;
		//Solo los que quedaron registrados en Sesión clase		
		$sql="SELECT
		E.IN_Identificacion,
		E.VC_Primer_Nombre,
		E.VC_Segundo_Nombre,
		E.VC_Primer_Apellido,
		E.VC_Segundo_Apellido,
		SCA.FK_estudiante,
		SC.FK_grupo
		-- ,tb_terr_grupo_arte_escuela_estudiante.DT_fecha_ingreso
		FROM tb_terr_grupo_arte_escuela_sesion_clase_asistencia AS SCA
		JOIN tb_terr_grupo_arte_escuela_sesion_clase AS SC ON SC.`PK_sesion_clase`=SCA.`FK_sesion_clase`
		JOIN tb_estudiante AS E ON E.`id`=SCA.`FK_estudiante`
		WHERE SC.`FK_grupo`=".$id_grupo." AND SC.`DA_fecha_clase` LIKE '".$mes_anio."%' GROUP BY SCA.`FK_estudiante`"; 
		$estudiante = $db_siclan->query($sql)->fetchAll(\PDO::FETCH_ASSOC);  

		return $estudiante;
	}

	function getEstadoAsistenciaEstudianteGrupoArteEscuela($id_estudiante,$id_sesion_clase){
		global $db_siclan;
		$estado_asistencia = $db_siclan->select("tb_terr_grupo_arte_escuela_sesion_clase_asistencia","IN_estado_asistencia",["AND"=>["FK_sesion_clase"=>$id_sesion_clase,"FK_estudiante"=>$id_estudiante]]);
		return $estado_asistencia;
	}

	function getEstadoAsistenciaEstudianteGrupoEmprendeClan($id_estudiante,$id_sesion_clase){
		global $db_siclan;
		$estado_asistencia = $db_siclan->select("tb_terr_grupo_emprende_clan_sesion_clase_asistencia","IN_estado_asistencia",["AND"=>["FK_sesion_clase"=>$id_sesion_clase,"FK_estudiante"=>$id_estudiante]]);
		return $estado_asistencia;
	}

	/***************************************************************************
	/* getEstadoAsistenciaEstudianteGrupoLaboratorioClan() retorna si un estudiante asistió o no a una sesion de clase especifica de un grupo de laboratorio clan
	***************************************************************************/
	function getEstadoAsistenciaEstudianteGrupoLaboratorioClan($id_estudiante,$id_sesion_clase){
		global $db_siclan;
		$estado_asistencia = $db_siclan->select("tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia","IN_estado_asistencia",["AND"=>["FK_sesion_clase"=>$id_sesion_clase,"FK_estudiante"=>$id_estudiante]]);
		return $estado_asistencia;
	}

	/***************************************************************************
	/* getEstudiantesGrupoEmprendeClan() consulta los estudiantes que se encuentran activos en un grupo especifico de emprende clan
	***************************************************************************/
	function getEstudiantesGrupoEmprendeClan($id_grupo,$mes_anio){
		global $db_siclan;


		$sql="SELECT
		E.IN_Identificacion,
		E.VC_Primer_Nombre,
		E.VC_Segundo_Nombre,
		E.VC_Primer_Apellido,
		E.VC_Segundo_Apellido,
		SCA.FK_estudiante,
		SC.FK_grupo
		-- ,tb_terr_grupo_arte_escuela_estudiante.DT_fecha_ingreso
		FROM tb_terr_grupo_emprende_clan_sesion_clase_asistencia AS SCA
		JOIN tb_terr_grupo_emprende_clan_sesion_clase AS SC ON SC.`PK_sesion_clase`=SCA.`FK_sesion_clase`
		JOIN tb_estudiante AS E ON E.`id`=SCA.`FK_estudiante`
		WHERE SC.`FK_grupo`=".$id_grupo." AND SC.`DA_fecha_clase` LIKE '".$mes_anio."%' GROUP BY SCA.`FK_estudiante`
		UNION 
		SELECT
		E.IN_Identificacion,
		E.VC_Primer_Nombre,
		E.VC_Segundo_Nombre,
		E.VC_Primer_Apellido,
		E.VC_Segundo_Apellido,
		GAEE.FK_estudiante,
		GAEE.FK_grupo
		FROM tb_terr_grupo_emprende_clan_estudiante AS GAEE
		JOIN tb_estudiante AS E ON E.`id`=GAEE.`FK_estudiante`
		WHERE GAEE.`FK_grupo`=".$id_grupo." AND GAEE.`estado`=1";
		$estudiante = $db_siclan->query($sql)->fetchAll(\PDO::FETCH_ASSOC); 

		return $estudiante;
	}

	function getEstudiantesGrupoEmprendeClanHistorico($id_grupo,$mes_anio){
		global $db_siclan;


		$sql="SELECT
		E.IN_Identificacion,
		E.VC_Primer_Nombre,
		E.VC_Segundo_Nombre,
		E.VC_Primer_Apellido,
		E.VC_Segundo_Apellido,
		SCA.FK_estudiante,
		SC.FK_grupo
		-- ,tb_terr_grupo_arte_escuela_estudiante.DT_fecha_ingreso
		FROM tb_terr_grupo_emprende_clan_sesion_clase_asistencia AS SCA
		JOIN tb_terr_grupo_emprende_clan_sesion_clase AS SC ON SC.`PK_sesion_clase`=SCA.`FK_sesion_clase`
		JOIN tb_estudiante AS E ON E.`id`=SCA.`FK_estudiante`
		WHERE SC.`FK_grupo`=".$id_grupo." AND SC.`DA_fecha_clase` LIKE '".$mes_anio."%' GROUP BY SCA.`FK_estudiante`";
		$estudiante = $db_siclan->query($sql)->fetchAll(\PDO::FETCH_ASSOC); 

		return $estudiante;
	}	

	/***************************************************************************
	/* getEstudiantesGrupoLaboratorioClan() consulta los estudiantes que se encuentran activos en un grupo especifico de laboratorio clan
	***************************************************************************/
	
	function getEstudiantesGrupoLaboratorioClan($id_grupo,$mes_anio){
		global $db_siclan;

		$sql="SELECT
		E.IN_Identificacion,
		E.VC_Primer_Nombre,
		E.VC_Segundo_Nombre,
		E.VC_Primer_Apellido,
		E.VC_Segundo_Apellido,
		SCA.FK_estudiante,
		SC.FK_grupo
		-- ,tb_terr_grupo_arte_escuela_estudiante.DT_fecha_ingreso
		FROM tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia AS SCA
		JOIN tb_terr_grupo_laboratorio_clan_sesion_clase AS SC ON SC.`PK_sesion_clase`=SCA.`FK_sesion_clase`
		JOIN tb_estudiante AS E ON E.`id`=SCA.`FK_estudiante`
		WHERE SC.`FK_grupo`=".$id_grupo." AND SC.`DA_fecha_clase` LIKE '".$mes_anio."%' GROUP BY SCA.`FK_estudiante`
		UNION 
		SELECT
		E.IN_Identificacion,
		E.VC_Primer_Nombre,
		E.VC_Segundo_Nombre,
		E.VC_Primer_Apellido,
		E.VC_Segundo_Apellido,
		GAEE.FK_estudiante,
		GAEE.FK_grupo
		FROM tb_terr_grupo_laboratorio_clan_estudiante AS GAEE
		JOIN tb_estudiante AS E ON E.`id`=GAEE.`FK_estudiante`
		WHERE GAEE.`FK_grupo`=".$id_grupo." AND GAEE.`estado`=1";
		$estudiante = $db_siclan->query($sql)->fetchAll(\PDO::FETCH_ASSOC); 

		return $estudiante;
	}

	function getEstudiantesGrupoLaboratorioClanHistorico($id_grupo,$mes_anio){ 
		global $db_siclan;

		$sql="SELECT
		E.IN_Identificacion,
		tpde.VC_Descripcion AS Tipo_Identificacion,
		E.VC_Primer_Nombre,
		E.VC_Segundo_Nombre,
		E.VC_Primer_Apellido,
		E.VC_Segundo_Apellido,
		tpdg.VC_Descripcion AS FK_Grupo_Poblacional,
		CASE WHEN EDA.TX_Tipo_Afiliacion IS NULL THEN 'N/R' WHEN EDA.TX_Tipo_Afiliacion = '' THEN 'N/R' ELSE EDA.TX_Tipo_Afiliacion END AS TX_Tipo_Afiliacion,
		COALESCE(EDA.sisben,'N/R') AS sisben,
		COALESCE(E.VC_Telefono,'N/R') AS VC_Telefono,
		COALESCE(E.VC_Correo,'N/R') AS VC_Correo,
		E.DD_F_Nacimiento,
		CASE WHEN E.CH_Genero = 'F' THEN 'FEMENINO'
		WHEN E.CH_Genero = 'M' THEN 'MASCULINO' END AS CH_Genero,
		SCA.FK_estudiante,
		SC.FK_grupo
		FROM tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia AS SCA
		JOIN tb_terr_grupo_laboratorio_clan_sesion_clase AS SC ON SC.`PK_sesion_clase`=SCA.`FK_sesion_clase`
		JOIN tb_estudiante AS E ON E.`id`=SCA.`FK_estudiante`
		JOIN tb_estudiante_detalle_anio AS EDA ON E.`id`=EDA.`FK_estudiante`
		JOIN tb_parametro_detalle AS tpde ON E.CH_Tipo_Identificacion = tpde.FK_Value AND tpde.FK_Id_Parametro = 5
		LEFT JOIN tb_parametro_detalle AS tpdg ON EDA.FK_Grupo_Poblacional = tpdg.FK_Value AND tpdg.FK_Id_Parametro = 14
		WHERE SC.`FK_grupo`=".$id_grupo." AND SC.`DA_fecha_clase` LIKE '".$mes_anio."%' GROUP BY SCA.`FK_estudiante`";
		$estudiante = $db_siclan->query($sql)->fetchAll(\PDO::FETCH_ASSOC); 

		return $estudiante;
	}

	/***************************************************************************
	/* getColegios() selecciona los colegios que existen en el sistema.
	***************************************************************************/
	function getColegios(){
		global $db_siclan;
		$colegio = $db_siclan->query("SELECT DISTINCT(C.PK_Id_Colegio),C.VC_Nom_Colegio 
			FROM tb_clan_colegio CC
			LEFT JOIN tb_colegios C ON CC.FK_Id_Colegio = C.PK_Id_Colegio")->fetchAll();
		return $colegio;
	}

	/***************************************************************************
	/* getMesSesionesClaseColegio() selecciona los meses que se han registrado sesiones de clase para estudiantes pertenecientes a un colegio.
	***************************************************************************/
	function getMesSesionesClaseColegio($id_colegio){
		global $db_siclan;
		$mes_anio = $db_siclan->query("SELECT DISTINCT(MONTH(S.DA_fecha_clase)) AS mes, YEAR(S.DA_fecha_clase) AS anio
			FROM tb_terr_grupo_arte_escuela_sesion_clase S WHERE S.FK_Colegio = ".$id_colegio)->fetchAll();
		//$mes_anio = array(['mes' => '02','anio' => '2017'], ['mes' => '03','anio' => '2017'],['mes' => '04','anio' => '2017'],['mes' => '05','anio' => '2017'],,['mes' => '06','anio' => '2017']);
		return $mes_anio;
	}

	function getFechaSesionesClaseGruposDeColegio($id_colegio,$mes_anio,$mes_anioh){
		global $db_siclan;
		$explode = explode("-",$mes_anio);
		$explodeh = explode("-",$mes_anioh);
		$fecha = $db_siclan->query("SELECT CONCAT(MONTH(SC.DA_fecha_clase),'-',DAY(SC.DA_fecha_clase)) AS DIA
			FROM tb_terr_grupo_arte_escuela_sesion_clase SC 
			WHERE SC.FK_colegio = ".$id_colegio." AND YEAR(SC.`DA_fecha_clase`)=".$explode[0]." AND MONTH(SC.`DA_fecha_clase`) >='".$explode[1]."' AND MONTH(SC.`DA_fecha_clase`) <=  '".$explodeh[1]."' GROUP BY SC.DA_fecha_clase ORDER BY SC.DA_fecha_clase")->fetchAll();
		return $fecha;
	}

	function getEstudiantesSesionesClaseGruposDeColegio($id_colegio,$mes_anio,$mes_anioh){
		global $db_siclan;
		$explode = explode("-",$mes_anio);
		$explodeh = explode("-",$mes_anioh);
		$estudiante = $db_siclan->query("SELECT DISTINCT ES.id,ES.IN_Identificacion,CONCAT(ES.VC_Primer_Apellido,' ',ES.VC_Segundo_Apellido,' ',ES.VC_Primer_Nombre,' ',
			ES.VC_Segundo_Nombre) AS nombre_estudiante,
			(CASE 
			WHEN M.GRADO = -2 THEN 'Pre-Jardín'
			WHEN M.GRADO = -1 THEN 'Jardín I o A o Kínder'
			WHEN M.GRADO = 0  THEN 'Jardín II o B, Transición o Grado 0' 
			WHEN M.GRADO = 1  THEN 'Primero'
			WHEN M.GRADO = 2  THEN 'Segundo'
			WHEN M.GRADO = 3  THEN 'Tercero'
			WHEN M.GRADO = 4  THEN 'Cuarto'
			WHEN M.GRADO = 5  THEN 'Quinto'
			WHEN M.GRADO = 6  THEN 'Sexto'
			WHEN M.GRADO = 7  THEN 'Séptimo'
			WHEN M.GRADO = 8  THEN 'Octavo'
			WHEN M.GRADO = 9  THEN 'Noveno'
			WHEN M.GRADO = 10 THEN 'Décimo'
			WHEN M.GRADO = 11 THEN 'Once'
			WHEN M.GRADO = 12 THEN 'Doce - Normal Superior'
			WHEN M.GRADO = 13 THEN 'Trece - Normal Superior'
			WHEN M.GRADO = 21 THEN 'Ciclo 1 Adultos'
			WHEN M.GRADO = 22 THEN 'Ciclo 2 Adultos'
			WHEN M.GRADO = 23 THEN 'Ciclo 3 Adultos'
			WHEN M.GRADO = 24 THEN 'Ciclo 4 Adultos'
			WHEN M.GRADO = 25 THEN 'Ciclo 5 Adultos'
			WHEN M.GRADO = 26 THEN 'Ciclo 6 Adultos'
			WHEN M.GRADO = 99 THEN 'Aceleración del Aprendizaje'
			ELSE ''  
			END) AS 'VC_Descripcion_Grado',O.VC_Nom_Organizacion,SC.FK_grupo,
			CONCAT(P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido,' ',P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre) AS nombre_artista,
			CL.VC_Nom_Clan,AA.VC_Nom_Area,SC.IN_lugar_atencion
			FROM tb_terr_grupo_arte_escuela_sesion_clase_asistencia S
			JOIN tb_terr_grupo_arte_escuela_sesion_clase SC ON S.FK_sesion_clase = SC.PK_sesion_clase
			JOIN tb_estudiante ES ON S.FK_estudiante = ES.id
			LEFT JOIN v_matricula_2017 AS M ON M.NRO_DOCUMENTO=ES.IN_Identificacion
			JOIN tb_organizaciones_2017 O ON SC.FK_organizacion = O.PK_Id_Organizacion
			JOIN tb_persona_2017 P ON SC.FK_usuario= P.PK_Id_Persona
			JOIN tb_clan CL ON SC.FK_clan = CL.PK_Id_Clan
			JOIN tb_areas_artisticas AA ON SC.FK_area_artistica = AA.PK_Area_Artistica
			WHERE SC.FK_colegio = ".$id_colegio." AND YEAR(SC.DA_fecha_clase)=".$explode[0]." AND MONTH(SC.DA_fecha_clase) >=".$explode[1]." AND MONTH(SC.DA_fecha_clase) <=  ".$explodeh[1]."
			ORDER BY SC.FK_grupo")->fetchAll(); 
		return $estudiante;
	}

	function consultarEstadoAsistenciaSesionClase($id_estudiante,$fecha_clase){
		global $db_siclan;
		//echo $id_estudiante." ".$fecha_clase."<br>";
		$estado_asistencia = $db_siclan->select("tb_terr_grupo_arte_escuela_sesion_clase_asistencia",[
			"[>]tb_terr_grupo_arte_escuela_sesion_clase" => ["FK_sesion_clase" => "PK_sesion_clase"]
		],
		["tb_terr_grupo_arte_escuela_sesion_clase_asistencia.IN_estado_asistencia"],[
			"AND"=>[
				"FK_estudiante" => $id_estudiante,
				"DA_fecha_clase" => $fecha_clase
			]
		]);
		return $estado_asistencia;
	}

	function getClanesColegiosSesionClase($id_colegio){
		global $db_siclan;
		$clan = $db_siclan->query("SELECT DISTINCT FK_Clan,VC_Nom_Clan FROM tb_terr_grupo_arte_escuela_sesion_clase WHERE FK_Colegio = ".$id_colegio)->fetchAll();
		return $clan;
	}

	function getAtendidosMesColegio($id_colegio,$mes_anio,$mes_anioh){
		global $db_siclan;
		$explode = explode("-",$mes_anio);
		$explodeh = explode("-",$mes_anioh);
		$datos = $db_siclan->query("SELECT COUNT(DISTINCT(SCA.FK_estudiante)) AS 'datos'
			FROM tb_terr_grupo_arte_escuela_sesion_clase_asistencia SCA
			JOIN tb_terr_grupo_arte_escuela_sesion_clase SC ON SC.`PK_sesion_clase`=SCA.`FK_sesion_clase`
			JOIN tb_terr_grupo_arte_escuela GAE ON GAE.`PK_Grupo`=SC.`FK_grupo`
			WHERE GAE.`FK_colegio`='".$id_colegio."' AND SCA.`IN_estado_asistencia`=1 AND YEAR(SC.`DA_fecha_clase`)=".$explode[0]." AND MONTH(SC.`DA_fecha_clase`) >='".$explode[1]."' AND MONTH(SC.`DA_fecha_clase`) <=  '".$explodeh[1]."'  UNION ALL SELECT COUNT(DISTINCT(GAEE.FK_estudiante)) AS 'datos'
			FROM tb_terr_grupo_arte_escuela GAE
			JOIN tb_terr_grupo_arte_escuela_estudiante GAEE ON GAEE.`FK_grupo`=GAE.`PK_Grupo`
			WHERE GAE.`FK_colegio`='".$id_colegio."' AND MONTH(GAEE.`DT_fecha_ingreso`) >= '".$explode[1]."' 
			AND MONTH(GAEE.`DT_fecha_ingreso`) <= '".$explodeh[1]."' ;")->fetchAll();
		return $datos; 
	} 

	/***************************************************************************
	/* getAtencionClanes() Consulta el número de estudiantes que ha atendido Arte en la Escuela en cada CLAN.
	***************************************************************************/
	function getAtencionClanes(){
		global $db_siclan;
		$atenciones_clan = $db_siclan->query(
			"SELECT 
			C.`VC_Nom_Clan`,
			COUNT(DISTINCT(SCAAE.`FK_estudiante`)) AS 'estudiantes',
			CONCAT('#',SUBSTRING((LPAD(HEX(ROUND(RAND() * 10000000)), 6, 0)),- 6)) AS 'color' 
			FROM tb_terr_grupo_arte_escuela_sesion_clase_asistencia SCAAE 
			JOIN tb_terr_grupo_arte_escuela_sesion_clase GAESC ON GAESC.`PK_sesion_clase` = SCAAE.`FK_sesion_clase` 
			JOIN tb_clan C ON GAESC.`FK_clan` = C.`PK_Id_Clan`
			WHERE SCAAE.`IN_estado_asistencia` = 1 GROUP BY GAESC.`FK_clan` ORDER BY COUNT(DISTINCT (SCAAE.`FK_estudiante`)) DESC ;"
		)->fetchAll();
		return $atenciones_clan;
	}
	/***************************************************************************
	/* getAtencionLineas() Consulta el número de estudiantes que se han atendido en cada linea de atención.
	***************************************************************************/
	function getAtencionLineas(){
		global $db_siclan;
		$atenciones_mes = $db_siclan->query(
			"SELECT 
			MES,
			VALORMES,
			SUM(estudiantes) AS 'ATENCIONES_MES',
			(SELECT
			COUNT(DISTINCT(SCAGAE.`FK_estudiante`))
			FROM `tb_terr_grupo_arte_escuela_sesion_clase_asistencia` SCAGAE
			JOIN `tb_terr_grupo_arte_escuela_sesion_clase` SCGAE ON SCAGAE.`FK_sesion_clase`=SCGAE.`PK_sesion_clase`
			WHERE MONTH(SCGAE.`DA_fecha_clase`)<=VALORMES AND SCAGAE.`IN_estado_asistencia`=1 AND MONTH(SCGAE.`DA_fecha_clase`)>1
			)+(SELECT
			COUNT(DISTINCT(SCAGEC.`FK_estudiante`))
			FROM `tb_terr_grupo_emprende_clan_sesion_clase_asistencia` SCAGEC
			JOIN `tb_terr_grupo_emprende_clan_sesion_clase` SCGEC ON SCAGEC.`FK_sesion_clase`=SCGEC.`PK_sesion_clase`
			WHERE MONTH(SCGEC.`DA_fecha_clase`)<=VALORMES AND SCAGEC.`IN_estado_asistencia`=1 AND MONTH(SCGEC.`DA_fecha_clase`)>1
			) AS 'CONSOLIDADO',
			CONCAT('#',SUBSTRING((LPAD(HEX(ROUND(RAND() * 10000000)),6,0)),-6)) AS 'color'
			FROM
			(
			SELECT 
			CASE MONTH(GAESC.`DA_fecha_clase`)
			WHEN '01' THEN 'ENERO'
			WHEN '02' THEN 'FEBRERO'
			WHEN '03' THEN 'MARZO'
			WHEN '04' THEN 'ABRIL'
			WHEN '05' THEN 'MAYO'
			WHEN '06' THEN 'JUNIO'
			WHEN '07' THEN 'JULIO'
			WHEN '08' THEN 'AGOSTO'
			WHEN '09' THEN 'SEPTIEMBRE'
			WHEN '10' THEN 'OCTUBRE'
			WHEN '11' THEN 'NOVIEMBRE'
			WHEN '12' THEN 'DICIEMBRE'
			END AS 'MES',
			MONTH(GAESC.`DA_fecha_clase`) AS 'VALORMES',
			COUNT(DISTINCT(SCAAE.`FK_estudiante`)) AS 'estudiantes',
			'AE'
			FROM tb_terr_grupo_arte_escuela_sesion_clase_asistencia SCAAE 
			JOIN tb_terr_grupo_arte_escuela_sesion_clase GAESC ON GAESC.`PK_sesion_clase`=SCAAE.`FK_sesion_clase`
			WHERE SCAAE.`IN_estado_asistencia`=1 AND MONTH(GAESC.`DA_fecha_clase`)>1 GROUP BY MONTH(GAESC.`DA_fecha_clase`)
			UNION
			SELECT
			CASE MONTH(GECSC.`DA_fecha_clase`)
			WHEN '01' THEN 'ENERO'
			WHEN '02' THEN 'FEBRERO'
			WHEN '03' THEN 'MARZO'
			WHEN '04' THEN 'ABRIL'
			WHEN '05' THEN 'MAYO'
			WHEN '06' THEN 'JUNIO'
			WHEN '07' THEN 'JULIO'
			WHEN '08' THEN 'AGOSTO'
			WHEN '09' THEN 'SEPTIEMBRE'
			WHEN '10' THEN 'OCTUBRE'
			WHEN '11' THEN 'NOVIEMBRE'
			WHEN '12' THEN 'DICIEMBRE'
			END AS 'MES',
			MONTH(GECSC.`DA_fecha_clase`) AS 'VALORMES',
			COUNT(DISTINCT(SCAEC.`FK_estudiante`)) AS 'estudiantes',
			'EC'
			FROM tb_terr_grupo_emprende_clan_sesion_clase_asistencia SCAEC 
			JOIN tb_terr_grupo_emprende_clan_sesion_clase GECSC ON GECSC.`PK_sesion_clase`=SCAEC.`FK_sesion_clase`
			WHERE SCAEC.`IN_estado_asistencia`=1 AND MONTH(GECSC.`DA_fecha_clase`)>1 GROUP BY MONTH(GECSC.`DA_fecha_clase`)
		) AS tunion GROUP BY MES ORDER BY VALORMES;"
	)->fetchAll();
		return $atenciones_mes;
	}
	/***************************************************************************
	/* getEstadisticaGenero() Consulta el número de estudiantes hombres y mujeres que atiende CLAN.
	***************************************************************************/
	function getEstadisticaGenero($anio){
		global $db_siclan;
		$estadistica_genero = $db_siclan->query(
			"SELECT
			E.`CH_Genero` AS 'genero', COUNT(DISTINCT(E.id)) AS 'estudiantes' 
			FROM tb_estudiante E 
			JOIN tb_terr_grupo_arte_escuela_sesion_clase_asistencia GAESC ON GAESC.`FK_estudiante`=E.id
			WHERE GAESC.`IN_estado_asistencia`=1 AND YEAR(E.DA_Fecha_Registro)='".$anio."'
			GROUP BY E.`CH_Genero`;"
		)->fetchAll();
		return $estadistica_genero;
	}
	/***************************************************************************
	/* getCantidadMatriculados() Consulta el número de estudiantes que han sido matriculados.
	***************************************************************************/
	function getCantidadMatriculados($anio){
		global $db_siclan;
		$cantidad_matriculados = $db_siclan->query(
			"SELECT
			COUNT(DISTINCT(E.id)) AS 'estudiantes' 
			FROM tb_estudiante E WHERE YEAR(E.DA_Fecha_Registro)='".$anio."';"
		)->fetchAll();
		return $cantidad_matriculados;
	}
	/***************************************************************************
	/* getCantidadAtendidos() Consulta el número de estudiantes que han sido atendidos al menos una vez.
	***************************************************************************/
	function getCantidadAtendidos(){
		global $db_siclan;
		$cantidad_atendidos = $db_siclan->query(
			"SELECT
			COUNT(DISTINCT(SCAAE.FK_estudiante)) AS 'estudiantes' 
			FROM tb_terr_grupo_arte_escuela_sesion_clase_asistencia SCAAE
			WHERE SCAAE.IN_estado_asistencia=1;"
		)->fetchAll();
		return $cantidad_atendidos;
	}
	
	/***************************************************************************
	/* getNumeroGruposActivos() Consulta el número de grupos activos en el año especificado.
	***************************************************************************/
	function getNumeroGruposActivos($anio){
		global $db_siclan;
		$numeroGruposActivos = $db_siclan->query(
			"SELECT 
			SUM(GRUPOS) AS 'GRUPOS'
			FROM
			(
			SELECT 
			COUNT(GAE.`PK_Grupo`) AS 'GRUPOS'
			FROM `tb_terr_grupo_arte_escuela` GAE 
			WHERE GAE.`estado`=1 AND YEAR(GAE.`DT_fecha_creacion`)='".$anio."'
			UNION
			SELECT 
			COUNT(GEC.`PK_Grupo`) AS 'GRUPOS'
			FROM `tb_terr_grupo_emprende_clan` GEC 
			WHERE GEC.`estado`=1 AND YEAR(GEC.`DT_fecha_creacion`)='".$anio."'
		) AS TUNION;"
	)->fetchAll();
		return $numeroGruposActivos;
	}

	/***************************************************************************
	/* getNumeroGruposInactivos() Consulta el número de grupos inactivos en el año especificado.
	***************************************************************************/
	function getNumeroGruposInactivos($anio){
		global $db_siclan;
		$numeroGruposInactivos = $db_siclan->query(
			"SELECT 
			SUM(GRUPOS) AS 'GRUPOS'
			FROM
			(
			SELECT 
			COUNT(GAE.`PK_Grupo`) AS 'GRUPOS'
			FROM `tb_terr_grupo_arte_escuela` GAE 
			WHERE GAE.`estado`=0 AND YEAR(GAE.`DT_fecha_creacion`)='".$anio."'
			UNION
			SELECT 
			COUNT(GEC.`PK_Grupo`) AS 'GRUPOS'
			FROM `tb_terr_grupo_emprende_clan` GEC 
			WHERE GEC.`estado`=0 AND YEAR(GEC.`DT_fecha_creacion`)='".$anio."'
		) AS TUNION;"
	)->fetchAll();
		return $numeroGruposInactivos;
	}

	/***************************************************************************
	/* getGruposActivosArteEnLaEscuelaPorClan() consulta los grupos de la base de datos que estan activos en la linea de atención arte en la escuela según un clan.
	***************************************************************************/
	function getGruposActivosArteEnLaEscuelaPorClan($id_clan){
		global $db_siclan;
		$grupo = $db_siclan->select("tb_terr_grupo_arte_escuela",
			[
				"[>]tb_colegios"=>["FK_colegio"=>"PK_Id_Colegio"],
				"[>]tb_areas_artisticas"=>["FK_area_artistica"=>"PK_Area_Artistica"],
				"[>]tb_persona_2017"=>["FK_artista_formador"=>"PK_Id_Persona"],
				"[>]tb_organizaciones_2017"=>["FK_organizacion"=>"PK_Id_Organizacion"]
			],
			[
				"tb_terr_grupo_arte_escuela.PK_Grupo",
				"tb_areas_artisticas.VC_Nom_Area",
				"tb_organizaciones_2017.VC_Nom_Organizacion",
				"tb_terr_grupo_arte_escuela.FK_artista_formador",
				"tb_colegios.VC_Nom_Colegio",
				"tb_persona_2017.VC_Primer_Nombre",
				"tb_persona_2017.VC_Segundo_Nombre",
				"tb_persona_2017.VC_Primer_Apellido",
				"tb_persona_2017.VC_Segundo_Apellido"
			],

			["AND"=>["FK_clan"=>$id_clan,"estado"=>1]]);
		return $grupo;
	}

	/***************************************************************************
	/* getGruposActivosEmprendeClanPorClan() consulta los grupos de la base de datos que estan activos en la linea de atención emprende clan, según un clan.
	***************************************************************************/
	function getGruposActivosEmprendeClanPorClan($id_clan){
		global $db_siclan;
		$grupo = $db_siclan->select("tb_terr_grupo_emprende_clan",
			[
				"[>]tb_modalidad"=>["FK_modalidad"=>"PK_Id_Modalidad"],
				"[>]tb_areas_artisticas"=>["FK_area_artistica"=>"PK_Area_Artistica"],
				"[>]tb_persona_2017"=>["FK_artista_formador"=>"PK_Id_Persona"],
				"[>]tb_organizaciones_2017"=>["FK_organizacion"=>"PK_Id_Organizacion"]
			],
			[
				"tb_terr_grupo_emprende_clan.PK_Grupo",
				"tb_areas_artisticas.VC_Nom_Area",
				"tb_organizaciones_2017.VC_Nom_Organizacion",
				"tb_terr_grupo_emprende_clan.FK_artista_formador",
				"tb_persona_2017.VC_Primer_Nombre",
				"tb_persona_2017.VC_Segundo_Nombre",
				"tb_persona_2017.VC_Primer_Apellido",
				"tb_persona_2017.VC_Segundo_Apellido",
				"tb_modalidad.VC_Nom_Modalidad"
			],
			["AND"=>["FK_clan"=>$id_clan,"estado"=>1]]);
		return $grupo;
	}

	function getMesNovdadesGrupoArteEscuela($id_grupo){
		global $db_siclan;
		return $db_siclan->query("SELECT DISTINCT YEAR(DA_fecha_sesion_clase) AS ANIO,MONTH(DA_fecha_sesion_clase) AS MES
			FROM tb_terr_grupo_arte_escuela_sesion_clase_novedad
			WHERE FK_Grupo =".$id_grupo)->fetchAll();
	}

	function getMesNovdadesGrupoEmprendeClan($id_grupo){
		global $db_siclan;
		return $db_siclan->query("SELECT DISTINCT YEAR(DA_fecha_sesion_clase) AS ANIO,MONTH(DA_fecha_sesion_clase) AS MES
			FROM tb_terr_grupo_emprende_clan_sesion_clase_novedad
			WHERE FK_Grupo =".$id_grupo)->fetchAll();
	}

	function getNovdadesGrupoArteEscuela($id_grupo,$mes_anio){
		global $db_siclan;
		return $db_siclan->query("SELECT N.DA_fecha_sesion_clase,
			CONCAT(PAF.VC_Primer_Apellido,' ',PAF.VC_Segundo_Apellido,' ',PAF.VC_Primer_Nombre,' ',PAF.VC_Segundo_Nombre) AS ARTISTA,
			CONCAT(PUR.VC_Primer_Apellido,' ',PUR.VC_Segundo_Apellido,' ',PUR.VC_Primer_Nombre,' ',PUR.VC_Segundo_Nombre) AS USUARIO_REGISTRO,
			N.IN_asistencia,N.IN_novedad,N.TX_observacion,N.DT_fecha_registro
			FROM tb_terr_grupo_arte_escuela_sesion_clase_novedad N
			JOIN tb_persona_2017 PAF ON N.FK_artista_formador = PAF.PK_Id_Persona
			JOIN tb_persona_2017 PUR ON N.FK_usuario_registro = PUR.PK_Id_Persona
			WHERE N.FK_grupo =".$id_grupo." AND DA_fecha_sesion_clase LIKE '".$mes_anio."%'")->fetchAll(PDO::FETCH_ASSOC);
	}

	function getNovdadesGrupoEmprendeClan($id_grupo,$mes_anio){
		global $db_siclan;
		return $db_siclan->query("SELECT N.DA_fecha_sesion_clase,
			CONCAT(PAF.VC_Primer_Apellido,' ',PAF.VC_Segundo_Apellido,' ',PAF.VC_Primer_Nombre,' ',PAF.VC_Segundo_Nombre) AS ARTISTA,
			CONCAT(PUR.VC_Primer_Apellido,' ',PUR.VC_Segundo_Apellido,' ',PUR.VC_Primer_Nombre,' ',PUR.VC_Segundo_Nombre) AS USUARIO_REGISTRO,
			N.IN_asistencia,N.IN_novedad,N.TX_observacion,N.DT_fecha_registro
			FROM tb_terr_grupo_emprende_clan_sesion_clase_novedad N
			JOIN tb_persona_2017 PAF ON N.FK_artista_formador = PAF.PK_Id_Persona
			JOIN tb_persona_2017 PUR ON N.FK_usuario_registro = PUR.PK_Id_Persona
			WHERE N.FK_grupo =".$id_grupo." AND DA_fecha_sesion_clase LIKE '".$mes_anio."%'")->fetchAll(PDO::FETCH_ASSOC);
	}
	?>