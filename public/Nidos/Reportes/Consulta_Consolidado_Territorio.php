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

	<script type="text/javascript" src="Js/Consulta_Consolidado_Territorio.js?v=2021.09.21.10"></script>
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
					<h1>CONSOLIDADO TERRITORIO</h1>
				</div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item active"><a class="nav-link" data-toggle="tab" href="#consolidado_territorio" role="tab">Consolidado territorio</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#experiencias_cifras" role="tab">Reporte PANDORA</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#listado_beneficiarios" role="tab">Listado de beneficiarios territorio</a></li>
					
				</ul>

				<div class="tab-content">
					<div class="tab-pane active" id="consolidado_territorio" role="tabpanel">
						<br>
						<div class="col-lg-12">
							<div class="col-lg-3 col-md-3">
								<h3><label>Territorio de:</label></h3>
							</div>
							<div class="col-lg-3 col-md-3">
								<h3>
									<font color="teal"><label id="LB_NombreTerritorio"></label> </font>
								</h3>
							</div>
							<div class="col-lg-3 col-md-3">
								<div class="panel panel-success">
									<div class="panel-heading" style="text-align: center;">
										<h1><label id="LB_Unicos"></label></h1>
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-3">
								<div class="panel panel-warning">
									<div class="panel-heading" style="text-align: center;">
										<h1><label id="LB_Porcentaje"></label>%</h1>
										<label id="LB_Meta"></label>
									</div>
								</div>
							</div>
						</div>

						<div class="col-lg-12">
							<div class="col-lg-12 col-md-12">
								<div class="p-3 mb-2 bg-success text-white" style="text-align: center;">
									<h4>CONSOLIDADO POR LOCALIDAD</h4>
								</div>
							</div>
						</div>

						<table id='table-consolidado-territorio' class='table table-striped table-bordered table-hover' width='100%' style='font-size: 12px; border: 2;'>
							<thead>
								<tr style='background-color: #FCF3CF; text-align: center;'>
									<td>LOCALIDAD</td>
									<td>MAR</td>
									<td>ABR</td>
									<td>MAY</td>
									<td>JUN</td>
									<td>JUL</td>
									<td>AGO</td>
									<td>SEP</td>
									<td>OCT</td>
									<td>NOV</td>
									<td>DIC</td>
									<td>TOTAL</td>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
						<br><br><br>
						<div class="col-lg-12">
							<div class="col-lg-12 col-md-12">
								<div class="p-3 mb-2 bg-success text-white" style="text-align: center;">
									<h4>CONSOLIDADO POR LOCALIDAD</h4>
								</div>
							</div>
						</div>

						<table id='table-consolidado-entidades' class='table table-striped table-bordered table-hover' width='100%' style='font-size: 12px; border: 2;'>
							<thead>
								<tr style='background-color: #FCF3CF; text-align: center;'>
									<td>LOCALIDAD</td>
									<td>MAR</td>
									<td>ABR</td>
									<td>MAY</td>
									<td>JUN</td>
									<td>JUL</td>
									<td>AGO</td>
									<td>SEP</td>
									<td>OCT</td>
									<td>NOV</td>
									<td>DIC</td>
									<td>TOTAL</td>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
						<br><br><br>
						<div class="col-lg-12">
							<div class="col-lg-12 col-md-12">
								<div class="p-3 mb-2 bg-success text-white" style="text-align: center;">
									<h4>CONSOLIDADO POR LUGAR DE ATENCIÓN</h4>
								</div>
							</div>
						</div>
						
						<table id='table-consolidado-lugar' class='table table-striped table-bordered table-hover' width='100%' style='font-size: 12px; border: 2;'>
						<thead>
							<tr>
							<th rowspan='2' style='background-color: #fff2cc'>LOCALIDAD</th>
							<th rowspan='2' style='background-color: #fff2cc'>LUGAR</th>
							<th rowspan='2' style='background-color: #fff2cc'>ENTIDAD</th>
							<th rowspan='2' style='background-color: #fff2cc'>TOTAL ACUMULADO</th>
							<th colspan='3' style='background-color: #5499C7'><center>MARZO</center></th>
							<th colspan='3' style='background-color: #5499C7'><center>ABRIL</center></th>
							<th colspan='3' style='background-color: #5499C7'><center>MAYO</center></th>
							<th colspan='3' style='background-color: #5499C7'><center>JUNIO</center></th>
							<th colspan='3' style='background-color: #5499C7'><center>JULIO</center></th>
							<th colspan='3' style='background-color: #5499C7'><center>AGOSTO</center></th>
							<th colspan='3' style='background-color: #5499C7'><center>SEPTIEMBRE</center></th>
							<th colspan='3' style='background-color: #5499C7'><center>OCTUBRE</center></th>
							<th colspan='3' style='background-color: #5499C7'><center>NOVIEMBRE</center></th>
							<th colspan='3' style='background-color: #5499C7'><center>DICIEMBRE</center></th>					
						</tr>
							<th>GRU.</th>
							<th>LAB.</th>
							<th>TOTAL</th>
							<th>GRU.</th>
							<th>LAB.</th>
							<th>TOTAL</th>
							<th>GRU.</th>
							<th>LAB.</th>
							<th>TOTAL</th>
							<th>GRU.</th>
							<th>LAB.</th>
							<th>TOTAL</th>
							<th>GRU.</th>
							<th>LAB.</th>
							<th>TOTAL</th>
							<th>GRU.</th>
							<th>LAB.</th>
							<th>TOTAL</th>
							<th>GRU.</th>
							<th>LAB.</th>
							<th>TOTAL</th>
							<th>GRU.</th>
							<th>LAB.</th>
							<th>TOTAL</th>
							<th>GRU.</th>
							<th>LAB.</th>
							<th>TOTAL</th>
							<th>GRU.</th>
							<th>LAB.</th>
							<th>TOTAL</th>
							</tr> 
						</thead>
						
						<tbody>
						</tbody>
						</table>






					<!--	<div class="col-lg-12">
							<div class="col-lg-3 col-md-3">
								<div class="panel panel-primary">
									<div class="panel-heading" style="text-align: center;">
										<h4><label id="LB_Atendidos"></label></h4>
										Asistencia Real
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-3">
								<div class="panel panel-danger">
									<div class="panel-heading" style="text-align: center;">
										<h4><label id="LB_Repetidos"></label></h4>
										Beneficiarios con más de una atención
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-3">
								<div class="panel panel-default">
									<div class="panel-heading" style="text-align: center;">
										<h4><label id="LB_UsoDatos"></label></h4>
										Sin uso de datos
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-3">
								<br>
							</div>
						</div> -->

						
						<div class="col-lg-12">
							<div class="col-lg-12 col-md-12">
								<div class="p-3 mb-2 bg-danger text-white" style="text-align: center;">
									<h4>CONSOLIDADO POR DUPLA</h4>
								</div>
							</div>
						</div>

						<table id='table-consolidado-dupla' class='table table-striped table-bordered table-hover' width='100%' style='font-size: 12px; border: 2;'>
							<thead>
								<tr style='background-color: #D7BDE2; text-align: center;'>
									<td>DUPLA</td>
									<td>FEB</td>
									<td>MAR</td>
									<td>ABR</td>
									<td>MAY</td>
									<td>JUN</td>
									<td>JUL</td>
									<td>AGO</td>
									<td>SEP</td>
									<td>OCT</td>
									<td>NOV</td>
									<td>DIC</td>
									<td>TOTAL</td>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>

				<!--		<div class="col-lg-12">
							<div class="col-lg-12 col-md-12">
								<div class="p-3 mb-2 bg-success text-white" style="text-align: center;">
									<h4>CONSOLIDADO POR LUGAR DE ATENCIÓN</h4>
								</div>
							</div>
						</div><br>


						<div class="col-lg-12">
							<div class="col-lg-2 col-md-2">
								<div class="panel panel-success">
									<div class="panel-heading" style="text-align: center;">
										<h4><label id="LB_ICBF"></label></h4>
										ICBF
									</div>
								</div>
							</div>
							<div class="col-lg-2 col-md-2">
								<div class="panel panel-danger">
									<div class="panel-heading" style="text-align: center;">
										<h4><label id="LB_SDIS"></label></h4>
										SDIS
									</div>
								</div>
							</div>
							<div class="col-lg-2 col-md-2">
								<div class="panel panel-primary">
									<div class="panel-heading" style="text-align: center;">
										<h4><label id="LB_SED"></label></h4>
										SED
									</div>
								</div>
							</div>
							<div class="col-lg-2 col-md-2">
								<div class="panel panel-warning">
									<div class="panel-heading" style="text-align: center;">
										<h4><label id="LB_IDARTES"></label></h4>
										IDARTES
									</div>
								</div>
							</div>
							<div class="col-lg-2 col-md-2">
								<div class="panel panel-default">
									<div class="panel-heading" style="text-align: center;">
										<h4><label id="LB_PRIVADA"></label></h4>
										PRIVADA
									</div>
								</div>
							</div>
							<div class="col-lg-1 col-md-1">
								<div class="panel panel-info">
									<div class="panel-heading" style="text-align: center;">
										<h4><label id="LB_GRC"></label></h4>
										GR/C
									</div>
								</div>
							</div>
							<div class="col-lg-1 col-md-1">
								<div class="panel panel-success">
									<div class="panel-heading" style="text-align: center;">
										<h4><label id="LB_SM"></label></h4>
										S. M.
									</div>
								</div>
							</div>
						</div> -->

						
					</div>

					<div class="tab-pane" id="experiencias_cifras" role="tabpanel">
						<br><br>						
						<div class="row">
							<label class="col-md-2">Seleccione el Mes:</label>
							<div class="col-md-10">
								<select class="form-control" data-live-search="true" name="SL_Mes_Reporte" id="SL_Mes_Reporte"></select>
							</div>
						</div>
						<br>
						<input class="form-control btn btn-primary" id="BT_Consultar_Pandora" type="submit" value="Consultar Experiencias Registradas con Cifras">
						<br>
						<div id="div_Consolidado_Pandora" style="display: none;">
							<div class="row">
								<div class='col-xs-12 col-md-12'>
									<table id='table-reporte-pandora' class='table table-striped table-bordered table-hover' width='100%' style='font-size: 12px;'>
										<thead>
											<tr>
												<th rowspan='2' style='background-color: #fff2cc'>Mes de reporte</th>
												<th rowspan='2' style='background-color: #fff2cc'>Modalidad de la actividad</th>
												<th rowspan='2' style='background-color: #fff2cc'>Número actividades</th>
												<th rowspan='2' style='background-color: #fff2cc'>Fecha realización de la actividad</th>
												<th rowspan='2' style='background-color: #fff2cc'>Lugar Escenario</th>
												<th rowspan='2' style='background-color: #fff2cc'>Capacidad/aforo</th>
												<th rowspan='2' style='background-color: #fff2cc'>Localidad</th>
												<th rowspan='2' style='background-color: #fff2cc'>Upz_Upr</th>
												<th rowspan='2' style='background-color: #fff2cc'>Barrio</th>
												<th rowspan='2' style='background-color: #fff2cc'>Número total de artistas</th>
												<th rowspan='2' style='background-color: #fff2cc'>Personas inscritas</th>
												<th rowspan='2' style='background-color: #fff2cc'>Mujeres</th>
												<th rowspan='2' style='background-color: #fff2cc'>Hombres</th>
												<th rowspan='2' style='background-color: #fff2cc'>Total beneficiarios</th>
												<th colspan='6' style='background-color: #5499C7'>
													<center>SECTORES ETARIOS</center>
												</th>
												<th colspan='16' style='background-color: #52BE80'>
													<center>SECTORES SOCIALES </center>
												</th>
												<th colspan='7' style='background-color: #A569BD'>
													<center>GRUPOS ÉTNICOS</center>
												</th>

											</tr>
											<tr>
												<th style='background-color: #7FB3D5'>Primera Infancia entre 0 y 5 años</th>
												<th style='background-color: #7FB3D5'>Infancia y  6-12 años</th>
												<th style='background-color: #7FB3D5'>Adolescencia 13-17 años</th>
												<th style='background-color: #7FB3D5'>Juventud 18-28 años</th>
												<th style='background-color: #7FB3D5'>Personas Adultas 29-59 años</th>
												<th style='background-color: #7FB3D5'>Personas Mayores 60 años</th>

												<th style='background-color: #7DCEA0'>Comunidades Campesinas y Rurales</th>
												<th style='background-color: #7DCEA0'>Mujeres Gestantes y Lactantes</th>
												<th style='background-color: #7DCEA0'>Personas que ejercen actividades sexuales pagadas</th>
												<th style='background-color: #7DCEA0'>Personas habitantes de calle</th>
												<th style='background-color: #7DCEA0'>Personas con discapacidad</th>
												<th style='background-color: #7DCEA0'>Personas  privadas de la libertad</th>
												<th style='background-color: #7DCEA0'>Profesionales del Sector</th>
												<th style='background-color: #7DCEA0'>Sectores LGBTIQ</th>
												<th style='background-color: #7DCEA0'>Personas víctimas del conflicto armado</th>
												<th style='background-color: #7DCEA0'>Población migrante</th>
												<th style='background-color: #7DCEA0'>Personas víctimas de trata</th>
												<th style='background-color: #7DCEA0'>Familias En Emergencia Social Y Catastrófica</th>
												<th style='background-color: #7DCEA0'>Familias Ubicadas En Zonas De Deterioro Urbano</th>
												<th style='background-color: #7DCEA0'>Familias En Situación De Vulnerabilidad</th>
												<th style='background-color: #7DCEA0'>Personas En Situación De Desplazamiento</th>
												<th style='background-color: #7DCEA0'>Personas Consumidoras De Sustancias Psicoactivas</th>

												<th style='background-color: #D7BDE2'>Pueblo Rrom – Gitano</th>
												<th style='background-color: #D7BDE2'>Pueblo Rrom – Gitano (Prorrom)</th>
												<th style='background-color: #D7BDE2'>Pueblo y/o comunidad indígena</th>
												<th style='background-color: #D7BDE2'>Comunidades negras</th>
												<th style='background-color: #D7BDE2'>Población afrodescendiente</th>
												<th style='background-color: #D7BDE2'>Comunidades palenqueras</th>
												<th style='background-color: #D7BDE2'>Pueblo raizal</th>

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

					<div class="tab-pane" id="listado_beneficiarios" role="tabpanel">
						<br><br>
						
						<div id="div_Consolidado_Pandora">
								<div class='col-xs-12 col-md-12'>
									<table id='table-listado-beneficiario' class='table table-striped table-bordered table-hover' width='100%' style='font-size: 12px;'>
										<thead>
											<tr style='background-color: #7FB3D5; text-align: center;'>
												<th>Identificación</th>
												<th>Tipo de Identificación</th>
												<th>Nombre Beneficiario</th>
												<th>Genero</th>
												<th>Enfoque Diferencial </th>
												<th>Uso de datos</th>
												<th>Dupla</th>
												<th>Lugar de Atención</th>
												<th>Grupo</th>
												<th>Primera Atención</th>												
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
</body>
</html>