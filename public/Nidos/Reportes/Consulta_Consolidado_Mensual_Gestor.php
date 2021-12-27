<?php 
session_start();
if (!isset($_SESSION["session_username"])) {
	header("location:../index.php");
} else {
	$Id_Persona = $_SESSION["session_username"];
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Consolidado Mensual</title>

	<link href="../../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

	<script type="text/javascript" src="Js/Consulta_Consolidado_Mensual_Gestor.js?v=2021.08.15.17923456789"></script>
	<link href="../../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">
	<script src="../../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript"></script>

	<link href="../../bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet">
	<link href="../../bower_components/datatables.net-buttons-dt/css/buttons.dataTables.min.css" rel="stylesheet">
	<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src="../../bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="../../bower_components/datatables.net-responsive-bs/js/responsive.bootstrap.min.js"></script>

	<script src="../../bower_components/datatables.net-buttons/js/dataTables.buttons.min.js" type="text/javascript"></script>
	<script src="../../bower_components/jszip/dist/jszip.min.js" type="text/javascript"></script>
	<script src="../../bower_components/datatables.net-buttons/js/buttons.html5.min.js" type="text/javascript"></script>

	<script src="../../node_modules/datatables.net-fixedcolumns/js/dataTables.fixedColumns.min.js"></script>
	<link href="../../node_modules/datatables.net-fixedcolumns-bs/css/fixedColumns.bootstrap.min.css" rel="stylesheet">

	<script src="../../bower_components/pdfmake/build/pdfmake.js" type="text/javascript"></script>
	<script src="../../bower_components/pdfmake/build/vfs_fonts.js" type="text/javascript"></script>

	<link rel="stylesheet" type="text/css" href="../../css/Nidos.css">

	<script src="../../bower_components/jquery-validation/dist/jquery.validate.min.js"></script>
</head>

<body>
	<?php include('../../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>REVISIÓN Y APROBACIÓN DE EXPERIENCIAS</h1>
				</div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item active"><a class="nav-link" data-toggle="tab" href="#experiencias_cifras" role="tab">Revisión de experiencias</a></li>
					<!--	<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#consulta_experiencias" role="tab">Consolidado Mensual por Dupla</a></li> -->
				</ul>

				<div class="tab-content">
					<!--	<div class="tab-pane" id="consulta_experiencias" role="tabpanel">
						<?php echo "<input type='hidden' id='id_usuario' name='id_usuario' value='" . $Id_Persona . "'" ?>
						<br><br>
						<div class="row">
							<label class="col-md-2" for="SL_Dupla_Consultar">Seleccione la Dupla:</label>
							<div class="col-md-10">
								<select class="form-control Dupla_Consultar" data-live-search="true" name="SL_Dupla_Consultar" id="SL_Dupla_Consultar" title="Seleccione una dupla"></select>
							</div>
						</div>
						<div class="row">
							<label class="col-md-2" for="SL_Mes">Seleccione el Mes:</label>
							<div class="col-md-10">
								<select class="form-control SeleccionarGrupo" data-live-search="true" name="SL_Mes" id="SL_Mes"></select>
							</div>
						</div>
						<br>
						<input class="form-control btn btn-primary" id="BT_Consultar_Consolidado" type="submit" value="Consultar Consolidado Mensual">

						<div id="div_Consolidado" style="display: none;">
							<div class="row">
								<div class='col-xs-12 col-md-12'>
									<table id="table_consolidado_mensual" class="table table-striped table-bordered table-hover" width="100%" border="2">
										<thead>
											<tr>
												<td class="text-center" COLSPAN=7><strong> </strong></td>
												<td style="background-color: #A9CCE3; font-size:6" class="text-center" COLSPAN=4><strong>NUEVOS</strong></td>
												<td style="background-color: #FAD7A0" class="text-center" COLSPAN=16><strong>ASISTENCIA REAL</strong></td>
											</tr>
											<tr style="font-size: 12px;">
												<td style="background-color: #F5B7B1" class="text-center"><strong>ENTIDAD / TIPO LUGAR</strong></td>
												<td style="background-color: #76D7C4" class="text-center"><strong>UPZ</strong></td>
												<td style="background-color: #76D7C4" class="text-center"><strong>BARRIO</strong></td>
												<td style="background-color: #76D7C4" class="text-center"><strong>LUGAR DE ATENCIÓN</strong></td>
												<td style="background-color: #76D7C4" class="text-center"><strong>COBERTURA</strong></td>
												<td style="background-color: #76D7C4" class="text-center"><strong>NIVEL</strong></td>
												<td style="background-color: #76D7C4" class="text-center"><strong># CUIDADORES GRUPO</strong></td>
												<td style="background-color: #76D7C4" class="text-center"><strong>NÚMERO DE ENCUENTROS</strong></td>

												<td style="background-color: #A9CCE3" class="text-center"><strong>Total de 1 mes a 3 años</strong></td>
												<td style="background-color: #A9CCE3" class="text-center"><strong>Total de 4 a 6 años</strong></td>
												<td style="background-color: #A9CCE3" class="text-center"><strong>Madres Gestantes</strong></td>
												<td style="background-color: #3A84B5" class="text-center"><strong>TOTAL</strong></td>

												<td style="background-color: #FAD7A0" class="text-center"><strong>Total de 1 mes a 3 años</strong></td>
												<td style="background-color: #FAD7A0" class="text-center"><strong>Total de 4 a 6 años</strong></td>
												<td style="background-color: #FAD7A0" class="text-center"><strong>Niños 1 mes a 3</strong></td>
												<td style="background-color: #FAD7A0" class="text-center"><strong>Niñas 1 mes a 3</strong></td>
												<td style="background-color: #FAD7A0" class="text-center"><strong>Niños 4 a 6 años</strong></td>
												<td style="background-color: #FAD7A0" class="text-center"><strong>Niñas 4 a 6 años</strong></td>
												<td style="background-color: #FAD7A0" class="text-center"><strong>Madres Gestantes</strong></td>
												<td style="background-color: #FAD7A0" class="text-center"><strong>Afro descendientes</strong></td>
												<td style="background-color: #FAD7A0" class="text-center"><strong>Indígenas</strong></td>
												<td style="background-color: #FAD7A0" class="text-center"><strong>Raizales</strong></td>
												<td style="background-color: #FAD7A0" class="text-center"><strong>ROM</strong></td>
												<td style="background-color: #FAD7A0" class="text-center"><strong>Rural</strong></td>
												<td style="background-color: #FAD7A0" class="text-center"><strong>Discapacidad</strong></td>
												<td style="background-color: #FAD7A0" class="text-center"><strong>Conflicto</strong></td>
												<td style="background-color: #FAD7A0" class="text-center"><strong>Pri. de Libertad</strong></td>
												<td style="background-color: #F1980C" class="text-center"><strong>TOTAL</strong></td>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
								</div>
							</div>
						</div>
					</div> -->

					<div class="tab-pane active" id="experiencias_cifras" role="tabpanel">
						<br><br>
						<div class="row">
							<label class="col-md-2">Seleccione la Dupla:</label>
							<div class="col-md-10">
								<select class="form-control" data-live-search="true" name="SL_Dupla_Cifras" id="SL_Dupla_Cifras" title="Seleccione una dupla"></select>
							</div>
						</div>
						<div class="row">
							<label class="col-md-2">Seleccione el Mes:</label>
							<div class="col-md-10">
								<select class="form-control" data-live-search="true" name="SL_Mes_Cifras" id="SL_Mes_Cifras"></select>
							</div>
						</div>
						<br>
						<input class="form-control btn btn-primary" id="BT_Experiencias_Cifras" type="submit" value="Consultar Experiencias Registradas con Cifras">
						<br>
						
						<div id="div-reporte-evento" style="display: none;">
						<br><br>
						<div class="row p-t">
								<div class="col-xs-6 col-md-3 col-lg-3">
									<h4><strong>TOTAL DE ATENCIONES: </strong></h4>
								</div>
								<div class="col-xs-6 col-md-3 col-lg-3">
									<h4><strong><span id="SP_Total_Atenciones"></span></strong></h4>
								</div>								
							</div>

							<div class="row p-t">
								<div class='col-xs-6 col-md-6'>
								<h4><center><b>ANEXOS ENCUENTROS GRUPALES</b></center></h4>
									<table id='table-lugar-atencion' class='table table-striped table-bordered' width='100%' style='font-size: 12px; background-color: #EAF2F8;'>
										<thead>
											<tr>
												<th>Lugar de atención</th>
												<th># de atenciones</th>
												<th>Anexo Soporte</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
								</div>
								<div class='col-xs-6 col-md-6'>
								<h4><center><b>ANEXOS LABORATORIOS</b></center></h4>
									<table id='table-lugar-laboratorio' class='table table-striped table-bordered' width='100%' style='font-size: 12px; background-color: #FDEDEC;'>
										<thead>
											<tr>
												<th>Lugar de atención</th>
												<th># de atenciones</th>
												<th>Anexo Soporte</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
								</div>
							</div>



							<div class="row">
								<div class='col-xs-12 col-md-12'>
									<table id='table-reporte-evento' class='table table-striped table-bordered table-hover' width='100%' style='font-size: 12px;'>
										<thead>
											<tr>
												<th rowspan='2' style='background-color: #fff2cc'>ID</th>
												<th rowspan='2' style='background-color: #fff2cc'>Lugar</th>
												<th rowspan='2' style='background-color: #fff2cc'>Grupo / Nivel Escolar</th>
												<th rowspan='2' style='background-color: #fff2cc'>Modalidad</th>
												<th rowspan='2' style='background-color: #fff2cc'>Nombre Experiencia</th>
												<th rowspan='2' style='background-color: #fff2cc'>Fecha</th>
												<th rowspan='2' style='background-color: #fff2cc'>Cuidadores</th>
												<th colspan='12' style='background-color: #5499C7'>
													<center>Beneficiarios atención real</center>
												</th>
												<th colspan='12' style='background-color: #EC7063'>
													<center>Beneficiarios Nuevos</center>
												</th>
												<th rowspan='2' style='background-color: #52BE80'>Anexo experiencia</th>
												<th rowspan='2' style='background-color: #52BE80'>Aprobar experiencias</th>
											</tr>
											<tr>
												<th style='background-color: #D4E6F1'>Niños 0-3</th>
												<th style='background-color: #D4E6F1'>Niñas 0-3</th>
												<th style='background-color: #7FB3D5'>Total 0 - 3 años</th>
												<th style='background-color: #D4E6F1'>Niños 4-5</th>
												<th style='background-color: #D4E6F1'>Niñas 4-5</th>
												<th style='background-color: #7FB3D5'>Total 4 - 5 años</th>
												<th style='background-color: #D4E6F1'>Niños 6</th>
												<th style='background-color: #D4E6F1'>Niñas 6</th>
												<th style='background-color: #7FB3D5'>Total 6 años</th>
												<th style='background-color: #D4E6F1'>Gestantes</th>
												<th style='background-color: #5499C7'>Total beneficiarios</th>
												<th style='background-color: #45B39D'>Enfoque diferencial</th>

												<th style='background-color: #E6B0AA'>Niños 0-3</th>
												<th style='background-color: #E6B0AA'>Niñas 0-3</th>
												<th style='background-color: #D98880'>Total 0-3 años</th>
												<th style='background-color: #E6B0AA'>Niños 4-6</th>
												<th style='background-color: #E6B0AA'>Niñas 4-6</th>
												<th style='background-color: #D98880'>Total 4-6 años</th>
												<th style='background-color: #E6B0AA'>Niños 6</th>
												<th style='background-color: #E6B0AA'>Niñas 6</th>
												<th style='background-color: #D98880'>Total 6 años</th>
												<th style='background-color: #E6B0AA'>Gestantes</th>
												<th style='background-color: #EC7063'>Total beneficiarios</th>
												<th style='background-color: #F75848'>Enfoque diferencial</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
								</div>
							</div>
							<br>
							<input class="form-control btn btn-success" id="Generar_Reporte" type="submit" value="GENERAR REPORTE CONSOLIDADO">
							<br>
						</div>

					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="miModalAprobacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="myModalLabel" style="text-align: center">CONFIRMACIÓN APROBACIÓN EXPERIENCIA</h4>
					</div>
					<div class="modal-body">
						<form id="form_aprobar_experiencia">
							<div class="row">
								<div class="col-xs-12 col-md-12">
									¿Esta segur@ de aprobar la atención del grupo <label id="grupo"></label> con nombre de experiencia <label id="experiencias"></label>. <br>

								</div>
								<input type="hidden" id="id_expe" name="id_expe">
							</div>
							<div class="row">
								<div class="col-lg-6 col-md-6 col-xs-12">
									<div class="panel panel-success">
										<div class="panel-heading">
										<h3 style="text-align: center;"><b>Atención Real</b></h3></font><br>
										<table>
										<tr>
										<td>- Total de 0 a 3 años:</td>
										<td><label id="real3"></label></font></td>
										</tr>
										<tr>
										<td>- Total de 4 a 5 años:</td>
										<td><label id="real5"></label></font></td>
										</tr>
										<tr>
										<td>- Total de 6 años:</td>
										<td><label id="real6"></label></font></td>
										</tr>
										<tr>
										<td>- Total gestantes:</td>
										<td><label id="realgestantes"></label></font></td>
										</tr>
										<tr>
										<td>- Enfoque diferencial:</td>
										<td><label id="realdiscapidad"></label></font></td>
										</tr>
										<tr>
										<td>* Total de beneficiarios:</td>
										<td><h3><font color="red"><label id="total"></label></font></h3></td>
										</tr>
										</table>
										</div>
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-xs-12">
									<div class="panel panel-warning">
										<div class="panel-heading">
										<h3 style="text-align: center;"><b>Beneficiarios Nuevos</b></h3>
										<table>
										<tr>
										<td>- Total de 0 a 3 años:</td>
										<td><label id="nuevos3"></label></font></td>
										</tr>
										<tr>
    									<td>- Total de 4 a 5 años:</td>
										<td><label id="nuevos5"></label></font></td>
										</tr>
										<tr>
    									<td>- Total de 6 años:</td> 
										<td><label id="nuevos6"></label></font></td>
										</tr>
										<tr>
    									<td>- Total gestantes:</td> 
										<td><label id="nuevosgestantes"></label></font></td>
										</tr>
										<tr>
										<td>- Enfoque diferencial:</td>
										<td><label id="nuevosdiscapidad"></label></font><td>
										</tr>
										<tr>
										<td>* Beneficiarios nuevos:</td>
										<td><h3><font color="blue"> <label id="nuevos"></label></font></h3></td>
										</tr>
										</table>
										</div>
									</div>
								</div>
							</div>
							<br>
							<div class="row" style="text-align: center">
								<div class="form-group">
									<div class="col-xs-6 col-sm-6 col-md-offset-2 col-md-4" style="text-align: center">
										<input class="form-control btn btn-block btn-success" id="BT_eliminar_lugar" type="submit" value="APROBAR">
									</div>
									<div class="col-xs-6 col-sm-6 col-md-4" style="text-align: center">
										<button type="button" class="form-control btn btn-block btn-danger" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">CANCELAR</span>
										</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div id="miModalBeneficiariosNuevos" class="modal modal-wide fade">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<center><strong>
								<h4 class="modal-title">Beneficiarios Nuevos del grupo</h4>
							</strong></center>
					</div>
					<div class="modal-body">
						<div id="info_beneficiarios"></div>
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-success" data-dismiss="modal" value="Ok" />
					</div>
				</div>
			</div>
		</div>

		<div id="miModalEnfoqueReal" class="modal modal-wide fade">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<center><strong>
								<h4 class="modal-title">Beneficiarios con enfoque diferencial</h4>
							</strong></center>
					</div>
					<div class="modal-body">
						
					<table id='table-beneficiarios-enfoque' class='table table-striped table-bordered table-hover' width='100%' style='font-size: 12px;'>
										<thead>
											<tr style='text-align: center;'>
												<th style='background-color: #fff2cc'>Identificacion</th>
												<th style='background-color: #fff2cc'>Nombre beneficiario</th>
												<th style='background-color: #fff2cc'>Genero</th>
												<th style='background-color: #fff2cc'>Fecha Nacimiento</th>
												<th style='background-color: #fff2cc'>Enfoque Diferencial</th>	
											</tr>											
										</thead>
										<tbody>
										</tbody>
									</table>



					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-success" data-dismiss="modal" value="Ok" />
					</div>
				</div>
			</div>
		</div>



		

	</div>
</body>

</html>