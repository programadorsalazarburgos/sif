<?php
//require('../../../public/fpdf/fpdf.php');
require('rotation.php');
require('../modelo/Acceso_Datos.php');//Se incluye la Libreria de Acceso a la Base de Datos.
include_once("../modelo/conexionreporte.php");
conectar_bd();

class PDF extends PDF_Rotate
{
//El metodo para crear el encabezado
	function Header()
	{
	    //$this->Image('../../SICLAN2/public/imagenes/Bogota.jpg' , 5, 5, 60 , 40,'JPG');
		//$this->Image('../../SICLAN2/public/imagenes/clan.jpg' , 160, 10, 40 , 22,'JPG');
		//$this->SetFont('Arial','B',12); //Tipo de letra, estilo y tamaño
	    //$this->Cell(0,30,'CONVOCATORIA ORGANIZACIONES',0,1,'C'); //Titulo del reporte
	    $this->SetFont('Arial','B',40);
    	$this->SetTextColor(192,255,183);
    	$this->RotatedText(35,190,'Convocatoria Organizaciones',45);	   
	}
	function RotatedText($x, $y, $txt, $angle)
	{
	    //Text rotated around its origin
	    $this->Rotate($angle,$x,$y);
	    $this->Text($x,$y,$txt);
	    $this->Rotate(0);
	}
	function TablaBasica()
	   {
	    //Cabecera
	//Encabezado de la tabla
	    $this->Cell(15,10,'ID',1,0,'C'); //ancho,alto,dato,borde,salto,alineacion centrado**
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
}

$pdf=new PDF('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(0,0,0);
$width=190;
$respuesta = mysqli_query($conexio,'SELECT VC_Nombre_Entidad FROM tb_propuesta_organizacion_precontractual WHERE FK_Id_Usuario="'.$_GET['ident'].'";');
$pdf->SetWidths(array($width));
		while($fila = mysqli_fetch_array($respuesta)){
			$pdf->Row(array('PROPUESTA PRESENTADA POR LA ORGANIZACION '.strtoupper(utf8_decode($fila["VC_Nombre_Entidad"]))));
		}
$pdf->SetFillColor(0,69,134);
$pdf->SetTextColor(255,255,255);
$pdf->MultiCell(190,8,utf8_decode('SECRETARÍA DISTRITAL DE CULTURA, RECREACIÓN Y DEPORTE Y ENTIDADES ADSCRITAS
FORMATO PARA LA PRESENTACIÓN DE PROYECTOS
Apoyos y Convenios de Asociación (Alianzas Estratégicas de iniciativa privada)
'),1,'C', true); //Titulo del reporte
$pdf->Ln();
$pdf->SetTextColor(0,0,0);
//$pdf->Cell(0,8,'REPORTE DE PROPUESTA ORGANIZACION: ',0,1,'C'); //Titulo del reporte
//Table with 20 rows and 4 columns
$pdf->SetFont('Arial','',9);
//$id_proyecto['id_usuario'] = 1;
$pdf->Ln();$pdf->Ln();
//INFORMACION DEL PROYECTO
$respuesta = mysqli_query($conexio,'SELECT * FROM tb_propuesta_proyecto WHERE FK_Id_Usuario="'.$_GET['ident'].'";');
$pdf->SetFont('Arial','B',9);
$pdf->SetFillColor(0,69,134);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(190,8,utf8_decode('1. INFORMACIÓN GENERAL: '),0,0,'C', true); //Titulo del reporte
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(204,204,204);
$pdf->Ln();
$pdf->Cell(190,8,utf8_decode('INFORMACIÓN DEL PROYECTO: '),0,0,'C', true); //Titulo del reporte
$pdf->Ln();
$pdf->SetFont('Arial','B',9);
		$width=190/3;
		$pdf->Cell($width,8,utf8_decode('Fecha Radicación: '),1,0,'C'); //Titulo del reporte
		$pdf->Cell($width,8,'Nombre Proyecto: ',1,0,'C'); //Titulo del reporte
		$pdf->Cell($width,8,'Tipo Proyecto: ',1,0,'C'); //Titulo del reporte
		$pdf->Ln();
		$pdf->SetFont('Arial','',9);
		$pdf->SetWidths(array($width,$width,$width));
		while($fila = mysqli_fetch_array($respuesta)){
			$pdf->Row(array($fila['DA_Fecha_Radicacion'],$fila['VC_Nombre_Proyecto'],$fila["VC_Tipo_Proyecto"]));
		}
		$pdf->Ln();

//INFORMACION DE LA ORGANIZACION
$respuesta = mysqli_query($conexio,'SELECT VC_Nombre_Entidad, VC_Nit, VC_Direccion, LOC.VC_Nom_Localidad, VC_Objeto_Social, VC_Telefono, VC_Correo, IN_Estrato_Sede FROM tb_propuesta_organizacion_precontractual ORG JOIN tb_localidades LOC ON ORG.IN_Id_Localidad = LOC.PK_Id_Localidad WHERE ORG.FK_Id_Usuario="'.$_GET['ident'].'";');
$pdf->SetFillColor(204,204,204);
$pdf->Ln();
$pdf->Cell(190,8,utf8_decode('INFORMACIÓN DE LA ORGANIZACIÓN: '),0,0,'L', true); //Titulo del reporte
$pdf->Ln();
$pdf->SetFont('Arial','',9);
		$width=95;
		$pdf->SetWidths(array($width,$width,$width));
		while($fila = mysqli_fetch_array($respuesta)){
			$pdf->Row(array('Nombre Entidad: '.$fila['VC_Nombre_Entidad'],utf8_decode('Número NIT: ').$fila['VC_Nit']));
			$pdf->Row(array(utf8_decode('Dirección: ').$fila['VC_Direccion'],utf8_decode('Localidad: ').$fila['VC_Nom_Localidad']));
			$pdf->Row(array('Objeto Social: '.$fila['VC_Objeto_Social'],utf8_decode('Teléfono: ').$fila['VC_Telefono']));
			$pdf->Row(array(utf8_decode('Correo: ').$fila['VC_Correo'],utf8_decode('Estrato de la Sede: ').$fila['IN_Estrato_Sede']));
		}
		$pdf->Ln();

//INFORMACION DEL REPRESENTANTE LEGAL
$respuesta = mysqli_query($conexio,'SELECT VC_Representante_Legal, VC_Cedula_RL, VC_Direccion_RL, VC_Telefono_RL, VC_Correo_RL FROM tb_propuesta_organizacion_precontractual WHERE FK_Id_Usuario="'.$_GET['ident'].'";');
$pdf->SetFillColor(204,204,204);
$pdf->Cell(190,8,utf8_decode('INFORMACIÓN DEL REPRESENTANTE LEGAL: '),0,0,'L', true); //Titulo del reporte
$pdf->Ln();
$pdf->SetFont('Arial','',9);
		$width=95;
		$pdf->SetWidths(array($width,$width,$width));
		while($fila = mysqli_fetch_array($respuesta)){
			$pdf->Row(array('Representante Legal: '.$fila['VC_Representante_Legal'],utf8_decode('Identificación: ').$fila['VC_Cedula_RL']));
			$pdf->Row(array(utf8_decode('Dirección Representante: ').$fila['VC_Direccion_RL'],utf8_decode('Teléfono Representante: ').$fila['VC_Telefono_RL']));
			$pdf->Row(array(utf8_decode('Correo Representante: ').$fila['VC_Correo_RL']));
		}
		$pdf->Ln();

//INFORMACION DEL DIRECTOR DEL PROYECTO
$respuesta = mysqli_query($conexio,'SELECT VC_Nombre_Director, VC_Cedula_Director, VC_Direccion_Director, VC_Telefono_Director, VC_Correo_Director FROM tb_propuesta_proyecto WHERE FK_Id_Usuario="'.$_GET['ident'].'";');
$pdf->SetFillColor(204,204,204);
$pdf->Cell(190,8,utf8_decode('INFORMACIÓN DEL DIRECTOR DEL PROYECTO: '),0,0,'L', true); //Titulo del reporte
$pdf->Ln();
$pdf->SetFont('Arial','',9);
		$width=95;
		$pdf->SetWidths(array($width,$width,$width));
		while($fila = mysqli_fetch_array($respuesta)){
			$pdf->Row(array('Nombre del Director: '.$fila['VC_Nombre_Director'],utf8_decode('Identificación: ').$fila['VC_Cedula_Director']));
			$pdf->Row(array(utf8_decode('Dirección del Director: ').$fila['VC_Direccion_Director'],utf8_decode('Teléfono del Director: ').$fila['VC_Telefono_Director']));
			$pdf->Row(array(utf8_decode('Correo Director: ').$fila['VC_Correo_Director']));
		}
		$pdf->Ln();

$pdf->SetFillColor(0,69,134);
$pdf->SetTextColor(255,255,255);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(190,8,utf8_decode('2. DIMENSIÓN DEL PROYECTO: FORMACIÓN '),0,0,'C', true); //Titulo del reporte
$pdf->Ln();

//ANTECEDENTES DE LA ORGANIZACION
$pdf->AddPage();
$pdf->SetFillColor(0,69,134);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(190,8,utf8_decode('3. ANTECEDENTES DE LA ENTIDAD PROPONENTE'),0,0,'C', true); //Titulo del reporte
$pdf->Ln();
$pdf->SetTextColor(0,0,0);
$respuesta = mysqli_query($conexio,'SELECT VC_Antecedentes FROM tb_propuesta_proyecto WHERE FK_Id_Usuario="'.$_GET['ident'].'";');
$pdf->SetFont('Arial','',9);
		$width=190;
		$pdf->SetWidths(array($width));
		while($fila = mysqli_fetch_array($respuesta)){
			$pdf->MultiCell(190, 5, $fila['VC_Antecedentes'], 1, 'J', false);
		}
		$pdf->Ln();

//ENTIDADES CON LAS QUE HA TRABAJADO LA ORGANIZACION
$respuesta = mysqli_query($conexio,'SELECT * FROM tb_propuesta_historial_organizacion WHERE FK_Id_Usuario="'.$_GET['ident'].'";');
$pdf->SetFillColor(204,204,204);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(190,8,utf8_decode('HISTORIAL DE ENTIDADES CON LAS QUE DESARROLLA O HA DESARROLLADO PROYECTOS: '),0,0,'L', true); //Titulo del reporte
$pdf->Ln();
$pdf->SetFont('Arial','B',9);
		$width=190/6;
		$pdf->Cell($width,8,utf8_decode('Entidad'),1,0,'C'); //Titulo del reporte
		$pdf->Cell($width,8,'Nombre Proyecto',1,0,'C'); //Titulo del reporte
		$pdf->Cell($width,8,utf8_decode('Duración'),1,0,'C'); //Titulo del reporte
		$pdf->Cell($width*2,8,'Actividad',1,0,'C'); //Titulo del reporte
		$pdf->Cell($width,8,'Beneficiarios',1,0,'C'); //Titulo del reporte
		$pdf->Ln();
		$pdf->SetFont('Arial','',9);
		$pdf->SetWidths(array($width,$width,$width,$width*2,$width));
		while($fila = mysqli_fetch_array($respuesta)){
			$datetime1 = date_create(str_replace('/','-',$fila['VC_Inicio']));
			$datetime2 = date_create(str_replace('/','-',$fila['VC_Fin']));
			$interval = date_diff($datetime1, $datetime2);
			$dias = $interval->format('%y año(s) %m mes(es) %d dia(s)');

			//$dias	= (date('d/m/Y', strtotime($fila['VC_Inicio'])))-(date('d/m/Y', strtotime($fila['VC_Fin'])))/86400;
			//$dias 	= abs($dias); $dias = floor($dias);
			//$meses = $dias/30;
			$pdf->Row(array($fila['VC_Entidad'],$fila['VC_Nombre_Proyecto'],utf8_decode($dias),$fila["VC_Actividad_Desarrollada"],$fila["FL_Cantidad_Beneficiados"]));
		}
		$pdf->Ln();

//DESCRIPCION DEL PROBLEMA
$pdf->SetFillColor(0,69,134);
$pdf->SetTextColor(255,255,255);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(190,8,utf8_decode('4. DESCRIPCIÓN LA SITUACIÓN O PROBLEMA A RESOLVER'),0,0,'C', true); //Titulo del reporte
$pdf->Ln();
$pdf->SetTextColor(0,0,0);
$respuesta = mysqli_query($conexio,'SELECT VC_Descripcion_Problema FROM tb_propuesta_proyecto WHERE FK_Id_Usuario="'.$_GET['ident'].'";');
$pdf->SetFont('Arial','',9);
		$width=190;
		$pdf->SetFont('Arial','',9);
		$pdf->SetWidths(array($width));
		while($fila = mysqli_fetch_array($respuesta)){
			$pdf->MultiCell(190, 5, $fila['VC_Descripcion_Problema'], 1, 'J', false);
			//$pdf->Row(array($fila['VC_Descripcion_Problema']));
		}
		$pdf->Ln();

//OBJETIVOS DEL PROYETO
$pdf->SetFillColor(0,69,134);
$pdf->SetTextColor(255,255,255);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(190,8,utf8_decode('5. OBJETIVOS DEL PROYECTO'),0,0,'C', true); //Titulo del reporte
$pdf->Ln();
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(204,204,204);
$pdf->SetFont('Arial','',9);
$pdf->Cell(190,8,utf8_decode('OBJETIVO GENERAL '),0,0,'C', true); //
$pdf->Ln();
$respuesta = mysqli_query($conexio,'SELECT VC_Objetivo_General FROM tb_propuesta_proyecto WHERE FK_Id_Usuario="'.$_GET['ident'].'";');
		$width=190;
		$pdf->SetWidths(array($width));
		while($fila = mysqli_fetch_array($respuesta)){
			$pdf->MultiCell(190, 5, $fila['VC_Objetivo_General'], 1, 'J', false);
			//$pdf->Row(array($fila['VC_Descripcion_Problema']));
		}
		$pdf->Ln();

$pdf->Cell(190,8,utf8_decode('OBJETIVOS ESPECÍFICOS '),0,0,'C', true); //
$pdf->Ln();
		$width=190/2;
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell($width,8,utf8_decode('Objetivo Específico: '),1,0,'C'); //Titulo del reporte
		$pdf->Cell($width,8,'Actividades ',1,0,'C'); //Titulo del reporte
		$pdf->Ln();
$respuesta = mysqli_query($conexio,'SELECT * FROM tb_propuesta_proyecto_obj_especificos WHERE FK_Id_Usuario="'.$_GET['ident'].'";');
$pdf->SetFont('Arial','',9);
		$width=190/2;
		$pdf->SetWidths(array($width,$width));
		while($fila = mysqli_fetch_array($respuesta)){
			$pdf->Row(array($fila['VC_Objetivo_Especifico'],$fila['VC_Actividades']));
		}
		$pdf->Ln();

//DESCRIPCION DEL PROYETO
$pdf->SetFillColor(0,69,134);
$pdf->SetTextColor(255,255,255);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(190,8,utf8_decode('6. DESCRIPCION DEL PROYECTO'),0,0,'C', true); //Titulo del reporte
$pdf->Ln();
$pdf->SetTextColor(0,0,0);
$respuesta = mysqli_query($conexio,'SELECT VC_Descripcion_Proyecto FROM tb_propuesta_proyecto WHERE FK_Id_Usuario="'.$_GET['ident'].'";');
$pdf->SetFont('Arial','',9);
		$width=190;
		$pdf->SetWidths(array($width));
		while($fila = mysqli_fetch_array($respuesta)){
			$pdf->MultiCell(190, 5, $fila['VC_Descripcion_Proyecto'], 1, 'J', false);
			//$pdf->Row(array($fila['VC_Descripcion_Problema']));
		}
		$pdf->Ln();

//POBLACION OBJEIVO DEL PROYETO
$pdf->SetFillColor(0,69,134);
$pdf->SetTextColor(255,255,255);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(190,8,utf8_decode('7. POBLACION OBJETIVO DEL PROYECTO'),0,0,'C', true); //Titulo del reporte
$pdf->Ln();
$pdf->SetTextColor(0,0,0);
$respuesta = mysqli_query($conexio,'SELECT VC_Beneficiarios, FL_Cantidad_Beneficiados FROM tb_propuesta_proyecto WHERE FK_Id_Usuario="'.$_GET['ident'].'";');
		$pdf->SetFont('Arial','',9);
		$width=190;
		$pdf->SetWidths(array($width));
		//$pdf->SetMargins(75, 0, 0);
		while($fila = mysqli_fetch_array($respuesta)){
			$categorias = explode(",",$fila["VC_Beneficiarios"]);
			$pdf->MultiCell(190, 5,'Los beneficiarios se encuentran clasificados o distribuidos mediante la siguiente tabla', 1, 'J', false);
			$pdf->Ln();
				$pdf->SetFont('Arial','B',9);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Beneficiarios según sexo'),1, 'C', false);
				$pdf->SetFont('Arial','',9);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,'Mujeres: '.$categorias[0], 1, 'J', false);$pdf->setX(75);
				$pdf->MultiCell(190/3, 5,'Hombres: '.$categorias[1], 1, 'J', false);$pdf->setX(75);
				$pdf->SetFont('Arial','B',9);				
				$pdf->MultiCell(190/3, 5,'Total Beneficiarios: '.($categorias[0]+$categorias[1]), 1, 'J', false);$pdf->setX(75);					
				$pdf->SetFont('Arial','B',9);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Beneficiarios según Ciclo vital'),1, 'C', false);
				$pdf->SetFont('Arial','',9);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Primera Infancia (0-5 años): ').$categorias[2], 1, 'J', false);$pdf->setX(75);
				$pdf->MultiCell(190/3, 5,utf8_decode('Infancia (6-11 años): ').$categorias[3], 1, 'J', false);$pdf->setX(75);		
				$pdf->MultiCell(190/3, 5,utf8_decode('Adolescencia (12-13 años): ').$categorias[4], 1, 'J', false);$pdf->setX(75);	
				$pdf->MultiCell(190/3, 5,utf8_decode('Juventud (14-26 años): ').$categorias[5], 1, 'J', false);$pdf->setX(75);
				$pdf->MultiCell(190/3, 5,utf8_decode('Adulto (27-59 años): ').$categorias[6], 1, 'J', false);$pdf->setX(75);		
				$pdf->MultiCell(190/3, 5,utf8_decode('Adulto Mayor (60 años y más): ').$categorias[7], 1, 'J', false);$pdf->setX(75);
				$pdf->SetFont('Arial','B',9);
				$pdf->MultiCell(190/3, 5,'Total Beneficiarios: '.($categorias[2]+$categorias[3]+$categorias[4]+$categorias[5]+$categorias[6]+$categorias[7]), 1, 'J', false);$pdf->setX(75);	
				$pdf->SetFont('Arial','B',9);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Beneficiarios según Sector Social'),1, 'C', false);
				$pdf->SetFont('Arial','',9);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Campesinos: ').$categorias[8], 1, 'J', false);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Artesanos: ').$categorias[9], 1, 'J', false);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Personas con discapacidad: ').$categorias[10], 1, 'J', false);$pdf->setX(75);	
				$pdf->MultiCell(190/3, 5,utf8_decode('LBGTI: ').$categorias[11], 1, 'J', false);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Reinsertados - Reincorporados: ').$categorias[12], 1, 'J', false);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Víctimas: ').$categorias[13], 1, 'J', false);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Dezplazados: ').$categorias[14], 1, 'J', false);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Habitantes de calle: ').$categorias[15], 1, 'J', false);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Medios comunitarios: ').$categorias[16], 1, 'J', false);$pdf->setX(75);
				$pdf->SetFont('Arial','B',9);
				$pdf->MultiCell(190/3, 5,'Total Beneficiarios: '.($categorias[8]+$categorias[9]+$categorias[10]+$categorias[11]+$categorias[12]+$categorias[13]+$categorias[14]+$categorias[15]+$categorias[16]), 1, 'J', false);$pdf->setX(75);
				$pdf->SetFont('Arial','B',9);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Beneficiarios según la étnia'),1, 'C', false);
				$pdf->SetFont('Arial','',9);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Pueblo Raizal: ').$categorias[17], 1, 'J', false);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Afrodescendientes,negritudes,palenque: ').$categorias[18], 1, 'J', false);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Pueblo Rrom - gitano: ').$categorias[19], 1, 'J', false);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Pueblos indígenas: ').$categorias[20], 1, 'J', false);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Otras etnias: ').$categorias[21], 1, 'J', false);$pdf->setX(75);
				$pdf->SetFont('Arial','B',9);
				$pdf->MultiCell(190/3, 5,'Total Beneficiarios: '.($categorias[17]+$categorias[18]+$categorias[19]+$categorias[20]+$categorias[21]), 1, 'J', false);$pdf->setX(75);
				$pdf->SetFont('Arial','B',9);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Beneficiarios según Estrato'),1, 'C', false);
				$pdf->SetFont('Arial','',9);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Estrato 1: ').$categorias[22], 1, 'J', false);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Estrato 2: ').$categorias[23], 1, 'J', false);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Estrato 3: ').$categorias[24], 1, 'J', false);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Estrato 4: ').$categorias[25], 1, 'J', false);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Estrato 5: ').$categorias[26], 1, 'J', false);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Estrato 6: ').$categorias[27], 1, 'J', false);$pdf->setX(75);
				$pdf->SetFont('Arial','B',9);
				$pdf->MultiCell(190/3, 5,'Total Beneficiarios: '.($categorias[22]+$categorias[23]+$categorias[24]+$categorias[25]+$categorias[26]+$categorias[27]), 1, 'J', false);$pdf->setX(75);
				$pdf->SetFont('Arial','B',9);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Beneficiarios según Alcance'),1, 'C', false);
				$pdf->SetFont('Arial','',9);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Local: ').$categorias[28], 1, 'J', false);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('InterLocal: ').$categorias[29], 1, 'J', false);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Metropolitano: ').$categorias[30], 1, 'J', false);$pdf->setX(75);
				$pdf->SetFont('Arial','B',9);
				$pdf->MultiCell(190/3, 5,'Total Beneficiarios: '.($categorias[28]+$categorias[29]+$categorias[30]), 1, 'J', false);$pdf->setX(75);
				$pdf->SetFont('Arial','B',9);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Beneficiarios según Localidad'),1, 'C', false);
				$pdf->SetFont('Arial','',9);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Usaquén: ').$categorias[31], 1, 'J', false);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Chapinero: ').$categorias[32], 1, 'J', false);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Santa Fe: ').$categorias[33], 1, 'J', false);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('San Cristobal: ').$categorias[34], 1, 'J', false);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Usme: ').$categorias[35], 1, 'J', false);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Tunjuelito: ').$categorias[36], 1, 'J', false);$pdf->setX(75);
				$pdf->MultiCell(190/3, 5,utf8_decode('Bosa: ').$categorias[37], 1, 'J', false);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Kennedy: ').$categorias[38], 1, 'J', false);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Fontibón: ').$categorias[39], 1, 'J', false);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Engativá: ').$categorias[40], 1, 'J', false);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Suba: ').$categorias[41], 1, 'J', false);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Barrios Unidos: ').$categorias[42], 1, 'J', false);$pdf->setX(75);
				$pdf->MultiCell(190/3, 5,utf8_decode('Teusaquillo: ').$categorias[43], 1, 'J', false);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Mártires: ').$categorias[44], 1, 'J', false);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Antonio Nariño: ').$categorias[45], 1, 'J', false);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Puente Aranda: ').$categorias[46], 1, 'J', false);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Candelaria: ').$categorias[47], 1, 'J', false);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Rafael Uribe: ').$categorias[48], 1, 'J', false);$pdf->setX(75);
				$pdf->MultiCell(190/3, 5,utf8_decode('Ciudad Bolivar: ').$categorias[49], 1, 'J', false);$pdf->setX(75);					
				$pdf->MultiCell(190/3, 5,utf8_decode('Sumapaz: ').$categorias[50], 1, 'J', false);$pdf->setX(75);
				$pdf->SetFont('Arial','B',9);
				$pdf->MultiCell(190/3, 5,'Total Beneficiarios: '.($categorias[31]+$categorias[32]+$categorias[33]+$categorias[34]+$categorias[35]+$categorias[36]+$categorias[37]+$categorias[38]+$categorias[39]+$categorias[40]+$categorias[41]+$categorias[42]+$categorias[43]+$categorias[44]+$categorias[45]+$categorias[46]+$categorias[47]+$categorias[48]+$categorias[49]+$categorias[50]), 1, 'J', false);$pdf->setX(75);
				//$pdf->Row(array($fila['VC_Descripcion_Problema']));
		}
		$pdf->Ln();

//METAS DEL PROYETO
$pdf->SetFillColor(0,69,134);
$pdf->SetTextColor(255,255,255);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(190,8,utf8_decode('8. METAS DEL PROYECTO'),0,0,'C', true); //Titulo del reporte
$pdf->Ln();
$pdf->SetTextColor(0,0,0);
$width=190/5;
		$pdf->Cell($width,8,utf8_decode('Proceso'),1,0,'C'); //Titulo del reporte
		$pdf->Cell($width/2,8,'Magnitud',1,0,'C'); //Titulo del reporte
		$pdf->Cell($width,8,utf8_decode('Unidad de Medida'),1,0,'C'); //Titulo del reporte
		$pdf->Cell($width+($width/2),8,'Descripcion',1,0,'C'); //Titulo del reporte
		$pdf->Cell($width,8,'Periodo',1,0,'C'); //Titulo del reporte
		$pdf->Ln();
$respuesta = mysqli_query($conexio,'SELECT * FROM tb_propuesta_proyecto_metas WHERE FK_Id_Usuario="'.$_GET['ident'].'";');
$pdf->SetFont('Arial','',9);
		$width=190/5;
		$pdf->SetWidths(array($width,$width/2,$width,$width+($width/2),$width));
		while($fila = mysqli_fetch_array($respuesta)){
			$pdf->Row(array($fila['VC_Proceso'],$fila['VC_Magnitud'],$fila['VC_Unidad_Medida'],$fila['VC_Descripcion'],$fila['VC_Periodo']));
		}
		$pdf->Ln();

//INDICADORES DEL PROYETO
$pdf->SetFillColor(0,69,134);
$pdf->SetTextColor(255,255,255);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(190,8,utf8_decode('9. INDICADORES DEL PROYECTO'),0,0,'C', true); //Titulo del reporte
$pdf->Ln();
$pdf->SetTextColor(0,0,0);
$width=190/5;
		$pdf->Cell($width,8,utf8_decode('Indicador'),1,0,'C'); //Titulo del reporte
		$pdf->Cell($width+($width/2),8,utf8_decode('Fórmula'),1,0,'C'); //Titulo del reporte
		$pdf->Cell($width/2,8,utf8_decode('Edo Inicial'),1,0,'C'); //Titulo del reporte
		$pdf->Cell($width,8,'Valor Esperado',1,0,'C'); //Titulo del reporte
		$pdf->Cell($width,8,'Periodo',1,0,'C'); //Titulo del reporte
		$pdf->Ln();
$respuesta = mysqli_query($conexio,'SELECT * FROM tb_propuesta_proyecto_indicadores WHERE FK_Id_Usuario="'.$_GET['ident'].'";');
$pdf->SetFont('Arial','',9);
		$width=190/5;
		$pdf->SetWidths(array($width,$width+($width/2),$width/2,$width,$width));
		while($fila = mysqli_fetch_array($respuesta)){
			$pdf->Row(array($fila['VC_Nombre_Indicador'],$fila['VC_Formula'],$fila['VC_Estado_Inicial'],$fila['VC_Valor_Esperado'],$fila['VC_Periodo']));
		}
		$pdf->Ln();

//INDICADORES DEL PROYETO
$pdf->SetFillColor(0,69,134);
$pdf->SetTextColor(255,255,255);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(190,8,utf8_decode('10. EQUIPO DE TRABAJO DEL PROYECTO'),0,0,'C', true); //Titulo del reporte
$pdf->Ln();
$pdf->SetTextColor(0,0,0);

$respuesta = mysqli_query($conexio,'SELECT * FROM tb_propuesta_proyecto_equipo WHERE FK_Id_Usuario="'.$_GET['ident'].'";');
$pdf->SetFont('Arial','',9);
		$width=190;
		$pdf->SetWidths(array($width));
		while($fila = mysqli_fetch_array($respuesta)){
			$pdf->SetFont('Arial','B',9);
			$pdf->MultiCell(190, 5,utf8_decode('Nombre: ').$fila['VC_Nombre_Persona'], 1, 'J', false);
			$pdf->MultiCell(190, 5,utf8_decode('Rol: ').$fila['VC_Rol'], 1, 'J', false);
			$pdf->SetFont('Arial','',9);
			$pdf->MultiCell(190, 5,utf8_decode('Perfil: ').$fila['VC_Perfil'], 1, 'J', false);			
			//$pdf->Row(array($fila['VC_Nombre_Persona'],$fila['VC_Perfil'],$fila['VC_Rol']));
		}
		$pdf->Ln();

//ANEXOS DEL PROYETO
$pdf->SetFillColor(0,69,134);
$pdf->SetTextColor(255,255,255);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(190,8,utf8_decode('ANEXOS DEL PROYECTO'),0,0,'C', true); //Titulo del reporte
$pdf->Ln();$pdf->Ln();
$pdf->SetTextColor(0,0,0);
$width=190/2;
$pdf->setX(56.25);
$pdf->SetFillColor(204,204,204);
		$pdf->Cell($width,8,utf8_decode('Nombre Anexo'),1,0,'C', true); //Titulo del reporte
		$pdf->Ln();
$respuesta = mysqli_query($conexio,'SELECT * FROM tb_propuesta_proyecto_archivos WHERE FK_Id_Usuario="'.$_GET['ident'].'" AND VC_Fuente="PROPUESTA";');
$pdf->SetFont('Arial','',9);
		$width=190/2;
		$pdf->SetWidths(array($width));
		while($fila = mysqli_fetch_array($respuesta)){
			//$pdf->setX(56.25);
			//$pdf->Row(array($fila['VC_Nombre_Archivo']));
			$pdf->setX(56.25);
			$pdf->MultiCell(190/2, 5,$fila['VC_Nombre_Archivo'], 1, 'J', false);
		}
		$pdf->Ln();

$pdf->SetFillColor(0,69,134);
$pdf->SetTextColor(255,255,255);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(190,8,utf8_decode('FIRMA Y DECLARACION DE CONOCIMIENTO'),0,0,'C', true); //Titulo del reporte
$pdf->Ln();$pdf->Ln();
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',9);
$pdf->MultiCell(190, 5,utf8_decode('Declaro que, yo ___________________________________________, así como la entidad que legalmente represento, nos encontramos habilitados para contratar con el Estado y no me encuentro incurso en ninguna inhabilidad, y que acepto las condiciones establecidas por el mismo y afirmo cumplirlas en su integridad, incluyendo aquellas referentes a las normas de derechos de autor.'), 0, 'J', false);
$pdf->Ln();$pdf->Ln();
$pdf->Cell(190/2, 5,utf8_decode('Firma del representante legal:     ___________________________'), 0, 'J', false);
$pdf->Cell(190/2, 5,utf8_decode('Nombre del representante legal: ____________________________'), 0, 'J', false);
$pdf->Ln();$pdf->Ln();
$pdf->MultiCell(190, 5,utf8_decode('Documento de identidad:            ___________________________'), 0, 'J', false);


$pdf->Output('ReportePropuesta.pdf','I');
?>