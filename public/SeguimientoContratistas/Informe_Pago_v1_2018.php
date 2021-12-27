<?php
session_start();
//require_once "../../src/autoloader.php";
if(!isset($_SESSION["session_username"])) {
	header("location:index.php");

} else {
	$Id_Persona = $_SESSION["session_username"];
	$Id_Rol =	$_SESSION['session_usertype'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../css/material-desing.css">
	<link href="../bower_components/summernote/dist/summernote.css" rel="stylesheet">
	<link href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet"> 
	<link href="../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" >  
	<link href="../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet"> 
	<link href="../bower_components/datatables.net-buttons-dt/css/buttons.dataTables.min.css" rel="stylesheet"> 

	<script src="../bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="../bower_components/fontawesome/svg-with-js/js/fontawesome-all.min.js" ></script>
	<script src="../bower_components/summernote/dist/summernote.min.js"></script>
	<script src="../bower_components/summernote/dist/lang/summernote-es-ES.js"></script>
	<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script> 
	<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> 
	<script src="../bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script> 
	<script src="../bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script> 
	<script src="../bower_components/jszip/dist/jszip.min.js"></script> 
	<script src="../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript" ></script>  
	<script src="../bower_components/jquery-validation/dist/jquery.validate.min.js" type="text/javascript" ></script>  
	<script src="../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script> 
	<script src="../bower_components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js"></script>
	<script src="../bower_components/bootstrap-filestyle/src/bootstrap-filestyle.js"> </script>

	<!-- <script type="text/javascript" src="../LibreriasExternas/datatables-plugins/buttons/buttons.html5.min.js"></script> -->
	<script src='../LibreriasExternas/pdfmake-0.1.36/build/pdfmake.js'></script>
	<script src='../LibreriasExternas/pdfmake-0.1.36/build/vfs_fonts.js'></script>

	<script src="Js/Informe_Pago.js?v=2018.10.05.001"></script>
	<link rel="stylesheet" type="text/css" href="Css/Informe_Pago.css">
	<style media="screen">
	.input-group{
		float: left;
	}  
	.control-label-left{
		text-align: left !important;
	}
	.modal-ml {
		width: 95%;
	}
	.popover-content {
		padding: 2px;
		background-color: #ffff4e;
		width: 300px;
	}
	.note-popup {
		width: 300px;
		min-width: 0px;
		padding: 5px;
		background-color: #ffff4e;
	}
	.popover {
		max-width: 400px;
	}
	.btn-old {
		color: white !important;
		background-color: #9e9e9e !important;
		border-color: #d6d6d6 !important;
	}
	.btn-old:hover {
		color: white !important;
		background-color: #777777 !important;
		border-color: #d6d6d6 !important;
	}
	.btn-old:active {
		color: white !important;
		background-color: #777777 !important;
		border-color: #d6d6d6 !important;
	}
	.label-old {
		color: white !important;
		background-color: #9e9e9e !important;
		border-color: #d6d6d6 !important;
	}
	.label-old:hover {
		color: white !important;
		background-color: #777777 !important;
		border-color: #d6d6d6 !important;
	}
	.label-old:active {
		color: white !important;
		background-color: #777777 !important;
		border-color: #d6d6d6 !important;
	}
	.btn-observ {
		color: black !important;
		background-color: #ffff4e !important;
		border-color: #ffff35 !important;
	}
	.btn-observ:hover {
		color: #333 !important;
		background-color: #fbfb8e !important;
		border-color: #ffff35 !important;
	}
	.btn-observ:active {
		color: #333 !important;
		background-color: #fbfb8e !important;
		border-color: #ffff35 !important;
	}
	.material-switch > label::before {
		background: #ff4642;
		box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
		border-radius: 8px;
		content: '';
		height: 16px;
		margin-top: -8px;
		margin-left: 0px;
		position: absolute;
		opacity: 0.3;
		transition: all 0.4s ease-in-out;
		width: 45px;
	}
	.material-switch > label::after {
		background: #ff4642;
		border-radius: 16px;
		box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
		content: '';
		height: 24px;
		left: 0px;
		margin-top: -8px;
		position: absolute;
		top: -4px;
		transition: all 0.3s ease-in-out;
		width: 24px;
	}
	.note-editor.note-frame{
		margin-bottom: 0px;
	}
	/* The container */
	.container {
		display: block;
		position: relative;
		padding-left: 35px;
		margin-bottom: 12px;
		cursor: pointer;
		font-size: 14px;
		-webkit-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none;
	}

	/* Hide the browser's default radio button */
	.container input {
		position: absolute;
		opacity: 0;
		cursor: pointer;
	}

	/* Create a custom radio button */
	.checkmark {
		position: absolute;
		top: 0;
		left: 0;
		height: 21px;
		width: 21px;
		background-color: #eee;
		border-radius: 50%;
	}

	/* On mouse-over, add a grey background color */
	.container:hover input ~ .checkmark {
		background-color: #ccc;
	}

	/* When the radio button is checked, add a blue background */
	.container input:checked ~ .checkmark {
		background-color: #2196F3;
	}

	/* Create the indicator (the dot/circle - hidden when not checked) */
	.checkmark:after {
		content: "";
		position: absolute;
		display: none;
	}

	/* Show the indicator (dot/circle) when checked */
	.container input:checked ~ .checkmark:after {
		display: block;
	}

	/* Style the indicator (dot/circle) */
	.container .checkmark:after {
		top: 7px;
		left: 7px;
		width: 7px;
		height: 7px;
		border-radius: 50%;
		background: white;
	}
</style>
</head>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid" style="padding-top: 30px">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-header">
					<h1 style="font-size: 45px;">Informe para Pago</h1>
					<input type='hidden' id='id-usuario' value='<?php echo $Id_Persona; ?>'>
					<input type='hidden' id='id-rol' value='<?php echo $Id_Rol; ?>'>
				</div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item " ><a class="nav-link" data-toggle="tab" href="#informe_pago" role="tab" id="informe_pago_link">Informe para Pago</a></li>
					<!-- <li class="nav-item active"><a class="nav-link" data-toggle="tab" href="#documento" role="tab">Informe Detallado</a></li> -->
					<li class="nav-item  active"><a class="nav-link" data-toggle="tab" href="#listado" id="listado_link" role="tab">Listado</a></li>
				</ul>
				<div class="tab-content">
					<br>
					<br>
					<div class="tab-pane" id="informe_pago" role="tabpanel">
						<form id="form-informe-pago" class="form-horizontal">
							<fieldset>
								<div id="form-informe-pago-container">
									<div class="form-group text-center row">
										<div align=center>
											<table border=0 cellpadding=0 cellspacing=0 width=1107 class=xl6425986 style='border-collapse:collapse;table-layout:fixed;width:831pt'>
												<col class=xl6325986 width=9 style='mso-width-source:userset;mso-width-alt:
												329;width:7pt'>
												<col class=xl6425986 width=26 style='mso-width-source:userset;mso-width-alt:
												950;width:20pt'>
												<col class=xl6425986 width=31 style='mso-width-source:userset;mso-width-alt:
												1133;width:23pt'>
												<col class=xl6425986 width=40 style='mso-width-source:userset;mso-width-alt:
												1462;width:30pt'>
												<col class=xl6425986 width=4 style='mso-width-source:userset;mso-width-alt:
												146;width:3pt'>
												<col class=xl6425986 width=35 style='mso-width-source:userset;mso-width-alt:
												1280;width:26pt'>
												<col class=xl6425986 width=45 style='mso-width-source:userset;mso-width-alt:
												1645;width:34pt'>
												<col class=xl6425986 width=24 span=2 style='mso-width-source:userset;
												mso-width-alt:877;width:18pt'>
												<col class=xl6425986 width=63 style='mso-width-source:userset;mso-width-alt:
												2304;width:47pt'>
												<col class=xl6425986 width=64 style='mso-width-source:userset;mso-width-alt:
												2340;width:48pt'>
												<col class=xl6425986 width=0 style='display:none;mso-width-source:userset;
												mso-width-alt:0'>
												<col class=xl6425986 width=11 style='mso-width-source:userset;mso-width-alt:
												402;width:8pt'>
												<col class=xl6425986 width=67 style='mso-width-source:userset;mso-width-alt:
												2450;width:50pt'>
												<col class=xl6425986 width=34 style='mso-width-source:userset;mso-width-alt:
												1243;width:26pt'>
												<col class=xl6425986 width=39 style='mso-width-source:userset;mso-width-alt:
												1426;width:29pt'>
												<col class=xl6425986 width=33 style='mso-width-source:userset;mso-width-alt:
												1206;width:25pt'>
												<col class=xl6425986 width=24 style='mso-width-source:userset;mso-width-alt:
												877;width:18pt'>
												<col class=xl6425986 width=19 style='mso-width-source:userset;mso-width-alt:
												694;width:14pt'>
												<col class=xl6425986 width=44 style='mso-width-source:userset;mso-width-alt:
												1609;width:33pt'>
												<col class=xl6425986 width=23 style='mso-width-source:userset;mso-width-alt:
												841;width:17pt'>
												<col class=xl6425986 width=19 style='mso-width-source:userset;mso-width-alt:
												694;width:14pt'>
												<col class=xl6425986 width=0 style='display:none;mso-width-source:userset;
												mso-width-alt:0'>
												<col class=xl6425986 width=40 style='mso-width-source:userset;mso-width-alt:
												1462;width:30pt'>
												<col class=xl6425986 width=51 style='mso-width-source:userset;mso-width-alt:
												1865;width:38pt'>
												<col class=xl6425986 width=34 style='mso-width-source:userset;mso-width-alt:
												1243;width:26pt'>
												<col class=xl6425986 width=22 style='mso-width-source:userset;mso-width-alt:
												804;width:17pt'>
												<col class=xl6425986 width=50 style='mso-width-source:userset;mso-width-alt:
												1828;width:38pt'>
												<col class=xl6425986 width=40 style='mso-width-source:userset;mso-width-alt:
												1462;width:30pt'>
												<col class=xl6425986 width=34 style='mso-width-source:userset;mso-width-alt:
												1243;width:26pt'>
												<col class=xl6425986 width=19 span=2 style='mso-width-source:userset;
												mso-width-alt:694;width:14pt'>
												<col class=xl6425986 width=30 style='mso-width-source:userset;mso-width-alt:
												1097;width:23pt'>
												<col class=xl6425986 width=19 style='mso-width-source:userset;mso-width-alt:
												694;width:14pt'>
												<col class=xl6425986 width=16 style='mso-width-source:userset;mso-width-alt:
												585;width:12pt'>
												<col class=xl6425986 width=43 style='mso-width-source:userset;mso-width-alt:
												1572;width:32pt'>
												<col class=xl6425986 width=12 style='mso-width-source:userset;mso-width-alt:
												438;width:9pt'>
												<col class=xl6425986 width=0 span=13 style='display:none;mso-width-source:
												userset;mso-width-alt:0'>
												<col class=xl6425986 width=0 span=13 style='display:none;mso-width-source:
												userset;mso-width-alt:0'>
												<tr height=10 style='height:7.5pt'>
													<td height=10 class=xl6325986 width=9 style='height:7.5pt;width:7pt'></td>
													<td class=xl6425986 width=26 style='width:20pt'>&nbsp;</td>
													<td class=xl6425986 width=31 style='width:23pt'>&nbsp;</td>
													<td class=xl6425986 width=40 style='width:30pt'>&nbsp;</td>
													<td class=xl6425986 width=4 style='width:3pt'>&nbsp;</td>
													<td class=xl6425986 width=35 style='width:26pt'>&nbsp;</td>
													<td class=xl6425986 width=45 style='width:34pt'>&nbsp;</td>
													<td class=xl6425986 width=24 style='width:18pt'>&nbsp;</td>
													<td class=xl6425986 width=24 style='width:18pt'>&nbsp;</td>
													<td class=xl6425986 width=63 style='width:47pt'>&nbsp;</td>
													<td class=xl6425986 width=64 style='width:48pt'>&nbsp;</td>
													<td class=xl6425986 width=0>&nbsp;</td>
													<td class=xl6425986 width=11 style='width:8pt'>&nbsp;</td>
													<td class=xl6425986 width=67 style='width:50pt'>&nbsp;</td>
													<td class=xl6425986 width=34 style='width:26pt'>&nbsp;</td>
													<td class=xl6425986 width=39 style='width:29pt'>&nbsp;</td>
													<td class=xl6425986 width=33 style='width:25pt'>&nbsp;</td>
													<td class=xl6425986 width=24 style='width:18pt'>&nbsp;</td>
													<td class=xl6425986 width=19 style='width:14pt'>&nbsp;</td>
													<td class=xl6425986 width=44 style='width:33pt'>&nbsp;</td>
													<td class=xl6425986 width=23 style='width:17pt'>&nbsp;</td>
													<td class=xl6425986 width=19 style='width:14pt'>&nbsp;</td>
													<td class=xl6425986 width=0>&nbsp;</td>
													<td class=xl6425986 width=40 style='width:30pt'>&nbsp;</td>
													<td class=xl6425986 width=51 style='width:38pt'>&nbsp;</td>
													<td class=xl6425986 width=34 style='width:26pt'>&nbsp;</td>
													<td class=xl6425986 width=22 style='width:17pt'>&nbsp;</td>
													<td class=xl6425986 width=50 style='width:38pt'>&nbsp;</td>
													<td class=xl6425986 width=40 style='width:30pt'>&nbsp;</td>
													<td class=xl6425986 width=34 style='width:26pt'>&nbsp;</td>
													<td class=xl6425986 width=19 style='width:14pt'>&nbsp;</td>
													<td class=xl6425986 width=19 style='width:14pt'>&nbsp;</td>
													<td class=xl6425986 width=30 style='width:23pt'>&nbsp;</td>
													<td class=xl6425986 width=19 style='width:14pt'>&nbsp;</td>
													<td class=xl6425986 width=16 style='width:12pt'>&nbsp;</td>
													<td class=xl6425986 width=43 style='width:32pt'>&nbsp;</td>
													<td class=xl6425986 width=12 style='width:9pt'>&nbsp;</td>
													<td class=xl6425986 width=0>&nbsp;</td>
													<td class=xl6425986 width=0>&nbsp;</td>
													<td class=xl6425986 width=0>&nbsp;</td>
													<td class=xl6425986 width=0>&nbsp;</td>
													<td class=xl6425986 width=0>&nbsp;</td>
													<td class=xl6425986 width=0>&nbsp;</td>
													<td class=xl6425986 width=0>&nbsp;</td>
													<td class=xl6425986 width=0>&nbsp;</td>
													<td class=xl6425986 width=0>&nbsp;</td>
													<td class=xl6425986 width=0>&nbsp;</td>
													<td class=xl6425986 width=0>&nbsp;</td>
													<td class=xl6425986 width=0>&nbsp;</td>
													<td class=xl6425986 width=0>&nbsp;</td>
												</tr>
												<tr height=19 style='mso-height-source:userset;height:14.25pt'>
													<td height=19 class=xl6325986 style='height:14.25pt'></td>
													<td colspan=8 rowspan=8 height=136 width=229 style='height:120.2pt;
													width:172pt' align=left valign=top><span style='mso-ignore:vglayout;
													position:absolute;z-index:21;margin-left:29px;margin-top:5px;width:138px;
													height:127px'><img width=138 height=127
													src="../imagenes/logo_alcaldia_largo.png"
													v:shapes="_x0035__x0020_Imagen"></span>
													<span style='mso-ignore:vglayout2'>
														<table cellpadding=0 cellspacing=0>
															<tr>
																<td colspan=8 rowspan=8 height=136 class=xl18325986 width=229
																style='height:120.2pt;width:172pt'><a name="RANGE!B2:AJ85">&nbsp;</a></td>
															</tr>
														</table></span>
													</td>
													<td colspan=16 rowspan=5 class=xl18425986>GESTIÓN FINANCIERA</td>
													<td colspan=11 rowspan=2 class=xl18525986>Código: 3TR-GFI-F-01</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=10 style='mso-height-source:userset;height:7.5pt'>
													<td height=10 class=xl6325986 style='height:7.5pt'></td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=10 style='mso-height-source:userset;height:7.5pt'>
													<td height=10 class=xl6325986 style='height:7.5pt'></td>
													<td colspan=11 rowspan=3 class=xl18525986>Fecha: 05/02/2018</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=13 style='mso-height-source:userset;height:9.75pt'>
													<td height=13 class=xl6325986 style='height:9.75pt'></td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=10 style='mso-height-source:userset;height:7.5pt'>
													<td height=10 class=xl6325986 style='height:7.5pt'></td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=16 style='mso-height-source:userset;height:12.6pt'>
													<td height=16 class=xl6325986 style='height:12.6pt'></td>
													<td colspan=16 rowspan=3 class=xl18625986 width=531 style='width:397pt'>INFORME
														PARA PAGO (PERSONA NATURAL Y/O JURÍDICA)
													</td>
													<td colspan=11 rowspan=3 class=xl18525986>Versión: 1</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=4 style='mso-height-source:userset;height:3.0pt'>
													<td height=4 class=xl6325986 style='height:3.0pt'></td>

												</tr>
												<tr height=4 style='mso-height-source:userset;height:3.0pt'>
													<td height=4 class=xl6325986 style='height:3.0pt'></td>

												</tr>
												<tr height=28 style='mso-height-source:userset;height:21.0pt'>
													<td height=28 class=xl6325986 style='height:21.0pt'></td>
													<td colspan=8 class=xl17525986>Fecha del Informe
													</td>
													<!-- <td colspan=8 class=xl18025986 data-toggle="tooltip" title="Este campo se colocará automaticamente al descargar el PDF" data-placement="right">DD/MM/AAAA</td> -->

													<td colspan=8 class=xl18025986 data-toggle="tooltip" title="" data-placement="right">
														<input maxlength="50" style="background-color:white; color:black;" class="text-center form-control datepicker-class" readonly required id="input-fecha-informe" name="input-fecha-informe" placeholder="DD/MM/AAAA" type="text">
													</td>

													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6625986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=36 style='mso-height-source:userset;height:27.0pt'>
													<td height=36 class=xl6325986 style='height:27.0pt'></td>
													<td colspan=35 class=xl17725986>INFORMACIÓN BÁSICA DEL CONTRATISTA
													</td>
												</tr>
												<tr height=36 style='mso-height-source:userset;height:27.0pt'>
													<td height=36 class=xl6325986 style='height:27.0pt'></td>
													<td colspan=7 class=xl17425986>PERÍODO DEL INFORME</td>
													<td colspan=5 class=xl18025986 style='border-left:none;height:  10px;color:black;'><input maxlength="50" style="background-color:white; color:black;" class="text-center form-control datepicker-class" readonly required id="input-periodo-inicio" name="input-periodo-inicio" placeholder="DD/MM/AAAA" type="text"></td>
													<td colspan=5 class=xl18025986 style='border-left:none;height:  10px;color:black;'><input maxlength="50" style="background-color:white; color:black;" class="text-center form-control datepicker-class" readonly required id="input-periodo-fin" name="input-periodo-fin" placeholder="DD/MM/AAAA" type="text"></td>
													<td colspan=10 class=xl17425986 style='border-left:none;height:  100%;color:black;'>No. DEL CONTRATO
													</td>
													<td colspan=8 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" readonly type="text" name="input-numero-contrato" id="input-numero-contrato"></td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=39 style='mso-height-source:userset;height:29.25pt'>
													<td height=39 class=xl6325986 style='height:29.25pt'></td>
													<td colspan=13 class=xl17425986>NOMBRES Y APELLIDOS DEL CONTRATISTA</td>
													<td colspan=14 class=xl17125986 st style='border-left:none;height: 10px;'><input style="width: 100%; height: 100%;" readonly type="text" name="input-nombres-apellidos" id="input-nombres-apellidos"></td>
													<td colspan=3 class=xl17425986 style='border-left:none;height:  10px;color:black;'>
														<select style="width: 100%; height: 100%;"  name="select-identificacion" id="select-identificacion">
														</select>
													</td>
													<td colspan=5 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" name="input-identificacion" id="input-identificacion"></td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=39 style='mso-height-source:userset;height:29.25pt'>
													<td height=39 class=xl6325986 style='height:29.25pt'></td>
													<td colspan=13 class=xl17425986>ACTIVIDAD ECONÓMICA (CIIU)</td>
													<td colspan=14 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" name="input-ciiu" id="input-ciiu" ></td>
													<td colspan=8 class=xl12025986></td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=49 style='mso-height-source:userset;height:36.75pt'>
													<td height=49 class=xl6325986 style='height:36.75pt'></td>
													<td colspan=13 class=xl17025986 width=434 style='width:325pt'>NOMBRES Y
														APELLIDOS DEL CONTRATISTA CEDENTE<br>(Diligencie este item, en caso de cesión de contrato)
													</td>
													<td colspan=14 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" name="input-nombres-apellidos-cedente" id="input-nombres-apellidos-cedente" ></td>
													<td colspan=3 class=xl17425986 style='border-left:none;height:  10px;color:black;'>
														<select style="width: 100%; height: 100%;"  name="select-identificacion-cedente" id="select-identificacion-cedente">
														</select>
													</td>
													<td colspan=5 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" name="input-identificacion-cendete" id="input-identificacion-cendete" ></td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=23 style='mso-height-source:userset;height:17.25pt'>
													<td height=23 class=xl6325986 style='height:17.25pt'>
													</td>
													<td colspan=35 class=xl17325986 width=1086 style='width:815pt'>INFORMACIÓN
														BANCARIA DEL CONTRATISTA A QUIEN SE LE VA A GIRAR
													</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=23 style='mso-height-source:userset;height:17.25pt'>
													<td height=23 class=xl6325986 style='height:17.25pt'></td>
													<td colspan=3 rowspan=2 class=xl17425986>BANCO:</td>
													<td colspan=9 rowspan=2 class=xl17125986 style='border-left:none;height:  10px;color:black;'>
														<select style="width: 100%; height: 100%;"  name="select-banco" id="select-banco" >
														</select>
													</td>
													<td colspan=5 rowspan=2 class=xl17425986>TIPO DE CUENTA:</td>
													<td colspan=6 rowspan=2 class=xl17125986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" name="input-tipo-cuenta" id="input-tipo-cuenta" ></td>
													<td colspan=4 rowspan=2 class=xl17425986>No. CUENTA:</td>
													<td colspan=8 rowspan=2 class=xl17125986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" name="input-numero-cuenta" id="input-numero-cuenta" ></td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=19 style='mso-height-source:userset;height:14.25pt'>
													<td height=19 class=xl6325986 style='height:14.25pt'></td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=24 style='mso-height-source:userset;height:18.0pt'>
													<td height=24 class=xl6325986 style='height:18.0pt'></td>
													<td colspan=35 class=xl16225986>INFORMACIÓN DEL CONTRATO
													</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=50 style='mso-height-source:userset;height:37.5pt'>
													<td height=50 class=xl6325986 style='height:37.5pt'></td>
													<td colspan=4 class=xl16325986>Objeto:</td>
													<td colspan=31 class=xl16425986 width=985 style='border-left:none;height:  10px;color:black;'><textarea rows="3" style="resize: vertical;width: 100%; height: 100%; margin-bottom: -5px;" type="text" name="input-objeto" id="input-objeto" ></textarea></td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=30 style='mso-height-source:userset;height:22.5pt'>
													<td height=30 class=xl6325986 style='height:22.5pt'></td>
													<td colspan=4 class=xl16325986 width=101 style='width:76pt'>Fecha de Inicio</td>
													<td colspan=5 class=xl18025986 style='border-left:none;height:  10px;color:black;'><input maxlength="50" style="background-color:white; color:black;" class="text-center form-control" readonly id="input-fecha-inicio" name="input-fecha-inicio" placeholder="DD/MM/AAAA" type="text"></td>
													<td colspan=4 rowspan=2 class=xl16325986>Plazo Inicial:</td>
													<td colspan=4 rowspan=2 class=xl15925986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" name="input-plazo-inicial" id="input-plazo-inicial" ></td>
													<td colspan=4 rowspan=2 class=xl16325986>Prórrogas:
													</td>
													<td colspan=5 rowspan=2 class=xl15925986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" name="input-prorrogas" id="input-prorrogas" ></td>
													<td colspan=4 rowspan=2 class=xl16325986>Fecha Final:</td>
													<td colspan=5 rowspan=2 class=xl15925986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" maxlength="50" style="background-color:white; color:black;" class="text-center form-control datepicker-class" id="input-fecha-plazo-fin" name="input-fecha-plazo-fin" placeholder="DD/MM/AAAA" type="text"></td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=32 style='mso-height-source:userset;height:24.0pt'>
													<td height=32 class=xl6325986 style='height:24.0pt'></td>
													<td colspan=4 class=xl16325986 width=101 style='width:76pt'>Fecha Terminación</td>
													<td colspan=5 class=xl18025986 style='border-left:none;height:  10px;color:black;'><input maxlength="50" style="background-color:white; color:black;" class="text-center form-control" readonly id="input-fecha-fin" name="input-fecha-fin" placeholder="DD/MM/AAAA" type="text"></td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=23 style='mso-height-source:userset;height:17.25pt'>
													<td height=23 class=xl6325986 style='height:17.25pt'></td>
													<td colspan=9 class=xl15725986 width=292 style='width:219pt'>Número de pagos pactados
													</td>
													<td colspan=4 class=xl12025986 style='height: 10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="numberOnly" name="input-numero-pagos" id="input-numero-pagos" ></td>
													<td colspan=22 class=xl15925986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=32 style='mso-height-source:userset;height:24.0pt'>
													<td height=32 class=xl6325986 style='height:24.0pt'></td>
													<td colspan=4 class=xl14725986 width=101 style='width:76pt'>Pago No.
													</td>
													<td colspan=2 class=xl12025986 style='height: 10px;color:black;'><input style="width: 100%; height: 100%;" type="text" name="input-pago-numero" id="input-pago-numero" ></td>
													<td colspan=2 class=xl12025986 style='height:  10px;color:black;'>de</td>
													<td class=xl12025986 style='height:10px;color:black;'><input style="width: 100%; height: 100%;" type="text" name="input-pago-de-total" id="input-pago-de-total" ></td>
													<td colspan=26 class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=32 style='mso-height-source:userset;height:24.0pt'>
													<td height=32 class=xl6325986 style='height:24.0pt'></td>
													<td colspan=35 class=xl12425986>INFORMACIÓN FINANCIERA DEL CONTRATO</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=45 style='mso-height-source:userset;height:33.75pt'>
													<td height=45 class=xl6325986 style='height:33.75pt'></td>
													<td colspan=4 class=xl15025986 width=101 style='width:76pt'>No REGISTRO<br>PRESUPUESTAL</td>
													<td colspan=5 class=xl15025986>CÓDIGO FUENTE</td>
													<td colspan=4 class=xl15025986>CONVENIO</td>
													<td colspan=4 class=xl15025986>VALOR A PAGAR</td>
													<td colspan=5 class=xl15025986 width=105 style='border-left:none;width:78pt'>No
														REGISTRO<br>
														PRESUPUESTAL
													</td>
													<td colspan=5 class=xl15025986>CÓDIGO FUENTE
													</td>
													<td colspan=4 class=xl15025986>CONVENIO</td>
													<td colspan=4 class=xl15025986>VALOR A PAGAR</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl7025986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=23 style='mso-height-source:userset;height:17.25pt'>
													<td height=23 class=xl6325986 style='height:17.25pt'></td>
													<td colspan=4 class=xl14225986 style='height:10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="rp-contenido" name="input-rp-contenido-a" id="input-rp-contenido-a" value="a) xxxx"></td>
													<td colspan=5 class=xl14225986 style='border-left:none;height:  10px;color:black;'>
														<select style="width: 100%; height: 100%;"  name="select-codigo-a" id="select-codigo-a">
														</select>
													</td>
													<td colspan=4 class=xl14225986 style='border-left:none;height:  10px;color:black;'>
														<select style="width: 100%; height: 100%;"  name="select-convenio-a" id="select-convenio-a">
														</select>
													</td>
													<td colspan=4 class=xl14225986 style='height:10px;color:black;'><input style="width: 100%; height: 100%;" type="text" name="input-rp-valor-a" id="input-rp-valor-a" class="decimalPesos" value="$ 0"></td>
													<td colspan=5 class=xl14225986 style='height:10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="rp-contenido" name="input-rp-contenido-c" id="input-rp-contenido-c" value="c)"></td>
													<td colspan=5 class=xl14225986 style='border-left:none;height:  10px;color:black;'>
														<select style="width: 100%; height: 100%;"  name="select-codigo-c" id="select-codigo-c">
														</select>
													</td>
													<td colspan=4 class=xl14225986 style='border-left:none;height:  10px;color:black;'>
														<select style="width: 100%; height: 100%;"  name="select-convenio-c" id="select-convenio-c">
														</select>
													</td>
													<td colspan=4 class=xl14225986 style='height:10px;color:black;'><input style="width: 100%; height: 100%;" type="text" name="input-rp-valor-c" id="input-rp-valor-c" class="decimalPesos" value="$ 0"></td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=23 style='mso-height-source:userset;height:17.25pt'>
													<td height=23 class=xl6325986 style='height:17.25pt'></td>
													<td colspan=4 class=xl14225986 style='height:10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="rp-contenido" name="input-rp-contenido-b" id="input-rp-contenido-b" value="b)"></td>
													<td colspan=5 class=xl14225986 style='border-left:none;height:  10px;color:black;'>
														<select style="width: 100%; height: 100%;"  name="select-codigo-b" id="select-codigo-b">
														</select>
													</td>
													<td colspan=4 class=xl14225986 style='border-left:none;height:  10px;color:black;'>
														<select style="width: 100%; height: 100%;"  name="select-convenio-b" id="select-convenio-b">
														</select>
													</td>
													<td colspan=4 class=xl14225986 style='height:10px;color:black;'><input style="width: 100%; height: 100%;" type="text" name="input-rp-valor-b" id="input-rp-valor-b" class="decimalPesos" value="$ 0"></td>
													<td colspan=5 class=xl14225986 style='height:10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="rp-contenido" name="input-rp-contenido-d" id="input-rp-contenido-d" value="d)"></td>
													<td colspan=5 class=xl14225986 style='border-left:none;height:  10px;color:black;'>
														<select style="width: 100%; height: 100%;"  name="select-codigo-d" id="select-codigo-d">
														</select>
													</td>
													<td colspan=4 class=xl14225986 style='border-left:none;height:  10px;color:black;'>
														<select style="width: 100%; height: 100%;"  name="select-convenio-d" id="select-convenio-d">
														</select>
													</td>
													<td colspan=4 class=xl14225986 style='height:10px;color:black;'><input style="width: 100%; height: 100%;" type="text" name="input-rp-valor-d" id="input-rp-valor-d" class="decimalPesos" value="$ 0"></td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=38 style='mso-height-source:userset;height:28.5pt'>
													<td height=38 class=xl6325986 style='height:28.5pt'></td>
													<td colspan=6 class=xl8725986>Valor inicial Contrato:</td>
													<td colspan=29 class=xl13625986  style='height:10px;color:black;'><input readonly style="width: 100%; height: 100%;" type="text" name="input-valor-inicial" id="input-valor-inicial" class="decimalPesos sum-total" value="$ 0"></td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=38 style='mso-height-source:userset;height:28.5pt'>
													<td height=38 class=xl6325986 style='height:28.5pt'></td>
													<td colspan=6 class=xl8725986>Valor Adición 1</td>
													<td colspan=29 class=xl13625986  style='height:10px;color:black;'><input style="width: 100%; height: 100%;" type="text" name="input-valor-adicion-1" id="input-valor-adicion-1" class="decimalPesos sum-total" value="$ 0"></td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=38 style='mso-height-source:userset;height:28.5pt'>
													<td height=38 class=xl6325986 style='height:28.5pt'></td>
													<td colspan=6 class=xl8725986>Valor Adición 2</td>
													<td colspan=29 class=xl13625986  style='height:10px;color:black;'><input style="width: 100%; height: 100%;" type="text" name="input-valor-adicion-2" id="input-valor-adicion-2" class="decimalPesos sum-total" value="$ 0"></td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=38 style='mso-height-source:userset;height:28.5pt'>
													<td height=38 class=xl6325986 style='height:28.5pt'></td>
													<td colspan=6 class=xl8725986>Valor Adición 3</td>
													<td colspan=29 class=xl13625986  style='height:10px;color:black;'><input style="width: 100%; height: 100%;" type="text" name="input-valor-adicion-3" id="input-valor-adicion-3" class="decimalPesos sum-total" value="$ 0"></td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=38 style='mso-height-source:userset;height:28.5pt'>
													<td height=38 class=xl6325986 style='height:28.5pt'></td>
													<td colspan=6 class=xl13225986 width=181 style='width:136pt'>Valor total del Contrato (Incluidas adiciones)</td>
													<td colspan=29 class=xl13625986  style='height:10px;color:black;'><input style="width: 100%; height: 100%;" type="text" readonly name="input-valor-total-contrato" id="input-valor-total-contrato" class="decimalPesos" value="$ 0"></td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=60 style='mso-height-source:userset;height:45.0pt'>
													<td height=60 class=xl6325986 style='height:45.0pt'></td>
													<td colspan=6 class=xl9125986 width=181 style='width:136pt'>Valor pago a efectuar</td>
													<td colspan=5 class=xl13625986 style='height:10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="decimalPesos refresh-saldo pago-efectuar" name="input-valor-pago-efectuar" id="input-valor-pago-efectuar" value="$ 0"></td>
													<td colspan=3 class=xl13925986>Valor en letras</td>
													<td colspan=21 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" name="input-valor-letras" id="input-valor-letras" readonly ></td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=43 style='mso-height-source:userset;height:32.25pt'>
													<td height=43 class=xl6325986 style='height:32.25pt'></td>
													<td colspan=6 class=xl13225986 width=181 style='width:136pt'>Giros efectuados a la fecha
													</td>
													<td colspan=29 class=xl13625986 style='height:10px;color:black;'><input style="width: 100%; height: 100%;" type="text" name="input-giros-efectuados" id="input-giros-efectuados" class="decimalPesos refresh-saldo" value="$ 0"></td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=43 style='mso-height-source:userset;height:32.25pt'>
													<td height=43 class=xl6325986 style='height:32.25pt'></td>
													<td colspan=6 class=xl13225986 width=181 style='width:136pt'>Saldo pendiente de giro
													</td>
													<td colspan=29 class=xl13625986 style='height:10px;color:black;'><input  readonly style="width: 100%; height: 100%;" type="text" name="input-saldo-pediente" id="input-saldo-pediente" class="decimalPesos" value="$ 0"></td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=43 style='mso-height-source:userset;height:32.25pt'>
													<td height=43 class=xl6325986 style='height:32.25pt'></td>
													<td colspan=6 class=xl13525986 width=181 style='width:136pt'>Valor a liberar
													</td>
													<td colspan=29 class=xl13625986 style='height:10px;color:black;'><input style="width: 100%; height: 100%;" type="text" name="input-valor-liberar" id="input-valor-liberar" class="decimalPesos" value="$ 0"></td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=25 style='mso-height-source:userset;height:18.75pt'>
													<td height=25 class=xl6325986 style='height:18.75pt'></td>
													<td colspan=35 class=xl12425986>ACTIVIDADES DEL CONTRATISTA DURANTE EL PERÍODO DEL INFORME
													</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=43 style='mso-height-source:userset;height:25.25pt'>
													<td height=43 class=xl6325986 style='height:32.25pt'></td>
													<td colspan=6 class=xl13525986 width=181 style='width:136pt'>Cantidad de Obligaciones</td>
													<td colspan=29 class=xl13625986 style='height:10px;color:black;'><input style="width: 100%; height: 100%;" type="number" name="input-numero-obligaciones" id="input-numero-obligaciones" value="4"></td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=43 style='mso-height-source:userset;height:32.25pt'>
													<td height=43 class=xl6325986 style='height:32.25pt'></td>
													<td colspan=35 class=xl12425986>PRODUCTOS ENTREGADOS DURANTE EL PERÍODO DEL
														PRESENTE INFORME
													</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=36 style='page-break-before:always;mso-height-source:userset;height:27.0pt'>
													<td height=36 class=xl6325986 style='height:27.0pt'></td>
													<td colspan=13 class=xl12725986>PRODUCTO ENTREGADO</td>
													<td colspan=6 class=xl12825986 width=193 style='border-left:none;width:145pt'>FECHA DE ENTREGA  DEL PRODUCTO</td>
													<td colspan=16 class=xl12725986 >MECANISMO DE VERIFICACIÓN</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=46 style='mso-height-source:userset;height:34.5pt'>
													<td height=46 class=xl6325986 style='height:34.5pt'></td>
													<td colspan=13 class=xl12225986 style='height:  10px;color:black;'><textarea rows="5" style="resize: vertical;width: 100%; height: 100%;" type="text" name="textarea-producto" id="textarea-producto" > </textarea></td>													
													<td colspan=6 class=xl12225986 style='border-left:none;height: 10px;color:black;' ><div style="height:100%" data-toggle="tooltip" title="Este campo se colocará automaticamente al descargar el PDF" data-placement="right"><br><br><span id="span-fecha-informe">DD/MM/AAAA</span> </div></td>
													<td colspan=16 class=xl12225986 style='border-left:none;height:  10px;color:black;'>
														<textarea rows="5" style="resize: vertical;width: 100%; height: 100%;" type="text" name="textarea-mecanismo-verificacion" id="textarea-mecanismo-verificacion" placeholder="(En este espacio, por favor indique si adjunta medio magnético , anexos físicos o por favor mencione el nombre de la Tabla de retención documental del Sistema ORFEO donde reposa la prueba del producto entregado por usted)."></textarea>
													</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=53 style='mso-height-source:userset;height:39.75pt'>
													<td height=53 class=xl6325986 style='height:39.75pt'></td>
													<td colspan=35 class=xl12425986>DECLARACIÓN JURAMENTADA
													</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=22 style='mso-height-source:userset;height:16.7pt'>
													<td height=22 class=xl6325986 style='height:16.7pt'></td>
													<td colspan=11 class=xl12525986>&nbsp;</td>
													<td colspan=2 class=xl12825986 >SI</td>
													<td colspan=2 class=xl12825986 >NO</td>
													<td colspan=20 class=xl12825986 >OBSERVACIONES</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=22 style='mso-height-source:userset;height:16.7pt'>
													<td height=22 class=xl6325986 style='height:16.7pt'></td>
													<td colspan=11 class=xl8725986>¿Es usted persona natural del régimen común?</td>
													<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="declaracion declaracion-si" name="input-declaracion-1-si" id="input-declaracion-1-si" ></td>
													<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="declaracion declaracion-no" name="input-declaracion-1-no" id="input-declaracion-1-no" ></td>
													<td colspan=20 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" name="input-declaracion-1-observacion" id="input-declaracion-1-observacion" ></td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=22 style='mso-height-source:userset;height:16.7pt'>
													<td height=22 class=xl6325986 style='height:16.7pt'></td>
													<td colspan=11 class=xl8725986>¿Es usted persona natural del régimen simplificado?
													</td>
													<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="declaracion declaracion-si" name="input-declaracion-2-si" id="input-declaracion-2-si" ></td>
													<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="declaracion declaracion-no" name="input-declaracion-2-no" id="input-declaracion-2-no" ></td>
													<td colspan=20 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" name="input-declaracion-2-observacion" id="input-declaracion-2-observacion" ></td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=22 style='mso-height-source:userset;height:16.7pt'>
													<td height=22 class=xl6325986 style='height:16.7pt'></td>
													<td colspan=11 class=xl9125986 width=356 style='border-right:.5pt solid black;
													width:267pt'>¿Es responsable de declaración de renta año inmediatamente anterior?</td>
													<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="declaracion declaracion-si" name="input-declaracion-3-si" id="input-declaracion-3-si" ></td>
													<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="declaracion declaracion-no" name="input-declaracion-3-no" id="input-declaracion-3-no" ></td>
													<td colspan=20 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" name="input-declaracion-3-observacion" id="input-declaracion-3-observacion" ></td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=34 style='mso-height-source:userset;height:25.9pt'>
													<td height=34 class=xl6325986 style='height:25.9pt'></td>
													<td colspan=11 class=xl9125986 width=356 style='border-right:.5pt solid black;
													width:267pt'>Tiene dependientes a su cargo? (Decreto 1070 de 2013 Art. 387	E.T.)</td>

													<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="declaracion declaracion-si" name="input-declaracion-4-si" id="input-declaracion-4-si" ></td>
													<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="declaracion declaracion-no" name="input-declaracion-4-no" id="input-declaracion-4-no" ></td>
													<td colspan=20 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text"  name="input-declaracion-4-observacion" id="input-declaracion-4-observacion" ></td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=36 style='mso-height-source:userset;height:27.0pt'>
													<td height=36 class=xl6325986 style='height:27.0pt'></td>
													<td colspan=11 class=xl9125986 width=356 style='border-right:.5pt solid black; width:267pt'>¿Efectua pago en su cuenta AFC? De ser así en observaciones
														indique el valor mensual
													</td>

													<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="declaracion declaracion-si" name="input-declaracion-5-si" id="input-declaracion-5-si" ></td>
													<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="declaracion declaracion-no" name="input-declaracion-5-no" id="input-declaracion-5-no" ></td>
													<td colspan=20 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text"  name="input-declaracion-5-observacion" id="input-declaracion-5-observacion" ></td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=35 style='mso-height-source:userset;height:26.45pt'>
													<td height=35 class=xl6325986 style='height:26.45pt'></td>
													<td colspan=11 class=xl9125986 width=356 style='border-right:.5pt solid black;width:267pt'>Efectua pagos por concepto de medicina prepagada? (Art. 387
													E.T.) de ser así, en observaciones indique el valor mensual que paga</td>

													<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="declaracion declaracion-si" name="input-declaracion-6-si" id="input-declaracion-6-si" ></td>
													<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="declaracion declaracion-no" name="input-declaracion-6-no" id="input-declaracion-6-no" ></td>
													<td colspan=20 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text"  name="input-declaracion-6-observacion" id="input-declaracion-6-observacion" ></td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=52 style='mso-height-source:userset;height:39.6pt'>
													<td height=52 class=xl6325986 style='height:39.6pt'></td>
													<td colspan=11 class=xl9125986 width=356 style='border-right:.5pt solid black; width:267pt'>¿Actualmente tiene suscrito otros contratos con el Distrito o la Nación?</td>

													<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="declaracion declaracion-si" name="input-declaracion-7-si" id="input-declaracion-7-si" ></td>
													<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="declaracion declaracion-no" name="input-declaracion-7-no" id="input-declaracion-7-no" ></td>
													<td colspan=20 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text"  name="input-declaracion-7-observacion" id="input-declaracion-7-observacion" ></td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=24 style='mso-height-source:userset;height:18.0pt'>
													<td height=24 class=xl6325986 style='height:18.0pt'></td>
													<td colspan=35 rowspan=2 class=xl10225986 width=1086 style='border-right:.5pt solid black;border-bottom:.5pt hairline black;width:815pt'>Yo <span id="nombre-contratista-juramento"> JAVIER LEONARDO LEON NUÑEZ</span>,
														en mi calidad de contratista del IDARTES certifico bajo la gravedad de
														juramento, que los documentos soporte del pago de Salud, Pensión y ARL,
														corresponden a los ingresos provenientes del contrato materia del pago sujeto
														a retención y que estos aportes <font class="font625986">NO</font><font
														class="font525986"> <input style="width: 25px; height:20px" type="text" class="declaracion"  name="input-disminucion-retencion-no" id="input-disminucion-retencion-no" > </font><font class="font625986">SI</font><font class="font525986"> <input style="width: 25px; height:20px" type="text" class="declaracion"  name="input-disminucion-retencion-si" id="input-disminucion-retencion-si" > sirvieron para la disminución de la base de Retención en la Fuente de Renta o del impuesto de Industria y Comercio en otro cobro, por lo tanto </font><font
														class="font625986">NO</font><font class="font525986"> <input style="width: 25px; height:20px" type="text" class="declaracion"  name="input-tomados-retencion-no" id="input-tomados-retencion-no" > </font><font
														class="font625986">SI</font><font
														class="font525986"> <input style="width: 25px; height:20px" type="text" class="declaracion"  name="input-tomados-retencion-si" id="input-tomados-retencion-si" > pueden ser tomados para tal fin por el IDARTES.<br>
														<br> El (los) número(s) o referencias(s) de las(s) planilla(s) por el aporte de(l) (los) mes(es) de <input style="width: 200px; height:20px" type="text" name="input-mes-planilla" id="input-mes-planilla"  data-toggle="tooltip" title="Ejemplo: Enero, Febrero, ..." data-placement="top"> es(son):<br>
														<input style="width: 200px; height:20px" type="text" name="input-numero-planilla" id="input-numero-planilla" data-toggle="tooltip" title="Ejemplo: 00000000, 11111111, ..." data-placement="top"> (Anexo copia(s) de la(s) planilla(s)).</font>
														<div class="form-group row" >
															<div class="col-md-12 col-lg-12">
																<br>
																<div class="col-md-11 col-lg-11" id="div_descarga_planilla">

																</div>
																<br>
																<div id="div_anexo_planilla" style="    margin-top: 6px;" data-toggle="tooltip" title="Dejar Vacío para no modificar" data-placement="right" class="col-md-4 col-lg-4">
																	<input accept="application/pdf" id="anexo_planilla" multiple name="file[]" type="file" class="filestyle" data-btnClass="btn-danger" data-buttonBefore="true" runat="server" data-text="&nbspPlanilla(s) y/o Extras">
																</div>
																<div class="col-md-4 col-lg-4" id="div_progressbar_planilla">
																	<div style="padding-top: 5px">
																		<div class="progress" style="margin-bottom: 20px;">
																			<div class="progress-bar progress-bar-striped active" role="progressbar" id="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
																				<span >0%</span>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=139 style='mso-height-source:userset;height:104.45pt'>
													<td height=139 class=xl6325986 style='height:104.45pt'></td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=12 style='mso-height-source:userset;height:9.4pt'>
													<td height=12 class=xl6325986 style='height:9.4pt'></td>
													<td colspan=35 class=xl9925986 style='border-right:.5pt solid black'>LOS
														PRODUCTOS QUE SE CERTIFICAN Y EL CUMPLIMIENTO DE OBLIGACIONES CONTRACTUALES
														HAN SIDO VERIFICADOS POR:
													</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=20 style='mso-height-source:userset;height:15.0pt'>
													<td height=20 class=xl6325986 style='height:15.0pt'></td>
													<td colspan=35 rowspan=2 class=xl9625986 style='border-right:.5pt solid black'>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=21 style='mso-height-source:userset;height:16.15pt'>
													<td height=21 class=xl6325986 style='height:16.15pt'></td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=21 style='mso-height-source:userset;height:16.15pt'>
													<td height=21 class=xl6325986 style='height:16.15pt'></td>
													<td class=xl7225986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=19 style='mso-height-source:userset;height:14.25pt'>
													<td height=19 class=xl6325986 style='height:14.25pt'></td>
													<td class=xl6525986>&nbsp;</td>
													<td class=xl7525986 colspan=9><span id="nombre-supervisor"></span></td>
													<td class=xl7525986>&nbsp;</td>
													<td class=xl7525986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl7525986 colspan=9><span id="nombre-contratista"></span></td>
													<td class=xl7525986>&nbsp;</td>
													<td class=xl7525986>&nbsp;</td>
													<td class=xl7625986>&nbsp;</td>
													<td class=xl7625986>&nbsp;</td>
													<td class=xl7625986>&nbsp;</td>
													<td class=xl7425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=21 style='mso-height-source:userset;height:16.15pt'>
													<td height=21 class=xl6325986 style='height:16.15pt'></td>
													<td class=xl6525986>&nbsp;</td>
													<td class=xl7725986 colspan=2><span id="cargo-supervisor"></span></td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td colspan=11 class=xl9025986><span id="cargo-contratista"></span></td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6625986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=23 style='mso-height-source:userset;height:17.65pt'>
													<td height=23 class=xl6325986 style='height:17.65pt'></td>
													<td class=xl6525986>&nbsp;</td>
													<td colspan=12 class=xl9025986><span id="rol-supervisor"></span></td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6625986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=21 style='mso-height-source:userset;height:16.15pt'>
													<td height=21 class=xl6325986 style='height:16.15pt'></td>
													<td colspan=35 rowspan=2 class=xl9625986 style='border-right:.5pt solid black'>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=21 style='mso-height-source:userset;height:16.15pt'>
													<td height=21 class=xl6325986 style='height:16.15pt'></td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=21 style='mso-height-source:userset;height:16.15pt'>
													<td height=21 class=xl6325986 style='height:16.15pt'></td>
													<td class=xl7225986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=19 style='mso-height-source:userset;height:14.25pt'>
													<td height=19 class=xl6325986 style='height:14.25pt'></td>
													<td class=xl6525986>&nbsp;</td>
													<td class=xl7525986 colspan=9><span id="nombre-apoyo"></span></td>
													<td class=xl7525986>&nbsp;</td>
													<td class=xl7525986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl8925986>&nbsp;</td>
													<td class=xl8925986>&nbsp;</td>
													<td class=xl8925986>&nbsp;</td>
													<td class=xl8925986>&nbsp;</td>
													<td class=xl8925986>&nbsp;</td>
													<td class=xl8925986>&nbsp;</td>
													<td class=xl8925986>&nbsp;</td>
													<td class=xl8925986>&nbsp;</td>
													<td class=xl8925986>&nbsp;</td>
													<td class=xl8925986>&nbsp;</td>
													<td class=xl8925986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6625986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=21 style='mso-height-source:userset;height:16.15pt'>
													<td height=21 class=xl6325986 style='height:16.15pt'></td>
													<td class=xl6525986>&nbsp;</td>
													<td class=xl7725986 colspan=2><span id="cargo-apoyo"></span></td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl7325986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td colspan=11 class=xl9025986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6625986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=23 style='mso-height-source:userset;height:17.65pt'>
													<td height=23 class=xl6325986 style='height:17.65pt'></td>
													<td class=xl6525986>&nbsp;</td>
													<td colspan=12 class=xl9025986><span id="rol-apoyo"></span></td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6625986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr height=21 style='mso-height-source:userset;height:16.15pt'>
													<td height=21 class=xl6325986 style='height:16.15pt'></td>
													<td class=xl6525986>&nbsp;</td>
													<td class=xl7825986>&nbsp;</td>
													<td class=xl7825986>&nbsp;</td>
													<td class=xl7825986>&nbsp;</td>
													<td class=xl7825986>&nbsp;</td>
													<td class=xl7825986>&nbsp;</td>
													<td class=xl7825986>&nbsp;</td>
													<td class=xl7825986>&nbsp;</td>
													<td class=xl7825986>&nbsp;</td>
													<td class=xl7825986>&nbsp;</td>
													<td class=xl7825986>&nbsp;</td>
													<td class=xl7825986>&nbsp;</td>
													<td class=xl7825986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6625986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>
												<tr class=xl6425986 height=21 style='mso-height-source:userset;height:16.15pt'>
													<td height=21 class=xl7925986 style='height:16.15pt'>&nbsp;</td>
													<td class=xl8025986>&nbsp;</td>
													<td class=xl8125986>&nbsp;</td>
													<td class=xl8125986>&nbsp;</td>
													<td class=xl8125986>&nbsp;</td>
													<td class=xl8125986>&nbsp;</td>
													<td class=xl8125986>&nbsp;</td>
													<td class=xl8125986>&nbsp;</td>
													<td class=xl8125986>&nbsp;</td>
													<td class=xl8125986>&nbsp;</td>
													<td class=xl8125986>&nbsp;</td>
													<td class=xl8125986>&nbsp;</td>
													<td class=xl8125986>&nbsp;</td>
													<td class=xl8125986>&nbsp;</td>
													<td class=xl8125986>&nbsp;</td>
													<td class=xl8125986>&nbsp;</td>
													<td class=xl8125986>&nbsp;</td>
													<td class=xl8125986>&nbsp;</td>
													<td class=xl8125986>&nbsp;</td>
													<td class=xl8125986>&nbsp;</td>
													<td class=xl8125986>&nbsp;</td>
													<td class=xl8125986>&nbsp;</td>
													<td class=xl8125986>&nbsp;</td>
													<td class=xl8125986>&nbsp;</td>
													<td class=xl8125986>&nbsp;</td>
													<td class=xl8125986>&nbsp;</td>
													<td class=xl8125986>&nbsp;</td>
													<td class=xl8125986>&nbsp;</td>
													<td class=xl8125986>&nbsp;</td>
													<td class=xl8125986>&nbsp;</td>
													<td class=xl8125986>&nbsp;</td>
													<td class=xl8125986>&nbsp;</td>
													<td class=xl8125986>&nbsp;</td>
													<td class=xl8125986>&nbsp;</td>
													<td class=xl8125986>&nbsp;</td>
													<td class=xl8225986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
													<td class=xl6425986>&nbsp;</td>
												</tr>

											</table>
										</div>
									</div>
								</div>
								<div class="form-group text-center row">
									<div class="">
										<div class="col-lg-offset-4 col-lg-1 col-md-offset-4 col-md-1 col-sm-offset-4 col-sm-1 text-left">
											<button id="btn-limpiar-informe" type="button" class="btn btn-warning  btn-lg">Limpiar</button>
										</div>
										<div class="col-lg-2 col-md-2 col-sm-2 text-left">
											<div style="margin-top: 8px; margin-left: 50px;" class="material-switch pull-left" data-toggle='tooltip' title="Finalizado / Sin Finalizar" data-placement="bottom" >
												<input  id="input-finalizado-1" name="input-finalizado-1"  class="checkState" type="checkbox"/>
												<label for="input-finalizado-1" class="label-success"></label>
											</div>
											<label style="margin-top: 8px" class="col-lg-6 text-left" id="label-state-finalizado-1">Sin Finalizar</label>
										</div>
										<div class="col-lg-5 col-md-5 col-sm-5 text-left">
											<button id="submit-informe-pago" type="button" class="btn btn-success  btn-lg">Guardar</button>
										</div>
									</div>
								</div>
							</fieldset>
						</form>
					</div>
					<div class="tab-pane active" id="listado" role="tabpanel">
						<div class="alert alert-dismissible alert-info">
							<strong>NOTA IMPORTANTE:</strong><br> Recuerde que el archivo pdf se debe imprimir en hoja OFICIO.
						</div>
						<div class="form-group row" >
							<div class="col-md-4" style="padding-right:0px ">
								<br>
								<br>
								<label  for="input-fecha-de"  class="col-md-4 control-label">Tipo Persona</label>
								<div class="input-group col-md-8" style="padding-left: 15px;padding-right: 15px;" >
									<select id="select-tipo-lista" name="select-tipo-lista[]"  class="selectpicker form-control" multiple>
										<option value="1" selected>Propios</option>
										<option value="2">Terceros</option>
									</select>
								</div>
							</div>
						</div>
						<div class="form-group row" >
							<div class="col-md-4" style="padding-right:0px ">
								<label  for="input-fecha-de"  class="col-md-4 control-label">Estado Informe de Pago</label>
								<div class="input-group col-md-8" style="padding-left: 15px;padding-right: 15px;" >
									<select id="select-estado-lista" name="select-estado-lista[]"  class="selectpicker form-control" multiple>
										<option value="1" selected>Ver</option>
										<option value="2" selected>Editar</option>
										<option value="3" selected>Descargar</option>
										<option value="4" selected>Por Revisar</option>
									</select>
								</div>
							</div>
						</div>
						<div class="form-group row" >
							<div class="col-md-4" style="padding-right:0px ">
								<label  for="input-fecha-de"  class="col-md-4 control-label">Estado Documento</label>
								<div class="input-group col-md-8" style="padding-left: 15px;padding-right: 15px;" >
									<select id="select-estado-lista-doc" name="select-estado-lista-doc[]"  class="selectpicker form-control" multiple>
										<option value="1" selected>Diligenciar</option>
										<option value="2" selected>Editar</option>
										<option value="3" selected>Descargar</option>
										<option value="4" selected>Por Revisar</option>
									</select>
								</div>
							</div>
						</div>
						<div class="form-group row" >
							<div class="col-md-4" style="padding-right:0px ">
								<label  for="input-fecha-de"  class="col-md-4 control-label">Fecha Final del Periodo </label>
								<div class="input-group col-md-7" style="padding-left: 15px;padding-right: 15px;" >
									<span class="input-group-addon"><i style="margin-right: 0px;" class="fa fa-calendar"></i></span>
									<input style="background-color: white; z-index: 1;" maxlength="500" class="form-control datepicker-class" id="fecha-periodo" name="fecha-periodo" placeholder="dd/mm/aaaa" type="text">
								</div>
							</div>
						</div>
						<div class="form-group row text-right">
							<div class="col-md-3">
								<button class="btn btn-info" id="btn-consultar">Consultar</button>
							</div>
						</div>
						<div class="col-lg-12 row" >
							<div class="table-responsive">
								<table id="table-listado-informes" class="table table-hover " width="100%" style="width: 100%">
									<thead>
										<tr>
											<th>id</th>
											<th>N Identificacion</th>
											<th>Nombre Contratista</th>
											<th>N Contrato</th>
											<th>Periodo</th>
											<th>Fecha de Registro/Edicion</th>
											<!-- <th width="15%">Estado</th> -->
											<th>Informe de Pago</th>
											<!-- <th>Fecha de Finalizado</th> -->
											<th>Documento</th>
										</tr> 
									</thead>
									<tbody>
									</tbody>
								</table>  
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
	<div class="modal fade" id="modal-revisar-informe" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<form id="form-revisar-informe" class="form-horizontal" method="post">
			<div class="modal-dialog modal-ml" role="document" >
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title" id="h4-modal-informe-title"></h4>
					</div>
					<div class="modal-body">
						<fieldset>
							<div class="modal-body" id="contenedor-revisar-informe">
							</div>
						</fieldset>
					</div>
					<div class="modal-footer">
						<div class="col-lg-5 col-md-5 col-sm-5 text-right">
							<button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Cerrar</button>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 text-left">
							<div style="margin-top: 8px; margin-left: 50px;" class="material-switch pull-left" data-toggle='tooltip' title="Aprobar / No Aprobar" data-placement="bottom" >
								<input  id="input-aprobado" name="input-aprobado"  class="checkState" type="checkbox"/>
								<label for="input-aprobado" class="label-success"></label>
							</div>
							<label style="margin-top: 8px" class="col-lg-6 text-left" id="label-state">Sin Aprobar</label>
						</div>
						<div class="col-lg-5 col-md-5 col-sm-5 text-left">
							<button id="submit-revisar-informe" class="btn btn-lg btn-success">Guardar</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>

	<div class="modal fade" id="modal-editar-informe" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<form id="form-editar-informe" class="form-horizontal" method="post">
			<div class="modal-dialog modal-ml" role="document" >
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title" id="h4-modal-informe-title"></h4>
					</div>
					<div class="modal-body">
						<fieldset>
							<div class="modal-body" id="contenedor-editar-informe">
							</div>
						</fieldset>
					</div>
					<div class="modal-footer">
						<div class="col-lg-5 col-md-5 col-sm-5 text-right">
							<button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Cerrar</button>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 text-left">
							<div style="margin-top: 8px; margin-left: 50px;" class="material-switch pull-left" data-toggle='tooltip' title="Finalizado / Sin Finalizar" data-placement="bottom" >
								<input  id="input-finalizado-2" name="input-finalizado-2"  class="checkState" type="checkbox"/>
								<label for="input-finalizado-2" class="label-success"></label>
							</div>
							<label style="margin-top: 8px" class="col-lg-6 text-left" id="label-state-finalizado-2">Sin Finalizar</label>
						</div>
						<div class="col-lg-5 col-md-5 col-sm-5 text-left">
							<button id="submit-editar-informe" class="btn btn-success">Guardar Cambios</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="modal fade" id="modal-visualizar-informe" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<form id="form-visualizar-informe" class="form-horizontal" method="post">
			<div class="modal-dialog modal-ml" role="document" >
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title" id="h4-modal-informe-title"></h4>
					</div>
					<div class="modal-body">
						<fieldset>
							<div class="modal-body" id="contenedor-visualizar-informe">
							</div>
						</fieldset>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="modal fade" id="modal-informe-detallado-editar" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<form id="form-informe-detallado" class="form-horizontal">
			<div class="modal-dialog modal-ml" role="document" >
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title" id="h4-modal-informe-title"></h4>
					</div>
					<div class="modal-body">			
						<fieldset>
							<div id="form-informe-detallado-container">
								<div class="container-fluid">
									<div class="form-group row text-center" >
										<div class="col-lg-12 col-md-12 col-sm-12 text-left">
											<b>ES FORMATO INFORME EQUIPO TERRITORIAL:</b>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 text-left">
											<div style="margin-top: 8px; margin-left: 50px;" class="material-switch pull-left" data-placement="bottom" >
												<input  id="input-informe-territorial" name="input-informe-territorial"  class="checkState" type="checkbox"/>
												<label for="input-informe-territorial" class="label-success"></label>
											</div>
											<label style="margin-top: 8px" class="col-lg-6 text-left" id="label-state-informe-territorial">NO</label>
											<br>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 text-left" id="radio-tipo-territorial" hidden>
											<label class="container">Coordinador
												<input type="radio" checked="checked" name="tipo-territorial" value="1">
												<span class="checkmark"></span>
											</label>
											<label class="container">Administrativo
												<input type="radio" name="tipo-territorial" value="2">
												<span class="checkmark"></span>
											</label>
											<label class="container">Operativo
												<input type="radio" name="tipo-territorial" value="3">
												<span class="checkmark"></span>
											</label>
										</div>
										<table class="table-border-custom" border="1">
											<colgroup>
												<col style="width:50%">
												<col style="width:50%">
											</colgroup>
											<tr>
												<td class="content-table subtitle-table">NOMBRE DEL CONTRATISTA:</td>
												<td class="content-table"><span id="nombre-contratista" name="nombre-contratista"></span></td>
											</tr>
											<tr>
												<td class="content-table subtitle-table">N° DE CONTRATO:</td>
												<td class="content-table"><span id="input-numero-contrato" name="input-numero-contrato"></span></td>
											</tr>
											<tr>
												<td class="content-table subtitle-table">PERIODO:</td>
												<td class="content-table"><span id="input-periodo-inicio" name="input-periodo-inicio"></span> AL <span id="input-periodo-fin" name="input-periodo-fin"></span>
												</td>
											</tr>											
											<tr>
												<td class="content-table title-table" style="background-color: #e6e6e6;" colspan="2">OBJETO DEL CONTRATO</td>
											</tr>
											<tr>
												<td class="content-table" style="text-align: center; background-color: #e6e6e6;" colspan="2"><span id="input-objeto" nombre="input-objeto"></span></td>
											</tr>
											<tr class="coordinador">
												<td class="content-table" style="text-align: left;" colspan="2"> <center><b>PRODUCTO</b></center>
												Informe periódico donde indique el desarrollo de cada una de las obligaciones contractuales anexando los soportes correspondientes</td>
											</td>
											<tr class="coordinador">
												<td class="content-table" style="text-align: left;" colspan="2"><b>GESTIÓN ADMINSTRATIVA- INFRAESTRUCTURA:</b> Coordinar con los equipos Crea y el componente administrativo las necesidades y oportunidades de mejora relacionadas con Infraestructura, dotaciones, servicios y otras necesidades para el óptimo funcionamiento del Crea.  (Operativo- Entrega de materiales a AF)</td>
											</td>
											<tr class="coordinador">
												<td class="content-table" style="text-align: left;" colspan="2"><b>GESTIÓN DE LA INFORMACIÓN:</b> Coordinar con el equipo de información la actualización de la información para la creación de grupos, seguimiento  a la cobertura, asistencia y a la permanencia. Verificar en el Sistema de Información SICrea-según su perfil realizar las consultas en las  líneas de Arte en la Escuela, Impulsa  (Súbete a la Escena y Manos a la Obra) y otros convenios. Analizar reportes mensuales para hacer seguimiento a la cobertura- . radiografía de la atención nes a mes.</td>
											</td>
											<tr class="coordinador">
												<td class="content-table" style="text-align: left;" colspan="2"><b>GESTIÓN PEDAGÒGICA:</b> Coordinar con el Componente Pedagógico las acciones relacionadas con la convivencia en CREA, seguimiento a la asistencia de los Artistas Formadores que permite revisar la permanencia y apoyar el trabajo en equipo entre AF (Artistas Formadores), Gestores Pedagógicos  y Territoriales para el  desarrollo de las líneas AE(Arte en la Escuela, Impulsa CREA, Manos a la Obra y Súbete a la Escena y Converge.) Acciones relacionadas con el clima organizacional</td>
											</td>
											<tr class="coordinador">
												<td class="content-table" style="text-align: left;" colspan="2"><b>GESTIÓN  DE LA COMUNIDAD:</b> Coordinar en Crea  las (Relaciones con el entorno y contexto): Convocatorias a la comunidad, servicio de atención al ciudadano, acciones de movilización social y circulación (apoyo a la producción y a la comunicación, portafolio de servicios CREA, reuniones con la comunidad, colegios, reuniones internas y externas que garanticen la calidad del servicio CREA, Apoyo al área de Circulación. </td>
											</td>
											<tr class="coordinador">
												<td class="content-table" style="text-align: left;" colspan="2"><b>GESTIÓN DOCUMENTAL:</b> Apoyar las acciones relacionadas con el Sistema de Gestión Documental de IDARTES</td>
											</tr>
											<tr class="administrativo">
												<td class="content-table" style="text-align: left;" colspan="2"> <center><b>PRODUCTO</b></center>
												Informe periódico donde indique el desarrollo de cada una de las obligaciones contractuales anexando los soportes correspondientes.	</td>
											</tr>
											<tr class="administrativo">
												<td class="content-table" style="text-align: left;" colspan="2"><b>GESTIÓN ADMINISTRATIVA:</b> Acciones relacionadas con novedades mensuales tales como: (infraestructura, Inventarios,). Reportes de adaptación de espacios, según necesidades y oportunidades de mejora para el desarrollo de las acciones en CREA. </td>
											</tr>
											<tr class="administrativo">
												<td class="content-table" style="text-align: left;" colspan="2"><b>GESTIÓN DE LA INFORMACIÓN:</b> Acciones relacionadas con el Sistema de Información según sus funciones como usuario- cada mes reportar las acciones asociadas con este componente. Datos de atención y seguimiento mensual relacionados con Cobertura, Permanencia y deserción en las líneas de Arte en la Escuela, Impulsa (Súbete a la Escena y Manos a la Obra) y otros convenios. </td>
											</tr>
											<tr class="administrativo">
												<td class="content-table" style="text-align: left;" colspan="2"><b>GESTIÓN DE LA COMUNIDAD (Relaciones con el entorno y contexto):</b> Convocatorias a la comunidad, servicio de atención al ciudadano, acciones de movilización social y circulación (apoyo a la producción y a la comunicación, portafolio de servicios Crea, reuniones con la comunidad, colegios, reuniones internas y externas que garanticen la calidad del servicio Crea.</td>
											</tr>
											<tr class="administrativo">
												<td class="content-table" style="text-align: left;" colspan="2"><b>GESTIÓN DEL COMPONENTE PEDAGÓGICO:</b> Acciones relacionadas con la permanencia de los artistas formadores, articulación con los Gestores Pedagógicos y Territoriales para las líneas de atención de  AE (Arte en la Escuela, Impulso Colectivo, Manos a la Obra y Súbete a la Escena) y Converge.) Acciones relacionadas con la convivencia escolar en Crea, para la resolución de conflictos. </td>
											</tr>
											<tr class="administrativo">
												<td class="content-table" style="text-align: left;" colspan="2"><b>GESTIÓN DOCUMENTAL:</b> Acciones relacionadas con el Sistema de Gestión Documental del IDARTES </td>
											</tr>
											<tr class="operativo">
												<td class="content-table" style="text-align: left;" colspan="2"> <center><b>PRODUCTO</b></center>
												Informe donde indique el desarrollo de cada una de las obligaciones contractuales anexando los soportes correspondientes. </td>
											</tr>
											<tr class="operativo">
												<td class="content-table" style="text-align: left;" colspan="2"><b>GESTIÓN ADMINISTRATIVA:</b> Acciones relacionadas con novedades mensuales tales como: (infraestructura, Inventarios). Reportes de adaptación de espacios, según necesidades y oportunidades de mejora para el desarrollo de las acciones en CREA. Bienes y servicios CREA.</td>
											</tr>
											<tr class="operativo">
												<td class="content-table" style="text-align: left;" colspan="2"><b>GESTIÓN DE LA INFORMACIÓN:</b> Acciones relacionadas con el Sistema de Información SIF según el módulo- cada mes reportar las acciones asociadas con este componente. Datos de atención y seguimiento mensual relacionados con Cobertura, Permanencia y Porcentaje de ocupación del CREA en las líneas de Arte en la Escuela, Impulsa CREA (Súbete a la Escena y Manos a la Obra) y otros convenios.</td>
											</tr>
											<tr class="operativo">
												<td class="content-table" style="text-align: left;" colspan="2"><b>GESTIÓN DE LA COMUNIDAD (Relaciones con el entorno y contexto):</b> Convocatorias a la comunidad, servicio de atención al ciudadano, acciones de movilización social y circulación (apoyo a la producción y a la comunicación, portafolio de servicios CREA, reuniones con la comunidad, colegios, reuniones internas y externas que garanticen la calidad del servicio CREA.</td>
											</tr>
											<tr class="operativo">
												<td class="content-table" style="text-align: left;" colspan="2"><b>GESTIÓN DEL COMPONENTE PEDAGÓGICO:</b> Acciones relacionadas con la pertinencia de la formación en territorio CREA con AF (Artistas Formadores), AFA, (Artistas Formadores Armonizadores), Orientadores de Línea: AE(Arte en la Escuela, Impulsa CREA, Manos a la Obra y Súbete a la Escena y Converge CREA.) Acciones relacionadas con la convivencia escolar en CREA. Reemplazos por ausencias.</td>
											</tr>
											<tr class="operativo">
												<td class="content-table" style="text-align: left;" colspan="2"><b>GESTIÓN DOCUMENTAL:</b> Acciones relacionadas con el Sistema de Gestión Documental de IDARTES, relacionadas con el cargo.</td>
											</tr>
											<tr id="tr-producto">
											</tr>
											<!-- <tr>
												<td class="content-table" style="text-align: left;" colspan="2"><br></td>
											</tr>
											<tr>
												<td class="content-table" style="text-align: left;" colspan="2" >
													<span id="span-nombre-apoyo"></span><br>
													<span id="span-cargo-apoyo"></span><br>
													<span id="span-rol-apoyo"></span><br>
												</td>
											</tr> -->
										</table>

									</div>
									<div class="form-group row" >
										<div class="form-group row col-md-12 col-lg-12" >
											<h3>Anexo (CD)</h3>
											<h5>El archivo debe estar en formato .zip y debe contener la información tal como quedaría en el CD</h5>
										</div>
										<div class="form-group row" >
											<div class="col-md-12 col-lg-12">
												<br>
												<div id="div_anexo_archivo" data-toggle="tooltip" title="Dejar Vacío para no modificar" data-placement="right" class="col-md-4 col-lg-4">
													<input accept="application/zip" id="anexo_archivo" name="file[]" type="file" class="filestyle" data-buttonName="btn-danger" data-buttonBefore="true" runat="server" data-buttonText="&nbspAnexo">
												</div>
												<div class="col-md-4 col-lg-4">
													<div style="padding-top: 5px">
														<div class="progress" style="margin-bottom: 20px;">
															<div class="progress-bar progress-bar-striped active" role="progressbar" id="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
																<span >0%</span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</fieldset>
					</div>
					<div class="modal-footer">
						<div class="col-lg-5 col-md-5 col-sm-5 text-right">
							<button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Cerrar</button>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 text-left">
							<div style="margin-top: 8px; margin-left: 50px;" class="material-switch pull-left" data-toggle='tooltip' title="Finalizado / Sin Finalizar" data-placement="bottom" >
								<input  id="input-finalizado-detallado" name="input-finalizado-detallado"  class="checkState" type="checkbox"/>
								<label for="input-finalizado-detallado" class="label-success"></label>
							</div>
							<label style="margin-top: 8px" class="col-lg-6 text-left" id="label-state-finalizado-detallado">Sin Finalizar</label>
						</div>
						<div class="col-lg-5 col-md-5 col-sm-5 text-left">
							<button id="submit-informe-detallado" class="btn btn-success  btn-lg">Guardar</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="modal fade" id="modal-revisar-informe-detallado" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<form id="form-revisar-informe-detallado" class="form-horizontal" method="post">
			<div class="modal-dialog modal-ml" role="document" >
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title" id="h4-modal-informe-title"></h4>
					</div>
					<div class="modal-body">
						<fieldset>
							<div class="modal-body" id="contenedor-revisar-informe-detallado">
							</div>
						</fieldset>
					</div>
					<div class="modal-footer">
						<div class="col-lg-5 col-md-5 col-sm-5 text-right">
							<button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Cerrar</button>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-2 text-left">
							<div style="margin-top: 8px; margin-left: 50px;" class="material-switch pull-left" data-toggle='tooltip' title="Aprobar / No Aprobar" data-placement="bottom" >
								<input  id="input-aprobado-detallado" name="input-aprobado-detallado"  class="checkState" type="checkbox"/>
								<label for="input-aprobado-detallado" class="label-success"></label>
							</div>
							<label style="margin-top: 8px" class="col-lg-6 text-left" id="label-state-detallado">Sin Aprobar</label>
						</div>
						<div class="col-lg-5 col-md-5 col-sm-5 text-left">
							<button id="submit-revisar-informe-detallado" class="btn btn-lg btn-success">Guardar</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</body>
</html>
