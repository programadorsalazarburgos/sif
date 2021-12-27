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
	<title>Administración Atenciones Virtuales</title>


	<link href="../../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

	<script type="text/javascript" src="Js/Administracion_Atenciones_Virtuales.js?v=2021.05.25.01	"></script> 

	<link href="../../bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"  rel="stylesheet" type="text/css" >
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

	<link href="../../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
	<script src="../../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

	<link href="../../bower_components/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet" type="text/css">
	<script src="../../bower_components/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>

	<link href="../../bower_components/jquery-timepicker-wvega/jquery.timepicker.css" rel="stylesheet" type="text/css">
	<script src="../../bower_components/jquery-timepicker-wvega/jquery.timepicker.js" type="text/javascript"></script>
	<script src="../../bower_components/moment/moment.js" type="text/javascript"></script>

	<link href="../../bower_components/summernote/dist/summernote.css" rel="stylesheet"> 
	<script src="../../bower_components/summernote/dist/summernote.min.js"></script>          
	<script src="../../bower_components/summernote/dist/lang/summernote-es-ES.js"></script>  

	<script src="../../bower_components/jquery-validation/dist/jquery.validate.min.js"></script>
	<script src="../../bower_components/fontawesome/svg-with-js/js/fontawesome-all.min.js" ></script>

	<script src="../../bower_components/pdfmake/build/pdfmake.js" type="text/javascript" ></script>
	<script src="../../bower_components/pdfmake/build/vfs_fonts.js" type="text/javascript" ></script> 

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" href="../../css/Nidos.css">
	<?php include('../../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<style type="text/css">
		.p-t{
			padding-top: 15px;
		}
	</style>

</head>
<body>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Administración Atenciones Virtuales</h1>
				</div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item active" ><a class="nav-link" data-toggle="tab" href="#creacion_horarios" role="tab">Crear horarios de atención</a></li>
					<li class="nav-item"><a id="nav_modificacion_horarios" class="nav-link" data-toggle="tab" href="#modificacion_horarios" role="tab">Modificación de horarios</a></li>
					<li class="nav-item"><a id="nav_asignacion_artista" class="nav-link" data-toggle="tab" href="#asignacion_artista" role="tab">Asignación de artistas</a></li>
					<li class="nav-item"><a id="nav_administracion_formularios" class="nav-link" data-toggle="tab" href="#administracion_formularios" role="tab">Administración formularios</a></li>			
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="creacion_horarios" role="tabpanel">
						<form id="form_crear_oferta_diaria">
							<div class="row">
								<div class="col-xs-12 col-md-12 text-center bg-info">
									<h4>Horarios de Atención</h4>
								</div>
							</div>
							<?php echo "<input type='hidden' id='id_usuario' name='id_usuario' value='".$Id_Persona."'" ?><br><br>
							
							<div class="row p-t col-md-8 col-md-offset-2">
								<div class="col-md-6">
									<label>1. Seleccione el formulario</label>
									<select class="form-control selectpicker" required="required" title="Seleccione una opción" name="SL_Formulario" id="SL_Formulario">
										<option value="1">COMUNIDAD</option>
										<option value="2">INSTITUCIONAL TERRITORIAL 1 y 3</option>
										<option value="3">INSTITUCIONAL TERRITORIAL 2 y 4</option>
									</select>										
								</div>	
								<div class="col-md-6">
									<label>2. Seleccione el tipo de atención</label>	
									<select class="form-control selectpicker" required="required" title="Seleccione tipo de lectura" name="TX_TipoAtencion" id="TX_TipoAtencion">
										<option value="1">CUENTO Y POESÍA</option>
										<option value="2">CANTO</option>
									</select>										
								</div>						
							</div>
							<div class="row p-t col-md-8 col-md-offset-2">		
								<div class="col-md-6">	
									<label>3. Indique la cantidad franjas:</label>
									<a id="btn_Agregar" class="btn btn-primary " Title="Agregar" data-toggle='tooltip'  data-placement="right">Agregar</a>
									<a id="btn_Quitar"  class="btn btn-danger " Title="Quitar" data-toggle='tooltip'  data-placement="right">Quitar</a>
								</div>
								<div class="col-md-6">
									<label>4. Fecha de la atención</label>
									<div class="input-group date">
										<input type="text" readonly="readonly" required="required" class="form-control input-sm calendario" id="TX_Fecha_Atencion" placeholder="Fecha Oferta" style="border-style: solid; border-width: 2px; border-color: #3c763d;">
										<span class="input-group-addon">
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
									</div>
								</div>	
							</div><br><br>					
							<div class="row p-t col-md-8 col-md-offset-2">
								<table class="table" style="width:100%" id="tabla_Titulos_Registro">
									<thead>
										<tr>
											<th style="width: 1%; vertical-align: middle;">#</th>
											<th style="width: 33%">DÍA</th>
											<th style="width: 33%">HORA</th>
											<th style="width: 33%">CUPOS</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td style="width: 1%; vertical-align: middle;">1</td>
											<td style="width: 33%">
												<input type="text" class="form-control" placeholder="Día" id="TX_Dia_1" name="TX_Dia_1" readonly="readonly"><span class="help-block" id="error"></span>
											</td>
											<td style="width: 33%">
												<input type="text"class="form-control hora_inicio" id="TX_Hora_Inicio_1" name="TX_Hora_Inicio_1" readonly="readonly" placeholder="Hora de inicio"  required="required" /><span class="help-block" id="error"></span>
												<input type="hidden" class="form-control fecha" id="TX_Fecha_1" name="TX_Fecha_1"><span class="help-block" id="error"></span>				
											</td>
											<td style="width: 33%">	
												<input type="text" class="form-control" placeholder="Cupos" id="TX_Cupos_1" name="TX_Cupos_1"><span class="help-block" id="error"></span>				
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="row">
								<div class="col-xs-6 col-xs-offset-3 col-md-6 col-md-offset-3">
									<input class="form-control btn btn-primary" id="BT_guardar_oferta" type="submit" value="Crear oferta para este día">
								</div>
							</div>
						</form>
					</div>
					<div class="tab-pane" id="modificacion_horarios" role="tabpanel">
						<div class="row">
							<div class="col-xs-12 col-md-12 text-center bg-info">
								<h4>Consultar Oferta Mensual</h4>
							</div>
						</div>
						<br>
						<div class="row p-t col-md-8 col-md-offset-2">
							<div class="col-md-6">
								<label>1. Seleccione el mes:</label>
								<select class="form-control SeleccionarGrupo" data-live-search="true" name="SL_Mes" id="SL_Mes" title="Seleccione un Mes"></select>											
							</div>	
							<div class="col-md-6">
								<label>2. Seleccione el formulario</label>	
								<select class="form-control selectpicker" required="required" title="Seleccione una opción" name="SL_Formulario_Horario" id="SL_Formulario_Horario">
									<option value="1">COMUNIDAD</option>
									<option value="2">INSTITUCIONAL TERRITORIAL 1 y 3</option>
									<option value="3">INSTITUCIONAL TERRITORIAL 2 y 4</option>
								</select>									
							</div>						
						</div>
						<div class="row p-t col-md-4 col-md-offset-4">							
							<input class="form-control btn btn-primary" id="BT_Consultar_Horarios" type="submit" value="Consultar Horarios">
						</div>
						<br>
						<div class="row p-t col-md-12">
							<div class="table-responsive" id="div_oferta_atenciones_mes"  style="display: none;">
								<table id="tabla_oferta_mensual" class="table table-striped table-bordered table-hover" width="100%">
									<thead>
										<tr>
											<th class="text-center">Formulario</th>
											<th class="text-center">Tipo Atención</th>
											<th class="text-center">Fecha</th>
											<th class="text-center">Día</th>										
											<th class="text-center">Horario</th>
											<th class="text-center">Cupos</th>							
											<th class="text-center">Disponibles</th>
											<th class="text-center">Acciones</th>										
										</tr>
									</thead>
									<tbody></tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="asignacion_artista" role="tabpanel">
						<div class="row">
							<div class="form-group col-xs-12 col-md-12 text-center bg-info">
								<h4>Consultar Programación Diaria</h4>
							</div>
						</div>
						<br>
						<div class="row">
							<form id="form-asignacion-artista">
								<div class="form-group col-lg-offset-3 col-lg-6">
									<label>1. Formulario</label>	
									<select class="form-control selectpicker" title="Seleccione una opción" name="SL_Formulario_Artista" id="SL_Formulario_Artista" required>
										<option value="1">COMUNIDAD</option>
										<option value="2">INSTITUCIONAL TERRITORIAL 1 y 3</option>
										<option value="3">INSTITUCIONAL TERRITORIAL 2 y 4</option>
										<option value="4">ARN</option>
										<option value="5">AULAS HOSPITALARIAS</option>
									</select>
								</div>
								<div class="form-group col-lg-6 col-md-offset-3" id="div-horario-asignar-artista" style="display: none;">
									<label>2. Fecha Seleccione el día:</label>
									<div class="input-group date">
										<input type="text" class="form-control calendario" id="TX_Fecha_Asignacion">
										<span class="input-group-addon">
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
									</div>
								</div>
								<div class="form-group col-lg-4 col-lg-offset-4">							
									<button class="btn btn-block btn-primary" type="submit">Consultar</button>
								</div>
							</form>
						</div>
						<div class="row">
							<div class="form-group col-md-12">
								<div class="table-responsive" id="div_demanda_atenciones" style="display: none;">
									<table id="tabla_demanda_diaria" class="table table-striped table-bordered table-hover">
										<thead>
											<tr>
												<th>Fecha de la llamada</th>
												<th>Horario</th>
												<th>Tipo de atención</th>
												<th>A quien va dirigida </th>
												<th>Nombre cuidador</th>
												<th>Nombre beneficiario</th>
												<th>Enfoque</th>
												<th>Comentarios</th>
												<th>Celular</th>
												<th>Artista asignado</th>
												<th>Acciones</th>	
											</tr>
										</thead>
										<tbody></tbody>
									</table>
								</div>
							</div>
						</div>
					</div>		
					<div class="tab-pane" id="administracion_formularios" role="tabpanel">
						<div class="row">
							<div class="col-lg-12 text-center bg-info"><h4>Información del formulario</h4>
							</div>
						</div>
						<div class="row p-t">
							<div class="col-lg-8 col-lg-offset-2">
								<label>Formulario</label>
								<select class="form-control selectpicker" title="Seleccione una opción" name="sl-formulario" id="sl-formulario">
									<option value="1">Comunidad</option>
									<option value="2">Institucional 1 y 3</option>
									<option value="3">Institucional 2 y 4</option>
								</select>
							</div>
						</div>
						<form id="form-formulario">
							<div class="row p-t">
								<div class="col-lg-8 col-lg-offset-2">
									<label>Contenido del formulario cerrado</label>
									<div id="tx-contenido"></div>
								</div>
							</div>
							<div class="row p-t">
								<div class="col-lg-8 col-lg-offset-2 text-right">
									<label>Estado del formulario <input type="checkbox" id="cb-estado-formulario" data-on="Cerrado" data-off="Abierto" data-toggle="toggle" data-onstyle="danger" data-offstyle="success" data-width="100"></label>
								</div>
							</div>
							<div class="row p-t">
								<div class="col-lg-8 col-lg-offset-2">
									<div class="col-lg-4 col-lg-offset-4">
										<button class="form-control btn btn-block btn-primary" id="bt-modificar-formulario" type="submit">Modificar</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal modal-wide fade" id="miModalEditarFranja" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="myModalLabel" style="text-align: center">EDITAR INFORMACIÓN DE LA OFERTA</h4>
				</div>				
				<input type="hidden"  id="TX_ID_Franja_Editar" name="TX_ID_Franja_Editar">
				<div class="modal-body">
					<form id="form_editar_franja_div">
						<div class="form-group">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><font color="teal"><h4 class="modal-title">Franja horarira</h4></font></div>	
						</div>
						<div class="form-group">
							<div class="col-md-12"><br></div>
						</div>	
						<div class="row p-t">
							<div class="col-md-6">
								<label>Formulario:</label>
								<select class="form-control selectpicker" required="required" title="Seleccione una opción" name="SL_Formulario_Editar" id="SL_Formulario_Editar">
									<option value="1">COMUNIDAD</option>
									<option value="2">INSTITUCIONAL TERRITORIAL 1 y 3</option>
									<option value="3">INSTITUCIONAL TERRITORIAL 2 y 4</option>
									<option value="4">ARN</option>
								</select>
							</div>
							<div class="col-md-6">
								<label>Tipo de Atención:</label>
								<select class="form-control selectpicker" required="required" title="Seleccione tipo de lectura" name="TX_TipoAtencion_Editar" id="TX_TipoAtencion_Editar">
									<option value="1">CUENTO Y POESÍA</option>
									<option value="2">CANTO</option>
								</select>
							</div>
						</div>
						<div class="row p-t">							
							<div class="col-md-6">
								<label>Fecha:</label>
								<div class="input-group date">
									<input type="text" readonly="readonly" class="form-control input-sm calendario" id="TX_Fecha_Editar" placeholder="Fecha Oferta" style="border-style: solid; border-width: 2px; border-color: #3c763d;">
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span></span>
									</div>
								</div>
								<div class="col-md-6">
									<label>Hora de Inicio:</label>
									<input type="text"class="form-control" id="TX_Hora_Editar" name="TX_Hora_Editar" required="required" />	
								</div>
							</div>						
							<div class="row p-t">							
								<div class="col-md-6">
									<label>Cupos Disponibles:</label>
									<input type="text" class="form-control mayuscula" readonly="readonly" id="TX_CuposDis_Editar" name="TX_CuposDis_Editar">
								</div>				
								<div class="col-md-6">
									<label>Sumar más Cupos Disponibles:</label>
									<input type="text" class="form-control mayuscula" id="TX_Sumar_Cupos" name="TX_Sumar_Cupos">
								</div>							
							</div>
							<div class="form-group">
								<div class="col-md-12"><br></div>
							</div>						
							<div class="row" style="text-align: center">
								<div class="form-group">
									<div class="col-xs-6 col-sm-6 col-md-offset-2 col-md-4" style="text-align: center">
										<input class="form-control btn btn-block btn-success" id="BT_EditarFranja" type="submit" value="EDITAR FRANJA">
									</div>
									<div class="col-xs-6 col-sm-6 col-md-4" style="text-align: center">
										<button type="button" class="form-control btn btn-block btn-danger" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">CANCELAR</span>
										</button>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-12"><br></div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>




	<div class="modal modal-wide fade" id="miModalAsignarArtista" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="myModalLabel">ASIGNACIÓN DEL ARTISTA A LA ATENCIÓN</h4>
				</div>				
				<form id="form_Asignacion_Artista_div">
					<div class="modal-body">

						<div class="row">
							<div class="form-group col-lg-6">
								<input type="hidden" id="TX_ID_Franja_Artista" name="TX_ID_Franja_Artista">
								<label>Formulario</label>
								<p id="formulario"></p>
							</div>
							<div class="form-group col-lg-6">
								<label>Tipo de Atención</label>
								<p id="atencion"></p>
							</div>	
						</div>
						<div class="row">
							<div class="form-group col-lg-6">
								<label>Fecha</label>
								<div id="div-fecha-llamada">
									<input class="form-control" type="date" id="fecha-llamada" required>
								</div>
							</div>
							<div class="form-group col-lg-6">
								<label>Horario</label>
								<p id="horario"></p>
							</div>	
						</div>						
						<div class="row">
							<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<label>Artista Comunitario</label>
								<select class="form-control selectpicker" data-live-search="true"  title="Seleccione una opción" name="SL_Artista" id="SL_Artista" required> 
								</select>
							</div>	
						</div>
						<hr>
						<div class="row">
							<div class="form-group col-lg-6">
								<label>Localidad</label>
								<p id="localidad"></p>
							</div>
							<div class="form-group col-lg-6">
								<label>Barrio</label>
								<p id="barrio"></p>
							</div>	
						</div>
						<div class="row">
							<div class="form-group col-lg-6">
								<label>Dirección</label>
								<p id="direccion"></p>
							</div>
							<div class="form-group col-lg-6">
								<label>Upz</label>
								<select class="form-control selectpicker" data-live-search="true" title="Seleccione una opción" name="SL_Upz" id="SL_Upz">
								</select>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">Asignar artista</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
					</div>
				</form>
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
						<input type="hidden" id="TX_ID_Llamada" name="TX_ID_Llamada">
						<center>
							<table width="95%" cellspacing="1" cellpadding="3" border="2" bgcolor="#165480">
								<tr>
									<td bgcolor="#5FA6D7">
										<font size=3 style="color: white;">
											<b> INFORMACIÓN DEL CUIDADOR</b>
										</font>
									</td>
								</tr>
								<tr>
									<td bgcolor="#ffffcc">
										<div class="row p-t">
											<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
												<label>Tipo de identificación </label>
												<select class="form-control selectpicker" name="TX_TipoAcudiente_Editar" id="TX_TipoAcudiente_Editar" title="Seleccione Opción"></select>
											</div>
											<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
												<label>Número de documento</label>
												<input type="text" class="form-control mayuscula" id="TX_Documento_Acudiente_Editar" name="TX_Documento_Acudiente_Editar">
											</div>
											<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
												<label>Nombre completo</label>
												<input type="text" class="form-control mayuscula" id="TX_Nombre_Acudiente_Editar" name="TX_Nombre_Acudiente_Editar">
											</div>
											<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
												<label>Correo Electrónico</label>
												<input type="text" class="form-control mayuscula" id="TX_Correo_Editar" name="TX_Correo_Editar">
											</div>
										</div>
										<div class="row p-t">
											<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
												<label>Localidad</label>
												<select class="form-control selectpicker" name="TX_Localidad_Editar" id="TX_Localidad_Editar" title="Seleccione Opción">
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
											<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
												<label>Barrio</label>
												<input type="text" class="form-control mayuscula" id="TX_Barrio_Editar" name="TX_Barrio_Editar">
											</div>
											<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
												<label>Dirección</label>
												<input type="text" class="form-control mayuscula" id="TX_Direccion_Editar" name="TX_Direccion_Editar">
											</div>
											<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
												<label>Estrato</label>
												<select class="form-control selectpicker" name="TX_Estrato_Editar" id="TX_Estrato_Editar" title="Seleccione Opción">
													<option value="1">1</option>
													<option value="2">2</option>
													<option value="3">3</option>
													<option value="4">4</option>
													<option value="5">5</option>
													<option value="6">6</option>
												</select>
											</div>
										</div>
										<p>
										</td>
									</tr>
								</table><br>
								<table width="95%" cellspacing="1" cellpadding="3" border="2" bgcolor="#165480">
									<tr>
										<td bgcolor="#5FA6D7">
											<font size=3 style="color: white;">
												<b>INFORMACIÓN DEL NIÑO/NIÑA A QUIEN VA DIRIGIDA LA ATENCIÓN</b>
											</font>
										</td>
									</tr>
									<tr>
										<td bgcolor="#ffffcc">
											<div class="row p-t">
												<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
													<label>¿A quien va dirigida la lectura ?</label>
													<select class="form-control selectpicker" name="TX_Dirigido_Editar" id="TX_Dirigido_Editar" title="Seleccione Opción">
														<option value="1">Mujer Gestante</option>
														<option value="2">Niño</option>
														<option value="3">Niña</option>
													</select>
												</div>
												<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
													<label>Parentesco</label>
													<select class="form-control selectpicker" name="TX_Parentesco_Editar" id="TX_Parentesco_Editar" title="Seleccione Opción">
														<option value="1">Madre o padre</option>
														<option value="2">Tía o tío</option>
														<option value="3">Abuela o abuelo</option>
														<option value="4">Hermano o hermana</option>
														<option value="5">Acudiente</option>
														<option value="6">Otro</option>
													</select>
												</div>
												<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
													<label>¿Posse la patria potestad?</label>
													<select class="form-control selectpicker" name="TX_Potestad_Editar" id="TX_Potestad_Editar" title="Seleccione Opción">
														<option value="1">Si</option>
														<option value="0">No</option>
													</select>
												</div>

											</div>
											<div class="row p-t">
												<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
													<label>Nombres</label>
													<input type="text" class="form-control mayuscula" id="TX_Nombres_Editar" name="TX_Nombres_Editar">
												</div>
												<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
													<label>Apellidos</label>
													<input type="text" class="form-control mayuscula" id="TX_Apellidos_Editar" name="TX_Apellidos_Editar">
												</div>
												<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
													<label>Fecha Nacimiento</label>
													<input type="text" class="form-control mayuscula" id="TX_F_Nacimiento_Editar" name="TX_F_Nacimiento_Editar">
												</div>

											</div>
											<div class="row p-t">
												<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
													<label>Tipo de documento</label>
													<select class="form-control selectpicker" name="TX_TipoBeneficiario_Editar" id="TX_TipoBeneficiario_Editar" title="Seleccione Opción"></select>
												</div>
												<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
													<label>Número de documento</label>
													<input type="text" class="form-control mayuscula" id="TX_Num_Documento_Editar" name="TX_Num_Documento_Editar">
												</div>
												<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
													<label>Enfoque</label>
													<select class="form-control selectpicker" name="TX_Enfoque_Editar" id="TX_Enfoque_Editar" title="Seleccione Opción"></select>
												</div>

											</div>
											<p>
											</td>
										</tr>
									</table><br>
									<table width="95%" cellspacing="1" cellpadding="3" border="2" bgcolor="#165480">
										<tr>
											<td bgcolor="#5FA6D7">
												<font size=3 style="color: white;">
													<b>INFORMACIÓN DEL NIÑO/NIÑA A QUIEN VA DIRIGIDA LA ATENCIÓN</b>
												</font>
											</td>
										</tr>
										<tr>
											<td bgcolor="#ffffcc">
												<div class="row p-t">
													<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
														<label>Fecha de la llamada</label>
														<input type="text" class="form-control mayuscula" id="TX_Fecha_Llamada_Editar" name="TX_Fecha_Llamada_Editar">
													</div>
													<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
														<label>Horario de la llamada</label>
														<input type="text" class="form-control mayuscula" id="TX_Horario_Editar" name="TX_Horario_Editar">
													</div>
													<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
														<label>Número telefónico </label>
														<input type="text" class="form-control mayuscula" id="TX_Telefono_Editar" name="TX_Telefono_Editar">
													</div>
												</div>
												<p>
												</td>
											</tr>
										</table>
									</center>
									<div class="form-group">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><br></div>
									</div>
									<div class="row" style="text-align: center">
										<div class="form-group">
											<div class="col-xs-6 col-sm-6 col-md-offset-2 col-md-4" style="text-align: center">
												<input class="form-control btn btn-block btn-success" id="BT_EditarEvento" type="submit" value="EDITAR INFORMACIÓN DE LA LLAMADA">
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


				</body>
				</html>