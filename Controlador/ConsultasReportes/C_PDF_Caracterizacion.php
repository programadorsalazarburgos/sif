<?php
require_once('../../Modelo/medoo/medoo.php');
require_once('../../Modelo/medoo/parametros_conexion.php');
require('PDF_MC_Table.php');
class PDF extends PDF_MC_Table
{
//El metodo para crear el encabezado
	function Header()
	{
		$this->Image('../../public/imagenes/bogota.jpg' , 5, 10, 60 , 25,'JPG'); 
		$this->Image('../../public/imagenes/logo-crea-header.png' , 160, 10,'', 22,'PNG');
		$this->SetFont('Arial','B',12); //Tipo de letra, estilo y tamaño
	    $this->Cell(0,30,utf8_decode('CARACTERIZACIÓN DE GRUPO'),0,1,'C'); //Titulo del reporte
	    $this->SetFont('Arial','B',40);
	    $this->SetTextColor(192,255,183); 
	}
	function TablaBasica()
	{
		$this->Cell(15,10,'ID',1,0,'C');
	    $this->Cell(30,10,utf8_decode('Identificación'),1,0,'C'); //**
	    $this->Cell(115,10,'Nombre',1,0,'C'); //**
	    $this->Cell(25,10,'Asistencia',1,1,'C'); //**
	}
	// Pie de página
	function Footer()
	{
	    // Posición: a 1,5 cm del final
		$this->SetY(-15);
	    // Arial italic 8
		$this->SetFont('Arial','I',8);
	    // Número de página

		$this->Cell(0,10,'Pag '.$this->PageNo().'/{nb}',0,0,'C');
	}
	// Ciclo 
	function getCicloRomano($ciclo_grupo)
	{
		$ciclo_grupo = str_replace("0","No Aplica",$ciclo_grupo);
		$ciclo_grupo = str_replace("1","I",$ciclo_grupo);
		$ciclo_grupo = str_replace("2","II",$ciclo_grupo);
		$ciclo_grupo = str_replace("3","III",$ciclo_grupo);
		$ciclo_grupo = str_replace("4","IV",$ciclo_grupo);
		return $ciclo_grupo;
	}
}
$id_caracterizacion = $_GET['id_caracterizacion'];
$pdf=new PDF('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',9);
$pdf->SetFillColor(0,69,134);
$pdf->SetTextColor(255,255,255);

$info = $db_siclan->select("tb_caracterizacion_grupo","*",["PK_Id_Caracterizacion"=>$id_caracterizacion]);
$codigo_grupo = $info[0]['FK_Grupo'];
$ciclo_grupo = $info[0]['FK_Ciclo'];
$ciclo_grupo = $pdf->getCicloRomano($ciclo_grupo);
$tipo_grupo = $info[0]['FK_Id_Linea_Atencion'];

$width=190;
$pdf->SetWidths(array($width));
$pdf->SetTextColor(255,255,255);
$pdf->SetFont('Arial','B',9);
//ENCABEZADO DEL REPORTE
$pdf->Cell(190,8,utf8_decode('FICHA DE CARACTERIZACIÓN, PROCESO DE FORMACIÓN ARTÍSTICA'),0,0,'C', true); //Titulo del reporte
$pdf->Ln();
$pdf->SetTextColor(0,0,0);
$titulo="";
if ($tipo_grupo == "arte_escuela") {
	$titulo="AE-".$codigo_grupo;
	$info_grupo_ae = $db_siclan->query("SELECT
		AA.VC_Nom_Area,
		COL.VC_Nom_Colegio,
		CLAN.VC_Nom_Clan,
		GAE.IN_lugar_atencion,
		GAE.DT_fecha_creacion,
		CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido) AS Nombre_Formador
		FROM tb_caracterizacion_grupo CG
		JOIN tb_terr_grupo_arte_escuela GAE ON CG.FK_Grupo=GAE.PK_Grupo
		JOIN tb_areas_artisticas AA ON AA.PK_Area_Artistica=GAE.FK_area_artistica
		JOIN tb_colegios COL ON COL.PK_Id_Colegio=GAE.FK_colegio
		JOIN tb_clan CLAN ON CLAN.PK_Id_Clan=GAE.FK_clan
		JOIN tb_persona_2017 P ON CG.FK_Id_Usuario_Registro=P.PK_Id_Persona
		WHERE CG.PK_Id_Caracterizacion=".$id_caracterizacion);
	$width=190/2;
	$pdf->SetWidths(array($width,$width));  
	foreach($info_grupo_ae as $data){
		if($data['IN_lugar_atencion']==1){ $lugar_atencion = "COLEGIO";	}
		if($data['IN_lugar_atencion']==2){ $lugar_atencion = "CREA";	}
		if($data['IN_lugar_atencion']==3){ $lugar_atencion = "CREA Y COLEGIO"; }
		$pdf->Row(array('FORMADOR: '.$data['Nombre_Formador'],utf8_decode('ÁREA ARTÍSTICA: '.$data['VC_Nom_Area'])));
		$pdf->Row(array($data['VC_Nom_Colegio'],utf8_decode($data['VC_Nom_Clan'])));
		$fecha_primer_clase = $db_siclan->query("SELECT MIN(DA_Fecha_Clase) AS Primer_Clase FROM tb_terr_grupo_arte_escuela_sesion_clase GAES WHERE GAES.FK_grupo=".$codigo_grupo);
		foreach($fecha_primer_clase as $fecha){
			$pdf->Row(array('FECHA DE INICIO: '.$fecha['Primer_Clase'],'GRUPO: AE-'.$codigo_grupo));	
		}		
		$pdf->Row(array(utf8_decode('LUGAR DE ATENCIÓN: '.$lugar_atencion),'CICLO: '.$ciclo_grupo));
		$pdf->SetWidths(array($width*2));
		$horario_grupo = $db_siclan->select("tb_terr_grupo_arte_escuela_horario_clase","*",["FK_grupo"=>$codigo_grupo]);
		// $horario_grupo = mysqli_query($conexio,"SELECT * FROM tb_terr_grupo_arte_escuela_horario_clase  WHERE FK_grupo=".$codigo_grupo);
		$horario_concatenado="";
		foreach($horario_grupo as $horario){
			if($horario['IN_dia']==1){$dia="LUNES";}
			if($horario['IN_dia']==2){$dia="MARTES";}
			if($horario['IN_dia']==3){$dia="MIERCOLES";}
			if($horario['IN_dia']==4){$dia="JUEVES";}
			if($horario['IN_dia']==5){$dia="VIERNES";}
			if($horario['IN_dia']==6){$dia="SABADO";}
			$horario_concatenado .= '('.$dia.' '.$horario['TI_hora_inicio_clase'].' - '.$horario['TI_hora_fin_clase'].') ';
		}	
		$pdf->Row(array('HORARIO: '.$horario_concatenado));
		$promedio_estudiantes = $db_siclan->query("SELECT (SELECT COUNT(SCA.FK_estudiante) 
			FROM tb_terr_grupo_arte_escuela_sesion_clase S
			JOIN tb_terr_grupo_arte_escuela_sesion_clase_asistencia SCA ON SCA.FK_sesion_clase=S.PK_sesion_clase
			WHERE S.FK_grupo='$codigo_grupo' AND SCA.IN_estado_asistencia=1
			)/(SELECT COUNT(SCA.FK_estudiante) 
			FROM tb_terr_grupo_arte_escuela_sesion_clase S
			JOIN tb_terr_grupo_arte_escuela_sesion_clase_asistencia SCA ON SCA.FK_sesion_clase=S.PK_sesion_clase
			WHERE S.FK_grupo='$codigo_grupo')*100 AS PROMEDIO");
		foreach($promedio_estudiantes as $promedio){
			$pdf->Row(array('Promedio de Asistencia Estudiantes: '.round($promedio['PROMEDIO']).'%'));	
		}		
	}				
}//FIN IF DATOS GRUPO AE
if($tipo_grupo == 'emprende_clan'){
	$titulo="EC-".$codigo_grupo;
	$datos_grupo_ec = $db_siclan->query("SELECT AA.VC_Nom_Area,
		M.VC_Nom_Modalidad,
		CLAN.VC_Nom_Clan,
		GEC.DT_fecha_creacion, 
		CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido) AS Nombre_Formador
		FROM tb_caracterizacion_grupo CG
		JOIN tb_terr_grupo_emprende_clan GEC ON CG.FK_Grupo=GEC.PK_Grupo
		JOIN tb_areas_artisticas AA ON AA.PK_Area_Artistica=GEC.FK_area_artistica
		JOIN tb_modalidad M ON M.PK_Id_Modalidad=GEC.FK_modalidad
		JOIN tb_clan CLAN ON CLAN.PK_Id_Clan=GEC.FK_clan
		JOIN tb_persona_2017 P ON CG.FK_Id_Usuario_Registro=P.PK_Id_Persona
		WHERE CG.PK_Id_Caracterizacion=".$id_caracterizacion);
	$width=190/2;
	$pdf->SetWidths(array($width,$width));
	foreach($datos_grupo_ec as $datos_grupo){ 
		$lugar_atencion = "CREA";
		$pdf->Row(array('FORMADOR: '.$datos_grupo['Nombre_Formador'],utf8_decode('ÁREA ARTÍSTICA: ').$datos_grupo['VC_Nom_Area']));
		$pdf->Row(array('MODALIDAD: '.$datos_grupo['VC_Nom_Modalidad'],utf8_decode($datos_grupo['VC_Nom_Clan'])));
		$fecha_primer_clase = $db_siclan->query("SELECT MIN(DA_Fecha_Clase) AS Primer_Clase FROM tb_terr_grupo_emprende_clan_sesion_clase GECS WHERE GECS.FK_grupo=".$codigo_grupo);
		// $fecha_primer_clase = mysqli_query($conexio,"SELECT MIN(DA_Fecha_Clase) AS Primer_Clase FROM tb_terr_grupo_emprende_clan_sesion_clase GECS WHERE GECS.FK_grupo=".$codigo_grupo);
		foreach($fecha_primer_clase as $fecha){
			$pdf->Row(array('FECHA DE INICIO: '.$fecha['Primer_Clase'],'GRUPO: EC-'.$codigo_grupo));	
		}			
		$pdf->Row(array(utf8_decode('LUGAR DE ATENCIÓN: '.$lugar_atencion),'CICLO: '.$ciclo_grupo));
		$pdf->SetWidths(array($width*2));
		$horario_grupo = $db_siclan->query("SELECT * FROM tb_terr_grupo_emprende_clan_horario_clase  WHERE FK_grupo=".$codigo_grupo);
		// $horario_grupo = mysqli_query($conexio,"SELECT * FROM tb_terr_grupo_emprende_clan_horario_clase  WHERE FK_grupo=".$codigo_grupo);
		$horario_concatenado="";
		foreach($horario_grupo as $horario){
			if($horario['IN_dia']==1){$dia="LUNES";}
			if($horario['IN_dia']==2){$dia="MARTES";}
			if($horario['IN_dia']==3){$dia="MIERCOLES";}
			if($horario['IN_dia']==4){$dia="JUEVES";}
			if($horario['IN_dia']==5){$dia="VIERNES";}
			if($horario['IN_dia']==6){$dia="SABADO";}
			$horario_concatenado .= '('.$dia.' '.$horario['TI_hora_inicio_clase'].' - '.$horario['TI_hora_fin_clase'].') ';
		}
		$pdf->Row(array('HORARIO: '.$horario_concatenado));
		$promedio_estudiantes = $db_siclan->query("SELECT (SELECT COUNT(SCA.FK_estudiante) 
			FROM tb_terr_grupo_emprende_clan_sesion_clase S
			JOIN tb_terr_grupo_emprende_clan_sesion_clase_asistencia SCA ON SCA.FK_sesion_clase=S.PK_sesion_clase
			WHERE S.FK_grupo='$codigo_grupo' AND SCA.IN_estado_asistencia=1
			)/(SELECT COUNT(SCA.FK_estudiante) 
			FROM tb_terr_grupo_emprende_clan_sesion_clase S
			JOIN tb_terr_grupo_emprende_clan_sesion_clase_asistencia SCA ON SCA.FK_sesion_clase=S.PK_sesion_clase
			WHERE S.FK_grupo='$codigo_grupo')*100 AS PROMEDIO");
		foreach($promedio_estudiantes as $promedio){
			$pdf->Row(array('Promedio de Asistencia Estudiantes: '.round($promedio['PROMEDIO']).'%'));	
		}
	}
}
if($tipo_grupo == 'laboratorio_clan'){
	$titulo="LC-".$codigo_grupo;
	$datos_grupo_lc = $db_siclan->query("SELECT AA.VC_Nom_Area,
		CLAN.VC_Nom_Clan,
		LA.VC_Nombre_Lugar,
		GLC.DT_fecha_creacion, 
		CONCAT(P.VC_Primer_Nombre,' ',P.VC_Segundo_Nombre,' ',P.VC_Primer_Apellido,' ',P.VC_Segundo_Apellido) AS Nombre_Formador
		FROM tb_caracterizacion_grupo CG
		JOIN tb_terr_grupo_laboratorio_clan GLC ON CG.FK_Grupo=GLC.PK_Grupo
		JOIN tb_areas_artisticas AA ON AA.PK_Area_Artistica=GLC.FK_area_artistica
		JOIN tb_clan CLAN ON CLAN.PK_Id_Clan=GLC.FK_clan
		JOIN tb_terr_lugar_atencion_laboratorio_clan LA ON GLC.FK_lugar_atencion = LA.PK_lugar_atencion
		JOIN tb_persona_2017 P ON CG.FK_Id_Usuario_Registro=P.PK_Id_Persona
		WHERE CG.PK_Id_Caracterizacion=".$id_caracterizacion);
	$width=190/2;
	$pdf->SetWidths(array($width,$width));
	foreach($datos_grupo_lc as $datos_grupo){
		$lugar_atencion = $datos_grupo['VC_Nombre_Lugar'];
		$pdf->Row(array('FORMADOR: '.$datos_grupo['Nombre_Formador'],utf8_decode('ÁREA ARTÍSTICA: ').$datos_grupo['VC_Nom_Area']));
		$pdf->Row(array('MODALIDAD: NO APLICA',utf8_decode($datos_grupo['VC_Nom_Clan'])));
		$fecha_primer_clase = $db_siclan->query("SELECT MIN(DA_Fecha_Clase) AS Primer_Clase FROM tb_terr_grupo_laboratorio_clan_sesion_clase GECS WHERE GECS.FK_grupo=".$codigo_grupo);
		// $fecha_primer_clase = mysqli_query($conexio,"SELECT MIN(DA_Fecha_Clase) AS Primer_Clase FROM tb_terr_grupo_laboratorio_clan_sesion_clase GECS WHERE GECS.FK_grupo=".$codigo_grupo);
		foreach($fecha_primer_clase as $fecha){
			$pdf->Row(array('FECHA DE INICIO: '.$fecha['Primer_Clase'],'GRUPO: LC-'.$codigo_grupo));	
		}
		$pdf->Row(array(utf8_decode('LUGAR DE ATENCIÓN: '.$lugar_atencion),'CICLO: '.$ciclo_grupo));
		$pdf->SetWidths(array($width*2));
		$horario_grupo = $db_siclan->query("SELECT * FROM tb_terr_grupo_laboratorio_clan_horario_clase  WHERE FK_grupo=".$codigo_grupo);
		// $horario_grupo = mysqli_query($conexio,"SELECT * FROM tb_terr_grupo_laboratorio_clan_horario_clase  WHERE FK_grupo=".$codigo_grupo);
		$horario_concatenado="";
		foreach($horario_grupo as $horario){
			if($horario['IN_dia']==1){$dia="LUNES";}
			if($horario['IN_dia']==2){$dia="MARTES";}
			if($horario['IN_dia']==3){$dia="MIERCOLES";}
			if($horario['IN_dia']==4){$dia="JUEVES";}
			if($horario['IN_dia']==5){$dia="VIERNES";}
			if($horario['IN_dia']==6){$dia="SABADO";}
			$horario_concatenado .= '('.$dia.' '.$horario['TI_hora_inicio_clase'].' - '.$horario['TI_hora_fin_clase'].') ';
		}
		$pdf->Row(array('HORARIO: '.$horario_concatenado));
		$promedio_estudiantes = $db_siclan->query("SELECT (SELECT COUNT(SCA.FK_estudiante) 
			FROM tb_terr_grupo_laboratorio_clan_sesion_clase S
			JOIN tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia SCA ON SCA.FK_sesion_clase=S.PK_sesion_clase
			WHERE S.FK_grupo='$codigo_grupo' AND SCA.IN_estado_asistencia=1
			)/(SELECT COUNT(SCA.FK_estudiante) 
			FROM tb_terr_grupo_laboratorio_clan_sesion_clase S
			JOIN tb_terr_grupo_laboratorio_clan_sesion_clase_asistencia SCA ON SCA.FK_sesion_clase=S.PK_sesion_clase
			WHERE S.FK_grupo='$codigo_grupo')*100 AS PROMEDIO");
		foreach($promedio_estudiantes as $promedio){
			$pdf->Row(array('Promedio de Asistencia Estudiantes: '.round($promedio['PROMEDIO']).'%'));	
		}
	}
}
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(0,69,134);
$pdf->SetFont('Arial','B',9);
$width=190/2;
$pdf->SetWidths(array($width,$width));
foreach($info as $informacion_caracterizacion){
	$pdf->SetWidths(array($width*2));
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','B',9);
	if ($informacion_caracterizacion['IN_Estado']=='') {
		$msg = "Sin Revisar";
	}
	else{
		if ($informacion_caracterizacion['IN_Estado']=='1') {
			$msg = 'Aprobado';
		}
		else
		{
			$msg = 'No Aprobado';
		}
	}
	$pdf->Row(array('Estado: '.$msg));
	$pdf->SetTextColor(255,255,255);
			$pdf->Cell(190,8,utf8_decode('1. DESCRIPCIÓN DEL GRUPO'),0,0,'C', true); //Titulo
			$pdf->Ln();
			$pdf->SetAligns("J");
			$pdf->SetTextColor(0,0,0);
			$pdf->SetFont('Arial','',9);
			$pdf->Row(array(utf8_decode($informacion_caracterizacion['TX_Descripcion_Grupo'])));
			$pdf->SetTextColor(255,255,255);
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(190,8,utf8_decode('2. ASPECTOS DE CONVIVENCIA'),0,0,'C', true); //Titulo
			$pdf->Ln();
			$pdf->SetTextColor(0,0,0);
			$pdf->Row(array(utf8_decode('Calificación escala (1-5): '.$informacion_caracterizacion['IN_Escala_Convivencia'])));
			$pdf->SetFont('Arial','',9);
			$pdf->Row(array(utf8_decode($informacion_caracterizacion['TX_Convivencia'])));
			$pdf->SetTextColor(255,255,255);
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(190,8,utf8_decode('3. IDENTIFICACIÓN DE INTERÉSES DEL GRUPO'),0,0,'C', true); //Titulo
			$pdf->Ln();
			$pdf->SetTextColor(0,0,0);
			$pdf->Row(array(utf8_decode('INTERÉSES: '.$informacion_caracterizacion['TX_Array_Intereses'])));
			$pdf->SetFont('Arial','',9);
			$pdf->Row(array(utf8_decode($informacion_caracterizacion['TX_Descripcion_Intereses'])));
			$pdf->SetTextColor(255,255,255);
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(190,8,utf8_decode('4. VALORACIÓN PARA LA FORMACIÓN ARTÍSTICA'),0,0,'C', true); //Titulo
			$pdf->Ln();
			$pdf->SetFont('Arial','B',9);
			$pdf->SetTextColor(255,255,255);
			$pdf->SetFillColor(0,134,134);
			$pdf->Cell(190,8,utf8_decode('ACTITUDINALES'),0,0,'C', true); //Titulo
			$pdf->Ln();
			$pdf->SetTextColor(0,0,0);
			$pdf->Row(array(utf8_decode('Calificación escala (1-5): '.$informacion_caracterizacion['IN_Escala_Actitudinal'])));
			$pdf->SetFont('Arial','',9);
			$pdf->Row(array(utf8_decode($informacion_caracterizacion['TX_Actitudinal'])));
			$pdf->SetFont('Arial','B',9);
			$pdf->SetTextColor(0,0,0);
			$pdf->SetTextColor(255,255,255);
			$pdf->SetFillColor(0,134,134);
			$pdf->Cell(190,8,utf8_decode('COGNITIVOS'),0,0,'C', true); //Titulo
			$pdf->Ln();
			$pdf->SetTextColor(0,0,0);
			$pdf->Row(array(utf8_decode('Calificación escala (1-5): '.$informacion_caracterizacion['IN_Escala_Cognitiva'])));
			$pdf->SetFont('Arial','',9);
			$pdf->Row(array(utf8_decode($informacion_caracterizacion['TX_Cognitiva'])));
			$pdf->SetTextColor(255,255,255);
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(190,8,utf8_decode('PROCEDIMENTALES'),0,0,'C', true); //Titulo
			$pdf->Ln();
			$pdf->SetTextColor(0,0,0);
			$pdf->Row(array(utf8_decode('Calificación escala (1-5): '.$informacion_caracterizacion['IN_Escala_Procedimental'])));
			$pdf->SetFont('Arial','',9);
			$pdf->Row(array(utf8_decode($informacion_caracterizacion['TX_Procedimental'])));
			$pdf->SetTextColor(255,255,255);
			$pdf->SetFillColor(0,69,134);
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(190,8,utf8_decode('5. PARTICULARIDADES DEL GRUPO'),0,0,'C', true); //Titulo
			$pdf->Ln();
			$pdf->SetTextColor(0,0,0);
			$pdf->SetFont('Arial','',9);
			$pdf->Row(array(utf8_decode("Necesidades del grupo: ".$informacion_caracterizacion['VC_Necesidades'])));
			$pdf->Row(array(utf8_decode("Etnias: ".$informacion_caracterizacion['VC_Etnias'])));
			$pdf->Row(array(utf8_decode($informacion_caracterizacion['TX_Particularidades'])));
			$pdf->SetFont('Arial','B',9);
			$pdf->SetTextColor(255,255,255);
			$pdf->Cell(190,8,utf8_decode('6. DESCRIPCIÓN DEL ESPACIO'),0,0,'C', true); //Titulo
			$pdf->Ln();
			$pdf->SetTextColor(0,0,0);
			$pdf->SetFont('Arial','',9);
			$pdf->Row(array(utf8_decode($informacion_caracterizacion['TX_Descripcion_Espacio'])));
			$pdf->SetTextColor(255,255,255);
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(190,8,utf8_decode('7. OBSERVACIONES'),0,0,'C', true); //Titulo
			$pdf->Ln();
			$pdf->SetTextColor(0,0,0);
			$pdf->SetFont('Arial','',9);
			$pdf->Row(array(utf8_decode($informacion_caracterizacion['TX_Observaciones'])));//Titulo
			
		}
		$pdf->Output('Caracterización '.$titulo.'.pdf','D'); 
		?>