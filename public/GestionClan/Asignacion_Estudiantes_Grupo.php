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
	<title>Asignar Beneficiarios Grupo</title>
	<link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

	<link href="../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
	<script src="../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

	<link href="https://fonts.googleapis.com/css?family=Yatra One|BioRhyme|Righteous|Prompt" rel="stylesheet">

	<link href="../bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"  rel="stylesheet" type="text/css" >
	<link href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet">
	<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src="../bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="../bower_components/datatables.net-responsive-bs/js/responsive.bootstrap.min.js"></script>

	<link href="../bower_components/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet">
	<script src="../bower_components/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>

	<link href="../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" >
	<script src="../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript" ></script>

	<script src="../bower_components/fontawesome/svg-with-js/js/fontawesome-all.min.js" ></script>
	<script type="text/javascript" src="../js/bootbox.js"></script>
	<script type="text/javascript" src="../js/bootstrap-filestyle.js"> </script>
	<script type="text/javascript" src="Js/Asignacion_Estudiantes_Grupo.js?v=2021.04.29.7"></script>
	<script type="text/javascript" src="../Beneficiario/Js/RegistrarBeneficiario.js?v=2021.09.16.0"></script>
</head>
<style type="text/css">
div{
	font-family: 'Prompt';
	font-size: 14px;
}
label.btn span {
	font-size: 1.5em ;
}

label input[type="radio"] ~ i.fa.fa-circle-o{
	color: #c8c8c8;    display: inline;
}
label input[type="radio"] ~ i.fa.fa-dot-circle-o{
	display: none;
}
label input[type="radio"]:checked ~ i.fa.fa-circle-o{
	display: none;
}
label input[type="radio"]:checked ~ i.fa.fa-dot-circle-o{
	color: #50a75a;    display: inline;
}
label:hover input[type="radio"] ~ i.fa {
	color: #50a75a;
}

div[data-toggle="buttons"] label.active{
	color: #80fa00;
}

div[data-toggle="buttons"] label {
	display: inline-block;
	padding: 6px 12px;
	margin-bottom: 0;
	font-size: 14px;
	font-weight: normal;
	line-height: 2em;
	text-align: left;
	white-space: nowrap;
	vertical-align: top;
	cursor: pointer;
	background-color: none;
	border: 0px solid
	#c8c8c8;
	border-radius: 3px;
	color: #c8c8c8;
	-webkit-user-select: none;
	-moz-user-select: none;
	-ms-user-select: none;
	-o-user-select: none;
	user-select: none;
}

div[data-toggle="buttons"] label:hover {
	color: #80fa00;
}

div[data-toggle="buttons"] label:active, div[data-toggle="buttons"] label.active {
	-webkit-box-shadow: none;
	box-shadow: none;
}

.o-separador{
	position: absolute;
	left: 45%;
	bottom: 10px;
	z-index: 5;
	background: white;
	padding: 0 10px;
	color: #ababab;
}

#modal_registrar_estudiante_formulario {
	overflow-y:scroll;
}

.red-required{
	color: #ff0000 !important;
}

.datepicker{
	z-index:1151 !important;
}

</style>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Grupos Activos<small> CREA</small></h1>
					<div class="row">
						<div class="col-xs-6 col-md-3">
							<label for="SL_crea_cargar_grupos">Seleccione el Crea</label>
						</div>
						<div class="col-xs-6 col-md-9">
							<select class="form-control selectpicker" id="SL_crea_cargar_grupos" data-live-search="true"></select>
						</div>
					</div>
				</div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li data-tipo_grupo="arte_escuela" class="nav-item active tipo_linea_atencion" id="nav_arte_escuela"><a class="nav-link" data-toggle="tab" href="#grupos_arte_escuela" role="tab">Arte en la escuela</a></li>
					<li data-tipo_grupo="emprende_clan" class="nav-item tipo_linea_atencion" id="nav_emprende_clan"><a class="nav-link" data-toggle="tab" href="#grupos_emprende_clan" role="tab">Impulso Colectivo</a></li>
					<li data-tipo_grupo="laboratorio_clan" class="nav-item tipo_linea_atencion" id="nav_laboratorio_clan"><a class="nav-link" data-toggle="tab" href="#grupos_laboratorio_clan" role="tab">Converge</a></li>
					<input type="hidden" id="tipo_grupo_temp" value="arte_escuela">
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="grupos_arte_escuela" role="tabpanel">
						<div class="row">
							<div class="col-xs-12 col-md-12 text-center bg-info">
								<h4>ARTE EN LA ESCUELA <small>Asignar Beneficiarios a grupo</small></h4>
							</div>
						</div>
						<div class="row">
							<div class="table-responsive col-xs-12 col-md-12">
								<table class="table" id="table_grupos_arte_escuela">
									<thead>
										<tr>
											<th>N°</th>
											<th>Area Artistica</th>
											<th>Organización</th>
											<th>Formador</th>
											<th>Colegio</th>
											<th>Beneficiarios en grupo</th>
											<th>Opciones</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="grupos_emprende_clan" role="tabpanel">
						<div class="row">
							<div class="col-xs-12 col-md-12 text-center bg-info">
								<h4>IMPULSO COLECTIVO <small>Asignar Beneficiarios a grupo</small></h4>
							</div>
						</div>
						<div class="row">
							<div class="table-responsive col-xs-12 col-md-12">
								<table class="table" id="table_grupos_emprende_clan">
									<thead>
										<tr>
											<th>N°</th>
											<th>Area Artistica</th>
											<th>Organización</th>
											<th>Formador</th>
											<th>Modalidad</th>
											<th>Tipo Grupo</th>
											<th>Beneficiarios en grupo</th>
											<th>Opciones</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="grupos_laboratorio_clan" role="tabpanel">
						<div class="row">
							<div class="col-xs-12 col-md-12 text-center bg-info">
								<h4>CONVERGE <small>Asignar Beneficiarios a grupo</small></h4>
							</div>
						</div>
						<div class="row">
							<div class="table-responsive col-xs-12 col-md-12">
								<table class="table" id="table_grupos_laboratorio_clan">
									<thead>
										<tr>
											<th>N°</th>
											<th>Area Artistica</th>
											<th>Organización</th>
											<th>Formador</th>
											<th>Lugar Atención</th>
											<th>Población</th>
											<th>Beneficiarios en grupo</th>
											<th>Opciones</th>
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
		<div class="modal fade" id="modal_agregar_estudiante_grupo" tabindex="-1" role="dialog" aria-labelledby="label_modal_agregar_estudiante_grupo" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="title_modal_agregar_estudiante"></h4>
					</div>
					<div class="modal-body">
						<ul class="nav nav-tabs" id="menu_busqueda" role="tablist">
							<li class="active" id="nav_individual"><a class="nav-link btn-warning" data-toggle="tab" href="#individual" role="tab">Individual</a></li>
							<li id="nav_grado"><a class="nav-link btn-success" data-toggle="tab" href="#grado" role="tab">Por Grado</a></li>
						</ul>
						<div class="row">
							<div id="div_mensaje" class='col-xs-12 col-md-12 col-lg-12 col-sm-12'>
								<p class="alert alert-info">
									<span id="p_mensaje">Escriba el <i><u>número de documento</u></i> o el nombre del Beneficiario (<i><u>Por lo menos Primer Apellido</u></i>). Para agilizar la consulta suministre el <b>nombre completo</b> del Beneficiario.</span>
									<input data-toggle="toggle" data-onstyle="success" id="CH_tipo_consulta_estudiante" name= "CH_tipo_consulta_estudiante" data-offstyle="info" data-width="200" data-on="NOMBRES" data-off="NÚMERO DOCUMENTO" type="checkbox">
								</p>
							</div>
						</div>
						<div class='row'>
							<form action="" method="post" name="form_buscar_estudiante" id="form_buscar_estudiante" class="form_buscar_estudiante" enctype="multipart/form-data">													
								<div id="div_campo_busqueda_documento">
									<div class='col-xs-12 col-md-10 col-md-offset-1'>
										<div class="form-group col-xs-12">
											<div class='input-group'>
												<span class='input-group-addon' id='basic-addon_buscar_esutudiante'><span class='fa fa-user' aria-hidden='true'></span></span>
												<input class='form-control' aria-describedby='basic-addon1' placeholder='Número de Identificación' name='nro_documento' id="nro_documento" type='text'>
											</div>
										</div>
									</div>
								</div>
								<div id="div_campo_busqueda_nombres">
									<div class="col-xs-12 col-md-10 col-md-offset-1">
										<div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
											<div class="input-group">
												<span class="input-group-addon"><span class="fa fa-address-book"></span></span>
												<input class="mayuscula tecleable form-control" tabindex="1" placeholder="Primer Apellido" name="apellido1" id="apellido1" type="text"  />
											</div>
										</div>
										<div class="form-group col-xs-12 col-sm-12 col-md-6  col-lg-6">
											<div class="input-group">
												<span class="input-group-addon"><span class="fa fa-address-book"></span></span>
												<input class="mayuscula tecleable form-control" tabindex="1" placeholder="Segundo Apellido" name="apellido2" id="apellido2"  type="text"/>
											</div>
										</div>
									</div>
									<div class="col-xs-12 col-md-10 col-md-offset-1">
										<div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
											<div class="input-group">
												<span class="input-group-addon"><span class="fa fa-address-book"></span></span>
												<input class="mayuscula tecleable form-control" tabindex="3" placeholder="Primer Nombre" name="nombre1" id="nombre1" type="text"  />
											</div>
										</div>
										<div class="form-group col-xs-12 col-sm-12 col-md-6  col-lg-6">
											<div class="input-group">
												<span class="input-group-addon"><span class="fa fa-address-book"></span></span>
												<input class="mayuscula tecleable form-control" tabindex="4" placeholder="Segundo Nombre" name="nombre2" id="nombre2"  type="text"/>
											</div>
										</div>
									</div>
								</div>
								<div id="div_campo_busqueda_grado" >
									<br>
									<div class="col-xs-12 col-md-10 col-md-offset-1">
										<label class="col-xs-12 col-md-3 col-lg-3" for="SL_colegio">Colegio:</label>
										<div class="form-group col-xs-12 col-sm-12 col-md-9 col-lg-9">
											<div id="div_colegio"></div>	
										</div>
										<label class="col-xs-12 col-md-3 col-lg-3" for="SL_grado">Grado:</label>
										<div class="form-group col-xs-12 col-sm-12 col-md-9 col-lg-9">
											<select class="form-control selectpicker" title="Seleccione el Grado" data-live-search="true" name="SL_grado" id="SL_grado"></select>
										</div>
									</div>
								</div>				
								<div class="col-xs-12 col-md-10 col-md-offset-1">
									<div class="form-group col-xs-12">
										<!--<input type="hidden" name="_METHOD" value="POST" />-->
										<button type="submit" id="BT_buscar_estudiante"  class="btn btn-success col-xs-12">Buscar</button>
									</div>
								</div>
							</form>
						</div>
						<div class="row" id="div_cargando_datos_estudiantes">
							<div class="col-xs-12 col-md-12">
								<div class="alert alert-info">
									Cargando los datos de los Beneficiarios, por favor espere...
								</div>
							</div>
						</div>
						<div id="resultado_busqueda_estudiantes">
							<div class='row'>
								<div class='col-xs-12 col-md-12'>
									<div class="table-responsive text-center" id="datos_estudiante">
										<table width="100%" style="width: 100%" class='table table-striped table-bordered table-hover' id='table_resultado_busqueda'>
											<thead>
												<tr>
													<td><strong>Identificación</strong></td>
													<td><strong>Nombre</strong></td>
													<td><strong>Grado</strong></td>
													<td><strong>Colegio</strong></td>
													<td><strong>Opciones</strong></td>
												</tr>
											</thead>
											<tbody></tbody>
										</table>
										<div class="alert alert-danger opcion_crear_estudiante" role="alert" hidden>
											<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
											<span class="sr-only">Tenga en cuenta que:</span>
											Si no encuentra el Beneficiario esperado puede registrarlo usando
											<a type="button" class="btn btn-info" id="bt_mostrar_formulario_registro_estudiante">
												<span class="glyphicon glyphicon-align-left" aria-hidden="true"></span>
												Formulario Registro Beneficiario Manual
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div id="datos_detallados_estudiante">
							<legend>Datos del Beneficiario</legend>
							<div class='row'>
								<div class='col-xs-6 col-md-3'>
									<label for="label_nombre_estudiante">Nombre</label>
								</div>
								<div class='col-xs-6 col-md-9'>
									<b>
										<input class='form-control' type='text' disabled='disabled' id='label_nombre_estudiante' name='label_nombre_estudiante' />
									</b>
								</div>
							</div>
							<!-- <hr style="margin-bottom: 0px;">
							<div class='row' style="padding-top: 5px; background-color: #eeeeee;">
								<div class='col-xs-6 col-md-4'>
									<h4>CUESTIONARIO BIOSEGURIDAD</h4>
								</div>
							</div>
							<hr style="margin-top: 0px;">
							<div class='row'>
								<div class='col-xs-6 col-md-6' style="text-align: right;">
									<label for="sl_pregunta_uno">¿Se encuentra en estado de embarazo?</label>
								</div>
								<div class='col-xs-6 col-md-6'>
										<select class='form-control selectpicker' id='sl_pregunta_uno' name='sl_pregunta_uno' title="Seleccione una opción">
											<option value="0">NO</option>
											<option value="1">SI</option>
										</select>
								</div>
							</div>
							<div class='row' style="padding-top: 5px;">
								<div class='col-xs-6 col-md-6' style="text-align: right;">
									<label for="sl_pregunta_dos">¿Presenta alguna enfermedad con Comorbilidad del COVID19?</label>
								</div>
								<div class='col-xs-6 col-md-6'>
										<select class='form-control selectpicker' id='sl_pregunta_dos' name='sl_pregunta_dos' title="Seleccione una opción" multiple>
											<option value="N/A">Ninguna</option>
											<option value="Enfermedad cardiovascular">Enfermedad cardiovascular</option>
											<option value="Enfermedad renal crónica">Enfermedad renal crónica</option>
											<option value="Enfermedad respiratoria crónica">Enfermedad respiratoria crónica</option>
											<option value="Enfermedad hepática crónica">Enfermedad hepática crónica</option>
											<option value="Diabetes">Diabetes</option>
											<option value="Cánceres con inmunosupresión directa">Cánceres con inmunosupresión directa</option>
											<option value="Cánceres sin inmunosupresión directa, pero con posible inmunosupresión causada por el tratamiento">Cánceres sin inmunosupresión directa, pero con posible inmunosupresión causada por el tratamiento</option>
											<option value="VIH/SIDA">VIH/SIDA</option>
											<option value="Tuberculosis (activa)">Tuberculosis (activa)</option>
											<option value="Trastornos neurológicos crónicos">Trastornos neurológicos crónicos</option>
											<option value="Trastornos de células falciformes">Trastornos de células falciformes</option>
											<option value="Consumo de tabaco fumado">Consumo de tabaco fumado</option>
											<option value="Obesidad severa (IMC ≥40)">Obesidad severa (IMC ≥40)</option>
											<option value="Hipertensión">Hipertensión</option>
										</select>
								</div>
							</div>
							<div class='row' style="padding-top: 5px;">
								<div class='col-xs-6 col-md-6' style="text-align: right;">
									<label for="sl_pregunta_tres">¿Algún miembro de su familia que conviva con usted está considerado como población vulnerable (Adultos mayores de 60 años, mujeres en embarazo, niños menores de 6 años o personas con antecedentes)?</label>
								</div>
								<div class='col-xs-6 col-md-6'>
										<select class='form-control selectpicker' id='sl_pregunta_tres' name='sl_pregunta_tres' title="Seleccione una opción">
											<option value="0">NO</option>
											<option value="1">SI</option>
										</select>
								</div>
							</div>
							<div class='row' style="padding-top: 5px;">
								<div class='col-xs-6 col-md-6' style="text-align: right;">
									<label for="sl_pregunta_cuatro">¿Toma algún tipo de medicamento formulado actualmente?</label>
								</div>
								<div class='col-xs-6 col-md-6'>
										<select class='form-control selectpicker' id='sl_pregunta_cuatro' name='sl_pregunta_cuatro' title="Seleccione una opción">
											<option value="0">NO</option>
											<option value="1">SI</option>
										</select>
								</div>
							</div> -->
							<hr>
							<div class='row' style="padding-top: 5px;">
								<div class="col-xs-6 col-md-3" style="text-align: right;">
									<label for="TX_observaciones_asignacion_estudiante">Observaciones (Opcional)</label>
								</div>
								<div class="col-xs-12 col-md-9">
									<textarea class="form-control" id="TX_observaciones_asignacion_estudiante" placeholder="Observaciones"></textarea>
								</div>
							</div>
							<div class="row" style="padding-top: 5px;">
								<div class="col-xs-4 col-xs-offset-4 col-md-4 col-md-offset-4"><button id='BT_asignar_estudiante_grupo' class='form-control btn-success' <?php echo "data-id_usuario='".$Id_Persona."'"; ?>>Asignar Beneficiario</button></div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="modal_remover_estudiante_grupo" tabindex="-1" role="dialog" aria-labelledby="label_modal_remover_estudiante_grupo" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="title_modal_remover_estudiante"></h4>
					</div>
					<div class="modal-body">
						<div class="row" id="table_estudiantes_remover">
							<div class='col-xs-12 col-md-12'>
								<div class="table-responsive text-center" id="datos_estudiante_remover">
									<table class='table table-striped table-bordered table-hover' id='table_remover_estudiante'>
										<thead>
											<tr>
												<td><strong>Identificación</strong></td>
												<td><strong>Nombre</strong></td>
												<td><strong>Fecha Ingreso</strong></td>
												<td><strong>Remover</strong></td>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="SL_justificacion_remover_estudiante">Seleccione la razón del retiro:</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<select class="form-control" id="SL_justificacion_remover_estudiante" class="form-control selectpicker" data-live-search="true"></select>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<button class="form-control btn btn-danger" id="BT_remover_beneficiarios_masivo_grupo">Remover Beneficiario(s)</button>
							</div>
						</div>
						<div id="justificacion_remover_estudiante">
							<div class="row">
								<div class="col-xs-12 col-md-12 alert alert-danger">
									Retiro del Beneficiario: <b id="label_nombre_estudiante_retirar_grupo"></b>
								</div>
							</div>
							<!-- <div class="row">
								<div class="col-xs-6 col-md-3">
									<label for="SL_justificacion_remover_estudiante">Seleccione la razón del retiro:</label>
								</div>
								<div class="col-xs-12 col-md-9">
									<select class="form-control" id="SL_justificacion_remover_estudiante"></select>
								</div>
							</div> -->
							<div class="row">
								<div class="col-xs-4 col-xs-offset-4 col-md-4 col-md-offset-4">
									<button class="btn btn-warning form-control" id="BT_cancelar_retiro_estudiante">Cancelar Retiro</button>
								</div>
								<div class="col-xs-4 col-md-4">
									<button class="form-control btn btn-success" id="BT_remover_estudiante_grupo">Remover Beneficiario</button>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="modal_datos_adicionales_convenio_sdis" tabindex="-1" role="dialog" aria-labelledby="label_modal_datos_adicionales_convenio_sdis" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="title_modal_datos_adicionales_convenio_sdis">Interés de área artística</h4>
					</div>
					<div class="modal-body">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_registrar_estudiante_formulario">Cerrar</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="modal_formulario_registro_estudiante" tabindex="-1" role="dialog" aria-labelledby="label_modal_formulario_registro_estudiante" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content" id="contenido_modal_formulario_registro_estudiante">

				</div>
			</div>
		</div>
		<div class="modal fade" id="modal_formulario_completar_detalle_anio" tabindex="-1" role="dialog" aria-labelledby="label_modal_formulario_completar_detalle_anio" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content" id="contenido_modal_formulario_completar_detalle_anio">

				</div>
			</div>
		</div>
		<div class="modal fade" id="modal_agregar_estudiante_ensamble" tabindex="-1" role="dialog" aria-labelledby="label_modal_agregar_estudiante_ensamble" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="modal-title" id="title_modal_agregar_estudiante_ensamble"></h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-xs-12 col-md-12 alert alert-info" role="alert">
								<p>
									<b>Este grupo es tipo ensamble.</b>
									Debe seleccionar los Beneficiarios de grupos participantes.
								</p>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="SL_clan_grupo_ensamble_seleccionar_estudiante">Crea</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<select class="form-control selectpicker" data-live-search="true" id="SL_clan_grupo_ensamble_seleccionar_estudiante"></select>
								<input type="hidden" name="id_grupo_ensamble" id="id_grupo_ensamble" value="0">
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="SL_grupo_ensamble_seleccionar_estudiante">Grupo</label>
							</div>
							<div class="col-xs-12 col-md-9">
								<select class="form-control selectpicker" data-live-search="true" id="SL_grupo_ensamble_seleccionar_estudiante"></select>
							</div>
						</div>
						<div id="div_table_estudiante_ensamble" class="row">
							<div class="table-responsive col-xs-12 col-md-12">
								<table class="table table-hover" id="table_estudiante_ensamble">
									<thead>
										<tr>
											<th>Identificación</th>
											<th>Nombres</th>
											<th>Apellidos</th>
											<th>Opción</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>
	</p>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</body>
</html>
