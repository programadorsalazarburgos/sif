<?php

namespace General\Persistencia\DAOS; 


class ConsultasReportesDAO extends GestionDAO {

	private $db;
	private $dbPDO;
	
	function __construct()
	{        
		$this->db=$this->obtenerBD();
		$this->dbPDO=$this->obtenerPDOBD();
		//echo "<pre>".print_r($this->db,true)."</pre>";
	}
	
	public function crearObjeto($objeto) {
		//Nothing to do.
	}

	public function modificarObjeto($update) {
		//Nothing to do.
	}

	public function eliminarObjeto($objeto) {
		//Nothing to do.
	}

	public function consultarObjeto($localidad) {            
		//Nothing to do.
	}

	public function getAsistenciasMesAE($listaClanes,$anio)
	{ 
		//$sql="CALL sp_atendidos_mes_ae('".$listaClanes."',".$anio.")";
		//return $this->db->query($sql)->fetchAll(\PDO::FETCH_ASSOC); 

		$sql="CALL sp_atendidos_mes_ae(:listaClanes,:anio)";    
		@$sentencia=$this->dbPDO->prepare($sql); 
		@$sentencia->bindParam(':listaClanes',$listaClanes);
		@$sentencia->bindParam(':anio',$anio);  
		$sentencia->execute(); 
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);              

	} 

	public function getAsistenciasMesEC($listaClanes,$anio)
	{
		//$sql="CALL sp_atendidos_mes_ec('".$listaClanes."',".$anio.")";
		//return $this->db->query($sql)->fetchAll(\PDO::FETCH_ASSOC); 
		$sql="CALL sp_atendidos_mes_ec(:listaClanes,:anio)";  
		@$sentencia=$this->dbPDO->prepare($sql); 
		@$sentencia->bindParam(':listaClanes',$listaClanes);
		@$sentencia->bindParam(':anio',$anio);  
		$sentencia->execute(); 
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);           
	}

	public function getAsistenciasMesLC($listaClanes,$anio)
	{
		//$sql="CALL sp_atendidos_mes_lc('".$listaClanes."',".$anio.")";
		//return $this->db->query($sql)->fetchAll(\PDO::FETCH_ASSOC); 
		$sql="CALL sp_atendidos_mes_lc(:listaClanes,:anio)";  
		@$sentencia=$this->dbPDO->prepare($sql); 
		@$sentencia->bindParam(':listaClanes',$listaClanes);
		@$sentencia->bindParam(':anio',$anio);  
		$sentencia->execute(); 
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);             
	}         

	public function getNovedadesAFAE($listaClanes,$anio,$mes)
	{
		//$sql="CALL sp_novedades_af_ae('".$listaClanes."')";
		//return $this->db->query($sql)->fetchAll(\PDO::FETCH_ASSOC); 

		$sql="CALL sp_novedades_af_ae(:listaClanes,:anio,:mes)";  
		@$sentencia=$this->dbPDO->prepare($sql); 
		@$sentencia->bindParam(':listaClanes',$listaClanes); 
		@$sentencia->bindParam(':anio',$anio);     
		@$sentencia->bindParam(':mes',$mes);         
		$sentencia->execute(); 
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);           
	} 

	public function getNovedadesAFEC($listaClanes,$anio,$mes)
	{
		//$sql="CALL sp_novedades_af_ec('".$listaClanes."')";
		//return $this->db->query($sql)->fetchAll(\PDO::FETCH_ASSOC); 
		$sql="CALL sp_novedades_af_ec(:listaClanes,:anio,:mes)";  
		@$sentencia=$this->dbPDO->prepare($sql); 
		@$sentencia->bindParam(':listaClanes',$listaClanes); 
		@$sentencia->bindParam(':anio',$anio);     
		@$sentencia->bindParam(':mes',$mes);            
		$sentencia->execute();  
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);           
	}

	public function getNovedadesAFLC($listaClanes,$anio,$mes)
	{
		//$sql="CALL sp_novedades_af_lc('".$listaClanes."')";
		//return $this->db->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
		$sql="CALL sp_novedades_af_lc(:listaClanes,:anio,:mes)";  
		@$sentencia=$this->dbPDO->prepare($sql); 
		@$sentencia->bindParam(':listaClanes',$listaClanes); 
		@$sentencia->bindParam(':anio',$anio);      
		@$sentencia->bindParam(':mes',$mes);                 
		$sentencia->execute();  
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);            
	}                 

	public function getHorasArtistaMes($organizaciones,$anio) 
	{
		// $datos="'".$organizaciones."'";  
		$datos=$organizaciones; 
		//$sql="CALL sp_horas_mes_af('".$organizaciones."')";
		//return $this->db->query($sql)->fetchAll(\PDO::FETCH_ASSOC); 
		$sql="CALL sp_horas_mes_af(:organizaciones,:anio)";  
		@$sentencia=$this->dbPDO->prepare($sql); 
		@$sentencia->bindParam(':organizaciones',$datos);
		@$sentencia->bindParam(':anio',$anio);  
		$sentencia->execute();          
		//$sentencia->debugDumpParams();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);                   
	}

	function getMesSesionesClaseColegio($id_colegio,$anio,$id_clan){
		$sql="SELECT DISTINCT(MONTH(S.DA_fecha_clase)) AS mes
				FROM tb_terr_grupo_arte_escuela_sesion_clase S
				 WHERE FIND_IN_SET(S.FK_Colegio, :id_colegio) 
				 AND YEAR(S.DA_fecha_clase)=:anio 
				 AND FIND_IN_SET(S.FK_Clan, :id_clan) "; 

		@$sentencia = $this->dbPDO->prepare($sql);
		@$sentencia->bindParam(':id_colegio',$id_colegio);
		@$sentencia->bindParam(':anio',$anio);
		@$sentencia->bindParam(':id_clan',$id_clan);
		$sentencia->execute();          
		//$sentencia->debugDumpParams();  
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);    
	}

	public function getConsultaColegioMes($id_colegio,$mesd,$mesh,$anio,$crea) 
	{
		$sql="CALL sp_consulta_colegio_mes(:id_colegio,:mesd,:mesh,:anio,:crea)";  
		@$sentencia=$this->dbPDO->prepare($sql); 
		@$sentencia->bindParam(':id_colegio',$id_colegio);
		@$sentencia->bindParam(':mesd',$mesd);  
		@$sentencia->bindParam(':mesh',$mesh);  
		@$sentencia->bindParam(':anio',$anio);  
		@$sentencia->bindParam(':crea',$crea);       
		$sentencia->execute();          
		//$sentencia->debugDumpParams();
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);                   
	} 

	public function consultarTotalMesPorArea($datos)
	{ 
		$select="";
		$subSelect="";
		$join="";
		$where="";
		$subWhere="";
		$tipo_grupo=$datos['tipo_grupo'];
		if($tipo_grupo=='arte_escuela' && $datos['colegio']!=""){
			$select="T.colegio, ";
			$subSelect=",GROUP_CONCAT(DISTINCT(COL.VC_Nom_Colegio)) as colegio ";
			$subWhere="AND FIND_IN_SET(SC1.FK_colegio,:colegio) ";
			$join="JOIN tb_colegios as COL on COL.PK_Id_colegio=SC.FK_colegio ";
			$where="AND FIND_IN_SET(SC.FK_colegio,:colegio) ";
		}

		$sql="SELECT 
		".$select."
		T.Area,
		T.atendidos,
		T.total,
		ROUND((T.atendidos/T.total)*100,2) as promedio
		FROM (
		SELECT 
		COUNT(DISTINCT(SCA.FK_estudiante)) AS 'total', 
		(SELECT 
		COUNT(DISTINCT(SCA.FK_estudiante)) 
		FROM tb_terr_grupo_".$tipo_grupo."_sesion_clase_asistencia SCA
		JOIN tb_terr_grupo_".$tipo_grupo."_sesion_clase SC1 ON SC1.PK_sesion_clase=SCA.FK_sesion_clase
		JOIN tb_parametro_detalle AS PD ON PD.fk_id_parametro=6 AND PD.fk_value=SC1.FK_area_artistica
		WHERE SC1.FK_area_artistica=  SC.FK_area_artistica AND FIND_IN_SET(SC1.FK_clan,:clan)  ".$subWhere."
		AND YEAR(SC1.DA_fecha_clase)=:anio AND MONTH(SC1.DA_fecha_clase) >=:mesd AND MONTH(SC1.DA_fecha_clase) <= :mesh and  SCA.IN_estado_asistencia=1
		) as atendidos,
		PD.VC_Descripcion AS 'Area',
		'A' as tipo
		".$subSelect."
		FROM tb_terr_grupo_".$tipo_grupo."_sesion_clase_asistencia SCA
		JOIN tb_terr_grupo_".$tipo_grupo."_sesion_clase SC ON SC.PK_sesion_clase=SCA.FK_sesion_clase
		JOIN tb_parametro_detalle AS PD ON PD.fk_id_parametro=6 AND PD.fk_value=SC.FK_area_artistica
		".$join."
		WHERE FIND_IN_SET(SC.FK_area_artistica,:areas) AND FIND_IN_SET(SC.FK_clan,:clan)  ".$where."
		AND YEAR(SC.DA_fecha_clase)=:anio AND MONTH(SC.DA_fecha_clase) >=:mesd AND MONTH(SC.DA_fecha_clase) <= :mesh
		GROUP BY SC.FK_area_artistica) AS T"; 

			//echo $sql;

		@$sentencia=$this->dbPDO->prepare($sql);  
		@$sentencia->bindParam(':areas',$datos['areas']);
		@$sentencia->bindParam(':anio',$datos['anio']);
		@$sentencia->bindParam(':mesd',$datos['mesini']);
		@$sentencia->bindParam(':mesh',$datos['mesfin']);  
		@$sentencia->bindParam(':clan',$datos['clan']);
		if($tipo_grupo=='arte_escuela' && $datos['colegio']!=""){
			@$sentencia->bindParam(':colegio',$datos['colegio']);    
		} 
		$sentencia->execute();          
		//$sentencia->debugDumpParams();  
		return $sentencia->fetchAll(\PDO::FETCH_ASSOC);            
	}    

	public function consultarAsistenciasMesPorArea($datos)    
	{         //CALL consultarAsistenciasMesPorArea('4,5,6,2,3,1',5,5,2018,'30','arte_escuela',12);
	$sql="CALL consultarAsistenciasMesPorArea(:id_area,:mesd,:mesh,:anio,:colegio,:tipo_grupo,:clan)";  
	@$sentencia=$this->dbPDO->prepare($sql); 
	@$sentencia->bindParam(':id_area',$datos['areas']);
	@$sentencia->bindParam(':mesd',$datos['mesini']);  
	@$sentencia->bindParam(':mesh',$datos['mesfin']);  
	@$sentencia->bindParam(':anio',$datos['anio']);       
	@$sentencia->bindParam(':colegio',$datos['colegio']);
	@$sentencia->bindParam(':tipo_grupo',$datos['tipo_grupo']);
	@$sentencia->bindParam(':clan',$datos['clan']);
	$sentencia->execute();           
		//$sentencia->debugDumpParams();
	return $sentencia->fetchAll(\PDO::FETCH_ASSOC);                   
}              

public function getAtendidosMesColegio($id_colegio,$mesd,$mesh,$anio,$crea){

	$sql="SELECT COUNT(DISTINCT(SCA.FK_estudiante)) AS 'datos'
	FROM tb_terr_grupo_arte_escuela_sesion_clase_asistencia SCA
	JOIN tb_terr_grupo_arte_escuela_sesion_clase SC ON SC.PK_sesion_clase=SCA.FK_sesion_clase
	JOIN tb_terr_grupo_arte_escuela GAE ON GAE.PK_Grupo=SC.FK_grupo
	WHERE FIND_IN_SET(GAE.FK_colegio,:id_colegio) AND FIND_IN_SET(GAE.FK_clan, :crea) AND SCA.IN_estado_asistencia=1 AND YEAR(SC.DA_fecha_clase)=:anio AND MONTH(SC.DA_fecha_clase) >=:mesd AND MONTH(SC.DA_fecha_clase) <= :mesh  UNION ALL SELECT COUNT(DISTINCT(SCA.FK_estudiante)) AS 'datos'
	FROM tb_terr_grupo_arte_escuela_sesion_clase_asistencia SCA
	JOIN tb_terr_grupo_arte_escuela_sesion_clase SC ON SC.PK_sesion_clase=SCA.FK_sesion_clase
	JOIN tb_terr_grupo_arte_escuela GAE ON GAE.PK_Grupo=SC.FK_grupo
	WHERE FIND_IN_SET(GAE.FK_colegio,:id_colegio) AND FIND_IN_SET(GAE.FK_clan, :crea) AND YEAR(SC.DA_fecha_clase)=:anio AND MONTH(SC.DA_fecha_clase) >=:mesd AND MONTH(SC.DA_fecha_clase) <= :mesh;";
	@$sentencia=$this->dbPDO->prepare($sql); 
	@$sentencia->bindParam(':id_colegio',$id_colegio);
	@$sentencia->bindParam(':mesd',$mesd);  
	@$sentencia->bindParam(':mesh',$mesh);  
	@$sentencia->bindParam(':anio',$anio);  
	@$sentencia->bindParam(':crea',$crea);       
	$sentencia->execute();          
		//$sentencia->debugDumpParams();
	return $sentencia->fetchAll(\PDO::FETCH_ASSOC);    
	return $datos; 
} 

public function getConsultaAsistenciaECMes($id_clan,$mesd,$mesh,$anio) 
{
	$sql="CALL sp_consulta_emprende_mes(:id_clan,:mesd,:mesh,:anio)";  
	@$sentencia=$this->dbPDO->prepare($sql); 
	@$sentencia->bindParam(':id_clan',$id_clan);
	@$sentencia->bindParam(':mesd',$mesd);  
	@$sentencia->bindParam(':mesh',$mesh);  
	@$sentencia->bindParam(':anio',$anio);       
	$sentencia->execute();          
		//$sentencia->debugDumpParams();
	return $sentencia->fetchAll(\PDO::FETCH_ASSOC);                   
}  

public function getConsultaAsistenciaLCMes($id_clan,$mesd,$mesh,$anio) 
{
	$sql="CALL sp_consulta_laboratorio_mes(:id_clan,:mesd,:mesh,:anio)";  
	@$sentencia=$this->dbPDO->prepare($sql); 
	@$sentencia->bindParam(':id_clan',$id_clan);
	@$sentencia->bindParam(':mesd',$mesd);  
	@$sentencia->bindParam(':mesh',$mesh);  
	@$sentencia->bindParam(':anio',$anio);       
	$sentencia->execute();          
		//$sentencia->debugDumpParams();
	return $sentencia->fetchAll(\PDO::FETCH_ASSOC);                   
}      

public function getAtendidosMesECYLC($id_clan,$mesd,$mesh,$anio,$tipo_grupo){

	if ($tipo_grupo == 'emprende_clan') {
		$sql="SELECT COUNT(DISTINCT(SCA.FK_estudiante)) AS 'datos'
		FROM tb_terr_grupo_emprende_clan_sesion_clase_asistencia SCA
			JOIN tb_terr_grupo_emprende_clan_sesion_clase SC ON SC.PK_sesion_clase=SCA.FK_sesion_clase
			JOIN tb_terr_grupo_emprende_clan G ON G.PK_Grupo=SC.FK_grupo
			WHERE FIND_IN_SET(SC.FK_clan,:id_clan) AND SCA.IN_estado_asistencia=1 AND YEAR(SC.DA_fecha_clase)=:anio AND MONTH(SC.DA_fecha_clase) >= :mesd AND MONTH(SC.DA_fecha_clase) <= :mesh
		UNION ALL 
		SELECT COUNT(DISTINCT(SCA.FK_estudiante)) AS 'datos'
		FROM tb_terr_grupo_emprende_clan_sesion_clase_asistencia SCA
			JOIN tb_terr_grupo_emprende_clan_sesion_clase SC ON SC.PK_sesion_clase=SCA.FK_sesion_clase
			JOIN tb_terr_grupo_emprende_clan G ON G.PK_Grupo=SC.FK_grupo
			WHERE FIND_IN_SET(SC.FK_clan,:id_clan) AND YEAR(SC.DA_fecha_clase)=:anio AND MONTH(SC.DA_fecha_clase) >= :mesd AND MONTH(SC.DA_fecha_clase) <= :mesh;";
	}
	if ($tipo_grupo == 'laboratorio_clan') {
		$sql="SELECT COUNT(DISTINCT(SCA.FK_estudiante)) AS 'datos'
		FROM tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia SCA
			JOIN tb_terr_grupo_laboratorio_clan_sesion_clase SC ON SC.PK_sesion_clase=SCA.FK_sesion_clase
			JOIN tb_terr_grupo_laboratorio_clan G ON G.PK_Grupo=SC.FK_grupo
			WHERE FIND_IN_SET(SC.FK_clan,:id_clan) AND SCA.IN_estado_asistencia=1 AND YEAR(SC.DA_fecha_clase)=:anio AND MONTH(SC.DA_fecha_clase) >= :mesd AND MONTH(SC.DA_fecha_clase) <= :mesh
		UNION ALL 
		SELECT COUNT(DISTINCT(SCA.FK_estudiante)) AS 'datos'
		FROM tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia SCA
			JOIN tb_terr_grupo_laboratorio_clan_sesion_clase SC ON SC.PK_sesion_clase=SCA.FK_sesion_clase
			JOIN tb_terr_grupo_laboratorio_clan G ON G.PK_Grupo=SC.FK_grupo
			WHERE FIND_IN_SET(SC.FK_clan,:id_clan) AND YEAR(SC.DA_fecha_clase)=:anio AND MONTH(SC.DA_fecha_clase) >= :mesd AND MONTH(SC.DA_fecha_clase) <= :mesh;";
	}
	@$sentencia=$this->dbPDO->prepare($sql); 
	@$sentencia->bindParam(':id_clan',$id_clan);
	@$sentencia->bindParam(':mesd',$mesd);  
	@$sentencia->bindParam(':mesh',$mesh);  
	@$sentencia->bindParam(':anio',$anio);       
	$sentencia->execute();
	return $sentencia->fetchAll(\PDO::FETCH_ASSOC);    
	return $datos;
}     

public function getEstudiantesArteEscuelaByCrea($creas,$anos){
	$sql = "SELECT E.IN_Identificacion AS identificacion ,
	CONCAT(E.VC_Primer_Nombre,' ',E.VC_Segundo_Nombre,' ',E.VC_Primer_Apellido,' ',E.VC_Segundo_Apellido) AS nombres_y_apellidos,
	E.DD_F_Nacimiento AS Fecha_de_nacimiento,
	C.VC_Nom_Clan AS crea,
	CO.VC_Nom_Colegio AS colegio,
	CONCAT('AC-',G.PK_Grupo) AS grupo,
	AE.VC_Nom_Area AS area_artistica,
	CONCAT(AF.VC_Primer_Nombre,' ',AF.VC_Segundo_Nombre,' ',AF.VC_Primer_Apellido,' ',AF.VC_Segundo_Apellido) AS artista_formador,
	E.DA_Fecha_Registro AS fecha_de_ingreso,
	CASE WHEN EG.estado = 1 THEN '<center><button class=\"btn btn-success\">Activo</button></center>'
	WHEN EG.estado = 0 THEN '<center><button class=\"btn btn-warning\">Inactivo</button></center>' END AS estado		 		 		 

	FROM      tb_estudiante               			E
	JOIN tb_terr_grupo_arte_escuela_estudiante EG  ON EG.FK_estudiante   	 = E.id
	JOIN tb_terr_grupo_arte_escuela 			G   ON G.PK_Grupo           = EG.FK_grupo
	JOIN tb_clan                    			C   ON C.PK_Id_Clan         = G.FK_clan
	LEFT JOIN tb_colegios                			CO  ON CO.PK_Id_Colegio     = G.FK_colegio
	JOIN tb_areas_artisticas        			AE  ON AE.PK_Area_Artistica = G.FK_area_artistica
	JOIN tb_persona_2017            			AF  ON AF.PK_Id_Persona     = G.FK_artista_formador


	WHERE FIND_IN_SET(C.PK_Id_Clan,:creas) AND FIND_IN_SET(YEAR(G.DT_fecha_creacion),:anos) ORDER BY 1;";
	@$sentencia=$this->dbPDO->prepare($sql); 
	@$sentencia->bindParam(':creas',$creas);
	@$sentencia->bindParam(':anos',$anos);
	$sentencia->execute();  
	return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}    

public function getEstudiantesGruposEmprendeByCrea($creas,$anos){
	$sql = "SELECT E.IN_Identificacion AS identificacion ,
	CONCAT(E.VC_Primer_Nombre,' ',E.VC_Segundo_Nombre,' ',E.VC_Primer_Apellido,' ',E.VC_Segundo_Apellido) AS nombres_y_apellidos,
	E.DD_F_Nacimiento AS Fecha_de_nacimiento,
	C.VC_Nom_Clan AS crea,
	CONCAT('EC-',G.PK_Grupo) AS grupo,
	AE.VC_Nom_Area AS area_artistica,
	CONCAT(AF.VC_Primer_Nombre,' ',AF.VC_Segundo_Nombre,' ',AF.VC_Primer_Apellido,' ',AF.VC_Segundo_Apellido) AS artista_formador,
	E.DA_Fecha_Registro AS fecha_de_ingreso,
	CASE WHEN EG.estado = 1 THEN '<center><button class=\"btn btn-success\">Activo</button></center>'
	WHEN EG.estado = 0 THEN '<center><button class=\"btn btn-warning\">Inactivo</button></center>' END AS estado		 		 		 

	FROM      tb_estudiante               			  E
	JOIN tb_terr_grupo_emprende_clan_estudiante EG ON EG.FK_estudiante   	 = E.id
	JOIN tb_terr_grupo_emprende_clan 			  G  ON G.PK_Grupo           = EG.FK_grupo
	JOIN tb_clan                    			  C  ON C.PK_Id_Clan         = G.FK_clan
	JOIN tb_areas_artisticas        			  AE ON AE.PK_Area_Artistica = G.FK_area_artistica
	JOIN tb_persona_2017            			  AF ON AF.PK_Id_Persona     = G.FK_artista_formador

	WHERE FIND_IN_SET(C.PK_Id_Clan,:creas) AND FIND_IN_SET(YEAR(G.DT_fecha_creacion),:anos); ORDER BY 1";

	@$sentencia=$this->dbPDO->prepare($sql); 
	@$sentencia->bindParam(':creas',$creas);
	@$sentencia->bindParam(':anos',$anos);
	$sentencia->execute();  
	return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}   

public function getEstudiantesGruposLaboratorioByCrea($creas,$anos){
	$sql = "SELECT E.IN_Identificacion AS identificacion ,
	CONCAT(E.VC_Primer_Nombre,' ',E.VC_Segundo_Nombre,' ',E.VC_Primer_Apellido,' ',E.VC_Segundo_Apellido) AS nombres_y_apellidos,
	E.DD_F_Nacimiento AS Fecha_de_nacimiento,
	C.VC_Nom_Clan AS crea,
	GA.TX_Nombre_Aliado AS aliado,
	GAI.VC_Descripcion AS institucion,
	CONCAT('LB-',G.PK_Grupo) AS grupo,
	AE.VC_Nom_Area AS area_artistica,
	CONCAT(AF.VC_Primer_Nombre,' ',AF.VC_Segundo_Nombre,' ',AF.VC_Primer_Apellido,' ',AF.VC_Segundo_Apellido) AS artista_formador,
	E.DA_Fecha_Registro AS fecha_de_ingreso,
	CASE WHEN EG.estado = 1 THEN '<center><button class=\"btn btn-success\">Activo</button></center>'
	WHEN EG.estado = 0 THEN '<center><button class=\"btn btn-warning\">Inactivo</button></center>' END AS estado		 		 		 

	FROM      tb_estudiante               			  	E
	JOIN tb_terr_grupo_laboratorio_clan_estudiante EG  ON EG.FK_estudiante   	 = E.id
	JOIN tb_terr_grupo_laboratorio_clan 			G   ON G.PK_Grupo           = EG.FK_grupo
	LEFT JOIN tb_terr_grupo_laboratorio_crea_aliado     GA  ON GA.PK_Id_Aliado      = G.FK_Aliado
	LEFT JOIN tb_parametro_detalle						GAI ON GAI.FK_Value         = GA.FK_Institucion AND GAI.FK_Id_Parametro = 36
	JOIN tb_clan                    				C   ON C.PK_Id_Clan         = G.FK_clan
	JOIN tb_areas_artisticas        				AE  ON AE.PK_Area_Artistica = G.FK_area_artistica
	JOIN tb_persona_2017            				AF  ON AF.PK_Id_Persona     = G.FK_artista_formador

	WHERE FIND_IN_SET(C.PK_Id_Clan,:creas) AND FIND_IN_SET(YEAR(G.DT_fecha_creacion),:anos); ORDER BY 1";

	@$sentencia=$this->dbPDO->prepare($sql); 
	@$sentencia->bindParam(':creas',$creas);
	@$sentencia->bindParam(':anos',$anos);
	$sentencia->execute();  
	return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}             

public function getGruposArteEscuelaByCrea($creas,$anios)
{
	$sql="SELECT
	tt.*,
	SUM(IF(tt.MES='01', tt.ATENDIDOS, 0)) AS 'AtendidosEnero',
	SUM(IF(tt.MES='01', tt.REPORTADOS, 0)) AS 'TotalReportadosEnero',
	SUM(IF(tt.MES='01', tt.PORCENTAJE, 0)) AS 'PorcentajeEnero',
	SUM(IF(tt.MES='02', tt.ATENDIDOS, 0)) AS 'AtendidosFebrero',
	SUM(IF(tt.MES='02', tt.REPORTADOS, 0)) AS 'TotalReportadosFebrero',
	SUM(IF(tt.MES='02', tt.PORCENTAJE, 0)) AS 'PorcentajeFebrero',
	SUM(IF(tt.MES='03', tt.ATENDIDOS, 0)) AS 'AtendidosMarzo',
	SUM(IF(tt.MES='03', tt.REPORTADOS, 0)) AS 'TotalReportadosMarzo',
	SUM(IF(tt.MES='03', tt.PORCENTAJE, 0)) AS 'PorcentajeMarzo',
	SUM(IF(tt.MES='04', tt.ATENDIDOS, 0)) AS 'AtendidosAbril',
	SUM(IF(tt.MES='04', tt.REPORTADOS, 0)) AS 'TotalReportadosAbril',
	SUM(IF(tt.MES='04', tt.PORCENTAJE, 0)) AS 'PorcentajeAbril',
	SUM(IF(tt.MES='05', tt.ATENDIDOS, 0)) AS 'AtendidosMayo',
	SUM(IF(tt.MES='05', tt.REPORTADOS, 0)) AS 'TotalReportadosMayo',
	SUM(IF(tt.MES='05', tt.PORCENTAJE, 0)) AS 'PorcentajeMayo',
	SUM(IF(tt.MES='06', tt.ATENDIDOS, 0)) AS 'AtendidosJunio',
	SUM(IF(tt.MES='06', tt.REPORTADOS, 0)) AS 'TotalReportadosJunio',
	SUM(IF(tt.MES='06', tt.PORCENTAJE, 0)) AS 'PorcentajeJunio',
	SUM(IF(tt.MES='07', tt.ATENDIDOS, 0)) AS 'AtendidosJulio',
	SUM(IF(tt.MES='07', tt.REPORTADOS, 0)) AS 'TotalReportadosJulio',
	SUM(IF(tt.MES='07', tt.PORCENTAJE, 0)) AS 'PorcentajeJulio',
	SUM(IF(tt.MES='08', tt.ATENDIDOS, 0)) AS 'AtendidosAgosto',
	SUM(IF(tt.MES='08', tt.REPORTADOS, 0)) AS 'TotalReportadosAgosto',
	SUM(IF(tt.MES='08', tt.PORCENTAJE, 0)) AS 'PorcentajeAgosto',
	SUM(IF(tt.MES='09', tt.ATENDIDOS, 0)) AS 'AtendidosSeptiembre',
	SUM(IF(tt.MES='09', tt.REPORTADOS, 0)) AS 'TotalReportadosSeptiembre',
	SUM(IF(tt.MES='09', tt.PORCENTAJE, 0)) AS 'PorcentajeSeptiembre',
	SUM(IF(tt.MES='10', tt.ATENDIDOS, 0)) AS 'AtendidosOctubre',
	SUM(IF(tt.MES='10', tt.REPORTADOS, 0)) AS 'TotalReportadosOctubre',
	SUM(IF(tt.MES='10', tt.PORCENTAJE, 0)) AS 'PorcentajeOctubre',
	SUM(IF(tt.MES='11', tt.ATENDIDOS, 0)) AS 'AtendidosNoviembre',
	SUM(IF(tt.MES='11', tt.REPORTADOS, 0)) AS 'TotalReportadosNoviembre',
	SUM(IF(tt.MES='11', tt.PORCENTAJE, 0)) AS 'PorcentajeNoviembre',
	SUM(IF(tt.MES='12', tt.ATENDIDOS, 0)) AS 'AtendidosDiciembre',
	SUM(IF(tt.MES='12', tt.REPORTADOS, 0)) AS 'TotalReportadosDiciembre',
	SUM(IF(tt.MES='12', tt.PORCENTAJE, 0)) AS 'PorcentajeDiciembre',
	(
	SELECT 
	COUNT(DISTINCT SCAAT.FK_estudiante)
	FROM tb_terr_grupo_arte_escuela_sesion_clase SCT
	JOIN tb_terr_grupo_arte_escuela_sesion_clase_asistencia SCAAT ON SCAAT.FK_sesion_clase=SCT.PK_sesion_clase AND SCAAT.IN_estado_asistencia=1
	JOIN tb_estudiante E ON SCAAT.FK_estudiante=E.id
	WHERE SCT.FK_grupo=tt.grupo AND YEAR(SCT.DA_fecha_clase)=:anios
	) AS 'total_atendidos',
	(
	SELECT 
	COUNT(DISTINCT SCAAT.FK_estudiante)
	FROM tb_terr_grupo_arte_escuela_sesion_clase SCT
	JOIN tb_terr_grupo_arte_escuela_sesion_clase_asistencia SCAAT ON SCAAT.FK_sesion_clase=SCT.PK_sesion_clase AND SCAAT.IN_estado_asistencia=1
	JOIN tb_estudiante E ON SCAAT.FK_estudiante=E.id
	WHERE SCT.FK_grupo=tt.grupo AND E.CH_Genero='M' AND YEAR(SCT.DA_fecha_clase)=:anios
	) AS 'atendidos_hombres',
	(
	SELECT
	COUNT(DISTINCT SCAAT.FK_estudiante)
	FROM tb_terr_grupo_arte_escuela_sesion_clase SCT
	JOIN tb_terr_grupo_arte_escuela_sesion_clase_asistencia SCAAT ON SCAAT.FK_sesion_clase=SCT.PK_sesion_clase AND SCAAT.IN_estado_asistencia=1
	JOIN tb_estudiante E ON SCAAT.FK_estudiante=E.id
	WHERE SCT.FK_grupo=tt.grupo AND E.CH_Genero='F' AND YEAR(SCT.DA_fecha_clase)=:anios
	) AS 'atendidos_mujeres',
	(
	SELECT
	COUNT(DISTINCT SCAAT.FK_estudiante)
	FROM tb_terr_grupo_arte_escuela_sesion_clase SCT
	JOIN tb_terr_grupo_arte_escuela_sesion_clase_asistencia SCAAT ON SCAAT.FK_sesion_clase=SCT.PK_sesion_clase AND SCAAT.IN_estado_asistencia=1
	JOIN tb_estudiante E ON SCAAT.FK_estudiante=E.id
	WHERE SCT.FK_grupo=tt.grupo AND E.CH_Genero != 'M' AND E.CH_Genero != 'F' AND YEAR(SCT.DA_fecha_clase)=:anios
	) AS 'atendidos_sin_genero',
	(
	SELECT COUNT(DISTINCT SCART.FK_estudiante)
	FROM tb_terr_grupo_arte_escuela_sesion_clase SCT
	JOIN tb_terr_grupo_arte_escuela_sesion_clase_asistencia SCART ON SCART.FK_sesion_clase=SCT.PK_sesion_clase
	WHERE SCT.FK_grupo=tt.grupo AND YEAR(SCT.DA_fecha_clase)=:anios
	) AS 'total_reportados'
FROM
(
SELECT 
	AE.PK_Grupo AS 'grupo', 
	AE.modalidad_atencion,
	C.VC_Nom_Clan AS 'crea',
	AA.VC_Descripcion AS 'area',
	AE.tipo_grupo AS 'tipo_grupo',
	COL.VC_Nom_Colegio AS 'colegio',
	AE.VC_grados AS 'grados',
	O.VC_Nom_Organizacion AS 'organizacion',
	CONCAT(AF.VC_Primer_Nombre,' ',AF.VC_Segundo_Nombre,' ',AF.VC_Primer_Apellido,' ',AF.VC_Segundo_Apellido) AS 'artista_formador',
	(CASE
	WHEN AE.IN_lugar_atencion = 1 THEN 'Solo Colegio'
	WHEN AE.IN_lugar_atencion = 2 THEN 'Solo CREA'
	WHEN AE.IN_lugar_atencion = 3 THEN 'CREA y Colegio'
	ELSE ''
	END) AS 'lugar_atencion',
	AE.DT_fecha_creacion AS 'fecha_creacion',
	CONCAT(ABRIO.VC_Primer_Nombre,' ',ABRIO.VC_Segundo_Nombre,' ',ABRIO.VC_Primer_Apellido,' ',ABRIO.VC_Segundo_Apellido) AS 'abrio',
	(
	SELECT
	GROUP_CONCAT( 
	CONCAT(
	(
	CASE 
	WHEN HC.IN_dia=1 THEN 'Lunes'
	WHEN HC.IN_dia=2 THEN 'Martes'
	WHEN HC.IN_dia=3 THEN 'Miércoles'
	WHEN HC.IN_dia=4 THEN 'Jueves'
	WHEN HC.IN_dia=5 THEN 'Viernes'
	WHEN HC.IN_dia=6 THEN 'Sábado'
	WHEN HC.IN_dia=7 THEN 'Domingo'
	END
	),' (',HC.TI_hora_inicio_clase,' a ',HC.TI_hora_fin_clase,')')) 
	FROM tb_terr_grupo_arte_escuela_horario_clase AS HC 
	WHERE HC.FK_grupo=AE.PK_Grupo
	) AS 'horario',
	(
	SELECT COUNT(*)
	FROM tb_terr_grupo_arte_escuela_estudiante GE
	WHERE GE.FK_grupo=AE.PK_Grupo AND GE.estado=1
	) AS 'estudiante',
	AE.TX_observaciones AS 'observaciones',
	(
	CASE
	WHEN AE.estado=1 THEN 'Activo'
	WHEN AE.estado=0 THEN 'Inactivo'
	END 
	) AS 'estado',
	AE.DT_fecha_cierre AS 'fecha_cierre',
	CONCAT(CERRO.VC_Primer_Nombre,' ',CERRO.VC_Segundo_Nombre,' ',CERRO.VC_Primer_Apellido,' ',CERRO.VC_Segundo_Apellido) AS 'cerro',
	COUNT(DISTINCT SCAA.FK_estudiante) AS 'ATENDIDOS',
	COUNT(DISTINCT SCAR.FK_estudiante) AS 'REPORTADOS',
	COALESCE(ROUND(((COUNT(DISTINCT SCAA.FK_estudiante)/COUNT(DISTINCT SCAR.FK_estudiante))*100),2),0) AS PORCENTAJE,
	MONTH(SC.DA_fecha_clase) AS 'MES',
	CONV.VC_Descripcion AS 'CONVENIO'
	FROM tb_terr_grupo_arte_escuela AS AE
	JOIN tb_clan AS C ON C.PK_Id_Clan=AE.FK_clan
	LEFT JOIN tb_parametro_detalle AS AA ON AA.FK_Value=AE.FK_area_artistica AND AA.FK_Id_Parametro = 6
	LEFT JOIN tb_colegios AS COL ON COL.PK_Id_Colegio=AE.FK_colegio
	LEFT JOIN tb_organizaciones_2017 AS O ON O.PK_Id_Organizacion=AE.FK_organizacion
	LEFT JOIN tb_persona_2017 AS AF on AF.PK_Id_Persona=AE.FK_artista_formador
	LEFT JOIN tb_persona_2017 AS CERRO on CERRO.PK_Id_Persona=AE.FK_quien_cerro
	LEFT JOIN tb_persona_2017 AS ABRIO on ABRIO.PK_Id_Persona=AE.FK_creador
	LEFT JOIN tb_terr_grupo_arte_escuela_sesion_clase SC ON SC.FK_grupo=AE.PK_Grupo AND YEAR(SC.DA_fecha_clase)=:anios
	LEFT JOIN tb_terr_grupo_arte_escuela_sesion_clase_asistencia SCAA ON SCAA.FK_sesion_clase=SC.PK_sesion_clase AND SCAA.IN_estado_asistencia=1
	LEFT JOIN tb_terr_grupo_arte_escuela_sesion_clase_asistencia SCAR ON SCAR.FK_sesion_clase=SC.PK_sesion_clase
	LEFT JOIN tb_parametro_detalle AS CONV ON CONV.FK_Value=AE.IN_convenio AND CONV.FK_Id_Parametro = 68
	WHERE FIND_IN_SET(AE.FK_clan,:creas) AND FIND_IN_SET(YEAR(AE.DT_fecha_creacion),:anios)
	GROUP BY AE.PK_Grupo, MONTH(SC.DA_fecha_clase)) AS tt
	GROUP BY tt.grupo";
	@$sentencia=$this->dbPDO->prepare($sql); 
	@$sentencia->bindParam(':creas',$creas);
	@$sentencia->bindParam(':anios',$anios);
	$sentencia->execute();  
		//$sentencia->debugDumpParams();
	return $sentencia->fetchAll(\PDO::FETCH_ASSOC);            

}


public function getGruposEmprendeCreaByCrea($creas,$anios)
{ 
	$sql="SELECT
	tt.*,
	SUM(IF(tt.MES='01', tt.ATENDIDOS, 0)) AS 'AtendidosEnero',
	SUM(IF(tt.MES='01', tt.REPORTADOS, 0)) AS 'TotalReportadosEnero',
	SUM(IF(tt.MES='01', tt.PORCENTAJE, 0)) AS 'PorcentajeEnero',
	SUM(IF(tt.MES='02', tt.ATENDIDOS, 0)) AS 'AtendidosFebrero',
	SUM(IF(tt.MES='02', tt.REPORTADOS, 0)) AS 'TotalReportadosFebrero',
	SUM(IF(tt.MES='02', tt.PORCENTAJE, 0)) AS 'PorcentajeFebrero',
	SUM(IF(tt.MES='03', tt.ATENDIDOS, 0)) AS 'AtendidosMarzo',
	SUM(IF(tt.MES='03', tt.REPORTADOS, 0)) AS 'TotalReportadosMarzo',
	SUM(IF(tt.MES='03', tt.PORCENTAJE, 0)) AS 'PorcentajeMarzo',
	SUM(IF(tt.MES='04', tt.ATENDIDOS, 0)) AS 'AtendidosAbril',
	SUM(IF(tt.MES='04', tt.REPORTADOS, 0)) AS 'TotalReportadosAbril',
	SUM(IF(tt.MES='04', tt.PORCENTAJE, 0)) AS 'PorcentajeAbril',
	SUM(IF(tt.MES='05', tt.ATENDIDOS, 0)) AS 'AtendidosMayo',
	SUM(IF(tt.MES='05', tt.REPORTADOS, 0)) AS 'TotalReportadosMayo',
	SUM(IF(tt.MES='05', tt.PORCENTAJE, 0)) AS 'PorcentajeMayo',
	SUM(IF(tt.MES='06', tt.ATENDIDOS, 0)) AS 'AtendidosJunio',
	SUM(IF(tt.MES='06', tt.REPORTADOS, 0)) AS 'TotalReportadosJunio',
	SUM(IF(tt.MES='06', tt.PORCENTAJE, 0)) AS 'PorcentajeJunio',
	SUM(IF(tt.MES='07', tt.ATENDIDOS, 0)) AS 'AtendidosJulio',
	SUM(IF(tt.MES='07', tt.REPORTADOS, 0)) AS 'TotalReportadosJulio',
	SUM(IF(tt.MES='07', tt.PORCENTAJE, 0)) AS 'PorcentajeJulio',
	SUM(IF(tt.MES='08', tt.ATENDIDOS, 0)) AS 'AtendidosAgosto',
	SUM(IF(tt.MES='08', tt.REPORTADOS, 0)) AS 'TotalReportadosAgosto',
	SUM(IF(tt.MES='08', tt.PORCENTAJE, 0)) AS 'PorcentajeAgosto',
	SUM(IF(tt.MES='09', tt.ATENDIDOS, 0)) AS 'AtendidosSeptiembre',
	SUM(IF(tt.MES='09', tt.REPORTADOS, 0)) AS 'TotalReportadosSeptiembre',
	SUM(IF(tt.MES='09', tt.PORCENTAJE, 0)) AS 'PorcentajeSeptiembre',
	SUM(IF(tt.MES='10', tt.ATENDIDOS, 0)) AS 'AtendidosOctubre',
	SUM(IF(tt.MES='10', tt.REPORTADOS, 0)) AS 'TotalReportadosOctubre',
	SUM(IF(tt.MES='10', tt.PORCENTAJE, 0)) AS 'PorcentajeOctubre',
	SUM(IF(tt.MES='11', tt.ATENDIDOS, 0)) AS 'AtendidosNoviembre',
	SUM(IF(tt.MES='11', tt.REPORTADOS, 0)) AS 'TotalReportadosNoviembre',
	SUM(IF(tt.MES='11', tt.PORCENTAJE, 0)) AS 'PorcentajeNoviembre',
	SUM(IF(tt.MES='12', tt.ATENDIDOS, 0)) AS 'AtendidosDiciembre',
	SUM(IF(tt.MES='12', tt.REPORTADOS, 0)) AS 'TotalReportadosDiciembre',
	SUM(IF(tt.MES='12', tt.PORCENTAJE, 0)) AS 'PorcentajeDiciembre',
	(
	SELECT COUNT(DISTINCT SCAAT.FK_estudiante)
	FROM tb_terr_grupo_emprende_clan_sesion_clase SCT
	JOIN tb_terr_grupo_emprende_clan_sesion_clase_asistencia SCAAT ON SCAAT.FK_sesion_clase=SCT.PK_sesion_clase AND SCAAT.IN_estado_asistencia=1
	WHERE SCT.FK_grupo=tt.grupo  AND YEAR(SCT.DA_fecha_clase)=:anios
	) AS 'total_atendidos',
	(
	SELECT 
	COUNT(DISTINCT SCAAT.FK_estudiante)
	FROM tb_terr_grupo_emprende_clan_sesion_clase SCT
	JOIN tb_terr_grupo_emprende_clan_sesion_clase_asistencia SCAAT ON SCAAT.FK_sesion_clase=SCT.PK_sesion_clase AND SCAAT.IN_estado_asistencia=1
	JOIN tb_estudiante E ON SCAAT.FK_estudiante=E.id
	WHERE SCT.FK_grupo=tt.grupo AND E.CH_Genero='M' AND YEAR(SCT.DA_fecha_clase)=:anios
	) AS 'atendidos_hombres',
	(
	SELECT
	COUNT(DISTINCT SCAAT.FK_estudiante)
	FROM tb_terr_grupo_emprende_clan_sesion_clase SCT
	JOIN tb_terr_grupo_emprende_clan_sesion_clase_asistencia SCAAT ON SCAAT.FK_sesion_clase=SCT.PK_sesion_clase AND SCAAT.IN_estado_asistencia=1
	JOIN tb_estudiante E ON SCAAT.FK_estudiante=E.id
	WHERE SCT.FK_grupo=tt.grupo AND E.CH_Genero='F' AND YEAR(SCT.DA_fecha_clase)=:anios
	) AS 'atendidos_mujeres',
	(
	SELECT
	COUNT(DISTINCT SCAAT.FK_estudiante)
	FROM tb_terr_grupo_emprende_clan_sesion_clase SCT
	JOIN tb_terr_grupo_emprende_clan_sesion_clase_asistencia SCAAT ON SCAAT.FK_sesion_clase=SCT.PK_sesion_clase AND SCAAT.IN_estado_asistencia=1
	JOIN tb_estudiante E ON SCAAT.FK_estudiante=E.id
	WHERE SCT.FK_grupo=tt.grupo AND E.CH_Genero != 'M' AND E.CH_Genero != 'F' AND YEAR(SCT.DA_fecha_clase)=:anios
	) AS 'atendidos_sin_genero',
	(
	SELECT COUNT(DISTINCT SCART.FK_estudiante)
	FROM tb_terr_grupo_emprende_clan_sesion_clase SCT
	JOIN tb_terr_grupo_emprende_clan_sesion_clase_asistencia SCART ON SCART.FK_sesion_clase=SCT.PK_sesion_clase
	WHERE SCT.FK_grupo=tt.grupo AND YEAR(SCT.DA_fecha_clase)=:anios
	) AS 'total_reportados'
FROM
(
SELECT 
	EC.PK_Grupo AS 'grupo',
	EC.modalidad_atencion,
	C.VC_Nom_Clan AS 'crea',
	AA.VC_Descripcion AS 'area',
	EC.tipo_grupo AS 'tipo_grupo',
	MO.VC_Nom_Modalidad AS 'modalidad',
	O.VC_Nom_Organizacion AS 'organizacion',
	CONCAT(AF.VC_Primer_Nombre,' ',AF.VC_Segundo_Nombre,' ',AF.VC_Primer_Apellido,' ',AF.VC_Segundo_Apellido) AS 'artista_formador',
	EC.DT_fecha_creacion AS 'fecha_creacion',
	CONCAT(ABRIO.VC_Primer_Nombre,' ',ABRIO.VC_Segundo_Nombre,' ',ABRIO.VC_Primer_Apellido,' ',ABRIO.VC_Segundo_Apellido) AS 'abrio',
	(
	SELECT
	GROUP_CONCAT( 
	CONCAT(
	(
	CASE 
	WHEN HC.IN_dia=1 THEN 'Lunes'
	WHEN HC.IN_dia=2 THEN 'Martes'
	WHEN HC.IN_dia=3 THEN 'Miercoles'
	WHEN HC.IN_dia=4 THEN 'Jueves'
	WHEN HC.IN_dia=5 THEN 'Viernes'
	WHEN HC.IN_dia=6 THEN 'Sabado'
	WHEN HC.IN_dia=7 THEN 'Domingo'
	END
	),' (',HC.TI_hora_inicio_clase,' a ',HC.TI_hora_fin_clase,')')) 
	FROM tb_terr_grupo_emprende_clan_horario_clase AS HC 
	WHERE HC.FK_grupo=EC.PK_Grupo
	) AS 'horario',
	(
	SELECT COUNT(*)
	FROM tb_terr_grupo_emprende_clan_estudiante GE
	WHERE GE.FK_grupo=EC.PK_Grupo AND GE.estado=1
	) AS 'estudiante',
	EC.TX_observaciones AS 'observaciones',
	(
	CASE
	WHEN EC.estado=1 THEN 'Activo'
	WHEN EC.estado=0 THEN 'Inactivo'
	END
	) AS 'estado',
	EC.DT_fecha_cierre AS 'fecha_cierre',
	CONCAT(CERRO.VC_Primer_Nombre,' ',CERRO.VC_Segundo_Nombre,' ',CERRO.VC_Primer_Apellido,' ',CERRO.VC_Segundo_Apellido) AS 'cerro',
	COUNT(DISTINCT SCAA.FK_estudiante) AS 'ATENDIDOS',
	COUNT(DISTINCT SCAR.FK_estudiante) AS 'REPORTADOS',
	COALESCE(ROUND(((COUNT(DISTINCT SCAA.FK_estudiante)/COUNT(DISTINCT SCAR.FK_estudiante))*100),2),0) AS PORCENTAJE,
	MONTH(SC.DA_fecha_clase) AS 'MES',
	YEAR(SC.DA_fecha_clase) AS 'ANIO',
	CONV.VC_Descripcion AS 'CONVENIO'
	FROM tb_terr_grupo_emprende_clan AS EC
	JOIN tb_clan AS C ON C.PK_Id_Clan=EC.FK_clan
	LEFT JOIN tb_parametro_detalle AS AA ON AA.FK_Value=EC.FK_area_artistica AND AA.FK_Id_Parametro = 6
	LEFT JOIN tb_modalidad AS MO ON MO.PK_Id_Modalidad=EC.FK_modalidad
	LEFT JOIN tb_organizaciones_2017 AS O ON O.PK_Id_Organizacion=EC.FK_organizacion
	LEFT JOIN tb_persona_2017 AS AF on AF.PK_Id_Persona=EC.FK_artista_formador
	LEFT JOIN tb_persona_2017 AS CERRO on CERRO.PK_Id_Persona=EC.FK_quien_cerro
	LEFT JOIN tb_persona_2017 AS ABRIO on ABRIO.PK_Id_Persona=EC.FK_creador
	LEFT JOIN tb_terr_grupo_emprende_clan_sesion_clase SC ON SC.FK_grupo=EC.PK_Grupo AND YEAR(SC.DA_fecha_clase)=:anios
	LEFT JOIN tb_terr_grupo_emprende_clan_sesion_clase_asistencia SCAA ON SCAA.FK_sesion_clase=SC.PK_sesion_clase AND SCAA.IN_estado_asistencia=1
	LEFT JOIN tb_terr_grupo_emprende_clan_sesion_clase_asistencia SCAR ON SCAR.FK_sesion_clase=SC.PK_sesion_clase
	LEFT JOIN tb_parametro_detalle AS CONV ON CONV.FK_Value=EC.IN_convenio AND CONV.FK_Id_Parametro = 68
	WHERE FIND_IN_SET(EC.FK_clan,:creas)  AND FIND_IN_SET(YEAR(EC.DT_fecha_creacion),:anios)
	GROUP BY EC.PK_Grupo, MONTH(SC.DA_fecha_clase)) AS tt
	GROUP BY tt.grupo;";
	@$sentencia=$this->dbPDO->prepare($sql); 
	@$sentencia->bindParam(':creas',$creas);
	@$sentencia->bindParam(':anios',$anios);
	$sentencia->execute();
	//$sentencia->debugDumpParams();
	return $sentencia->fetchAll(\PDO::FETCH_ASSOC);           

}

public function getGruposLaboratorioCreaByCrea($creas,$anios)
{
	$sql="SELECT
	tt.*,
	SUM(IF(tt.MES='01', tt.ATENDIDOS, 0)) AS 'AtendidosEnero',
	SUM(IF(tt.MES='01', tt.REPORTADOS, 0)) AS 'TotalReportadosEnero',
	SUM(IF(tt.MES='01', tt.PORCENTAJE, 0)) AS 'PorcentajeEnero',
	SUM(IF(tt.MES='02', tt.ATENDIDOS, 0)) AS 'AtendidosFebrero',
	SUM(IF(tt.MES='02', tt.REPORTADOS, 0)) AS 'TotalReportadosFebrero',
	SUM(IF(tt.MES='02', tt.PORCENTAJE, 0)) AS 'PorcentajeFebrero',
	SUM(IF(tt.MES='03', tt.ATENDIDOS, 0)) AS 'AtendidosMarzo',
	SUM(IF(tt.MES='03', tt.REPORTADOS, 0)) AS 'TotalReportadosMarzo',
	SUM(IF(tt.MES='03', tt.PORCENTAJE, 0)) AS 'PorcentajeMarzo',
	SUM(IF(tt.MES='04', tt.ATENDIDOS, 0)) AS 'AtendidosAbril',
	SUM(IF(tt.MES='04', tt.REPORTADOS, 0)) AS 'TotalReportadosAbril',
	SUM(IF(tt.MES='04', tt.PORCENTAJE, 0)) AS 'PorcentajeAbril',
	SUM(IF(tt.MES='05', tt.ATENDIDOS, 0)) AS 'AtendidosMayo',
	SUM(IF(tt.MES='05', tt.REPORTADOS, 0)) AS 'TotalReportadosMayo',
	SUM(IF(tt.MES='05', tt.PORCENTAJE, 0)) AS 'PorcentajeMayo',
	SUM(IF(tt.MES='06', tt.ATENDIDOS, 0)) AS 'AtendidosJunio',
	SUM(IF(tt.MES='06', tt.REPORTADOS, 0)) AS 'TotalReportadosJunio',
	SUM(IF(tt.MES='06', tt.PORCENTAJE, 0)) AS 'PorcentajeJunio',
	SUM(IF(tt.MES='07', tt.ATENDIDOS, 0)) AS 'AtendidosJulio',
	SUM(IF(tt.MES='07', tt.REPORTADOS, 0)) AS 'TotalReportadosJulio',
	SUM(IF(tt.MES='07', tt.PORCENTAJE, 0)) AS 'PorcentajeJulio',
	SUM(IF(tt.MES='08', tt.ATENDIDOS, 0)) AS 'AtendidosAgosto',
	SUM(IF(tt.MES='08', tt.REPORTADOS, 0)) AS 'TotalReportadosAgosto',
	SUM(IF(tt.MES='08', tt.PORCENTAJE, 0)) AS 'PorcentajeAgosto',
	SUM(IF(tt.MES='09', tt.ATENDIDOS, 0)) AS 'AtendidosSeptiembre',
	SUM(IF(tt.MES='09', tt.REPORTADOS, 0)) AS 'TotalReportadosSeptiembre',
	SUM(IF(tt.MES='09', tt.PORCENTAJE, 0)) AS 'PorcentajeSeptiembre',
	SUM(IF(tt.MES='10', tt.ATENDIDOS, 0)) AS 'AtendidosOctubre',
	SUM(IF(tt.MES='10', tt.REPORTADOS, 0)) AS 'TotalReportadosOctubre',
	SUM(IF(tt.MES='10', tt.PORCENTAJE, 0)) AS 'PorcentajeOctubre',
	SUM(IF(tt.MES='11', tt.ATENDIDOS, 0)) AS 'AtendidosNoviembre',
	SUM(IF(tt.MES='11', tt.REPORTADOS, 0)) AS 'TotalReportadosNoviembre',
	SUM(IF(tt.MES='11', tt.PORCENTAJE, 0)) AS 'PorcentajeNoviembre',
	SUM(IF(tt.MES='12', tt.ATENDIDOS, 0)) AS 'AtendidosDiciembre',
	SUM(IF(tt.MES='12', tt.REPORTADOS, 0)) AS 'TotalReportadosDiciembre',
	SUM(IF(tt.MES='12', tt.PORCENTAJE, 0)) AS 'PorcentajeDiciembre',
	(
	SELECT COUNT(DISTINCT SCAAT.FK_estudiante)
	FROM tb_terr_grupo_laboratorio_clan_sesion_clase SCT
	JOIN tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia SCAAT ON SCAAT.FK_sesion_clase=SCT.PK_sesion_clase AND SCAAT.IN_estado_asistencia=1
	WHERE SCT.FK_grupo=tt.grupo AND YEAR(SCT.DA_fecha_clase)=:anios
	) AS 'total_atendidos',
	(
	SELECT 
	COUNT(DISTINCT SCAAT.FK_estudiante)
	FROM tb_terr_grupo_laboratorio_clan_sesion_clase SCT
	JOIN tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia SCAAT ON SCAAT.FK_sesion_clase=SCT.PK_sesion_clase AND SCAAT.IN_estado_asistencia=1
	JOIN tb_estudiante E ON SCAAT.FK_estudiante=E.id
	WHERE SCT.FK_grupo=tt.grupo AND E.CH_Genero='M' AND YEAR(SCT.DA_fecha_clase)=:anios
	) AS 'atendidos_hombres',
	(
	SELECT
	COUNT(DISTINCT SCAAT.FK_estudiante)
	FROM tb_terr_grupo_laboratorio_clan_sesion_clase SCT
	JOIN tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia SCAAT ON SCAAT.FK_sesion_clase=SCT.PK_sesion_clase AND SCAAT.IN_estado_asistencia=1
	JOIN tb_estudiante E ON SCAAT.FK_estudiante=E.id
	WHERE SCT.FK_grupo=tt.grupo AND E.CH_Genero='F' AND YEAR(SCT.DA_fecha_clase)=:anios
	) AS 'atendidos_mujeres',
	(
	SELECT
	COUNT(DISTINCT SCAAT.FK_estudiante)
	FROM tb_terr_grupo_laboratorio_clan_sesion_clase SCT
	JOIN tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia SCAAT ON SCAAT.FK_sesion_clase=SCT.PK_sesion_clase AND SCAAT.IN_estado_asistencia=1
	JOIN tb_estudiante E ON SCAAT.FK_estudiante=E.id
	WHERE SCT.FK_grupo=tt.grupo AND E.CH_Genero != 'M' AND E.CH_Genero != 'F' AND YEAR(SCT.DA_fecha_clase)=:anios
	) AS 'atendidos_sin_genero',
	(
	SELECT COUNT(DISTINCT SCART.FK_estudiante)
	FROM tb_terr_grupo_laboratorio_clan_sesion_clase SCT
	JOIN tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia SCART ON SCART.FK_sesion_clase=SCT.PK_sesion_clase
	WHERE SCT.FK_grupo=tt.grupo AND YEAR(SCT.DA_fecha_clase)=:anios
	) AS 'total_reportados'
FROM
(
SELECT  
	LC.PK_Grupo AS 'grupo',
	LC.modalidad_atencion,
	C.VC_Nom_Clan AS 'crea', 
	PD_LOC_CREA.VC_Descripcion AS 'localidad_crea',
	AA.VC_Descripcion AS 'area',
	PDTP.VC_Descripcion AS 'categoria_poblacion',
	LCTP.VC_Nombre AS 'subcategoria_poblacion',
	PDINS.VC_Descripcion AS 'institucion',
	ALIADO.TX_Nombre_Aliado AS 'aliado',
	CASE
	WHEN LC.IN_lugar_atencion=1 THEN C.VC_Nom_Clan
	WHEN LC.IN_lugar_atencion=2 THEN ALIADO.TX_Nombre_Aliado
	WHEN LC.IN_lugar_atencion=3 THEN 'DESCENTRALIZADO'
	END AS 'lugar_atencion',
	CASE
	WHEN LC.IN_lugar_atencion=1 THEN PD_LOC_CREA.VC_Descripcion
	WHEN LC.IN_lugar_atencion=2 THEN PDLOCALIADO.VC_Descripcion
	WHEN LC.IN_lugar_atencion=3 THEN 'DESCENTRALIZADO'
	END AS 'localidad_lugar_atencion',
	O.VC_Nom_Organizacion AS 'organizacion',
	CONCAT(AF.VC_Primer_Nombre,' ',AF.VC_Segundo_Nombre,' ',AF.VC_Primer_Apellido,' ',AF.VC_Segundo_Apellido) AS 'artista_formador',
	PD_TIPO_GRUPO.VC_Descripcion AS 'tipo_grupo',
	LC.DT_fecha_creacion AS 'fecha_creacion',
	CONCAT(ABRIO.VC_Primer_Nombre,' ',ABRIO.VC_Segundo_Nombre,' ',ABRIO.VC_Primer_Apellido,' ',ABRIO.VC_Segundo_Apellido) AS 'abrio',
	(
	SELECT
	GROUP_CONCAT( 
	CONCAT(
	(
	CASE 
	WHEN HC.IN_dia=1 THEN 'Lunes'
	WHEN HC.IN_dia=2 THEN 'Martes'
	WHEN HC.IN_dia=3 THEN 'Miercoles'
	WHEN HC.IN_dia=4 THEN 'Jueves'
	WHEN HC.IN_dia=5 THEN 'Viernes'
	WHEN HC.IN_dia=6 THEN 'Sabado'
	WHEN HC.IN_dia=7 THEN 'Domingo'
	END
	),' (',HC.TI_hora_inicio_clase,' a ',HC.TI_hora_fin_clase,')')) 
	FROM tb_terr_grupo_laboratorio_clan_horario_clase AS HC 
	WHERE HC.FK_grupo=LC.PK_Grupo
	) AS 'horario',
	(
	SELECT COUNT(*)
	FROM tb_terr_grupo_laboratorio_clan_estudiante GE
	WHERE GE.FK_grupo=LC.PK_Grupo AND GE.estado=1
	) AS 'estudiante',
	LC.TX_observaciones AS 'observaciones',
	(
	CASE
	WHEN LC.estado=1 THEN 'Activo'
	WHEN LC.estado=0 THEN 'Inactivo'
	END  
	) AS 'estado',
	LC.DT_fecha_cierre AS 'fecha_cierre',
	CONCAT(CERRO.VC_Primer_Nombre,' ',CERRO.VC_Segundo_Nombre,' ',CERRO.VC_Primer_Apellido,' ',CERRO.VC_Segundo_Apellido) AS 'cerro',
	COUNT(DISTINCT SCAA.FK_estudiante) AS 'ATENDIDOS',
	COUNT(DISTINCT SCAR.FK_estudiante) AS 'REPORTADOS',
	COALESCE(ROUND(((COUNT(DISTINCT SCAA.FK_estudiante)/COUNT(DISTINCT SCAR.FK_estudiante))*100),2),0) AS PORCENTAJE,
	MONTH(SC.DA_fecha_clase) AS 'MES',
	YEAR(SC.DA_fecha_clase) AS 'ANIO',
	CONV.VC_Descripcion AS 'CONVENIO'
	FROM tb_terr_grupo_laboratorio_clan AS LC
	JOIN tb_clan AS C ON C.PK_Id_Clan=LC.FK_clan
	LEFT JOIN tb_parametro_detalle PD_LOC_CREA ON PD_LOC_CREA.FK_Value = C.FK_Id_Localidad AND PD_LOC_CREA.FK_Id_Parametro='19'
	LEFT JOIN tb_parametro_detalle AS AA ON AA.FK_Value=LC.FK_area_artistica AND AA.FK_Id_Parametro = 6
	LEFT JOIN tb_parametro_detalle AS LA ON LA.FK_Value=LC.FK_lugar_atencion AND LA.FK_Id_Parametro = 28 AND LA.IN_Estado = 1
	LEFT JOIN tb_organizaciones_2017 AS O ON O.PK_Id_Organizacion=LC.FK_organizacion
	LEFT JOIN tb_persona_2017 AS AF on AF.PK_Id_Persona=LC.FK_artista_formador
	LEFT JOIN tb_persona_2017 AS CERRO on CERRO.PK_Id_Persona=LC.FK_quien_cerro
	LEFT JOIN tb_persona_2017 AS ABRIO on ABRIO.PK_Id_Persona=LC.FK_creador
	LEFT JOIN tb_terr_grupo_laboratorio_crea_aliado ALIADO ON LC.FK_Aliado = ALIADO.PK_Id_Aliado
	LEFT JOIN tb_parametro_detalle PDLOCALIADO ON ALIADO.FK_Localidad=PDLOCALIADO.FK_Value AND PDLOCALIADO.FK_Id_Parametro='19'
	LEFT JOIN tb_terr_grupo_laboratorio_crea_tipo_poblacion LCTP ON LC.tipo_poblacion = LCTP.PK_Id_Tabla
	LEFT JOIN tb_parametro_detalle PDTP ON LCTP.FK_Id_Categoria=PDTP.FK_Value AND PDTP.FK_Id_Parametro='37'
	LEFT JOIN tb_parametro_detalle PDINS ON LC.FK_Institucion=PDINS.FK_Value AND PDINS.FK_Id_Parametro='36'
	LEFT JOIN tb_parametro_detalle PD_TIPO_GRUPO ON LC.tipo_grupo=PD_TIPO_GRUPO.FK_Value AND PD_TIPO_GRUPO.FK_Id_Parametro='38'
	LEFT JOIN tb_terr_grupo_laboratorio_clan_sesion_clase SC ON SC.FK_grupo=LC.PK_Grupo AND YEAR(SC.DA_fecha_clase)=:anios
	LEFT JOIN tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia SCAA ON SCAA.FK_sesion_clase=SC.PK_sesion_clase AND SCAA.IN_estado_asistencia=1
	LEFT JOIN tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia SCAR ON SCAR.FK_sesion_clase=SC.PK_sesion_clase
	LEFT JOIN tb_parametro_detalle AS CONV ON CONV.FK_Value=LC.IN_convenio AND CONV.FK_Id_Parametro = 68
	WHERE FIND_IN_SET(LC.FK_clan,:creas)  AND FIND_IN_SET(YEAR(LC.DT_fecha_creacion),:anios)
	GROUP BY LC.PK_Grupo, MONTH(SC.DA_fecha_clase)) AS tt
	GROUP BY tt.grupo;";
	@$sentencia=$this->dbPDO->prepare($sql); 
	@$sentencia->bindParam(':creas',$creas);
	@$sentencia->bindParam(':anios',$anios);
	$sentencia->execute();  
		//$sentencia->debugDumpParams();
	return $sentencia->fetchAll(\PDO::FETCH_ASSOC);           
}

public function getPlaneacionArteEnLaEscuelaIdartes($anio, $fecha_inicial, $fecha_final, $asistencias)
{
	ini_set('memory_limit', '2G');

	$mes_inicial = explode("-",$fecha_inicial)[0];
	$dia_inicial = explode("-",$fecha_inicial)[1];
	$mes_final = explode("-",$fecha_final)[0];
	$dia_final = explode("-",$fecha_final)[1];

	$fecha_inicio = $anio."-".$mes_inicial."-".$dia_inicial;
	$fecha_fin = $anio."-".$mes_final."-".$dia_final;

	$sql="SELECT * FROM
	(SELECT                                                
	DISTINCT(SCA.FK_estudiante) AS 'Id_SIF',
	CASE
	WHEN E.VC_Tipo_Estudiante = 'MATRICULA' OR E.VC_Tipo_Estudiante = 'FORMULARIO' OR E.VC_Tipo_Estudiante = 'CREAENCASA' THEN PDTDSIMAT.VC_Descripcion
	WHEN E.VC_Tipo_Estudiante = 'PREINSCRIPCION' THEN PDTD.VC_Descripcion
	ELSE 'CONDICIÓN ESPECIAL - HABEAS DATA'
	END AS 'Tipo_Identificacion',
	E.IN_Identificacion AS 'Identificación',                                                
	CONCAT(E.`VC_Primer_Nombre`,' ',E.`VC_Segundo_Nombre`,' ',E.`VC_Primer_Apellido`,' ',E.`VC_Segundo_Apellido`) AS 'Nombre_Beneficiario',
	E.CH_Genero AS 'Genero',
	CONCAT('AE-',GAE.`PK_Grupo`) AS 'Grupo',                                              
	SC.tipo_grupo AS 'Tipo_Grupo',                                              
	CASE 
	WHEN SC.FK_usuario = 0 THEN 'EQUIPO CREA'
	WHEN SC.FK_usuario != 0 THEN 	CONCAT(P.`VC_Primer_Nombre`,' ',P.`VC_Segundo_Nombre`,' ',P.`VC_Primer_Apellido`,' ',P.`VC_Segundo_Apellido`)
	END AS 'Formador',
	SC.`VC_Nom_Clan` AS 'CREA',                                             
	O.VC_Nom_Organizacion AS 'Organización',                                                
	PDAA.VC_Descripcion AS 'Area_Artística',                                                
	PDLOCREA.`VC_Descripcion` AS 'Localidad_CREA',                                              
	PDLOCOL.`VC_Descripcion` AS 'Localidad_Colegio',                                                
	COL.`VC_Nom_Colegio` AS 'Colegio',
	COL.`VC_DANE_12` AS 'DANE12',                                             
	CASE                                                
	WHEN SC.`IN_lugar_atencion` = 1 THEN 'COLEGIO'                                              
	WHEN SC.`IN_lugar_atencion` = 2 THEN 'CREA'                                             
	WHEN SC.`IN_lugar_atencion` = 3 THEN 'CREA Y COLEGIO'
	WHEN SC.`IN_lugar_atencion` = 4 THEN 'REMOTO'
	END AS 'Lugar_Atención',                                                
	COUNT(SCA.`IN_estado_asistencia`) AS 'Asistencias',
	SUM(IF(SC.IN_lugar_atencion = 1,1,0)) AS 'Asistencias_Colegio',
	SUM(IF(SC.IN_lugar_atencion = 2,1,0)) AS 'Asistencias_CREA',
	SUM(IF(SC.IN_lugar_atencion = 4,1,0)) AS 'Asistencias_Remoto',
	SUM(IF(SCA.IN_Modalidad_Atencion = 1,1,0)) AS 'Asistencias_Modalidad_Presencial',
	SUM(IF(SCA.IN_Modalidad_Atencion = 2,1,0)) AS 'Asistencias_Modalidad_No_Presencial',
	SUM(IF(SCA.IN_Tipo_Atencion = 1,1,0)) AS 'Asistencias_Tipo_Atencion_Presencial',                                         
	SUM(IF(SCA.IN_Tipo_Atencion = 2,1,0)) AS 'Asistencias_Tipo_Atencion_Sincronica',                                        
	SUM(IF(SCA.IN_Tipo_Atencion = 3,1,0)) AS 'Asistencias_Tipo_Atencion_Asincronica',
	TIMESTAMPDIFF(YEAR,E.DD_F_Nacimiento,CURDATE()) AS 'Edad',                                              
	CASE                                                
	WHEN PD.VC_Descripcion IS NOT NULL THEN PD.VC_Descripcion                                               
	WHEN PD.VC_Descripcion IS NULL THEN 'NO REGISTRA'                                               
	END AS 'Grado',                                             
	CASE                                                
	WHEN PDPOB.`VC_Descripcion` IS NULL AND M.POB_VICT_CONF IS NOT NULL THEN 'Otro'                                             
	WHEN PDPOB.`VC_Descripcion` IS NOT NULL THEN PDPOB.`VC_Descripcion`                                             
	WHEN PDPOB.`VC_Descripcion` IS NULL THEN 'NO REGISTRA'                                              
	END AS 'Poblacion_Victima_Conflicto',                                               
	CASE                                                
	WHEN PDTDIS.`VC_Descripcion` IS NULL AND M.`TIPO_DISCAPACIDAD` IS NOT NULL THEN 'Otra'                                              
	WHEN PDTDIS.`VC_Descripcion` IS NULL THEN 'NO REGISTRA'                                                 
	WHEN PDTDIS.`VC_Descripcion` IS NOT NULL THEN PDTDIS.`VC_Descripcion`                                               
	END AS 'Tipo_Discapacidad',                                                 
	CASE                                                
	WHEN ET.VC_Nombre IS NULL AND M.`ETNIA` IS NOT NULL THEN 'Otra'                                             
	WHEN ET.VC_Nombre IS NOT NULL AND M.`ETNIA` IS NOT NULL THEN ET.VC_Nombre                                               
	WHEN ET.VC_Nombre IS NULL THEN 'NO REGISTRA'                                                
	END AS 'Etnia',                                             
	CASE                                                
	WHEN M.ESTRATO IS NULL THEN 'NO REGISTRA'                                               
	WHEN M.ESTRATO IS NOT NULL THEN M.ESTRATO                                               
	END AS 'Estrato',                                               
	E.`DA_Fecha_Registro` AS 'Fecha_Registro',                                              
	CASE                                                
	WHEN M.POB_VICT_CONF IS NULL THEN 'NO'                                              
	WHEN M.POB_VICT_CONF IS NOT NULL THEN 'SI'                                              
	END AS 'SIMAT',
	MIN(SC.DA_fecha_clase) AS 'FECHA_INICIO'                                              
	FROM tb_terr_grupo_arte_escuela_sesion_clase_asistencia SCA                                             
	JOIN tb_terr_grupo_arte_escuela_sesion_clase SC ON SCA.`FK_sesion_clase`=SC.`PK_sesion_clase`                                               
	LEFT JOIN tb_estudiante E ON SCA.`FK_estudiante`=E.id                                               
	JOIN tb_terr_grupo_arte_escuela GAE ON SC.`FK_grupo`=GAE.`PK_Grupo`                                             
	LEFT JOIN tb_persona_2017 P ON P.`PK_Id_Persona`=SC.`FK_usuario`                                             
	LEFT JOIN tb_organizaciones_2017 O ON GAE.FK_organizacion=O.PK_Id_Organizacion                                               
	JOIN tb_clan C ON SC.`FK_clan`=C.`PK_Id_Clan`                                               
	JOIN tb_parametro_detalle PDAA ON PDAA.`FK_Value`=SC.`FK_area_artistica` AND PDAA.FK_Id_Parametro='6'                                               
	JOIN tb_parametro_detalle PDLOCREA ON PDLOCREA.`FK_Value`=C.`FK_Id_Localidad` and PDLOCREA.FK_Id_Parametro='19'                                             
	JOIN tb_colegios COL ON GAE.`FK_colegio`=COL.`PK_Id_Colegio`                                                
	JOIN tb_parametro_detalle PDLOCOL ON PDLOCOL.`FK_Value`=COL.`FK_Id_Localidad` AND PDLOCOL.FK_Id_Parametro='19'                                              
	LEFT JOIN tb_estudiante_simat M ON E.IN_Identificacion = M.`NRO_DOCUMENTO`                                              
	LEFT JOIN tb_etnia ET ON M.`ETNIA`=ET.PK_Id_Etnia                                               
	LEFT JOIN tb_parametro_detalle PDPOB ON PDPOB.`FK_Value`=M.POB_VICT_CONF AND PDPOB.FK_Id_Parametro='9'                                              
	LEFT JOIN tb_parametro_detalle PDTDIS ON PDTDIS.`FK_Value`=M.TIPO_DISCAPACIDAD AND PDTDIS.FK_Id_Parametro='10'                                              
	LEFT JOIN tb_parametro_detalle PD ON PD.FK_Value=M.GRADO AND PD.FK_Id_Parametro='12'
	LEFT JOIN tb_parametro_detalle PDTD ON PDTD.FK_Value=E.CH_Tipo_Identificacion AND PDTD.FK_Id_Parametro='5'
	LEFT JOIN tb_parametro_detalle PDTDSIMAT ON PDTDSIMAT.FK_Value=E.CH_Tipo_Identificacion AND PDTDSIMAT.FK_Id_Parametro='13'
	WHERE SCA.`IN_estado_asistencia`=1 AND SC.tipo_grupo NOT LIKE '%SED%' AND SC.`DA_fecha_clase` BETWEEN :fecha_inicio AND :fecha_fin GROUP BY SCA.`FK_estudiante`) T WHERE T.Asistencias >= :asistencias;";  

	@$sentencia=$this->dbPDO->prepare($sql);
	@$sentencia->bindParam(':asistencias',$asistencias);
	@$sentencia->bindParam(':fecha_inicio',$fecha_inicio);
	@$sentencia->bindParam(':fecha_fin',$fecha_fin);
	$sentencia->execute();
	//$sentencia->debugDumpParams();
	return $sentencia->fetchAll(\PDO::FETCH_ASSOC);       
}

public function getPlaneacionArteEnLaEscuelaSED($anio, $fecha_inicial, $fecha_final, $asistencias)
{
	ini_set('memory_limit', '2G');

	$mes_inicial = explode("-",$fecha_inicial)[0];
	$dia_inicial = explode("-",$fecha_inicial)[1];
	$mes_final = explode("-",$fecha_final)[0];
	$dia_final = explode("-",$fecha_final)[1];

	$fecha_inicio = $anio."-".$mes_inicial."-".$dia_inicial;
	$fecha_fin = $anio."-".$mes_final."-".$dia_final;

	$sql="SELECT * FROM (
	SELECT                                                
	DISTINCT(SCA.FK_estudiante) AS 'Id_SIF',
	CASE
	WHEN E.VC_Tipo_Estudiante = 'MATRICULA' OR E.VC_Tipo_Estudiante = 'FORMULARIO' OR E.VC_Tipo_Estudiante = 'CREAENCASA' THEN PDTDSIMAT.VC_Descripcion
	WHEN E.VC_Tipo_Estudiante = 'PREINSCRIPCION' THEN PDTD.VC_Descripcion
	ELSE 'CONDICIÓN ESPECIAL - HABEAS DATA'
	END AS 'Tipo_Identificacion',                                           
	E.IN_Identificacion AS 'Identificación',                                                
	CONCAT(E.`VC_Primer_Nombre`,' ',E.`VC_Segundo_Nombre`,' ',E.`VC_Primer_Apellido`,' ',E.`VC_Segundo_Apellido`) AS 'Nombre_Beneficiario',
	E.CH_Genero AS 'Genero',                                             
	CONCAT('AE-',GAE.`PK_Grupo`) AS 'Grupo',                                              
	SC.tipo_grupo AS 'Tipo_Grupo',                                              
	CASE 
	WHEN SC.FK_usuario = 0 THEN 'EQUIPO CREA'
	WHEN SC.FK_usuario != 0 THEN 	CONCAT(P.`VC_Primer_Nombre`,' ',P.`VC_Segundo_Nombre`,' ',P.`VC_Primer_Apellido`,' ',P.`VC_Segundo_Apellido`)
	END AS 'Formador',
	SC.`VC_Nom_Clan` AS 'CREA',                                             
	O.VC_Nom_Organizacion AS 'Organización',                                                
	PDAA.VC_Descripcion AS 'Area_Artística',                                                
	PDLOCREA.`VC_Descripcion` AS 'Localidad_CREA',                                              
	PDLOCOL.`VC_Descripcion` AS 'Localidad_Colegio',                                                
	COL.`VC_Nom_Colegio` AS 'Colegio',
	COL.`VC_DANE_12` AS 'DANE12',
	CASE                                                
	WHEN SC.`IN_lugar_atencion` = 1 THEN 'COLEGIO'                                              
	WHEN SC.`IN_lugar_atencion` = 2 THEN 'CREA'                                             
	WHEN SC.`IN_lugar_atencion` = 3 THEN 'CREA Y COLEGIO'
	WHEN SC.`IN_lugar_atencion` = 4 THEN 'REMOTO'
	END AS 'Lugar_Atención',                                                
	COUNT(SCA.`IN_estado_asistencia`) AS 'Asistencias',
	SUM(IF(SC.IN_lugar_atencion = 1,1,0)) AS 'Asistencias_Colegio',
	SUM(IF(SC.IN_lugar_atencion = 2,1,0)) AS 'Asistencias_CREA',
	SUM(IF(SC.IN_lugar_atencion = 4,1,0)) AS 'Asistencias_Remoto',
	SUM(IF(SCA.IN_Modalidad_Atencion = 1,1,0)) AS 'Asistencias_Modalidad_Presencial',
	SUM(IF(SCA.IN_Modalidad_Atencion = 2,1,0)) AS 'Asistencias_Modalidad_No_Presencial',
	SUM(IF(SCA.IN_Tipo_Atencion = 1,1,0)) AS 'Asistencias_Tipo_Atencion_Presencial',                                         
	SUM(IF(SCA.IN_Tipo_Atencion = 2,1,0)) AS 'Asistencias_Tipo_Atencion_Sincronica',                                        
	SUM(IF(SCA.IN_Tipo_Atencion = 3,1,0)) AS 'Asistencias_Tipo_Atencion_Asincronica',
	TIMESTAMPDIFF(YEAR,E.DD_F_Nacimiento,CURDATE()) AS 'Edad',                                              
	CASE                                                
	WHEN PD.VC_Descripcion IS NOT NULL THEN PD.VC_Descripcion                                               
	WHEN PD.VC_Descripcion IS NULL THEN 'NO REGISTRA'                                               
	END AS 'Grado',                                             
	CASE                                                
	WHEN PDPOB.`VC_Descripcion` IS NULL AND M.POB_VICT_CONF IS NOT NULL THEN 'Otro'                                             
	WHEN PDPOB.`VC_Descripcion` IS NOT NULL THEN PDPOB.`VC_Descripcion`                                             
	WHEN PDPOB.`VC_Descripcion` IS NULL THEN 'NO REGISTRA'                                              
	END AS 'Poblacion_Victima_Conflicto',                                               
	CASE                                                
	WHEN PDTDIS.`VC_Descripcion` IS NULL AND M.`TIPO_DISCAPACIDAD` IS NOT NULL THEN 'Otra'                                              
	WHEN PDTDIS.`VC_Descripcion` IS NULL THEN 'NO REGISTRA'                                                 
	WHEN PDTDIS.`VC_Descripcion` IS NOT NULL THEN PDTDIS.`VC_Descripcion`                                               
	END AS 'Tipo_Discapacidad',                                                 
	CASE                                                
	WHEN ET.VC_Nombre IS NULL AND M.`ETNIA` IS NOT NULL THEN 'Otra'                                             
	WHEN ET.VC_Nombre IS NOT NULL AND M.`ETNIA` IS NOT NULL THEN ET.VC_Nombre                                               
	WHEN ET.VC_Nombre IS NULL THEN 'NO REGISTRA'                                                
	END AS 'Etnia',                                             
	CASE                                                
	WHEN M.ESTRATO IS NULL THEN 'NO REGISTRA'                                               
	WHEN M.ESTRATO IS NOT NULL THEN M.ESTRATO                                               
	END AS 'Estrato',                                               
	E.`DA_Fecha_Registro` AS 'Fecha_Registro',                                              
	CASE                                                
	WHEN M.POB_VICT_CONF IS NULL THEN 'NO'                                              
	WHEN M.POB_VICT_CONF IS NOT NULL THEN 'SI'                                              
	END AS 'SIMAT',
	MIN(SC.DA_fecha_clase) AS 'FECHA_INICIO'                                              
	FROM tb_terr_grupo_arte_escuela_sesion_clase_asistencia SCA                                             
	JOIN tb_terr_grupo_arte_escuela_sesion_clase SC ON SCA.`FK_sesion_clase`=SC.`PK_sesion_clase`                                               
	LEFT JOIN tb_estudiante E ON SCA.`FK_estudiante`=E.id                                               
	JOIN tb_terr_grupo_arte_escuela GAE ON SC.`FK_grupo`=GAE.`PK_Grupo`                                             
	LEFT JOIN tb_persona_2017 P ON P.`PK_Id_Persona`=SC.`FK_usuario`                                             
	LEFT JOIN tb_organizaciones_2017 O ON GAE.FK_organizacion=O.PK_Id_Organizacion                                               
	JOIN tb_clan C ON SC.`FK_clan`=C.`PK_Id_Clan`                                               
	JOIN tb_parametro_detalle PDAA ON PDAA.`FK_Value`=SC.`FK_area_artistica` AND PDAA.FK_Id_Parametro='6'                                               
	JOIN tb_parametro_detalle PDLOCREA ON PDLOCREA.`FK_Value`=C.`FK_Id_Localidad` and PDLOCREA.FK_Id_Parametro='19'                                             
	JOIN tb_colegios COL ON GAE.`FK_colegio`=COL.`PK_Id_Colegio`                                                
	JOIN tb_parametro_detalle PDLOCOL ON PDLOCOL.`FK_Value`=COL.`FK_Id_Localidad` AND PDLOCOL.FK_Id_Parametro='19'                                              
	LEFT JOIN tb_estudiante_simat M ON E.IN_Identificacion = M.`NRO_DOCUMENTO`                                              
	LEFT JOIN tb_etnia ET ON M.`ETNIA`=ET.PK_Id_Etnia                                               
	LEFT JOIN tb_parametro_detalle PDPOB ON PDPOB.`FK_Value`=M.POB_VICT_CONF AND PDPOB.FK_Id_Parametro='9'                                              
	LEFT JOIN tb_parametro_detalle PDTDIS ON PDTDIS.`FK_Value`=M.TIPO_DISCAPACIDAD AND PDTDIS.FK_Id_Parametro='10'
	LEFT JOIN tb_parametro_detalle PD ON PD.FK_Value=M.GRADO AND PD.FK_Id_Parametro='12'
	LEFT JOIN tb_parametro_detalle PDTD ON PDTD.FK_Value=E.CH_Tipo_Identificacion AND PDTD.FK_Id_Parametro='5'
	LEFT JOIN tb_parametro_detalle PDTDSIMAT ON PDTDSIMAT.FK_Value=E.CH_Tipo_Identificacion AND PDTDSIMAT.FK_Id_Parametro='13'                      
	WHERE SCA.`IN_estado_asistencia`=1 AND SC.tipo_grupo LIKE '%SED%' AND SC.`DA_fecha_clase` BETWEEN :fecha_inicio AND :fecha_fin GROUP BY SCA.`FK_estudiante`) T WHERE T.Asistencias >= :asistencias;";

	@$sentencia=$this->dbPDO->prepare($sql);
	@$sentencia->bindParam(':asistencias',$asistencias);
	@$sentencia->bindParam(':fecha_inicio',$fecha_inicio);
	@$sentencia->bindParam(':fecha_fin',$fecha_fin);
	$sentencia->execute();
	//$sentencia->debugDumpParams();
	return $sentencia->fetchAll(\PDO::FETCH_ASSOC);       
}

public function getPlaneacionEmprendeCrea($anio, $fecha_inicial, $fecha_final, $asistencias)
{
	ini_set('memory_limit', '2G');

	$mes_inicial = explode("-",$fecha_inicial)[0];
	$dia_inicial = explode("-",$fecha_inicial)[1];
	$mes_final = explode("-",$fecha_final)[0];
	$dia_final = explode("-",$fecha_final)[1];

	$fecha_inicio = $anio."-".$mes_inicial."-".$dia_inicial;
	$fecha_fin = $anio."-".$mes_final."-".$dia_final;

	$sql="SELECT * FROM (
	SELECT                                            
	DISTINCT(SCA.FK_estudiante) AS 'Id_SIF',
	CASE
	WHEN E.VC_Tipo_Estudiante = 'MATRICULA' OR E.VC_Tipo_Estudiante = 'FORMULARIO' OR E.VC_Tipo_Estudiante = 'CREAENCASA' THEN PDTDSIMAT.VC_Descripcion
	WHEN E.VC_Tipo_Estudiante = 'PREINSCRIPCION' THEN PDTD.VC_Descripcion
	ELSE 'CONDICIÓN ESPECIAL - HABEAS DATA'
	END AS 'Tipo_Identificacion',                                         
	E.IN_Identificacion AS 'Identificación',                                            
	CONCAT(E.`VC_Primer_Nombre`,' ',E.`VC_Segundo_Nombre`,' ',E.`VC_Primer_Apellido`,' ',E.`VC_Segundo_Apellido`) AS 'Nombre_Beneficiario',
	E.CH_Genero AS 'Genero',                                         
	CONCAT('IC-',SC.`FK_Grupo`) AS 'Grupo',                                         
	SC.tipo_grupo AS 'Tipo_Grupo',                                          
	CONCAT(P.`VC_Primer_Nombre`,' ',P.`VC_Segundo_Nombre`,' ',P.`VC_Primer_Apellido`,' ',P.`VC_Segundo_Apellido`) AS 'Formador',                                            
	O.VC_Nom_Organizacion AS 'Organización',                                            
	C.`VC_Nom_Clan` AS 'CREA',                                          
	PDAA.VC_Descripcion AS 'Area_Artística',                                            
	PDLOCLAN.VC_Descripcion AS 'Localidad_CREA',                                            
	COUNT(SCA.`IN_estado_asistencia`) AS 'Asistencias',
	SUM(IF(SC.IN_Tipo_Ubicacion = 1,1,0)) AS 'Asistencias_CREA',
	SUM(IF(SC.IN_Tipo_Ubicacion = 2,1,0)) AS 'Asistencias_Espacio_Alterno',
	SUM(IF(SC.IN_Tipo_Ubicacion = 3,1,0)) AS 'Asistencias_Remoto',
	SUM(IF(SCA.IN_Modalidad_Atencion = 1,1,0)) AS 'Asistencias_Modalidad_Presencial',
	SUM(IF(SCA.IN_Modalidad_Atencion = 2,1,0)) AS 'Asistencias_Modalidad_No_Presencial',
	SUM(IF(SCA.IN_Tipo_Atencion = 1,1,0)) AS 'Asistencias_Tipo_Atencion_Presencial',                                         
	SUM(IF(SCA.IN_Tipo_Atencion = 2,1,0)) AS 'Asistencias_Tipo_Atencion_Sincronica',                                        
	SUM(IF(SCA.IN_Tipo_Atencion = 3,1,0)) AS 'Asistencias_Tipo_Atencion_Asincronica',                                                                                     
	TIMESTAMPDIFF(YEAR,E.DD_F_Nacimiento,CURDATE()) AS 'Edad',                                          
	CASE                                            
	WHEN PDGP.VC_Descripcion IS NOT NULL THEN PDGP.VC_Descripcion                                           
	WHEN PDGP.VC_Descripcion IS NULL THEN 'NINGUNO'                                         
	END AS Grupo_Poblacional,                                           
	CASE                                            
	WHEN EDA.IN_estrato IS NOT NULL THEN EDA.IN_estrato                                         
	WHEN EDA.IN_estrato IS NULL THEN 'SIN ESPECIFICAR'                                          
	END AS Estrato,
	MIN(SC.DA_fecha_clase) AS 'FECHA_INICIO'                                          
	FROM tb_terr_grupo_emprende_clan_sesion_clase_asistencia SCA                                            
	LEFT JOIN tb_estudiante E ON SCA.`FK_estudiante`= E.`id`                                            
	LEFT JOIN tb_estudiante_detalle_anio EDA ON EDA.`FK_estudiante`=E.id AND EDA.anio=:anio                                            
	LEFT JOIN tb_terr_grupo_emprende_clan_sesion_clase SC ON SCA.`FK_sesion_clase`=SC.`PK_sesion_clase`                                         
	LEFT JOIN tb_terr_grupo_emprende_clan GEC ON SC.FK_grupo=GEC.PK_Grupo                                           
	LEFT JOIN tb_clan C ON SC.`FK_clan`=C.`PK_Id_Clan`                                          
	LEFT JOIN tb_parametro_detalle PDAA ON SC.`FK_area_artistica`=PDAA.FK_Value AND PDAA.FK_Id_Parametro='6'                                            
	LEFT JOIN tb_parametro_detalle PDLOCLAN ON C.`FK_Id_Localidad`=PDLOCLAN.FK_Value AND PDLOCLAN.FK_Id_Parametro='19'                                          
	LEFT JOIN `tb_persona_2017` P ON SC.FK_Usuario=P.PK_Id_Persona                                          
	LEFT JOIN tb_organizaciones_2017 O ON O.PK_Id_Organizacion=GEC.FK_organizacion                                          
	LEFT JOIN tb_parametro_detalle PDGP ON EDA.FK_Grupo_Poblacional = PDGP.FK_Value AND PDGP.FK_Id_Parametro='14'
	LEFT JOIN tb_parametro_detalle PDTD ON PDTD.FK_Value=E.CH_Tipo_Identificacion AND PDTD.FK_Id_Parametro='5'
	LEFT JOIN tb_parametro_detalle PDTDSIMAT ON PDTDSIMAT.FK_Value=E.CH_Tipo_Identificacion AND PDTDSIMAT.FK_Id_Parametro='13'
	WHERE SCA.`IN_estado_asistencia`=1 AND SC.`DA_fecha_clase` BETWEEN :fecha_inicio AND :fecha_fin GROUP BY SCA.`FK_estudiante`) T WHERE T.Asistencias >= :asistencias;";  

	@$sentencia=$this->dbPDO->prepare($sql);
	@$sentencia->bindParam(':anio',$anio);
	@$sentencia->bindParam(':fecha_inicio',$fecha_inicio);
	@$sentencia->bindParam(':fecha_fin',$fecha_fin);
	@$sentencia->bindParam(':asistencias',$asistencias);
	$sentencia->execute();
	//$sentencia->debugDumpParams();
	return $sentencia->fetchAll(\PDO::FETCH_ASSOC);       
}

public function getPlaneacionLaboratorioCrea($anio, $fecha_inicial, $fecha_final, $asistencias)
{
	ini_set('memory_limit', '2G');

	$mes_inicial = explode("-",$fecha_inicial)[0];
	$dia_inicial = explode("-",$fecha_inicial)[1];
	$mes_final = explode("-",$fecha_final)[0];
	$dia_final = explode("-",$fecha_final)[1];

	$fecha_inicio = $anio."-".$mes_inicial."-".$dia_inicial;
	$fecha_fin = $anio."-".$mes_final."-".$dia_final;

	$sql="SELECT * FROM (
	SELECT                                            
	DISTINCT(SCA.FK_estudiante) AS 'Id_SIF',
	CASE
	WHEN E.VC_Tipo_Estudiante = 'MATRICULA' OR E.VC_Tipo_Estudiante = 'FORMULARIO' OR E.VC_Tipo_Estudiante = 'CREAENCASA' THEN PDTDSIMAT.VC_Descripcion
	WHEN E.VC_Tipo_Estudiante = 'PREINSCRIPCION' THEN PDTD.VC_Descripcion
	ELSE 'CONDICIÓN ESPECIAL - HABEAS DATA'
	END AS 'Tipo_Identificacion',                                         
	E.IN_Identificacion AS 'IDENTIFICACIÓN',                                            
	CONCAT(E.`VC_Primer_Nombre`,' ',E.`VC_Segundo_Nombre`,' ',E.`VC_Primer_Apellido`,' ',E.`VC_Segundo_Apellido`) AS 'NOMBRE_BENEFICIARIO',
	E.CH_Genero AS 'GENERO',
	CONCAT('CV-',SC.`FK_Grupo`) AS 'GRUPO',
	PDAA.VC_Descripcion AS 'AREA_ARTÍSTICA',
	PDTG.VC_Descripcion AS 'TIPO_DE_GRUPO',                                    
	GROUP_CONCAT(DISTINCT PDTPLC.VC_Descripcion) AS 'CATEGORIA_POBLACIÓN',
	GROUP_CONCAT(DISTINCT TPLC.VC_Nombre) AS 'SUBCATEGORIA_POBLACIÓN',
	PDINST.VC_Descripcion AS 'INSTITUCIÓN',
	ALIADO.TX_Nombre_Aliado AS 'ALIADO',
	CASE
	WHEN GLC.IN_lugar_atencion = 1 THEN 'CREA'
	WHEN GLC.IN_lugar_atencion = 2 THEN 'ALIADO'
	WHEN GLC.IN_lugar_atencion = 3 THEN 'DESCENTRALIZADO'
	WHEN GLC.IN_lugar_atencion = 4 THEN 'REMOTO'
	END AS 'TIPO_DE_UBICACIÓN',
	CASE
	WHEN GLC.IN_lugar_atencion = 1 THEN C.`VC_Nom_Clan`
	WHEN GLC.IN_lugar_atencion = 2 THEN ALIADO.TX_Nombre_Aliado
	WHEN GLC.IN_lugar_atencion = 3 THEN 'DESCENTRALIZADO'
	WHEN GLC.IN_lugar_atencion = 4 THEN 'REMOTO'
	END AS 'LUGAR_DE_ATENCIÓN',
	CASE
	WHEN GLC.IN_lugar_atencion = 1 THEN PDLOCLAN.VC_Descripcion
	WHEN GLC.IN_lugar_atencion = 2 THEN PDLOCALIADO.VC_Descripcion
	WHEN GLC.IN_lugar_atencion = 3 THEN 'DESCENTRALIZADO'
	WHEN GLC.IN_lugar_atencion = 4 THEN 'REMOTO'
	END AS 'LOCALIDAD_LUGAR_ATENCIÓN',
	C.`VC_Nom_Clan` AS 'CREA',
	PDLOCLAN.VC_Descripcion AS 'LOCALIDAD_CREA',              
	CONCAT(P.`VC_Primer_Nombre`,' ',P.`VC_Segundo_Nombre`,' ',P.`VC_Primer_Apellido`,' ',P.`VC_Segundo_Apellido`) AS 'FORMADOR',
	O.VC_Nom_Organizacion AS 'ORGANIZACIÓN',                                        
	CASE                                                
	WHEN SC.FK_lugar_atencion = 17 THEN SC.VC_Nom_Clan                                              
	WHEN SC.FK_lugar_atencion != 17 THEN LALC.VC_Nombre_Lugar                                              
	END AS 'LUGAR_DE_ATENCIÓN_Desactualizado',
	COUNT(SCA.IN_estado_asistencia) AS 'ASISTENCIAS',
	SUM(IF(SC.IN_Tipo_Ubicacion = 1,1,0)) AS 'Asistencias_CREA',
	SUM(IF(SC.IN_Tipo_Ubicacion = 2,1,0)) AS 'Asistencias_Aliado',
	SUM(IF(SC.IN_Tipo_Ubicacion = 3,1,0)) AS 'Asistencias_Espacio_Alterno',
	SUM(IF(SC.IN_Tipo_Ubicacion = 4,1,0)) AS 'Asistencias_Remoto',
	SUM(IF(SCA.IN_Modalidad_Atencion = 1,1,0)) AS 'Asistencias_Modalidad_Presencial',
	SUM(IF(SCA.IN_Modalidad_Atencion = 2,1,0)) AS 'Asistencias_Modalidad_No_Presencial',
	SUM(IF(SCA.IN_Tipo_Atencion = 1,1,0)) AS 'Asistencias_Tipo_Atencion_Presencial',                                         
	SUM(IF(SCA.IN_Tipo_Atencion = 2,1,0)) AS 'Asistencias_Tipo_Atencion_Sincronica',                                        
	SUM(IF(SCA.IN_Tipo_Atencion = 3,1,0)) AS 'Asistencias_Tipo_Atencion_Asincronica',
	TIMESTAMPDIFF(YEAR,E.DD_F_Nacimiento,CURDATE()) AS 'EDAD',                                          
	CASE                                            
	WHEN PDTPP.VC_Descripcion IS NULL THEN 'NINGUNO'                                            
	WHEN PDTPP.VC_Descripcion IS NOT NULL THEN PDTPP.VC_Descripcion                                         
	END AS 'GRUPO_POBLACIONAL_Beneficiario',                                         
	E.`DA_Fecha_Registro` AS 'FECHA_DE_CREACIÓN_BENEFICIARIO',                                          
	CASE                                            
	WHEN ES.ANO_INF IS NOT NULL THEN 'SI'                                           
	WHEN ES.ANO_INF IS NULL THEN 'NO'                                           
	END AS 'SIMAT',
	MIN(SC.DA_fecha_clase) AS 'FECHA_INICIO'                                         
	FROM tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia SCA                                         
	LEFT JOIN tb_estudiante E ON SCA.`FK_estudiante`= E.`id`                                            
	LEFT JOIN tb_estudiante_simat ES ON ES.NRO_DOCUMENTO = E.IN_Identificacion                                    
	LEFT JOIN tb_estudiante_detalle_anio EDA ON EDA.`FK_estudiante`=E.id AND EDA.anio=:anio                                          
	JOIN tb_terr_grupo_laboratorio_clan_sesion_clase SC ON SCA.`FK_sesion_clase`=SC.`PK_sesion_clase`                                           
	JOIN tb_terr_grupo_laboratorio_clan GLC ON GLC.PK_Grupo=SC.FK_grupo                                         
	JOIN tb_clan C ON SC.`FK_clan`=C.`PK_Id_Clan`                                           
	JOIN tb_parametro_detalle PDAA ON SC.`FK_area_artistica`=PDAA.FK_Value AND PDAA.FK_Id_Parametro='6'                                         
	JOIN tb_parametro_detalle PDLOCLAN ON C.`FK_Id_Localidad`=PDLOCLAN.FK_Value AND PDLOCLAN.FK_Id_Parametro='19'                                           
	JOIN `tb_persona_2017` P ON SC.FK_Usuario=P.PK_Id_Persona                                           
	JOIN tb_organizaciones_2017 O ON O.PK_Id_Organizacion=SC.FK_organizacion                                            
	LEFT JOIN tb_terr_lugar_atencion_laboratorio_clan LALC ON LALC.PK_lugar_atencion=SC.FK_lugar_atencion
	LEFT JOIN tb_terr_grupo_laboratorio_crea_tipo_poblacion TPLC ON SC.tipo_poblacion = TPLC.PK_Id_Tabla
	LEFT JOIN tb_parametro_detalle PDTPLC ON TPLC.FK_Id_Categoria = PDTPLC.FK_Value AND PDTPLC.FK_Id_Parametro='37'                                            
	LEFT JOIN tb_parametro_detalle PDTPP ON EDA.FK_Grupo_Poblacional = PDTPP.FK_Value AND PDTPP.FK_Id_Parametro='14'                                            
	LEFT JOIN tb_parametro_detalle PDINST ON SC.FK_Institucion=PDINST.FK_Value AND PDINST.FK_Id_Parametro='36'
	LEFT JOIN tb_terr_grupo_laboratorio_crea_aliado ALIADO ON SC.FK_Aliado=ALIADO.PK_Id_Aliado
	LEFT JOIN tb_parametro_detalle PDTG ON SC.tipo_grupo=PDTG.FK_Value AND PDTG.FK_Id_Parametro='38'
	LEFT JOIN tb_parametro_detalle PDLOCALIADO ON ALIADO.FK_Localidad=PDLOCALIADO.FK_Value AND PDLOCALIADO.FK_Id_Parametro='19'
	LEFT JOIN tb_parametro_detalle PDTD ON PDTD.FK_Value=E.CH_Tipo_Identificacion AND PDTD.FK_Id_Parametro='5'
	LEFT JOIN tb_parametro_detalle PDTDSIMAT ON PDTDSIMAT.FK_Value=E.CH_Tipo_Identificacion AND PDTDSIMAT.FK_Id_Parametro='13'                      
	WHERE SCA.`IN_estado_asistencia`=1 AND SC.`DA_fecha_clase` BETWEEN :fecha_inicio AND :fecha_fin GROUP BY SCA.`FK_estudiante`) T WHERE T.ASISTENCIAS >= :asistencias;";  

	@$sentencia=$this->dbPDO->prepare($sql);
	@$sentencia->bindParam(':anio',$anio);
	@$sentencia->bindParam(':fecha_inicio',$fecha_inicio);
	@$sentencia->bindParam(':fecha_fin',$fecha_fin);
	@$sentencia->bindParam(':asistencias',$asistencias);
	$sentencia->execute();
	return $sentencia->fetchAll(\PDO::FETCH_ASSOC);       
}

public function getSesionesCreaAE($anio, $inicio, $fin)
{
	$mes_inicial = explode("-",$inicio)[0];
	$dia_inicial = explode("-",$inicio)[1];
	$mes_final = explode("-",$fin)[0];
	$dia_final = explode("-",$fin)[1];

	$fecha_inicio = $anio."-".$mes_inicial."-".$dia_inicial;
	$fecha_fin = $anio."-".$mes_final."-".$dia_final;

	$sql="SELECT                                            
	C.`VC_Nom_Clan` AS 'CREA',
	COUNT(SC.`PK_sesion_clase`) AS 'SESIONES'                                          
	FROM tb_terr_grupo_arte_escuela_sesion_clase SC                                         
	JOIN tb_clan C ON SC.`FK_clan`=C.`PK_Id_Clan`                                           
	WHERE YEAR(SC.`DA_fecha_clase`)=:anio AND SC.`IN_lugar_atencion`!=1 AND SC.`DA_fecha_clase` BETWEEN :fecha_inicio AND :fecha_fin GROUP BY SC.FK_clan;";

	@$sentencia=$this->dbPDO->prepare($sql); 
	@$sentencia->bindParam(':anio',$anio);
	@$sentencia->bindParam(':fecha_inicio',$fecha_inicio);
	@$sentencia->bindParam(':fecha_fin',$fecha_fin);
	$sentencia->execute();
	return $sentencia->fetchAll(\PDO::FETCH_ASSOC);       
}

public function getSesionesColegioAE($anio, $inicio, $fin)
{
	$mes_inicial = explode("-",$inicio)[0];
	$dia_inicial = explode("-",$inicio)[1];
	$mes_final = explode("-",$fin)[0];
	$dia_final = explode("-",$fin)[1];

	$fecha_inicio = $anio."-".$mes_inicial."-".$dia_inicial;
	$fecha_fin = $anio."-".$mes_final."-".$dia_final;

	$sql="SELECT                                            
	C.`VC_Nom_Colegio` AS 'COLEGIO',
	COUNT(SC.`PK_sesion_clase`) AS 'SESIONES'                                           
	FROM tb_terr_grupo_arte_escuela_sesion_clase SC                                         
	JOIN tb_colegios C ON SC.`FK_colegio`=C.`PK_Id_Colegio`                                         
	WHERE YEAR(SC.`DA_fecha_clase`)=:anio AND SC.`DA_fecha_clase` BETWEEN :fecha_inicio AND :fecha_fin GROUP BY SC.FK_colegio";

	@$sentencia=$this->dbPDO->prepare($sql); 
	@$sentencia->bindParam(':anio',$anio);
	@$sentencia->bindParam(':fecha_inicio',$fecha_inicio);
	@$sentencia->bindParam(':fecha_fin',$fecha_fin);
	$sentencia->execute();
	return $sentencia->fetchAll(\PDO::FETCH_ASSOC);       
}

public function getSesionesCreaEC($anio, $inicio, $fin)
{
	$mes_inicial = explode("-",$inicio)[0];
	$dia_inicial = explode("-",$inicio)[1];
	$mes_final = explode("-",$fin)[0];
	$dia_final = explode("-",$fin)[1];

	$fecha_inicio = $anio."-".$mes_inicial."-".$dia_inicial;
	$fecha_fin = $anio."-".$mes_final."-".$dia_final;

	$sql="SELECT                                
	C.`VC_Nom_Clan` AS 'CREA',                              
	COUNT(SC.`PK_sesion_clase`) AS 'SESIONES'                              
	FROM tb_terr_grupo_emprende_clan_sesion_clase SC                                
	JOIN tb_clan C ON SC.`FK_clan`=C.`PK_Id_Clan`                               
	WHERE YEAR(SC.`DA_fecha_clase`)=:anio AND SC.`DA_fecha_clase` BETWEEN :fecha_inicio AND :fecha_fin GROUP BY SC.FK_clan;";

	@$sentencia=$this->dbPDO->prepare($sql);
	@$sentencia->bindParam(':anio',$anio);
	@$sentencia->bindParam(':fecha_inicio',$fecha_inicio);
	@$sentencia->bindParam(':fecha_fin',$fecha_fin);
	$sentencia->execute();
	return $sentencia->fetchAll(\PDO::FETCH_ASSOC);       
}

public function getSesionesLC($anio, $inicio, $fin)
{
	$mes_inicial = explode("-",$inicio)[0];
	$dia_inicial = explode("-",$inicio)[1];
	$mes_final = explode("-",$fin)[0];
	$dia_final = explode("-",$fin)[1];

	$fecha_inicio = $anio."-".$mes_inicial."-".$dia_inicial;
	$fecha_fin = $anio."-".$mes_final."-".$dia_final;

	$sql="SELECT                                                
	C.`VC_Nom_Clan` AS 'CREA',
	PDINS.VC_Descripcion AS 'INSTITUCIÓN',
	LCAL.TX_Nombre_Aliado AS 'ALIADO',                                              
	CASE                                                
	WHEN SC.IN_Tipo_Ubicacion = 1 THEN SC.VC_Nom_Clan                                              
	WHEN SC.IN_Tipo_Ubicacion = 2 THEN LCAL.TX_Nombre_Aliado
	WHEN SC.IN_Tipo_Ubicacion = 3 THEN 'DESCENTRALIZADO'
	WHEN SC.IN_Tipo_Ubicacion = 4 THEN 'REMOTO'
	END AS 'Lugar_Atención',                                             
	COUNT(SC.`PK_sesion_clase`) AS 'SESIONES'                                               
	FROM tb_terr_grupo_laboratorio_clan_sesion_clase SC                                             
	LEFT JOIN tb_terr_grupo_laboratorio_crea_aliado LCAL ON LCAL.PK_Id_Aliado =SC.FK_Aliado
	LEFT JOIN tb_parametro_detalle PDINS ON SC.FK_Institucion=PDINS.FK_Value AND PDINS.FK_Id_Parametro='36'
	LEFT JOIN tb_clan C ON C.`PK_Id_Clan`=SC.FK_Clan
	WHERE YEAR(SC.`DA_fecha_clase`)=:anio AND SC.`DA_fecha_clase` BETWEEN :fecha_inicio AND :fecha_fin GROUP BY SC.FK_Aliado,SC.FK_Clan ORDER BY C.VC_Nom_Clan;"; 

	@$sentencia=$this->dbPDO->prepare($sql);
	@$sentencia->bindParam(':anio',$anio);
	@$sentencia->bindParam(':fecha_inicio',$fecha_inicio);
	@$sentencia->bindParam(':fecha_fin',$fecha_fin);
	$sentencia->execute();
	return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function consultarHorarioArtistaFormador($id_artista_formador,$linea_atencion){
	$sql="SELECT
	H.*,
	AA.VC_Nom_Area AS area_artistica,
	CL.VC_Nom_Clan AS nombre_crea,
	CONCAT(P.VC_Primer_Nombre, ' ', P.VC_Segundo_Nombre, ' ', P.VC_Primer_Apellido, ' ', P.VC_Segundo_Apellido) AS artista_formador
	FROM tb_terr_grupo_".$linea_atencion."_horario_clase H 
	LEFT JOIN tb_terr_grupo_".$linea_atencion." G ON G.PK_grupo = H.FK_grupo 
	LEFT JOIN tb_areas_artisticas AA ON G.FK_area_artistica = AA.PK_Area_Artistica 
	LEFT JOIN tb_clan CL ON G.FK_clan = CL.PK_Id_Clan 
	LEFT JOIN tb_persona_2017 P ON G.FK_artista_formador = P.PK_Id_Persona
	WHERE G.FK_artista_formador = :id_artista_formador AND G.estado = 1 
	ORDER BY H.IN_dia,H.TI_hora_inicio_clase";
	@$sentencia=$this->dbPDO->prepare($sql);
	@$sentencia->bindParam(':id_artista_formador',$id_artista_formador);
	$sentencia->execute();
	return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function consultarHorarioCreaAreaEstado($id_crea, $area_artistica, $estado, $linea_atencion){
	$sql="SELECT
	H.*,
	AA.VC_Nom_Area AS area_artistica,
	CL.VC_Nom_Clan AS nombre_crea,
	CONCAT(P.VC_Primer_Nombre, ' ', P.VC_Segundo_Nombre, ' ', P.VC_Primer_Apellido, ' ', P.VC_Segundo_Apellido) AS artista_formador
	FROM tb_terr_grupo_".$linea_atencion."_horario_clase H 
	LEFT JOIN tb_terr_grupo_".$linea_atencion." G ON G.PK_grupo = H.FK_grupo 
	LEFT JOIN tb_areas_artisticas AA ON G.FK_area_artistica = AA.PK_Area_Artistica 
	LEFT JOIN tb_clan CL ON G.FK_clan = CL.PK_Id_Clan 
	LEFT JOIN tb_persona_2017 P ON G.FK_artista_formador = P.PK_Id_Persona
	WHERE YEAR(G.DT_fecha_creacion)= YEAR(CURDATE()) AND G.FK_clan IN (".$id_crea.") AND G.FK_area_artistica IN (".$area_artistica.") AND G.estado = :estado 
	ORDER BY H.IN_dia,H.TI_hora_inicio_clase";
	@$sentencia=$this->dbPDO->prepare($sql);
	//@$sentencia->bindParam(':id_crea',$id_crea);
	//@$sentencia->bindParam(':area_artistica',$area_artistica);
	@$sentencia->bindParam(':estado',$estado);
	$sentencia->execute();
	return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function saveHistoricoPlaneacion($nombre_archivo, $url, $fecha, $usuario){
	$set_id_usuario = $this->dbPDO->prepare("SET @user_id = '".$usuario."';");
	$set_id_usuario->execute();
	$sql="INSERT INTO tb_crea_archivo (FK_Id_Crea, VC_Tipo, VC_Nombre, VC_Url, DA_Subida, FK_Usuario) VALUES ('27', 'PLANEACIÓN', :nombre_archivo, :url, :fecha, :usuario)";
	@$sentencia=$this->dbPDO->prepare($sql);
	@$sentencia->bindParam(':nombre_archivo',$nombre_archivo);
	@$sentencia->bindParam(':url',$url);
	@$sentencia->bindParam(':fecha',$fecha);
	@$sentencia->bindParam(':usuario',$usuario);
	$sentencia->execute();
	$id_insertado = $this->dbPDO->lastInsertId();
}

public function getHistoricoPlaneacion(){
	$sql="SELECT * FROM tb_crea_archivo CA WHERE CA.VC_Tipo ='PLANEACIÓN' ORDER BY CA.DA_Subida DESC";

	@$sentencia=$this->dbPDO->prepare($sql);
	$sentencia->execute();
	return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function eliminarReportePlaneacion($id_registro,$usuario){
	$set_id_usuario = $this->dbPDO->prepare("SET @user_id = '".$usuario."';");
	$sentencia = $this->dbPDO->prepare("DELETE FROM tb_crea_archivo WHERE PK_Id_Tabla=:id_registro");
	try {
		$this->dbPDO->beginTransaction();
		$set_id_usuario->execute();
		$sentencia->bindParam(':id_registro', $id_registro);
		$sentencia->execute();

		$this->dbPDO->commit();
		return 1;
	}catch(PDOExecption $e) {
		$this->dbPDO->rollback();
		return "Error!: " . $e->getMessage() . "</br>";
	}
}

public function getAsignaciones($tipo_grupo,$anio,$mesd,$mesh){
	if($tipo_grupo=="arte_escuela")$tipo="AE";
	else if($tipo_grupo=="emprende_clan")$tipo="IC";
	else $tipo="CV";
	$sql="SELECT 
	CONCAT('".$tipo."-',AF.FK_grupo) AS grupo,
	C.VC_Nom_Clan as crea,
	CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido) AS nombre_AF, 
	P.VC_Celular as celular_AF,
	P.VC_Correo as correo_AF, 
	AF.DT_fecha_asignacion_grupo as fecha_asignacion_AF,
	CONCAT(AAU.VC_Primer_Nombre,' ',AAU.VC_Segundo_Nombre,' ',AAU.VC_Primer_Apellido,' ',AAU.VC_Segundo_Apellido) AS usuario_asignó_AF,
	O.VC_Nom_Organizacion as organización,
	GO.DT_fecha_asignacion_grupo as fecha_asignación_organización,
	CONCAT(AAO.VC_Primer_Nombre,' ',AAO.VC_Segundo_Nombre,' ',AAO.VC_Primer_Apellido,' ',AAO.VC_Segundo_Apellido) AS usuario_asignó_organización
	from tb_terr_grupo_".$tipo_grupo."_artista_formador as AF 
	LEFT join tb_persona_2017 as P on P.PK_Id_Persona=AF.FK_artista_formador
	LEFT join tb_persona_2017 as AAU on AAU.PK_Id_Persona=AF.FK_usuario_asigno
	LEFT join tb_terr_grupo_".$tipo_grupo." as G on G.PK_Grupo=AF.FK_grupo
	LEFT join tb_terr_grupo_".$tipo_grupo."_organizacion as GO on GO.FK_grupo=G.PK_Grupo
	LEFT join tb_persona_2017 as AAO on AAO.PK_Id_Persona=GO.FK_usuario_asigno
	LEFT join tb_organizaciones_2017 as O on O.PK_Id_Organizacion=GO.FK_organizacion
	LEFT JOIN tb_clan as C on G.FK_clan=C.PK_Id_Clan
	WHERE YEAR(AF.DT_fecha_asignacion_grupo)= :anio  AND MONTH(AF.DT_fecha_asignacion_grupo)>= :mesd AND MONTH(AF.DT_fecha_asignacion_grupo)<= :mesf ";

	@$sentencia=$this->dbPDO->prepare($sql);
	@$sentencia->bindParam(':anio',$anio);
	@$sentencia->bindParam(':mesd',$mesd);
	@$sentencia->bindParam(':mesf',$mesh);

	$sentencia->execute();
	//$sentencia->debugDumpParams();
	return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public  function getGestionUsuarios($anio,$mesd,$mesh){
	$sql="
	SELECT 
	P.VC_Identificacion as documento,
	PD.VC_Descripcion as tipo_documento,
	PDX.VC_Descripcion as rol,
	O.VC_Nom_Organizacion AS organizacion,
	(SELECT
	GROUP_CONCAT(";

	if($anio >= 2018) {
		$sql = $sql . "DISTINCT FO.`VC_Perfil`)
		FROM `tb_af_organizacion_area_artistica` AS FO
		WHERE FO.`FK_Id_Persona`= P.PK_Id_Persona and FO.IN_Estado=1";
	}
	else {
		$sql = $sql . "
		/*SELECT
		GROUP_CONCAT(COALESCE(FO.`VC_Perfil`,''))
		FROM `tb_formador_organizacion_2017` AS FO
		WHERE  FO.`FK_Id_Persona`=P.PK_Id_Persona*/";
	}

	$sql = $sql . 
	") AS 'perfil',	
	CONCAT(P.`VC_Primer_Nombre`,' ',P.`VC_Segundo_Nombre`,' ',P.`VC_Primer_Apellido`,' ',P.`VC_Segundo_Apellido`) AS nombre_usuario,
	P.VC_Celular AS telefono, 
	P.VC_Correo AS correo,
	(
	SELECT GROUP_CONCAT(DISTINCT AA.VC_Nom_Area)
	FROM `tb_af_organizacion_area_artistica` AS FO
	JOIN tb_areas_artisticas AS AA ON AA.PK_Area_Artistica=FO.FK_Area_Artistica
	WHERE FO.`FK_Id_Persona`=P.PK_Id_Persona AND FO.IN_Estado=1
	) AS areas_artisticas,
	P.DA_Fecha_Registro AS fecha_registro,
	CONCAT(AAU.`VC_Primer_Nombre`,' ',AAU.`VC_Segundo_Nombre`,' ',AAU.`VC_Primer_Apellido`,' ',AAU.`VC_Segundo_Apellido`) AS usuario_registro,
	GROUP_CONCAT(TPO2.observacion) AS acciones,
	CASE WHEN TAU.IN_Estado = 1 THEN 'Activo' ELSE 'Inactivo' END AS estado,
	CASE 
	WHEN TPO.DT_fecha IS NULL THEN P.DA_Fecha_Registro 
	ELSE TPO.DT_fecha 
	END AS 'fecha_actualizacion',
	CONCAT(AAO.`VC_Primer_Nombre`,' ',AAO.`VC_Segundo_Nombre`,' ',AAO.`VC_Primer_Apellido`,' ',AAO.`VC_Segundo_Apellido`) AS usuario_actualizacion
	FROM tb_persona_2017 AS P
	JOIN tb_persona_2017 AS AAU ON AAU.PK_Id_Persona=P.Id_Usuario_Registro
	JOIN tb_parametro_detalle PD ON PD.fk_id_parametro=13 AND PD.FK_Value=P.FK_Tipo_Identificacion
	JOIN tb_parametro_detalle PDX ON PDX.fk_id_parametro IN (2,3,4) AND PDX.FK_Value=P.FK_Tipo_Persona
	LEFT JOIN tb_af_organizacion_area_artistica OP ON OP.FK_Id_Persona = P.PK_Id_Persona
	LEFT JOIN tb_organizaciones_2017 O ON O.PK_Id_Organizacion = OP.FK_Organizacion
	LEFT JOIN tb_persona_observacion TPO2 ON P.PK_Id_Persona = TPO2.id_persona
	left JOIN (select tpo.* from tb_persona_observacion tpo
	JOIN 
	(
	select id_persona,MAX(DT_fecha) DT_fecha from tb_persona_observacion 
	group by id_persona
	) tpot
	ON tpot.id_persona = tpo.id_persona AND tpot.DT_fecha = tpo.DT_fecha ) TPO ON TPO.id_persona = P.PK_Id_Persona
	JOIN tb_acceso_usuario_2017 TAU ON P.PK_Id_Persona = TAU.FK_Id_Persona
	left JOIN tb_persona_2017 AS AAO ON AAO.PK_Id_Persona=TPO.id_quien_hace_observacion	
	WHERE
	(YEAR(P.DA_Fecha_Registro)= :anio AND MONTH(P.DA_Fecha_Registro)>= :mesd AND MONTH(P.DA_Fecha_Registro)<= :mesf) OR ((YEAR(TPO.DT_fecha)= :anio AND MONTH(TPO.DT_fecha)>= :mesd AND MONTH(TPO.DT_fecha)<= :mesf) AND (YEAR(TPO2.DT_fecha)= :anio AND MONTH(TPO2.DT_fecha)>= :mesd AND MONTH(TPO2.DT_fecha)<= :mesf))
	GROUP BY P.PK_Id_Persona";
	@$sentencia=$this->dbPDO->prepare($sql);
	@$sentencia->bindParam(':anio',$anio);
	@$sentencia->bindParam(':mesd',$mesd);
	@$sentencia->bindParam(':mesf',$mesh);

	$sentencia->execute();
	//$sentencia->debugDumpParams();
	return $sentencia->fetchAll(\PDO::FETCH_ASSOC);	
}

public function getConsultaCentroMonitoreo($objeto){
	$sql="SELECT CM.TX_sql, CM.VC_filtros FROM tb_centro_monitoreo CM WHERE CM.VC_numeral =:numeral";
	@$sentencia=$this->dbPDO->prepare($sql);
	@$sentencia->bindParam(':numeral',$objeto->getVcNumeral());
	$sentencia->execute();
	return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}


public function getPanelCentroMonitoreo($objeto){
	$where="";

	if($objeto->getFkTipoIndicador()!=""){
		$where=" AND CM.FK_tipo_indicador=:fk_tipo_indicador ";
	}
	if($objeto->getInestado()!=""){
		$where=" AND CM.IN_estado=:IN_estado ";
	}		

	$sql="SELECT CM.*, PD.VC_Descripcion AS 'Nombre_Indicador' FROM tb_centro_monitoreo CM LEFT JOIN tb_parametro_detalle PD ON PD.FK_Value=CM.FK_tipo_indicador AND PD.FK_Id_Parametro=40 WHERE CM.IN_seccion=:in_seccion  ".$where." ORDER BY CM.VC_numeral"; 
	@$sentencia=$this->dbPDO->prepare($sql);
	@$sentencia->bindParam(':in_seccion',$objeto->getInSeccion());
	if($objeto->getFkTipoIndicador()!=""){
		@$sentencia->bindParam(':fk_tipo_indicador',$objeto->getFkTipoIndicador());
	}
	if($objeto->getInestado()!=""){
		@$sentencia->bindParam(':IN_estado',$objeto->getInestado());
	}		
	$sentencia->execute();
	return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

//este método recibe tanto el sql como el set de variables.
public function executeSql($sql, $valores_filtros){
	$consulta=$sql[0]['TX_sql'];

	if($valores_filtros != null){
		$filtros=explode(",", $valores_filtros);
		$sqlSET="";
		for($i=0; $i<count($filtros);$i++){
			if($filtros[$i]!=""){				
				$valor = explode(":",$filtros[$i]);
				// if($valor[0] == 'SL_LINEA_CREA' AND strlen($valor[1] > 1)){
				// 	$valor[1] = '1,2,3';
				// }
				$sqlSET="SET @".$valor[0]."=".$valor[1].";";
				$set_variables = $this->dbPDO->prepare($sqlSET);
				$set_variables->execute();
			}
		}	
	}
	$consultas = explode(";", $consulta); 
	$sentencia=null;
	for($i=0; $i<count($consultas);$i++){
		//echo $consultas[$i].'<br>'; 
		if($consultas[$i]!=""){
			@$sentencia=$this->dbPDO->prepare($consultas[$i]); 
			$sentencia->execute();
		}
	} 
	//@$sentencia=$this->dbPDO->prepare($consulta); 
	//$sentencia->execute();
	return $sentencia->fetchAll(\PDO::FETCH_ASSOC);	
} 


public function saveTipoIndicador($objeto){
	$sql="INSERT tb_centro_monitoreo 
	(VC_numeral,VC_titulo,TX_descripcion,IN_seccion,FK_tipo_indicador,VC_icono,VC_tipo_grafico,TX_sql,VC_filtros,IN_estado)
	VALUES
	(:VC_numeral,:VC_titulo,:TX_descripcion,:IN_seccion,:FK_tipo_indicador,:VC_icono,:VC_tipo_grafico,:TX_sql,:VC_filtros,:IN_estado)";
	@$sentencia=$this->dbPDO->prepare($sql);
	@$sentencia->bindParam(':VC_numeral',$objeto->getVcNumeral());
	@$sentencia->bindParam(':VC_titulo',$objeto->getVcTitulo());
	@$sentencia->bindParam(':TX_descripcion',$objeto->getTxDescripcion());
	@$sentencia->bindParam(':IN_seccion',$objeto->getInSeccion());
	@$sentencia->bindParam(':FK_tipo_indicador',$objeto->getFkTipoIndicador());
	@$sentencia->bindParam(':VC_icono',$objeto->getVcIcono());
	@$sentencia->bindParam(':VC_tipo_grafico',$objeto->getVcTipoGrafico());
	@$sentencia->bindParam(':TX_sql',$objeto->getTxSql());
	@$sentencia->bindParam(':VC_filtros',$objeto->getVcFiltros());
	@$sentencia->bindParam(':IN_estado',$objeto->getInEstado());    
	$sentencia->execute();
	return  $this->dbPDO->lastInsertId();
}

public function updateTipoIndicador($objeto){
	$sql="UPDATE tb_centro_monitoreo SET 
	VC_numeral=:VC_numeral,
	VC_titulo=:VC_titulo,
	TX_descripcion=:TX_descripcion,
	IN_seccion=:IN_seccion,
	FK_tipo_indicador=:FK_tipo_indicador,
	VC_icono=:VC_icono,
	VC_tipo_grafico=:VC_tipo_grafico,
	TX_sql=:TX_sql,
	VC_filtros=:VC_filtros,
	IN_estado=:IN_estado
	WHERE PK_id_centro_monitoreo=:PK_id_centro_monitoreo";

	$sentencia=$this->dbPDO->prepare($sql);
	@$sentencia->bindParam(':VC_numeral',$objeto->getVcNumeral());
	@$sentencia->bindParam(':VC_titulo',$objeto->getVcTitulo());
	@$sentencia->bindParam(':TX_descripcion',$objeto->getTxDescripcion());
	@$sentencia->bindParam(':IN_seccion',$objeto->getInSeccion());
	@$sentencia->bindParam(':FK_tipo_indicador',$objeto->getFkTipoIndicador());
	@$sentencia->bindParam(':VC_icono',$objeto->getVcIcono());
	@$sentencia->bindParam(':VC_tipo_grafico',$objeto->getVcTipoGrafico());
	@$sentencia->bindParam(':TX_sql',$objeto->getTxSql());
	@$sentencia->bindParam(':VC_filtros',$objeto->getVcFiltros());
	@$sentencia->bindParam(':IN_estado',$objeto->getInEstado());    
	@$sentencia->bindParam(':PK_id_centro_monitoreo',$objeto->getPKIdCentroMonitoreo());  
	$sentencia->execute(); 
	return $sentencia->rowCount();  	
}

public function getAsistenciasMesConvenioSeguridad_0810_2019($mes, $anio){
	$sql="CALL sp_consulta_asistencia_convenio_seguridad_0810(:mes, :anio)";  
	@$sentencia=$this->dbPDO->prepare($sql); 
	@$sentencia->bindParam(':mes',$mes);  
	@$sentencia->bindParam(':anio',$anio);       
	$sentencia->execute();          
		//$sentencia->debugDumpParams();
	return $sentencia->fetchAll(\PDO::FETCH_ASSOC); 
}

public function getBeneficariosAliadosConvenio_0810_2019($mes_desde, $mes_hasta){
	$sql="SELECT
	ALIADO.PK_Id_Aliado AS 'ID_ALIADO',
	ALIADO.TX_Nombre_Aliado AS 'ALIADO',
	COUNT(DISTINCT SCA.FK_estudiante) AS 'BENEFICIARIOS',
	COUNT(DISTINCT SCA.FK_sesion_clase) AS 'SESIONES'
	FROM tb_terr_grupo_laboratorio_clan_sesion_clase SS 
	LEFT JOIN tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia SCA ON SCA.FK_sesion_clase=SS.PK_sesion_clase
	LEFT JOIN tb_terr_grupo_laboratorio_crea_aliado ALIADO ON ALIADO.PK_Id_Aliado=SS.FK_Aliado
	WHERE SS.tipo_grupo=6 AND SCA.IN_estado_asistencia=1 AND MONTH(SS.DA_fecha_clase)>=:mes_desde AND MONTH(SS.DA_fecha_clase)<=:mes_hasta AND YEAR(SS.DA_fecha_clase)='2019'
	GROUP BY SS.FK_Aliado";
	@$sentencia=$this->dbPDO->prepare($sql);
	@$sentencia->bindParam(':mes_desde',$mes_desde);
	@$sentencia->bindParam(':mes_hasta',$mes_hasta);
	$sentencia->execute();
	return $sentencia->fetchAll(\PDO::FETCH_ASSOC);
}

public function getTotalGruposClan($creas,$anios)
{
	$sql="(SELECT
	tt.*,
	SUM(IF(tt.MES='01', tt.ATENDIDOS, 0)) AS 'AtendidosEnero',
	SUM(IF(tt.MES='01', tt.REPORTADOS, 0)) AS 'TotalReportadosEnero',
	SUM(IF(tt.MES='01', tt.PORCENTAJE, 0)) AS 'PorcentajeEnero',
	SUM(IF(tt.MES='02', tt.ATENDIDOS, 0)) AS 'AtendidosFebrero',
	SUM(IF(tt.MES='02', tt.REPORTADOS, 0)) AS 'TotalReportadosFebrero',
	SUM(IF(tt.MES='02', tt.PORCENTAJE, 0)) AS 'PorcentajeFebrero',
	SUM(IF(tt.MES='03', tt.ATENDIDOS, 0)) AS 'AtendidosMarzo',
	SUM(IF(tt.MES='03', tt.REPORTADOS, 0)) AS 'TotalReportadosMarzo',
	SUM(IF(tt.MES='03', tt.PORCENTAJE, 0)) AS 'PorcentajeMarzo',
	SUM(IF(tt.MES='04', tt.ATENDIDOS, 0)) AS 'AtendidosAbril',
	SUM(IF(tt.MES='04', tt.REPORTADOS, 0)) AS 'TotalReportadosAbril',
	SUM(IF(tt.MES='04', tt.PORCENTAJE, 0)) AS 'PorcentajeAbril',
	SUM(IF(tt.MES='05', tt.ATENDIDOS, 0)) AS 'AtendidosMayo',
	SUM(IF(tt.MES='05', tt.REPORTADOS, 0)) AS 'TotalReportadosMayo',
	SUM(IF(tt.MES='05', tt.PORCENTAJE, 0)) AS 'PorcentajeMayo',
	SUM(IF(tt.MES='06', tt.ATENDIDOS, 0)) AS 'AtendidosJunio',
	SUM(IF(tt.MES='06', tt.REPORTADOS, 0)) AS 'TotalReportadosJunio',
	SUM(IF(tt.MES='06', tt.PORCENTAJE, 0)) AS 'PorcentajeJunio',
	SUM(IF(tt.MES='07', tt.ATENDIDOS, 0)) AS 'AtendidosJulio',
	SUM(IF(tt.MES='07', tt.REPORTADOS, 0)) AS 'TotalReportadosJulio',
	SUM(IF(tt.MES='07', tt.PORCENTAJE, 0)) AS 'PorcentajeJulio',
	SUM(IF(tt.MES='08', tt.ATENDIDOS, 0)) AS 'AtendidosAgosto',
	SUM(IF(tt.MES='08', tt.REPORTADOS, 0)) AS 'TotalReportadosAgosto',
	SUM(IF(tt.MES='08', tt.PORCENTAJE, 0)) AS 'PorcentajeAgosto',
	SUM(IF(tt.MES='09', tt.ATENDIDOS, 0)) AS 'AtendidosSeptiembre',
	SUM(IF(tt.MES='09', tt.REPORTADOS, 0)) AS 'TotalReportadosSeptiembre',
	SUM(IF(tt.MES='09', tt.PORCENTAJE, 0)) AS 'PorcentajeSeptiembre',
	SUM(IF(tt.MES='10', tt.ATENDIDOS, 0)) AS 'AtendidosOctubre',
	SUM(IF(tt.MES='10', tt.REPORTADOS, 0)) AS 'TotalReportadosOctubre',
	SUM(IF(tt.MES='10', tt.PORCENTAJE, 0)) AS 'PorcentajeOctubre',
	SUM(IF(tt.MES='11', tt.ATENDIDOS, 0)) AS 'AtendidosNoviembre',
	SUM(IF(tt.MES='11', tt.REPORTADOS, 0)) AS 'TotalReportadosNoviembre',
	SUM(IF(tt.MES='11', tt.PORCENTAJE, 0)) AS 'PorcentajeNoviembre',
	SUM(IF(tt.MES='12', tt.ATENDIDOS, 0)) AS 'AtendidosDiciembre',
	SUM(IF(tt.MES='12', tt.REPORTADOS, 0)) AS 'TotalReportadosDiciembre',
	SUM(IF(tt.MES='12', tt.PORCENTAJE, 0)) AS 'PorcentajeDiciembre',
	(
	SELECT COUNT(DISTINCT SCAAT.FK_estudiante)
	FROM tb_terr_grupo_laboratorio_clan_sesion_clase SCT
	JOIN tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia SCAAT ON SCAAT.FK_sesion_clase=SCT.PK_sesion_clase AND SCAAT.IN_estado_asistencia=1
	WHERE SCT.FK_grupo=tt.grupo AND YEAR(SCT.DA_fecha_clase)=:anios
	) AS 'total_atendidos',
	(
	SELECT 
	COUNT(DISTINCT SCAAT.FK_estudiante)
	FROM tb_terr_grupo_laboratorio_clan_sesion_clase SCT
	JOIN tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia SCAAT ON SCAAT.FK_sesion_clase=SCT.PK_sesion_clase AND SCAAT.IN_estado_asistencia=1
	JOIN tb_estudiante E ON SCAAT.FK_estudiante=E.id
	WHERE SCT.FK_grupo=tt.grupo AND E.CH_Genero='M' AND YEAR(SCT.DA_fecha_clase)=:anios
	) AS 'atendidos_hombres',
	(
	SELECT
	COUNT(DISTINCT SCAAT.FK_estudiante)
	FROM tb_terr_grupo_laboratorio_clan_sesion_clase SCT
	JOIN tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia SCAAT ON SCAAT.FK_sesion_clase=SCT.PK_sesion_clase AND SCAAT.IN_estado_asistencia=1
	JOIN tb_estudiante E ON SCAAT.FK_estudiante=E.id
	WHERE SCT.FK_grupo=tt.grupo AND E.CH_Genero='F' AND YEAR(SCT.DA_fecha_clase)=:anios
	) AS 'atendidos_mujeres',
	(
	SELECT
	COUNT(DISTINCT SCAAT.FK_estudiante)
	FROM tb_terr_grupo_laboratorio_clan_sesion_clase SCT
	JOIN tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia SCAAT ON SCAAT.FK_sesion_clase=SCT.PK_sesion_clase AND SCAAT.IN_estado_asistencia=1
	JOIN tb_estudiante E ON SCAAT.FK_estudiante=E.id
	WHERE SCT.FK_grupo=tt.grupo AND E.CH_Genero != 'M' AND E.CH_Genero != 'F' AND YEAR(SCT.DA_fecha_clase)=:anios
	) AS 'atendidos_sin_genero',
	(
	SELECT COUNT(DISTINCT SCART.FK_estudiante)
	FROM tb_terr_grupo_laboratorio_clan_sesion_clase SCT
	JOIN tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia SCART ON SCART.FK_sesion_clase=SCT.PK_sesion_clase
	WHERE SCT.FK_grupo=tt.grupo AND YEAR(SCT.DA_fecha_clase)=:anios
	) AS 'total_reportados'
FROM
(
SELECT  
	CONCAT('CV-',LC.PK_Grupo) AS 'grupo',
	LC.modalidad_atencion,
	C.VC_Nom_Clan AS 'crea', 
	AA.VC_Descripcion AS 'area',
	PD_TIPO_GRUPO.VC_Descripcion AS 'tipo_grupo',
	PDINS.VC_Descripcion AS 'institucion',
	'No aplica' AS 'grados',
	O.VC_Nom_Organizacion AS 'organizacion',
	CONCAT(AF.VC_Primer_Nombre,' ',AF.VC_Segundo_Nombre,' ',AF.VC_Primer_Apellido,' ',AF.VC_Segundo_Apellido) AS 'artista_formador',
		CASE
	WHEN LC.IN_lugar_atencion=1 THEN C.VC_Nom_Clan
	WHEN LC.IN_lugar_atencion=2 THEN ALIADO.TX_Nombre_Aliado
	WHEN LC.IN_lugar_atencion=3 THEN 'DESCENTRALIZADO'
	END AS 'lugar_atencion',	
	LC.DT_fecha_creacion AS 'fecha_creacion',
	CONCAT(ABRIO.VC_Primer_Nombre,' ',ABRIO.VC_Segundo_Nombre,' ',ABRIO.VC_Primer_Apellido,' ',ABRIO.VC_Segundo_Apellido) AS 'abrio',
	(
	SELECT
	GROUP_CONCAT( 
	CONCAT(
	(
	CASE 
	WHEN HC.IN_dia=1 THEN 'Lunes'
	WHEN HC.IN_dia=2 THEN 'Martes'
	WHEN HC.IN_dia=3 THEN 'Miercoles'
	WHEN HC.IN_dia=4 THEN 'Jueves'
	WHEN HC.IN_dia=5 THEN 'Viernes'
	WHEN HC.IN_dia=6 THEN 'Sabado'
	WHEN HC.IN_dia=7 THEN 'Domingo'
	END
	),' (',HC.TI_hora_inicio_clase,' a ',HC.TI_hora_fin_clase,')')) 
	FROM tb_terr_grupo_laboratorio_clan_horario_clase AS HC 
	WHERE HC.FK_grupo=LC.PK_Grupo
	) AS 'horario',
	(
	SELECT COUNT(*)
	FROM tb_terr_grupo_laboratorio_clan_estudiante GE
	WHERE GE.FK_grupo=LC.PK_Grupo AND GE.estado=1
	) AS 'estudiante',
	LC.TX_observaciones AS 'observaciones',
	(
	CASE
	WHEN LC.estado=1 THEN 'Activo'
	WHEN LC.estado=0 THEN 'Inactivo'
	END  
	) AS 'estado',
	LC.DT_fecha_cierre AS 'fecha_cierre',
	CONCAT(CERRO.VC_Primer_Nombre,' ',CERRO.VC_Segundo_Nombre,' ',CERRO.VC_Primer_Apellido,' ',CERRO.VC_Segundo_Apellido) AS 'cerro',
	COUNT(DISTINCT SCAA.FK_estudiante) AS 'ATENDIDOS',
	COUNT(DISTINCT SCAR.FK_estudiante) AS 'REPORTADOS',
	COALESCE(ROUND(((COUNT(DISTINCT SCAA.FK_estudiante)/COUNT(DISTINCT SCAR.FK_estudiante))*100),2),0) AS PORCENTAJE,
	MONTH(SC.DA_fecha_clase) AS 'MES',
	YEAR(SC.DA_fecha_clase) AS 'ANIO',
	CONV.VC_Descripcion AS 'CONVENIO'
	FROM tb_terr_grupo_laboratorio_clan AS LC
	JOIN tb_clan AS C ON C.PK_Id_Clan=LC.FK_clan
	LEFT JOIN tb_parametro_detalle PD_LOC_CREA ON PD_LOC_CREA.FK_Value = C.FK_Id_Localidad AND PD_LOC_CREA.FK_Id_Parametro='19'
	LEFT JOIN tb_parametro_detalle AS AA ON AA.FK_Value=LC.FK_area_artistica AND AA.FK_Id_Parametro = 6
	LEFT JOIN tb_parametro_detalle AS LA ON LA.FK_Value=LC.FK_lugar_atencion AND LA.FK_Id_Parametro = 28 AND LA.IN_Estado = 1
	LEFT JOIN tb_organizaciones_2017 AS O ON O.PK_Id_Organizacion=LC.FK_organizacion
	LEFT JOIN tb_persona_2017 AS AF on AF.PK_Id_Persona=LC.FK_artista_formador
	LEFT JOIN tb_persona_2017 AS CERRO on CERRO.PK_Id_Persona=LC.FK_quien_cerro
	LEFT JOIN tb_persona_2017 AS ABRIO on ABRIO.PK_Id_Persona=LC.FK_creador
	LEFT JOIN tb_terr_grupo_laboratorio_crea_aliado ALIADO ON LC.FK_Aliado = ALIADO.PK_Id_Aliado
	LEFT JOIN tb_parametro_detalle PDLOCALIADO ON ALIADO.FK_Localidad=PDLOCALIADO.FK_Value AND PDLOCALIADO.FK_Id_Parametro='19'
	LEFT JOIN tb_terr_grupo_laboratorio_crea_tipo_poblacion LCTP ON LC.tipo_poblacion = LCTP.PK_Id_Tabla
	LEFT JOIN tb_parametro_detalle PDTP ON LCTP.FK_Id_Categoria=PDTP.FK_Value AND PDTP.FK_Id_Parametro='37'
	LEFT JOIN tb_parametro_detalle PDINS ON LC.FK_Institucion=PDINS.FK_Value AND PDINS.FK_Id_Parametro='36'
	LEFT JOIN tb_parametro_detalle PD_TIPO_GRUPO ON LC.tipo_grupo=PD_TIPO_GRUPO.FK_Value AND PD_TIPO_GRUPO.FK_Id_Parametro='38'
	LEFT JOIN tb_terr_grupo_laboratorio_clan_sesion_clase SC ON SC.FK_grupo=LC.PK_Grupo AND YEAR(SC.DA_fecha_clase)=:anios
	LEFT JOIN tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia SCAA ON SCAA.FK_sesion_clase=SC.PK_sesion_clase AND SCAA.IN_estado_asistencia=1
	LEFT JOIN tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia SCAR ON SCAR.FK_sesion_clase=SC.PK_sesion_clase
	LEFT JOIN tb_parametro_detalle AS CONV ON CONV.FK_Value=LC.IN_convenio AND CONV.FK_Id_Parametro = 68
	WHERE FIND_IN_SET(LC.FK_clan,:creas)  AND FIND_IN_SET(YEAR(LC.DT_fecha_creacion),:anios)
	GROUP BY LC.PK_Grupo, MONTH(SC.DA_fecha_clase)) AS tt
	GROUP BY tt.grupo)
	UNION
	(SELECT
	tt.*,
	SUM(IF(tt.MES='01', tt.ATENDIDOS, 0)) AS 'AtendidosEnero',
	SUM(IF(tt.MES='01', tt.REPORTADOS, 0)) AS 'TotalReportadosEnero',
	SUM(IF(tt.MES='01', tt.PORCENTAJE, 0)) AS 'PorcentajeEnero',
	SUM(IF(tt.MES='02', tt.ATENDIDOS, 0)) AS 'AtendidosFebrero',
	SUM(IF(tt.MES='02', tt.REPORTADOS, 0)) AS 'TotalReportadosFebrero',
	SUM(IF(tt.MES='02', tt.PORCENTAJE, 0)) AS 'PorcentajeFebrero',
	SUM(IF(tt.MES='03', tt.ATENDIDOS, 0)) AS 'AtendidosMarzo',
	SUM(IF(tt.MES='03', tt.REPORTADOS, 0)) AS 'TotalReportadosMarzo',
	SUM(IF(tt.MES='03', tt.PORCENTAJE, 0)) AS 'PorcentajeMarzo',
	SUM(IF(tt.MES='04', tt.ATENDIDOS, 0)) AS 'AtendidosAbril',
	SUM(IF(tt.MES='04', tt.REPORTADOS, 0)) AS 'TotalReportadosAbril',
	SUM(IF(tt.MES='04', tt.PORCENTAJE, 0)) AS 'PorcentajeAbril',
	SUM(IF(tt.MES='05', tt.ATENDIDOS, 0)) AS 'AtendidosMayo',
	SUM(IF(tt.MES='05', tt.REPORTADOS, 0)) AS 'TotalReportadosMayo',
	SUM(IF(tt.MES='05', tt.PORCENTAJE, 0)) AS 'PorcentajeMayo',
	SUM(IF(tt.MES='06', tt.ATENDIDOS, 0)) AS 'AtendidosJunio',
	SUM(IF(tt.MES='06', tt.REPORTADOS, 0)) AS 'TotalReportadosJunio',
	SUM(IF(tt.MES='06', tt.PORCENTAJE, 0)) AS 'PorcentajeJunio',
	SUM(IF(tt.MES='07', tt.ATENDIDOS, 0)) AS 'AtendidosJulio',
	SUM(IF(tt.MES='07', tt.REPORTADOS, 0)) AS 'TotalReportadosJulio',
	SUM(IF(tt.MES='07', tt.PORCENTAJE, 0)) AS 'PorcentajeJulio',
	SUM(IF(tt.MES='08', tt.ATENDIDOS, 0)) AS 'AtendidosAgosto',
	SUM(IF(tt.MES='08', tt.REPORTADOS, 0)) AS 'TotalReportadosAgosto',
	SUM(IF(tt.MES='08', tt.PORCENTAJE, 0)) AS 'PorcentajeAgosto',
	SUM(IF(tt.MES='09', tt.ATENDIDOS, 0)) AS 'AtendidosSeptiembre',
	SUM(IF(tt.MES='09', tt.REPORTADOS, 0)) AS 'TotalReportadosSeptiembre',
	SUM(IF(tt.MES='09', tt.PORCENTAJE, 0)) AS 'PorcentajeSeptiembre',
	SUM(IF(tt.MES='10', tt.ATENDIDOS, 0)) AS 'AtendidosOctubre',
	SUM(IF(tt.MES='10', tt.REPORTADOS, 0)) AS 'TotalReportadosOctubre',
	SUM(IF(tt.MES='10', tt.PORCENTAJE, 0)) AS 'PorcentajeOctubre',
	SUM(IF(tt.MES='11', tt.ATENDIDOS, 0)) AS 'AtendidosNoviembre',
	SUM(IF(tt.MES='11', tt.REPORTADOS, 0)) AS 'TotalReportadosNoviembre',
	SUM(IF(tt.MES='11', tt.PORCENTAJE, 0)) AS 'PorcentajeNoviembre',
	SUM(IF(tt.MES='12', tt.ATENDIDOS, 0)) AS 'AtendidosDiciembre',
	SUM(IF(tt.MES='12', tt.REPORTADOS, 0)) AS 'TotalReportadosDiciembre',
	SUM(IF(tt.MES='12', tt.PORCENTAJE, 0)) AS 'PorcentajeDiciembre',
	(
	SELECT COUNT(DISTINCT SCAAT.FK_estudiante)
	FROM tb_terr_grupo_emprende_clan_sesion_clase SCT
	JOIN tb_terr_grupo_emprende_clan_sesion_clase_asistencia SCAAT ON SCAAT.FK_sesion_clase=SCT.PK_sesion_clase AND SCAAT.IN_estado_asistencia=1
	WHERE SCT.FK_grupo=tt.grupo AND YEAR(SCT.DA_fecha_clase)=:anios
	) AS 'total_atendidos',
	(
	SELECT 
	COUNT(DISTINCT SCAAT.FK_estudiante)
	FROM tb_terr_grupo_emprende_clan_sesion_clase SCT
	JOIN tb_terr_grupo_emprende_clan_sesion_clase_asistencia SCAAT ON SCAAT.FK_sesion_clase=SCT.PK_sesion_clase AND SCAAT.IN_estado_asistencia=1
	JOIN tb_estudiante E ON SCAAT.FK_estudiante=E.id
	WHERE SCT.FK_grupo=tt.grupo AND E.CH_Genero='M' AND YEAR(SCT.DA_fecha_clase)=:anios
	) AS 'atendidos_hombres',
	(
	SELECT
	COUNT(DISTINCT SCAAT.FK_estudiante)
	FROM tb_terr_grupo_emprende_clan_sesion_clase SCT
	JOIN tb_terr_grupo_emprende_clan_sesion_clase_asistencia SCAAT ON SCAAT.FK_sesion_clase=SCT.PK_sesion_clase AND SCAAT.IN_estado_asistencia=1
	JOIN tb_estudiante E ON SCAAT.FK_estudiante=E.id
	WHERE SCT.FK_grupo=tt.grupo AND E.CH_Genero='F' AND YEAR(SCT.DA_fecha_clase)=:anios
	) AS 'atendidos_mujeres',
	(
	SELECT
	COUNT(DISTINCT SCAAT.FK_estudiante)
	FROM tb_terr_grupo_emprende_clan_sesion_clase SCT
	JOIN tb_terr_grupo_emprende_clan_sesion_clase_asistencia SCAAT ON SCAAT.FK_sesion_clase=SCT.PK_sesion_clase AND SCAAT.IN_estado_asistencia=1
	JOIN tb_estudiante E ON SCAAT.FK_estudiante=E.id
	WHERE SCT.FK_grupo=tt.grupo AND E.CH_Genero != 'M' AND E.CH_Genero != 'F' AND YEAR(SCT.DA_fecha_clase)=:anios
	) AS 'atendidos_sin_genero',
	(
	SELECT COUNT(DISTINCT SCART.FK_estudiante)
	FROM tb_terr_grupo_emprende_clan_sesion_clase SCT
	JOIN tb_terr_grupo_emprende_clan_sesion_clase_asistencia SCART ON SCART.FK_sesion_clase=SCT.PK_sesion_clase
	WHERE SCT.FK_grupo=tt.grupo AND YEAR(SCT.DA_fecha_clase)=:anios
	) AS 'total_reportados'
FROM
(
SELECT 
	CONCAT('IC-',EC.PK_Grupo) AS 'grupo',
	EC.modalidad_atencion,
	C.VC_Nom_Clan AS 'crea',
	AA.VC_Descripcion AS 'area',
	EC.tipo_grupo AS 'tipo_grupo',
	MO.VC_Nom_Modalidad AS 'institucion',
	'No aplica' AS 'grados',
	O.VC_Nom_Organizacion AS 'organizacion',
	CONCAT(AF.VC_Primer_Nombre,' ',AF.VC_Segundo_Nombre,' ',AF.VC_Primer_Apellido,' ',AF.VC_Segundo_Apellido) AS 'artista_formador',
	'---' AS 'lugar_atencion',
	EC.DT_fecha_creacion AS 'fecha_creacion',
	CONCAT(ABRIO.VC_Primer_Nombre,' ',ABRIO.VC_Segundo_Nombre,' ',ABRIO.VC_Primer_Apellido,' ',ABRIO.VC_Segundo_Apellido) AS 'abrio',
	(
	SELECT
	GROUP_CONCAT( 
	CONCAT(
	(
	CASE 
	WHEN HC.IN_dia=1 THEN 'Lunes'
	WHEN HC.IN_dia=2 THEN 'Martes'
	WHEN HC.IN_dia=3 THEN 'Miercoles'
	WHEN HC.IN_dia=4 THEN 'Jueves'
	WHEN HC.IN_dia=5 THEN 'Viernes'
	WHEN HC.IN_dia=6 THEN 'Sabado'
	WHEN HC.IN_dia=7 THEN 'Domingo'
	END
	),' (',HC.TI_hora_inicio_clase,' a ',HC.TI_hora_fin_clase,')')) 
	FROM tb_terr_grupo_emprende_clan_horario_clase AS HC 
	WHERE HC.FK_grupo=EC.PK_Grupo
	) AS 'horario',
	(
	SELECT COUNT(*)
	FROM tb_terr_grupo_emprende_clan_estudiante GE
	WHERE GE.FK_grupo=EC.PK_Grupo AND GE.estado=1
	) AS 'estudiante',
	EC.TX_observaciones AS 'observaciones',
	(
	CASE
	WHEN EC.estado=1 THEN 'Activo'
	WHEN EC.estado=0 THEN 'Inactivo'
	END
	) AS 'estado',
	EC.DT_fecha_cierre AS 'fecha_cierre',
	CONCAT(CERRO.VC_Primer_Nombre,' ',CERRO.VC_Segundo_Nombre,' ',CERRO.VC_Primer_Apellido,' ',CERRO.VC_Segundo_Apellido) AS 'cerro',
	COUNT(DISTINCT SCAA.FK_estudiante) AS 'ATENDIDOS',
	COUNT(DISTINCT SCAR.FK_estudiante) AS 'REPORTADOS',
	COALESCE(ROUND(((COUNT(DISTINCT SCAA.FK_estudiante)/COUNT(DISTINCT SCAR.FK_estudiante))*100),2),0) AS PORCENTAJE,
	MONTH(SC.DA_fecha_clase) AS 'MES',
	YEAR(SC.DA_fecha_clase) AS 'ANIO',
	CONV.VC_Descripcion AS 'CONVENIO'
	FROM tb_terr_grupo_emprende_clan AS EC
	JOIN tb_clan AS C ON C.PK_Id_Clan=EC.FK_clan
	LEFT JOIN tb_parametro_detalle AS AA ON AA.FK_Value=EC.FK_area_artistica AND AA.FK_Id_Parametro = 6
	LEFT JOIN tb_modalidad AS MO ON MO.PK_Id_Modalidad=EC.FK_modalidad
	LEFT JOIN tb_organizaciones_2017 AS O ON O.PK_Id_Organizacion=EC.FK_organizacion
	LEFT JOIN tb_persona_2017 AS AF on AF.PK_Id_Persona=EC.FK_artista_formador
	LEFT JOIN tb_persona_2017 AS CERRO on CERRO.PK_Id_Persona=EC.FK_quien_cerro
	LEFT JOIN tb_persona_2017 AS ABRIO on ABRIO.PK_Id_Persona=EC.FK_creador
	LEFT JOIN tb_terr_grupo_emprende_clan_sesion_clase SC ON SC.FK_grupo=EC.PK_Grupo AND YEAR(SC.DA_fecha_clase)=:anios
	LEFT JOIN tb_terr_grupo_emprende_clan_sesion_clase_asistencia SCAA ON SCAA.FK_sesion_clase=SC.PK_sesion_clase AND SCAA.IN_estado_asistencia=1
	LEFT JOIN tb_terr_grupo_emprende_clan_sesion_clase_asistencia SCAR ON SCAR.FK_sesion_clase=SC.PK_sesion_clase
	LEFT JOIN tb_parametro_detalle AS CONV ON CONV.FK_Value=EC.IN_convenio AND CONV.FK_Id_Parametro = 68
	WHERE FIND_IN_SET(EC.FK_clan,:creas)  AND FIND_IN_SET(YEAR(EC.DT_fecha_creacion),:anios)
	GROUP BY EC.PK_Grupo, MONTH(SC.DA_fecha_clase)) AS tt
	GROUP BY tt.grupo)
	UNION
	(SELECT
	tt.*,
	SUM(IF(tt.MES='01', tt.ATENDIDOS, 0)) AS 'AtendidosEnero',
	SUM(IF(tt.MES='01', tt.REPORTADOS, 0)) AS 'TotalReportadosEnero',
	SUM(IF(tt.MES='01', tt.PORCENTAJE, 0)) AS 'PorcentajeEnero',
	SUM(IF(tt.MES='02', tt.ATENDIDOS, 0)) AS 'AtendidosFebrero',
	SUM(IF(tt.MES='02', tt.REPORTADOS, 0)) AS 'TotalReportadosFebrero',
	SUM(IF(tt.MES='02', tt.PORCENTAJE, 0)) AS 'PorcentajeFebrero',
	SUM(IF(tt.MES='03', tt.ATENDIDOS, 0)) AS 'AtendidosMarzo',
	SUM(IF(tt.MES='03', tt.REPORTADOS, 0)) AS 'TotalReportadosMarzo',
	SUM(IF(tt.MES='03', tt.PORCENTAJE, 0)) AS 'PorcentajeMarzo',
	SUM(IF(tt.MES='04', tt.ATENDIDOS, 0)) AS 'AtendidosAbril',
	SUM(IF(tt.MES='04', tt.REPORTADOS, 0)) AS 'TotalReportadosAbril',
	SUM(IF(tt.MES='04', tt.PORCENTAJE, 0)) AS 'PorcentajeAbril',
	SUM(IF(tt.MES='05', tt.ATENDIDOS, 0)) AS 'AtendidosMayo',
	SUM(IF(tt.MES='05', tt.REPORTADOS, 0)) AS 'TotalReportadosMayo',
	SUM(IF(tt.MES='05', tt.PORCENTAJE, 0)) AS 'PorcentajeMayo',
	SUM(IF(tt.MES='06', tt.ATENDIDOS, 0)) AS 'AtendidosJunio',
	SUM(IF(tt.MES='06', tt.REPORTADOS, 0)) AS 'TotalReportadosJunio',
	SUM(IF(tt.MES='06', tt.PORCENTAJE, 0)) AS 'PorcentajeJunio',
	SUM(IF(tt.MES='07', tt.ATENDIDOS, 0)) AS 'AtendidosJulio',
	SUM(IF(tt.MES='07', tt.REPORTADOS, 0)) AS 'TotalReportadosJulio',
	SUM(IF(tt.MES='07', tt.PORCENTAJE, 0)) AS 'PorcentajeJulio',
	SUM(IF(tt.MES='08', tt.ATENDIDOS, 0)) AS 'AtendidosAgosto',
	SUM(IF(tt.MES='08', tt.REPORTADOS, 0)) AS 'TotalReportadosAgosto',
	SUM(IF(tt.MES='08', tt.PORCENTAJE, 0)) AS 'PorcentajeAgosto',
	SUM(IF(tt.MES='09', tt.ATENDIDOS, 0)) AS 'AtendidosSeptiembre',
	SUM(IF(tt.MES='09', tt.REPORTADOS, 0)) AS 'TotalReportadosSeptiembre',
	SUM(IF(tt.MES='09', tt.PORCENTAJE, 0)) AS 'PorcentajeSeptiembre',
	SUM(IF(tt.MES='10', tt.ATENDIDOS, 0)) AS 'AtendidosOctubre',
	SUM(IF(tt.MES='10', tt.REPORTADOS, 0)) AS 'TotalReportadosOctubre',
	SUM(IF(tt.MES='10', tt.PORCENTAJE, 0)) AS 'PorcentajeOctubre',
	SUM(IF(tt.MES='11', tt.ATENDIDOS, 0)) AS 'AtendidosNoviembre',
	SUM(IF(tt.MES='11', tt.REPORTADOS, 0)) AS 'TotalReportadosNoviembre',
	SUM(IF(tt.MES='11', tt.PORCENTAJE, 0)) AS 'PorcentajeNoviembre',
	SUM(IF(tt.MES='12', tt.ATENDIDOS, 0)) AS 'AtendidosDiciembre',
	SUM(IF(tt.MES='12', tt.REPORTADOS, 0)) AS 'TotalReportadosDiciembre',
	SUM(IF(tt.MES='12', tt.PORCENTAJE, 0)) AS 'PorcentajeDiciembre',
	(
	SELECT 
	COUNT(DISTINCT SCAAT.FK_estudiante)
	FROM tb_terr_grupo_arte_escuela_sesion_clase SCT
	JOIN tb_terr_grupo_arte_escuela_sesion_clase_asistencia SCAAT ON SCAAT.FK_sesion_clase=SCT.PK_sesion_clase AND SCAAT.IN_estado_asistencia=1
	JOIN tb_estudiante E ON SCAAT.FK_estudiante=E.id
	WHERE SCT.FK_grupo=tt.grupo AND YEAR(SCT.DA_fecha_clase)=:anios
	) AS 'total_atendidos',
	(
	SELECT 
	COUNT(DISTINCT SCAAT.FK_estudiante)
	FROM tb_terr_grupo_arte_escuela_sesion_clase SCT
	JOIN tb_terr_grupo_arte_escuela_sesion_clase_asistencia SCAAT ON SCAAT.FK_sesion_clase=SCT.PK_sesion_clase AND SCAAT.IN_estado_asistencia=1
	JOIN tb_estudiante E ON SCAAT.FK_estudiante=E.id
	WHERE SCT.FK_grupo=tt.grupo AND E.CH_Genero='M' AND YEAR(SCT.DA_fecha_clase)=:anios
	) AS 'atendidos_hombres',
	(
	SELECT
	COUNT(DISTINCT SCAAT.FK_estudiante)
	FROM tb_terr_grupo_arte_escuela_sesion_clase SCT
	JOIN tb_terr_grupo_arte_escuela_sesion_clase_asistencia SCAAT ON SCAAT.FK_sesion_clase=SCT.PK_sesion_clase AND SCAAT.IN_estado_asistencia=1
	JOIN tb_estudiante E ON SCAAT.FK_estudiante=E.id
	WHERE SCT.FK_grupo=tt.grupo AND E.CH_Genero='F' AND YEAR(SCT.DA_fecha_clase)=:anios
	) AS 'atendidos_mujeres',
	(
	SELECT
	COUNT(DISTINCT SCAAT.FK_estudiante)
	FROM tb_terr_grupo_arte_escuela_sesion_clase SCT
	JOIN tb_terr_grupo_arte_escuela_sesion_clase_asistencia SCAAT ON SCAAT.FK_sesion_clase=SCT.PK_sesion_clase AND SCAAT.IN_estado_asistencia=1
	JOIN tb_estudiante E ON SCAAT.FK_estudiante=E.id
	WHERE SCT.FK_grupo=tt.grupo AND E.CH_Genero != 'M' AND E.CH_Genero != 'F' AND YEAR(SCT.DA_fecha_clase)=:anios
	) AS 'atendidos_sin_genero',
	(
	SELECT COUNT(DISTINCT SCART.FK_estudiante)
	FROM tb_terr_grupo_arte_escuela_sesion_clase SCT
	JOIN tb_terr_grupo_arte_escuela_sesion_clase_asistencia SCART ON SCART.FK_sesion_clase=SCT.PK_sesion_clase
	WHERE SCT.FK_grupo=tt.grupo AND YEAR(SCT.DA_fecha_clase)=:anios
	) AS 'total_reportados'
FROM
(
SELECT 
	CONCAT('AE-',AE.PK_Grupo) AS 'grupo',
	AE.modalidad_atencion,
	C.VC_Nom_Clan AS 'crea',
	AA.VC_Descripcion AS 'area',
	AE.tipo_grupo AS 'tipo_grupo',
	COL.VC_Nom_Colegio AS 'colegio',
	AE.VC_grados AS 'grados',
	O.VC_Nom_Organizacion AS 'organizacion',
	CONCAT(AF.VC_Primer_Nombre,' ',AF.VC_Segundo_Nombre,' ',AF.VC_Primer_Apellido,' ',AF.VC_Segundo_Apellido) AS 'artista_formador',
	(CASE
	WHEN AE.IN_lugar_atencion = 1 THEN 'Solo Colegio'
	WHEN AE.IN_lugar_atencion = 2 THEN 'Solo CREA'
	WHEN AE.IN_lugar_atencion = 3 THEN 'CREA y Colegio'
	ELSE ''
	END) AS 'lugar_atencion',
	AE.DT_fecha_creacion AS 'fecha_creacion',
	CONCAT(ABRIO.VC_Primer_Nombre,' ',ABRIO.VC_Segundo_Nombre,' ',ABRIO.VC_Primer_Apellido,' ',ABRIO.VC_Segundo_Apellido) AS 'abrio',
	(
	SELECT
	GROUP_CONCAT( 
	CONCAT(
	(
	CASE 
	WHEN HC.IN_dia=1 THEN 'Lunes'
	WHEN HC.IN_dia=2 THEN 'Martes'
	WHEN HC.IN_dia=3 THEN 'Miércoles'
	WHEN HC.IN_dia=4 THEN 'Jueves'
	WHEN HC.IN_dia=5 THEN 'Viernes'
	WHEN HC.IN_dia=6 THEN 'Sábado'
	WHEN HC.IN_dia=7 THEN 'Domingo'
	END
	),' (',HC.TI_hora_inicio_clase,' a ',HC.TI_hora_fin_clase,')')) 
	FROM tb_terr_grupo_arte_escuela_horario_clase AS HC 
	WHERE HC.FK_grupo=AE.PK_Grupo
	) AS 'horario',
	(
	SELECT COUNT(*)
	FROM tb_terr_grupo_arte_escuela_estudiante GE
	WHERE GE.FK_grupo=AE.PK_Grupo AND GE.estado=1
	) AS 'estudiante',
	AE.TX_observaciones AS 'observaciones',
	(
	CASE
	WHEN AE.estado=1 THEN 'Activo'
	WHEN AE.estado=0 THEN 'Inactivo'
	END 
	) AS 'estado',
	AE.DT_fecha_cierre AS 'fecha_cierre',
	CONCAT(CERRO.VC_Primer_Nombre,' ',CERRO.VC_Segundo_Nombre,' ',CERRO.VC_Primer_Apellido,' ',CERRO.VC_Segundo_Apellido) AS 'cerro',
	COUNT(DISTINCT SCAA.FK_estudiante) AS 'ATENDIDOS',
	COUNT(DISTINCT SCAR.FK_estudiante) AS 'REPORTADOS',
	COALESCE(ROUND(((COUNT(DISTINCT SCAA.FK_estudiante)/COUNT(DISTINCT SCAR.FK_estudiante))*100),2),0) AS PORCENTAJE,
	MONTH(SC.DA_fecha_clase) AS 'MES',
	YEAR(SC.DA_fecha_clase) AS 'ANIO',
	CONV.VC_Descripcion AS 'CONVENIO'
	FROM tb_terr_grupo_arte_escuela AS AE
	JOIN tb_clan AS C ON C.PK_Id_Clan=AE.FK_clan
	LEFT JOIN tb_parametro_detalle AS AA ON AA.FK_Value=AE.FK_area_artistica AND AA.FK_Id_Parametro = 6
	LEFT JOIN tb_colegios AS COL ON COL.PK_Id_Colegio=AE.FK_colegio
	LEFT JOIN tb_organizaciones_2017 AS O ON O.PK_Id_Organizacion=AE.FK_organizacion
	LEFT JOIN tb_persona_2017 AS AF on AF.PK_Id_Persona=AE.FK_artista_formador
	LEFT JOIN tb_persona_2017 AS CERRO on CERRO.PK_Id_Persona=AE.FK_quien_cerro
	LEFT JOIN tb_persona_2017 AS ABRIO on ABRIO.PK_Id_Persona=AE.FK_creador
	LEFT JOIN tb_terr_grupo_arte_escuela_sesion_clase SC ON SC.FK_grupo=AE.PK_Grupo AND YEAR(SC.DA_fecha_clase)=:anios
	LEFT JOIN tb_terr_grupo_arte_escuela_sesion_clase_asistencia SCAA ON SCAA.FK_sesion_clase=SC.PK_sesion_clase AND SCAA.IN_estado_asistencia=1
	LEFT JOIN tb_terr_grupo_arte_escuela_sesion_clase_asistencia SCAR ON SCAR.FK_sesion_clase=SC.PK_sesion_clase
	LEFT JOIN tb_parametro_detalle AS CONV ON CONV.FK_Value=AE.IN_convenio AND CONV.FK_Id_Parametro = 68
	WHERE FIND_IN_SET(AE.FK_clan,:creas) AND FIND_IN_SET(YEAR(AE.DT_fecha_creacion),2021)
	GROUP BY AE.PK_Grupo, MONTH(SC.DA_fecha_clase)) AS tt
	GROUP BY tt.grupo)";
	@$sentencia=$this->dbPDO->prepare($sql); 
	@$sentencia->bindParam(':creas',$creas);
	@$sentencia->bindParam(':anios',$anios);
	$sentencia->execute();  
		//$sentencia->debugDumpParams();
	return $sentencia->fetchAll(\PDO::FETCH_ASSOC);           
}

}