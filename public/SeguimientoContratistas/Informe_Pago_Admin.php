<?php
session_start();
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

	<script src='../LibreriasExternas/pdfmake-0.1.36/build/pdfmake.js'></script>
	<script src='../LibreriasExternas/pdfmake-0.1.36/build/vfs_fonts.js'></script>

	<script type="text/javascript" src="Js/Informe_Pago_Admin.js?v=2021.03.30.0"></script>
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
	.modal {
		overflow-y:auto !important;
	}

</style>
</head>
<body>

	<div class="container-fluid" style="padding-top: 30px">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-header">
					<h1 style="font-size: 45px;">Informe de Pago | Administración</h1>
					<input type='hidden' id='id-usuario' value='<?php echo $Id_Persona; ?>'>
					<input type='hidden' id='id-rol' value='<?php echo $Id_Rol; ?>'>
				</div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<!-- <li class="nav-item " ><a class="nav-link" data-toggle="tab" href="#informe_pago" role="tab" id="informe_pago_link">Informe para Pago</a></li> -->
					<!-- <li class="nav-item active"><a class="nav-link" data-toggle="tab" href="#documento" role="tab">Informe Detallado</a></li> -->
					<li class="nav-item  active"><a class="nav-link" data-toggle="tab" href="#listado" id="listado_link" role="tab">Editar Contrato</a></li>
				</ul>
				<button class="btn btn-success pull-right" id="BT_CREAR_CONTRATO" name="BT_CREAR_CONTRATO"><span class="fa fa-plus fa-1x"></span> Registrar Nuevo Contrato</button>
				<div class="tab-content">
					<br>
					<div class="tab-pane active" id="listado" role="tabpanel">
						<div class="col-lg-12 row" >
							<div class="table-responsive">
								<table id="table-listado-informes" class="table table-hover " width="100%" style="width: 100%">
									<thead>
										<tr>
											<th>id</th>
											<th>N Identificacion</th>
											<th>Nombre Contratista</th>
											<th>N Contrato</th>
											<th>Opciones</th>
											<!-- <th>Fecha de Registro</th> -->
											<!-- <th width="15%">Estado</th> -->
											<th></th>
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
	<div class="modal fade" id="modal-editar-informe" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false">
		<form id="form-editar-informe" class="form-horizontal" method="post">
			<div class="modal-dialog modal-ml" role="document" >
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title" id="h4-modal-informe-title"></h4>
					</div>
					<div class="modal-body">
						<fieldset>
							<div id="contenedor-editar-informe">
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
												<td colspan=11 rowspan=2 class=xl18525986>Código: GF-F01</td> <!--Cambio de Versión-->
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
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
												<td colspan=11 rowspan=3 class=xl18525986>Fecha: 09/03/2021</td>  <!--Cambio de Versión-->
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
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
												<td colspan=11 rowspan=3 class=xl18525986>Versión: 4</td> <!--Cambio de Versión-->
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
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
												<td colspan=8 class=xl17525986></td>

												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
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
												<td colspan=5 class=xl17725986 style='border-left:none;height:  10px;color:black;'></td>
												<td colspan=5 class=xl17725986 style='border-left:none;height:  10px;color:black;'></td>
												<td colspan=10 class=xl17425986 style='border-left:none;height:  10px;color:black;'>No. DEL CONTRATO
												</td>
												<td colspan=8 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" class="creacion pull-left" type="text" name="input-numero-contrato" id="input-numero-contrato" placeholder="XXX-2020">
													</select></td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
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
												<td colspan=14 class=xl17125986 style='border-left:none;height: 10px;'><input style="width: 100%; height: 100%;" readonly disabled type="text" name="input-nombres-apellidos" id="input-nombres-apellidos"><select style="width: 100%; height: 100%;" class="selectpicker form-control" title="Seleccione el Contratista" data-live-search="true" data-style="btn-warning" name="select-contratista" id="select-contratista">
													</select></td>
												<!-- <td colspan=14 class=xl17125986 style='border-left:none;height:  10px;color:black;'>
													
												</td> -->
												<td colspan=3 class=xl17425986 style='border-left:none;height:  10px;color:black;'>
													<select style="width: 100%; height: 100%;"  name="select-identificacion" id="select-identificacion" class="creacion">
													</select>
												</td>
												<td colspan=5 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" name="input-identificacion" id="input-identificacion" class="creacion"></td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
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
												<td colspan=13 class=xl17425986>ACTIVIDAD ECONÓMICA (CIIU) </td>
												<td colspan=14 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" name="input-ciiu" id="input-ciiu" class="creacion"></td>
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
												<td colspan=14 class=xl17725986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" name="input-nombres-apellidos-cedente" id="input-nombres-apellidos-cedente" disabled></td>
												<td colspan=3 class=xl17425986 style='border-left:none;height:  10px;color:black;'>
													<select style="width: 100%; height: 100%;"  name="select-identificacion-cedente" id="select-identificacion-cedente" disabled>
													</select>
												</td>
												<td colspan=5 class=xl17725986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" name="input-identificacion-cendete" id="input-identificacion-cendete" disabled></td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
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
													<select style="width: 100%; height: 100%;"  name="select-banco" id="select-banco" disabled >
													</select>
												</td>
												<td colspan=5 rowspan=2 class=xl17425986>TIPO DE CUENTA:</td>
												<td colspan=6 rowspan=2 class=xl17125986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" name="input-tipo-cuenta" id="input-tipo-cuenta"  disabled></td>
												<td colspan=4 rowspan=2 class=xl17425986>No. CUENTA:</td>
												<td colspan=8 rowspan=2 class=xl16125986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" name="input-numero-cuenta" id="input-numero-cuenta" disabled ></td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
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
												<td colspan=31 class=xl16425986 width=985 style='border-left:none;height:  10px;color:black;'><textarea rows="3" style="resize: vertical;width: 100%; height: 100%; margin-bottom: -5px;" type="text" name="input-objeto" id="input-objeto" class="creacion"></textarea></td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
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
												<td colspan=4 class=xl16325986 width=101 style='width:76pt'>Fecha de
													Inicio
												</td>
												<td colspan=5 class=xl18025986 style='border-left:none;height:  10px;color:black;'><input maxlength="50" style="background-color:white; color:black;" class="text-center form-control datepicker-class creacion" readonly id="input-fecha-inicio" name="input-fecha-inicio" placeholder="DD/MM/AAAA" type="text"></td>
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
												<td colspan=5 class=xl18025986 style='border-left:none;height:  10px;color:black;'><input maxlength="50" style="background-color:white; color:black;" class="text-center form-control datepicker-class creacion" readonly id="input-fecha-fin" name="input-fecha-fin" placeholder="DD/MM/AAAA" type="text"></td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
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
												<td colspan=2 class=xl12025986 style='height: 10px;color:black;'><input style="width: 100%; height: 100%;" type="text" readonly disabled name="input-pago-numero" id="input-pago-numero" ></td>
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
												<td colspan=4 class=xl14225986 style='height:10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="rp-contenido creacion" name="input-rp-contenido-a" id="input-rp-contenido-a" value="a) xxxx"></td>
												<td colspan=5 class=xl14225986 style='border-left:none;height:  10px;color:black;'>
													<select class="creacion" style="width: 100%; height: 100%;" name="select-codigo-a" id="select-codigo-a">
													</select>
												</td>
												<td colspan=4 class=xl14225986 style='border-left:none;height:  10px;color:black;'>
													<select class="creacion" style="width: 100%; height: 100%;" name="select-convenio-a" id="select-convenio-a">
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
												<td colspan=29 class=xl13625986  style='height:10px;color:black;'><input style="width: 100%; height: 100%;" type="text" name="input-valor-inicial" id="input-valor-inicial" class="decimalPesos sum-total creacion" value="$ 0"></td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
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
												<td colspan=6 class=xl13225986 width=181 style='width:136pt'>Pagos efectuados a la fecha
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
												<td colspan=6 class=xl13225986 width=181 style='width:136pt'>Saldo pendiente de pago
												</td>
												<td colspan=29 class=xl13625986 style='height:10px;color:black;'><input style="width: 100%; height: 100%;" type="text" name="input-saldo-pediente" id="input-saldo-pediente" class="decimalPesos" value="$ 0"></td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
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
												<td colspan=13 class=xl12225986 style='height:  10px;color:black;'><textarea rows="5" style="resize: vertical;width: 100%; height: 100%;" type="text" name="textarea-producto" id="textarea-producto" readonly disabled > </textarea></td>
												<td colspan=6 class=xl12225986 style='border-left:none;height:  10px;color:black;' ><div style="background-color: #ebebe4; height:100%"></div></td>
												<td colspan=16 class=xl12225986 style='border-left:none;height:  10px;color:black;'>
													<textarea rows="5" style="resize: vertical;width: 100%; height: 100%;" type="text" name="textarea-mecanismo-verificacion" id="textarea-mecanismo-verificacion" readonly disabled placeholder="(En este espacio, por favor indique si adjunta medio magnético , anexos físicos o por favor mencione el nombre de la Tabla de retención documental del Sistema ORFEO donde reposa la prueba del producto entregado por usted)."></textarea>
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
											<tr height=35 style='mso-height-source:userset;height:26.45pt'>
												<td height=35 class=xl6325986 style='height:26.45pt'></td>
												<td colspan=11 class=xl9125986 width=356 style='border-right:.5pt solid black;width:267pt'>¿De acuerdo con el Artículo 383. Parágrafo 2 del Estatuto Tributario, para la prestación del servicio o actividad he contratado o vinculado dos (2) o más trabajadores asociados a la actividad por al menos noventa (90) días continuos o discontinuos:?</td>
												<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="declaracion financiero declaracion-si" name="input-declaracion-1-si" id="input-declaracion-1-si" ></td>
												<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="declaracion financiero declaracion-no" name="input-declaracion-1-no" id="input-declaracion-1-no" ></td>
												<td colspan=20 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" name="input-declaracion-1-observacion" id="input-declaracion-1-observacion" class="observacion-declaracion"></td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
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
												<td colspan=11 class=xl9125986 width=356 style='border-right:.5pt solid black;width:267pt'>¿Pertenece usted al nuevo Regimen Simple de tributación responsabilidad en el RUT (47)?</td>
												<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="declaracion financiero declaracion-si" name="input-declaracion-2-si" id="input-declaracion-2-si" ></td>
												<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="declaracion financiero declaracion-no" name="input-declaracion-2-no" id="input-declaracion-2-no" ></td>
												<td colspan=20 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" name="input-declaracion-2-observacion" id="input-declaracion-2-observacion" class="observacion-declaracion"></td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
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
												<td colspan=11 class=xl9125986 width=356 style='border-right:.5pt solid black;width:267pt'>¿Es usted responsable de Impuesto sobre Ventas (IVA)?</td>
												<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="declaracion financiero declaracion-si" name="input-declaracion-3-si" id="input-declaracion-3-si" ></td>
												<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="declaracion financiero declaracion-no" name="input-declaracion-3-no" id="input-declaracion-3-no" ></td>
												<td colspan=20 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" name="input-declaracion-3-observacion" id="input-declaracion-3-observacion" class="observacion-declaracion"></td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
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
												<td colspan=11 class=xl9125986 width=356 style='border-right:.5pt solid black;width:267pt'>¿Es responsable de declaración de renta año inmediatamente anterior?</td>
												<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="declaracion financiero declaracion-si" name="input-declaracion-4-si" id="input-declaracion-4-si" ></td>
												<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="declaracion financiero declaracion-no" name="input-declaracion-4-no" id="input-declaracion-4-no" ></td>
												<td colspan=20 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" name="input-declaracion-4-observacion" id="input-declaracion-4-observacion" class="observacion-declaracion"></td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
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
												width:267pt'>¿Es usted una Entidad Estatal o tiene regimen de tributacion especial?</td>
												<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="declaracion financiero declaracion-si" name="input-declaracion-5-si" id="input-declaracion-5-si" ></td>
												<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="declaracion financiero declaracion-no" name="input-declaracion-5-no" id="input-declaracion-5-no" ></td>
												<td colspan=20 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" value="¿Cual?" name="input-declaracion-5-observacion" id="input-declaracion-5-observacion" class="observacion-declaracion"></td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
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
												<td colspan=11 class=xl9125986 width=356 style='border-right:.5pt solid black;width:267pt'>¿Actualmente tiene suscrito otros contratos con el Distrito o la Nación?</td>
												<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="declaracion financiero declaracion-si" name="input-declaracion-12-si" id="input-declaracion-12-si" ></td>
												<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="declaracion financiero declaracion-no" name="input-declaracion-12-no" id="input-declaracion-12-no" ></td>
												<td colspan=20 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text"  name="input-declaracion-12-observacion" id="input-declaracion-12-observacion" class="observacion-declaracion"></td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
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
												<td colspan=11 class=xl8725986>¿Es usted Facturador Electronico?</td>
												<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="declaracion financiero declaracion-si" name="input-declaracion-6-si" id="input-declaracion-6-si" ></td>
												<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="declaracion financiero declaracion-no" name="input-declaracion-6-no" id="input-declaracion-6-no" ></td>
												<td colspan=20 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" name="input-declaracion-6-observacion" id="input-declaracion-6-observacion" class="observacion-declaracion"></td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
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
												width:267pt'>¿Tiene dependientes a su cargo? (Decreto 1070 de 2013 Art. 387 E.T.)(<b>solo se tomará encuenta si se anexan los soportes mencionados en la tabla Disminución Retención - Art 387</b>)</td>
												<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="declaracion financiero declaracion-si" name="input-declaracion-7-si" id="input-declaracion-7-si" ></td>
												<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="declaracion financiero declaracion-no" name="input-declaracion-7-no" id="input-declaracion-7-no" ></td>
												<td colspan=20 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text"  name="input-declaracion-7-observacion" id="input-declaracion-7-observacion" class="observacion-declaracion"></td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
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
												<td colspan=11 class=xl9125986 width=356 style='border-right:.5pt solid black; width:267pt'>¿Realizo pagos por intereses de vivienda en el año <b>2020</b>? (<b>solo se tomará encuenta si se anexan los soportes mencionados en la tabla Disminución Retención - Art 387</b>)</td>
												<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="declaracion financiero declaracion-si" name="input-declaracion-8-si" id="input-declaracion-8-si" ></td>
												<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="declaracion financiero declaracion-no" name="input-declaracion-8-no" id="input-declaracion-8-no" ></td>
												<td colspan=20 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text"  name="input-declaracion-8-observacion" id="input-declaracion-8-observacion" class="observacion-declaracion"></td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
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
												<td colspan=11 class=xl9125986 width=356 style='border-right:.5pt solid black;width:267pt'>¿Realizo pagos de Medicina Prepagada o Plan Complementario en el año <b>2020</b>? (<b>solo se tomará encuenta si se anexan los soportes mencionados en la tabla Disminución Retención - Art 387</b>)</td>

												<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="declaracion financiero declaracion-si" name="input-declaracion-9-si" id="input-declaracion-9-si" ></td>
												<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="declaracion financiero declaracion-no" name="input-declaracion-9-no" id="input-declaracion-9-no" ></td>
												<td colspan=20 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text"  name="input-declaracion-9-observacion" id="input-declaracion-9-observacion" class="observacion-declaracion"></td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
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
												<td colspan=11 class=xl9125986 width=356 style='border-right:.5pt solid black; width:267pt'>¿Efectúa pagos en una cuenta AFC? De ser así en observaciones indique el valor mensual pagado anexando certificación bancaria de la cuenta AFC</td>

												<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="declaracion financiero declaracion-si" name="input-declaracion-10-si" id="input-declaracion-10-si" ></td>
												<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="declaracion financiero declaracion-no" name="input-declaracion-10-no" id="input-declaracion-10-no" ></td>
												<td colspan=20 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text"  name="input-declaracion-10-observacion" id="input-declaracion-10-observacion" class="observacion-declaracion"></td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
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
												<td colspan=11 class=xl9125986 width=356 style='border-right:.5pt solid black; width:267pt'>¿Efectúa pagos de Pensiones Voluntarias? De ser así en observaciones indique el valor mensual (Anexar copia del pago correspondiente)</td>

												<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="declaracion financiero declaracion-si" name="input-declaracion-11-si" id="input-declaracion-11-si" ></td>
												<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="declaracion financiero declaracion-no" name="input-declaracion-11-no" id="input-declaracion-11-no" ></td>
												<td colspan=20 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text"  name="input-declaracion-11-observacion" id="input-declaracion-11-observacion" class="observacion-declaracion"></td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
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
											<!--<tr height=35 style='mso-height-source:userset;height:26.45pt'>
												<td height=35 class=xl6325986 style='height:26.45pt'></td>
												<td colspan=11 class=xl9125986 width=356 style='border-right:.5pt solid black;width:267pt'>¿Actualmente tiene suscrito otros contratos con el Distrito o la Nación?</td>
												<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="declaracion financiero declaracion-si" name="input-declaracion-12-si" id="input-declaracion-12-si" ></td>
												<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="declaracion financiero declaracion-no" name="input-declaracion-12-no" id="input-declaracion-12-no" ></td>
												<td colspan=20 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text"  name="input-declaracion-12-observacion" id="input-declaracion-12-observacion" class="observacion-declaracion"></td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
											</tr>-->
											<tr height=52 style='mso-height-source:userset;height:39.6pt'>
												<td height=52 class=xl6325986 style='height:39.6pt'></td>
												<td colspan=11 class=xl9125986 width=356 style='border-right:.5pt solid black; width:267pt'>¿Tiene alguna sancion o embargo?</td>
												<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="declaracion financiero declaracion-si" name="input-declaracion-13-si" id="input-declaracion-13-si" ></td>
												<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="declaracion financiero declaracion-no" name="input-declaracion-13-no" id="input-declaracion-13-no" ></td>
												<td colspan=20 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text"  name="input-declaracion-13-observacion" id="input-declaracion-13-observacion" class="observacion-declaracion"></td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
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
												<td colspan=11 class=xl9125986 width=356 style='border-right:.5pt solid black; width:267pt'>¿El pago de la ARL es asumido por el IDARTES?</td>
												<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="declaracion financiero declaracion-si" name="input-declaracion-14-si" id="input-declaracion-14-si" ></td>
												<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text" class="declaracion financiero declaracion-no" name="input-declaracion-14-no" id="input-declaracion-14-no" ></td>
												<td colspan=20 class=xl12025986 style='border-left:none;height:  10px;color:black;'><input style="width: 100%; height: 100%;" type="text"  name="input-declaracion-14-observacion" value="Anexar planilla" id="input-declaracion-14-observacion" class="observacion-declaracion"></td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
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
													<br> El (los) número(s) o referencias(s) de las(s) planilla(s) por el aporte de(l) (los) mes(es) de <input style="width: 200px; height:20px" type="text" name="input-mes-planilla" id="input-mes-planilla"  readonly disabled data-toggle="tooltip" title="Ejemplo: Enero, Febrero" data-placement="top"> es(son):<br>
													<input style="width: 200px; height:20px" type="text" name="input-numero-planilla" id="input-numero-planilla" readonly disabled > (Anexo copia(s) de la(s) planilla(s).</font>
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
												<td class=xl7525986 colspan=9>
													<select title="Aquí el Supervisor" class="selectpicker" data-live-search="true" data-style="btn-warning" style="width: 100%; height: 100%;" name="select-supervisor" id="select-supervisor" >
													</select>
													<input type="button" class="btn btn-danger clear-select" data-select="select-supervisor" value="X">
												</td>
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
												<td class=xl7525986 colspan=9>
													<select title="Aquí el Apoyo a la Supervisión" class="selectpicker" data-live-search="true" style="width: 100%; height: 100%;"  name="select-apoyo" id="select-apoyo" >
													</select>
													<input type="button" class="btn btn-danger clear-select" data-select="select-apoyo" value="X">
												</td>
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
												<td class=xl7525986 colspan=14>
													<select title="Aquí el Segundo Apoyo a la Supervisión" class="selectpicker" data-live-search="true" style="width: 100%; height: 100%;"  name="select-apoyo-dos" id="select-apoyo-dos" >
													</select>
													<input type="button" class="btn btn-danger clear-select" data-select="select-apoyo-dos" value="X">
												</td>
												<td class=xl6625986>&nbsp;</td>
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
												<td colspan=11 class=xl7725986><span id="cargo-apoyo-dos"></span></td>
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
												<td colspan=12 class=xl9025986>Apoyo a la Supervisión</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>Apoyo a la Supervisión Dos</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
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
											</tr><tr height=21 style='mso-height-source:userset;height:16.15pt'>
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
											</tr>
											<tr height=19 style='mso-height-source:userset;height:14.25pt'>
												<td height=19 class=xl6325986 style='height:14.25pt'></td>
												<td class=xl6525986>&nbsp;</td>
												<td class=xl6425986 colspan=9>
													<select title="Aquí el Apoyo Financiero" class="selectpicker" data-live-search="true" style="width: 100%; height: 100%;"  name="select-apoyo-financiero" id="select-apoyo-financiero" >
													</select>
													<input type="button" class="btn btn-danger clear-select" data-select="select-apoyo-financiero" value="X">
												</td>
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
												<td class=xl7525986 colspan=14>
													<select title="Aquí el Apoyo Auxiliar" class="selectpicker" data-live-search="true" style="width: 100%; height: 100%;"  name="select-apoyo-auxiliar" id="select-apoyo-auxiliar" >
													</select>
													<input type="button" class="btn btn-danger clear-select" data-select="select-apoyo-auxiliar" value="X">
												</td>
												<td class=xl6625986>&nbsp;</td>
										 		<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>											
											</tr>
											<tr height=23 style='mso-height-source:userset;height:17.65pt'>
												<td height=23 class=xl6325986 style='height:17.65pt'></td>
												<td class=xl6525986>&nbsp;</td>
												<td colspan=12 class=xl9025986>Vo.Bo Apoyo Financiero</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>Apoyo Auxiliar</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
												<td class=xl6425986>&nbsp;</td>
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
						</fieldset>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
						<button id="submit-editar-informe" name="submit-editar-informe" class="btn btn-success btn-lg">Guardar Cambios</button>
						<button id="submit-crear-contrato" name="submit-crear-contrato" class="btn btn-success btn-lg">Guardar Contrato</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</body>
</html>
