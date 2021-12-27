<?php
session_start();
if(!isset($_SESSION["session_username"])) {
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

	<link href="../../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

	<script type="text/javascript" src="Js/Entrega_contenidos.js?v=2020.07.15"></script>

	<link href="../../bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"  rel="stylesheet" type="text/css">
	<link href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet">
	<link href="../../bower_components/datatables.net-buttons-dt/css/buttons.dataTables.min.css" rel="stylesheet" >
	<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src="../../bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="../../bower_components/datatables.net-responsive-bs/js/responsive.bootstrap.min.js"></script>	

	<script src="../../bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"  type="text/javascript" ></script>
	<script src="../../bower_components/jszip/dist/jszip.min.js" type="text/javascript" ></script>
	<script src="../../bower_components/datatables.net-buttons/js/buttons.html5.min.js" type="text/javascript" ></script>

	<link href="../../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">
	<script src="../../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript"></script>

	<script src="../../bower_components/bootstrap-filestyle/src/bootstrap-filestyle.min.js" type="text/javascript"></script>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">

	<style type="text/css">
		.p-t{
			padding-top: 15px;
		}
		.th-tabla{
			font-size: 12px;
		}
	</style>

	<title>Entrega de contenidos</title>
</head>
<body>
	<?php include('../../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Entrega de contenidos</h1>
				</div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item active"><a class="nav-link" data-toggle="tab" href="#beneficiarios-sin-informacion" role="tab">Beneficiarios sin información</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#beneficiarios-con-informacion" role="tab">Beneficiarios con información</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#consulta-beneficiarios-sin-informacion" role="tab">Consulta beneficiarios sin información</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="beneficiarios-sin-informacion" role="tabpanel">
						<div class="col-lg-12 text-center bg-info" style="margin-bottom: 20px;">
							<h4>Entrega de contenidos a beneficiarios sin información</h4>
						</div>
						<form id="form-beneficiarios-sin-info">
							<div class="panel panel-default col-lg-6 col-lg-offset-3">
								<div class="panel-heading"><i class="fas fa-2x fa-sort-numeric-down"></i> Beneficiarios atendidos</div>
								<div class="panel-body">
									<div class="row p-t">
										<div class="col-lg-6">
											<label>Total</label>
											<input class="form-control" type="number" name="tx-total" id="tx-total" required="required">
										</div>
										<div class="col-lg-6">
											<label>Mujeres gestantes</label>
											<input class="form-control" type="number" name="tx-mujeres" id="tx-mujeres" required="required">
										</div>
									</div>
									<div class="row p-t">
										<div class="col-lg-4">
											<label>Niños</label>
											<input class="form-control" type="number" name="tx-ninos" id="tx-ninos" required="required">
										</div>
										<div class="col-lg-4">
											<label>Niños de 0 a 3 años</label>
											<input class="form-control" type="number" name="tx-ninos-cero-tres" id="tx-ninos-cero-tres" required="required">
										</div>
										<div class="col-lg-4">
											<label>Niños de 3 a 6 años</label>
											<input class="form-control" type="number" name="tx-ninos-tres-seis" id="tx-ninos-tres-seis" required="required">
										</div>
									</div>
									<div class="row p-t">
										<div class="col-lg-4">
											<label>Niñas</label>
											<input class="form-control" type="number" name="tx-ninas" id="tx-ninas" required="required">
										</div>
										<div class="col-lg-4">
											<label>Niñas de 0 a 3 años</label>
											<input class="form-control" type="number" name="tx-ninas-cero-tres" id="tx-ninas-cero-tres" required="required">
										</div>
										<div class="col-lg-4">
											<label>Niñas de 3 a 6 años</label>
											<input class="form-control" type="number" name="tx-ninas-tres-seis" id="tx-ninas-tres-seis" required="required">
										</div>
									</div>
								</div>
							</div>
							<div class="panel panel-default col-lg-6 col-lg-offset-3">
								<div class="panel-heading"><i class="fa fa-2x fa-users"></i> Beneficiarios atendidos por enfoque diferencial</div>
								<div class="panel-body">
									<div class="row p-t">
										<div class="col-lg-4">
											<label>Afrodescendiente</label>
											<input class="form-control enfoque" type="number" name="tx-afro" id="tx-afro" required="required">
										</div>
										<div class="col-lg-4">
											<label>Comunidad rural y campesina</label>
											<input class="form-control enfoque" type="number" name="tx-rural" id="tx-rural" required="required">
										</div>
										<div class="col-lg-4">
											<label>Condición de discapacidad</label>
											<input class="form-control enfoque" type="number" name="tx-discapacidad" id="tx-discapacidad" required="required">
										</div>
									</div>
									<div class="row p-t">
										<div class="col-lg-4">
											<label>Conflicto armado</label>
											<input class="form-control enfoque" type="number" name="tx-conflicto" id="tx-conflicto" required="required">
										</div>
										<div class="col-lg-4">
											<label>Indígena</label>
											<input class="form-control enfoque" type="number" name="tx-indigena" id="tx-indigena" required="required">
										</div>
										<div class="col-lg-4">
											<label>Menores privados de la libertad</label>
											<input class="form-control enfoque" type="number" name="tx-libertad" id="tx-libertad" required="required">
										</div>
									</div>
									<div class="row p-t">
										<div class="col-lg-4">
											<label>Mujeres victimas de violencia</label>
											<input class="form-control enfoque" type="number" name="tx-violencia" id="tx-violencia" required="required">
										</div>
										<div class="col-lg-4">
											<label>Raizal</label>
											<input class="form-control enfoque" type="number" name="tx-raizal" id="tx-raizal" required="required">
										</div>
										<div class="col-lg-4">
											<label>Rom o gitano</label>
											<input class="form-control enfoque" type="number" name="tx-rom" id="tx-rom" required="required">
										</div>
									</div>
								</div>
							</div>
							<div class="panel panel-default col-lg-6 col-lg-offset-3">
								<div class="panel-heading"><i class="fas fa-2x fa-map-marker-alt"></i> Información del lugar</div>
								<div class="panel-body">
									<div class="row p-t">
										<div class="col-lg-6">
											<label>Lugar de atención</label>
											<select class="form-control selectpicker" name="sl-lugar" id="sl-lugar" title="Seleccione una opción" data-live-search="true" required="required"></select>
										</div>
										<div class="col-lg-6">
											<label>Grupo</label>
											<select class="form-control selectpicker" name="sl-grupo" id="sl-grupo" title="Seleccione una opción" required="required"></select>
										</div>
									</div>
									<div class="row p-t">
										<div class="col-lg-3">
											<label>Localidad</label>
											<p id="localidad"></p>
										</div>
										<div class="col-lg-3">
											<label>Upz</label>
											<p id="upz"></p>
										</div>
										<div class="col-lg-3">
											<label>Entidad</label>
											<p id="entidad"></p>
										</div>
										<div class="col-lg-3">
											<label>Barrio</label>
											<p id="barrio"></p>
										</div>
									</div>
								</div>
							</div>
							<div class="panel panel-default col-lg-6 col-lg-offset-3">
								<div class="panel-heading"><i class="fa fa-2x fa-photo-video"></i> Información del contenido</div>
								<div class="panel-body">
									<div class="row p-t">
										<div class="col-lg-4">
											<label>Contenido entregado</label>
											<select class="form-control selectpicker" name="sl-contenido" id="sl-contenido" title="Selección múltiple" multiple required="required"></select>
										</div>
										<div class="col-lg-4">
											<label>Fecha de entrega</label>
											<input class="form-control" type="date" name="tx-fecha" id="tx-fecha" required="required">
										</div>
										<div class="col-lg-4">
											<label>Documento de soporte</label>
											<input type="file" name="fl-documento" id="fl-documento" runat="server" accept="application/pdf" required="required">
											<p>Archivo PDF - Peso máximo 5MB</p>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-2 col-md-offset-5">
								<button class="form-control btn btn-primary" id="bt-guardar" type="submit">Guardar</button>
							</div>
						</form>
					</div>
					<div class="tab-pane" id="beneficiarios-con-informacion" role="tabpanel">
						<div class="col-lg-12 text-center bg-info" style="margin-bottom: 20px;">
							<h4>Entrega de contenidos a beneficiarios con información completa</h4>
						</div>
						<form id="form-beneficiarios-con-info">
							<div class="col-lg-6 col-lg-offset-3">
								<div class="row p-t">
									<div class="col-lg-6">
										<label>Lugar de atención</label>
										<select class="form-control selectpicker" name="sl-lugar-d" id="sl-lugar-d" title="Seleccione una opción" data-live-search="true" required="required"></select>
									</div>
									<div class="col-lg-6">
										<label>Grupo</label>
										<select class="form-control selectpicker" name="sl-grupo-d" id="sl-grupo-d" title="Seleccione una opción" data-live-search="true" required="required"></select>
									</div>
								</div>
								<div class="row p-t">
									<div class="col-lg-3">
										<label>Localidad</label>
										<p id="localidad-d"></p>
									</div>
									<div class="col-lg-3">
										<label>Upz</label>
										<p id="upz-d"></p>
									</div>
									<div class="col-lg-3">
										<label>Entidad</label>
										<p id="entidad-d"></p>
									</div>
									<div class="col-lg-3">
										<label>Barrio</label>
										<p id="barrio-d"></p>
									</div>
								</div>
								<div class="row p-t">
									<div class="col-lg-6">
										<label>Contenido entregado</label>
										<select class="form-control selectpicker" name="sl-contenido-d" id="sl-contenido-d" title="Selección múltiple" multiple required="required"></select>
									</div>
									<div class="col-lg-6">
										<label>Fecha de entrega</label>
										<input class="form-control" type="date" name="tx-fecha-d " id="tx-fecha-d " required="required">
									</div>
								</div>
							</div>
							<div class="col-lg-12">
								<div class="row p-t">
									<table class="table table-bordered" style="width:100%" id="tabla-beneficiarios">
										<thead>
											<tr>
												<th class="th-tabla">#</th>
												<th class="th-tabla">Número de<br>documento</th>
												<th class="th-tabla">Tipo de<br>documento</th>
												<th class="th-tabla">Primer<br>nombre</th>
												<th class="th-tabla">Segundo<br>nombre</th>
												<th class="th-tabla">Primer<br>apellido</th>
												<th class="th-tabla">Segundo<br>apellido</th>
												<th class="th-tabla">Fecha de<br>nacimiento</th>
												<th class="th-tabla">Género</th>
												<th class="th-tabla">Enfoque<br>diferencial</th>
												<th class="th-tabla">Estrato</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>1</td>
												<td>
													<input type="text" class="form-control input-sm identificacion" placeholder="Identificación" id="tx-identificacion-1" name="tx-identificacion-1" required="required" minlength="3" maxlength="25">
												</td>
												<td>
													<select class="form-control selectpicker tipo-documento" data-style="btn-default btn-sm" data-width="180px" data-live-search="true" id="sl-tipo-documento-1" name="sl-tipo-documento-1" title="Tipo de documento" required="required"></select>
												</td>
												<td>
													<input type="text" class="form-control input-sm mayuscula" placeholder="P. nombre" id="tx-p-nombre-1" name="tx-p-nombre-1" required="required" required="required" minlength="3">
												</td>
												<td>
													<input type="text" class="form-control input-sm mayuscula" placeholder="S. nombre" id="tx-s-nombre-1" name="tx-s-nombre-1">
												</td>
												<td>
													<input type="text" class="form-control input-sm mayuscula" placeholder="P. apellido" id="tx-p-apellido-1" name="tx-p-apellido-1" required="required" minlength="3">
												</td>
												<td>
													<input type="text" class="form-control input-sm mayuscula" placeholder="S. apellido" id="tx-s-apellido-1" name="tx-s-apellido-1">
												</td>
												<td>
													<input type="date" class="form-control input-sm" placeholder="Fecha de nacimiento" id="tx-f-nacimiento-1" name="tx-f-nacimiento-1" style="width:140px;" required="required">
												</td>
												<td>
													<select class="form-control selectpicker" data-style="btn-default btn-sm" id="sl-genero-1" name="sl-genero-1" title="Género" data-width="110px" required="required"></select>
												</td>
												<td>
													<select class="form-control selectpicker" data-style="btn-default btn-sm" data-width="160px" data-live-search="true" id="sl-enfoque-1" name="sl-enfoque-1" title="Enfoque diferencial" required="required"></select>
												</td>
												<td>
													<select class="form-control selectpicker" data-style="btn-default btn-sm" id="sl-estrato-1" name="sl-estrato-1" title="Estrato" data-width="50px" required="required"></select>
													<input type="hidden" class="form-control input-sm" id="TX_Existe_1" name="TX_Existe_1">
												</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="row p-t text-right">
									<button type="button" class="btn btn-success" id="bt-agregar"><i class="fas fa-plus-circle"></i></button>
									<button type="button" class="btn btn-danger" id="bt-remover"><i class="fas fa-minus-circle"></i></button>
								</div>
								<div class="row p-t text-center">
									<button type="submit" class="btn btn-primary" id="bt-guardar-d">Guardar</button>
								</div>
							</div>
						</form>
					</div>
					<div class="tab-pane" id="consulta-beneficiarios-sin-informacion" role="tabpanel">
						<div class="row p-t">
							<div class="col-lg-6 col-lg-offset-3">
								<label>Mes</label>
								<select class="form-control selectpicker" name="sl-mes" id="sl-mes" title="Seleccione una opción">
								</select>
							</div>
						</div>
						<div class="row p-t">
							<div class="col-lg-12 table-responsive" id="div-beneficiarios-sin-informacion">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>

