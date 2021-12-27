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
	    $this->Image('../../public/imagenes/Bogota.jpg' , 5, 5, 60 , 40,'JPG');
		$this->Image('../../public/imagenes/clan.jpg' , 160, 10, 40 , 22,'JPG');
		$this->SetFont('Arial','B',12); //Tipo de letra, estilo y tamaño
	    $this->Cell(0,30,'CONVOCATORIA ORGANIZACIONES',0,1,'C'); //Titulo del reporte	   
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
$pdf->SetFillColor(0,69,134);
$pdf->SetTextColor(255,255,255);
$pdf->MultiCell(190,8,utf8_decode('REPORTE DE ENTREGA DE DOCUMENTOS HABILITANTES'),1,'C', true); //Titulo del reporte
$pdf->SetTextColor(0,0,0);
$width=190;
$pdf->Ln();
$pdf->Ln();
$respuesta = mysqli_query($conexio,'SELECT VC_Nombre_Usuario FROM tb_propuesta_usuarios WHERE PK_Id_Usuario="'.$_GET['ident'].'";');
$pdf->SetWidths(array($width));
		while($fila = mysqli_fetch_array($respuesta)){
			$pdf->Row(array('DOCUMENTOS HABILITANTES ENTREGADOS POR EL USUARIO '.strtoupper($fila["VC_Nombre_Usuario"])));
		}

$pdf->SetFont('Arial','',9);
$pdf->Ln();
//DOCUMENTOS HABILITANTES SUBIDOS POR EL USUARIO.
$respuesta = mysqli_query($conexio,'SELECT * FROM tb_propuesta_proyecto_archivos WHERE FK_Id_Usuario="'.$_GET['ident'].'" AND VC_Fuente="HABILITANTE";');
$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(204,204,204);
$pdf->Ln();
$pdf->Cell(190,8,utf8_decode('DOCUMENTOS HABILITANTES ENVIADOS POR LA ORGANIZACIÓN: '),0,0,'C', true); //Titulo del reporte
$pdf->Ln();
$pdf->SetFont('Arial','B',9);
		$width=190/2;
		$pdf->Cell($width+($width/2),8,utf8_decode('Nombre del Archivo: '),1,0,'C'); //Titulo del reporte
		$pdf->Cell($width-($width/2),8,'Tipo Archivo ',1,0,'C'); //Titulo del reporte
		$pdf->Ln();
		$pdf->SetFont('Arial','',9);
		$pdf->SetWidths(array($width+($width/2),$width-($width/2)));
		while($fila = mysqli_fetch_array($respuesta)){
			$pdf->Row(array($fila['VC_Nombre_Archivo'],$fila['VC_Tipo']));
		}
		$pdf->Ln();
$pdf->Output('ReporteHabilitantes.pdf','I');
?>