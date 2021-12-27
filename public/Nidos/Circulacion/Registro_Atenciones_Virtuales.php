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
	<title>Registro Atenciones Virtuales</title>


	<link href="../../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

	<script type="text/javascript" src="Js/Registro_Atenciones_Virtuales.js?v=2020.11.17.02"></script>

	<script src="../../node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="../../node_modules/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<link href="../../node_modules/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">

	<script src="../../node_modules/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<link href="../../node_modules/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">

	<script src="../../node_modules/datatables.net-buttons/js/dataTables.buttons.min.js"></script> 
	<script src="../../node_modules/datatables.net-buttons/js/buttons.html5.min.js"></script> 
	<script src="../../node_modules/jszip/dist/jszip.min.js"></script> 

	<script src="../../node_modules/datatables.net-fixedcolumns/js/dataTables.fixedColumns.min.js"></script> 
	<link href="../../node_modules/datatables.net-fixedcolumns-bs/css/fixedColumns.bootstrap.min.css" rel="stylesheet">

	<link href="../../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">
	<script src="../../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript"></script>

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
	<style type="text/css">
		textarea {
			resize: vertical;
		}
	</style>

</head>

<body>
	<?php include("../../LibreriasExternas/Analytics/analyticstracking.php"); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Registro Atenciones Virtuales</h1>
				</div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item active"><a id="nav_asignacion_artista" class="nav-link" data-toggle="tab" href="#asignacion_artista" role="tab">Registro de llamadas</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="asignacion_artista" role="tabpanel">
						<div class="form-group">
							<div class="row">
								<div class="col-xs-12 col-md-12 text-center bg-info"><h4>Atenciones virtuales asignadas</h4></div>
							</div>
						</div>
						<form id="form-consultar-atenciones-virtuales-aignadas">
							<div class="row">
								<div class="form-group col-md-6 col-md-offset-3">
									<label>Mes:</label>
									<select class="form-control selectpicker SeleccionarGrupo" id="SL_Mes" title="Seleccione un opción" required></select>
								</div>
							</div>
							<div class="row">
								<div class="form-group col-md-6 col-md-offset-3">
									<button type="submit" class="btn btn-block btn-primary">Consultar</button>
								</div>
							</div>
						</form>


						<div id="div_atenciones_asignadas" style="display: none;">
							<div class="form-group">
								<div class="row">
									<div class="col-lg-12 table-responsive">
										<table id="tabla_atenciones_asignadas" class="table table-striped table-bordered table-hover" width="100%">
											<thead>
												<tr>
													<th>Fecha</th>
													<th>Horario</th>
													<th>Tipo de atención</th>
													<th>A quien va dirigida</th>
													<th>Nombre cuidador</th>
													<th>Nombre beneficiario</th>
													<th>Edad</th>
													<th>Enfoque</th>
													<th>Comentarios</th>
													<th>Aceptó políticas</th>
													<th>Celular</th>
													<th>Condición de salud</th>
													<th>Dificultades movilidad física</th>
													<th>Formulario</th>
													<th>Registrar llamada</th>
												</tr>
											</thead>
											<tbody></tbody>
										</table>
									</div>	
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal" id="miModalRegistroLlamada" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="myModalLabel" style="text-align: center">
						<span id="modal-title"></span>
					</h4>
				</div>
				<form id="form_Registro_Llamada_div">
					<div class="modal-body">
						<input type="hidden" id="TX_ID_Franja_Artista" name="TX_ID_Franja_Artista">
						<div class="row">
							<div class="form-group col-md-12">
								<label>¿La llamada fue efectiva?</label>
								<select class="form-control selectpicker" title="Seleccione una opción" id="SL_Llamada_Realizada" required>
									<option value="1">SI</option>
									<option value="2">NO</option>
								</select>
							</div>
							<div class="form-group col-md-12" id="formulario-sin-horario">
								<label>Fecha de la llamada</label>
								<input class="form-control" type="date" id="fecha-formulario-sin-horario">
							</div>
						</div>
						
						<div id="div_modal_llamadaSI" style="display: none;">
							
							<div class="row">
								<div class="form-group col-md-6">
									<label>Duración de la llamada:</label>
									<textarea class="form-control" id="TX_Duracion_Llamada" placeholder="(HH:MM:SS)" rows="5"></textarea>
								</div>
								<div class="form-group col-md-6">
									<label>¿Qué material narró o cantó?</label>
									<textarea class="form-control" id="TX_Material" rows="5"></textarea>
								</div>
							</div>
							<div class="row">
								<div class="form-group col-md-6">
									<label>¿Qué les pareció la Lectura?</label>
									<textarea class="form-control" id="TX_Lectura" rows="5"></textarea>
								</div>
								<div class="form-group col-md-6">
									<label>¿Cómo reaccionó tu hijo o hija?</label>
									<textarea class="form-control" id="TX_Reacciono" rows="5"></textarea>
								</div>
							</div>
						</div>
						<div id="div_modal_llamadaNO" style="display: none;">
							<div class="row">
								<div class="form-group col-md-12">
									<label>Observaciones de la llamada:</label>
									<textarea class="form-control" id="TX_Observaciones" rows="5"></textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">Registrar llamada</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
					</div>
				</form>


			</div>
		</div>
	</div>
	<div class="modal" id="miModalConsultarLlamada" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="myModalLabel" style="text-align: center">
						<span>INFORMACIÓN DE LA LLAMADA - </span><span id="s-nombre-beneficiario-consulta"></span> <span id="s-apellido-beneficiario-consulta"></span>
					</h4>
				</div>
				<div class="modal-body">
					<div id="div-consulta-llamada-realizada">
						<div class="form-group">
							<div class="row">
								<div class="col-md-6">
									<label>Duración de la llamada:</label>
									<p id="p-duracion"></p>
								</div>

								<div class="col-md-6">
									<label>¿Qué material narró o cantó?</label>
									<p id="p-material"></p>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-md-6">
									<label>¿Qué les pareció la Lectura?</label>
									<p id="p-parecio"></p>
								</div>
								<div class="col-md-6">
									<label>¿Cómo reaccionó tu hijo o hija?</label>
									<p id="p-reaccion"></p>
								</div>
							</div>
						</div>
					</div>
					<div id="div-consulta-llamada-no-realizada">
						<div class="row">
							<div class="col-md-12">
								<label>Observaciones:</label>
								<p id="p-observaciones"></p>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal modal-wide fade" id="miModalEditarLlamada" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="myModalLabel" style="text-align: center">EDITAR INFORMACIÓN DE LA LLAMADA</h4>
				</div><br>
				<div class="modal-body">
					<form id="form_editar_llamado_div">
						<input type="hidden" id="tx-id-llamada">

						<div class="panel panel-default">
							<div class="panel-heading">INFORMACIÓN DEL CUIDADOR</div>
							<div class="panel-body">
								<div class="form-group">
									<div class="row">
										<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
											<label>Tipo de identificación</label>
											<select class="form-control selectpicker" id="sl-tipo-doc-cuidador-editar" title="Seleccione una opción" required></select>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
											<label>Número de documento</label>
											<input type="number" class="form-control" id="tx-documento-cuidador-editar" required>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
											<label>Nombre completo</label>
											<input type="text" class="form-control mayuscula" id="tx-nombre-cuidador-editar" required>
										</div>
									</div>
								</div>

								<div class="form-group">
									<div class="row">
										<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
											<label>Correo Electrónico</label>
											<input type="email" class="form-control" id="tx-correo-cuidador-editar" required>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
											<label>Localidad</label>
											<select class="form-control selectpicker" id="sl-localidad-cuidador-editar" title="Seleccione una opción" required>
												<option value="1">1. USAQUÉN</option>
												<option value="2">2. CHAPINERO</option>
												<option value="3">3. SANTA FE</option>
												<option value="4">4. SAN CRISTOBAL</option>
												<option value="5">5. USME</option>
												<option value="6">6. TUNJUELITO</option>
												<option value="7">7. BOSA</option>
												<option value="8">8. KENNEDY</option>
												<option value="9">9. FONTIBÓN</option>
												<option value="10">10. ENGATIVÁ</option>
												<option value="11">11. SUBA</option>
												<option value="12">12. BARRIOS UNIDOS</option>
												<option value="13">13. TEUSAQUILLO</option>
												<option value="14">14. MÁRTIRES</option>
												<option value="15">15. ANTONIO NARIÑO</option>
												<option value="16">16. PUENTE ARANDA</option>
												<option value="17">17. CANDELARIA</option>
												<option value="18">18. RAFAEL URIBE</option>
												<option value="19">19. CIUDAD BOLIVAR</option>
												<option value="20">20. SUMAPAZ</option>
												<option value="21">21. OTRA CIUDAD O PAIS</option>
											</select>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
											<label>Barrio</label>
											<input type="text" class="form-control mayuscula" id="tx-barrio-cuidador-editar" required>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
											<label>Dirección</label>
											<input type="text" class="form-control mayuscula" id="tx-direccion-cuidador-editar" required>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
											<label>Estrato</label>
											<select class="form-control selectpicker" id="sl-estrato-cuidador-editar" title="Seleccione una opción" required>
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
												<option value="6">6</option>
											</select>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
											<label>Edad</label>
											<input type="number" class="form-control" id="tx-edad-cuidador-editar" required>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">INFORMACIÓN DEL NIÑO/NIÑA A QUIEN VA DIRIGIDA LA ATENCIÓN</div>
							<div class="panel-body">
								<div class="form-group">
									<div class="row">
										<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
											<label>¿A quien va dirigida la lectura?</label>
											<p id="tx-dirigida-editar"></p>
										</div>
									</div>
								</div>

								<div id="div-dirigido-ninos" style="display: none;">
									<div class="form-group">
										<div class="row">
											<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
												<label>¿Posee la patria potestad?</label>
												<p id="tx-potestad-editar"></p>
											</div>
											<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
												<label>Parentesco</label>
												<select class="form-control selectpicker" id="tx-parentesco-editar" title="Seleccione una opción" required>
													<option value="1">Madre o padre</option>
													<option value="2">Tía o tío</option>
													<option value="3">Abuela o abuelo</option>
													<option value="4">Hermano o hermana</option>
													<option value="5">Acudiente</option>
													<option value="6">Otro</option>
												</select>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
												<label>Nombres</label>
												<input type="text" class="form-control mayuscula" id="tx-nombres-beneficiario-editar" required>
											</div>
											<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
												<label>Apellidos</label>
												<input type="text" class="form-control mayuscula" id="tx-apellidos-beneficiario-editar" required>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="display: none;" id="div-check-si">
												<label>Fecha de nacimiento</label>
												<input type="date" class="form-control" id="tx-fecha-nacimiento-beneficiario-editar">
											</div>
											<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="display: none;" id="div-check-no">
												<label>Edad</label>
												<select class="form-control selectpicker" title="Seleccione una opción" id="sl-edad-beneficiario-editar">
													<option value="1">De 1 mes a 1 año</option>
													<option value="2">2 años</option>
													<option value="3">3 años</option>
													<option value="4">4 años</option>
													<option value="5">5 años</option>
												</select>
											</div>
											<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
												<label>Enfoque diferencial</label>	
												<select class="form-control selectpicker" title="Seleccione una opción" id="sl-enfoque-beneficiario-editar" required></select>
											</div>
										</div>
									</div>

									<div id="Informacion_potestaSi" style="display: none;">
										<div class="form-group">
											<div class="row">
												<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
													<label>Tipo de documento</label>
													<select class="form-control selectpicker" title="Seleccione una opción" data-live-search="true" id="sl-tipo-doc-beneficiario-editar"></select>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
													<label>Número de documento</label>	
													<input type="number" class="form-control" id="tx-numero-doc-beneficiario-editar">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- <div class="panel panel-default">
							<div class="panel-heading">INFORMACIÓN DE LA ATENCIÓN</div>
							<div class="panel-body">
								<div class="form-group">
									<div class="row">
										<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
											<label>Fecha de la llamada</label>
											<p id="p-fecha-llamada"></p>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
											<label>Inicio de la llamada</label>
											<p id="p-inicio-llamada"></p>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
											<label>Fin de la llamada</label>
											<p id="p-fin-llamada"></p>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
											<label>Número telefónico</label>
											<p id="p-telefono-llamada"></p>
										</div>
									</div>
								</div>
							</div>
						</div> -->
						<div class="form-group">
							<div class="row">
								<div class="col-xs-6 col-sm-6 col-md-offset-2 col-md-4">
									<button type="submit" class="btn btn-block btn-success" id="BT_EditarEvento">Editar información</button>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-4">
									<button type="button" class="form-control btn btn-block btn-danger" data-dismiss="modal" aria-label="Close">Cancelar</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>