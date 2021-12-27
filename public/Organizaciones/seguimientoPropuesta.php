<?php
session_start();
if(!isset($_SESSION["session_username"])) {
	header("location:index.php");
} else {
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="../datepicker/css/datepicker.css" rel="stylesheet"/>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link href="../bootstrap/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

	<script type="text/javascript" src="Js/Seguimiento_Organizaciones.js?v=2020.09.30.0"></script>

	<link href="https://fonts.googleapis.com/css?family=Yatra One|BioRhyme|Righteous|Prompt" rel="stylesheet">
	<link href="../bootstrap/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../bootstrap/bootstrap-select/bootstrap-select.css">
	<script src="../bootstrap/datatables/media/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="../bootstrap/bootstrap-select/bootstrap-select.js"></script>
	<script type="text/javascript" src="../js/bootbox.js"></script>
	<script src="../datepicker/js/bootstrap-datepicker.js"></script>
	<script src="../bootstrap/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

	<link rel="stylesheet" type="text/css" href="../LibreriasExternas/alertifyjs/css/alertify.min.css">
	<script type="text/javascript" src="../LibreriasExternas/alertifyjs/alertify.min.js"></script>
	<link href="../LibreriasExternas/bootstrap-toggle/bootstrap-toggle.min.css" rel="stylesheet">
	<script src="../LibreriasExternas/bootstrap-toggle/bootstrap-toggle.min.js"></script>
	<script src='../LibreriasExternas/pdfmake/pdfmake.min.js'></script>
	<script src='../LibreriasExternas/pdfmake/vfs_fonts.js'></script>
</head>
<style type="text/css">
div{
	font-family: 'Prompt';
	font-size: 14px;
	font-weight: normal; 
}
th{	
	text-align: center;
}
textarea{
	resize: vertical;
}
</style>
<body style="padding-left: 2%; padding-right: 2%">
	<br>
	<ul class="nav nav-tabs" role="tablist" id="tabs_seguimiento">
		<li class="nav-item"><a id="tab_relizar_seguimiento_v1" class="nav-link hidden" data-toggle="tab" href="#realizar_seguimiento_v1" role="tab">Realizar Seguimiento 2017</a></li>
		<li class="nav-item"><a id="tab_relizar_seguimiento_v2" class="nav-link hidden" data-toggle="tab" href="#realizar_seguimiento_v2" role="tab">Realizar Seguimiento 2018</a></li>
		<li class="nav-item"><a id="tab_relizar_seguimiento_v3" class="nav-link hidden" data-toggle="tab" href="#realizar_seguimiento_v3" role="tab">Realizar Seguimiento 2019</a></li>
		<li class="nav-item active"><a id="tab_consultar_seguimientos" class="nav-link" data-toggle="tab" href="#consultar_seguimientos" role="tab">Consultar Seguimientos</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane" id="realizar_seguimiento_v1" role="tabpanel">
			<div class="row">
				<div class="col-xs-12 col-md-12 text-center bg-primary">
					<h4>Realizar Seguimiento <small><font style="color:#fff">Organizaciones</font></small></h4>
				</div>
			</div>
			<div id="DIV_FORM_SEGUIMIENTO" class="col-md-12" style="padding-top: 10px">
				<form id="FORM_SEGUIMIENTO">
					<div class="col-md-12">
						<div class="col-md-12" style="text-align: center; border-style: ridge; padding-top: 10px; background-color: rgb(210,210,210);">
							<p>INFORME ESTADÍSTICO Y METODOLÓGICO DE SEGUIMIENTO DE LA PROPUESTA PEDAGÓGICO</p>
						</div>
						<div class="col-md-12" style="text-align: left; border-style: ridge; padding-top: 10px; padding-bottom: 10px;">
							<div class="col-md-8">
								<label class="NOMBRE"></label>
							</div>
							<div class="col-md-1">
								<label id="LB_NIT">NIT:</label>
							</div>
							<div class="col-md-3">
								<input type="text" id="TX_NIT" name="TX_NIT" class="form-control" placeholder="NIT organización" required>
							</div>
						</div>
						<div class="col-md-12" style="text-align: left; border-style: ridge; padding-top: 10px; padding-bottom: 10px;">
							<div class="col-md-1">
								<label id="LB_No_Convenio">Convenio:</label>
							</div>
							<div class="col-md-3">
								<input type="text" id="TX_Numero_Convenio" name="TX_Numero_Convenio" class="form-control" placeholder="Número del Convenio" required>
							</div>
							<div class="col-md-1">
								<label id="LB_Fecha_Inicio">Inicio:</label>
							</div>
							<div class="col-md-3">
								<input type="text" id="TX_Fecha_Inicio" name="TX_Fecha_Inicio" class="form-control" required readonly>
							</div>
							<div class="col-md-1">
								<label id="LB_Fecha_Final">Fin:</label>
							</div>
							<div class="col-md-3">
								<input type="text" id="TX_Fecha_Fin" name="TX_Fecha_Fin" class="form-control" required readonly>
							</div>
						</div>
						<div class="col-md-12" style="text-align: left; border-style: ridge; padding-top: 10px; padding-bottom: 10px;">
							<div class="col-md-3">
								<label id="LB_Periodo">Periodo Reportado:</label>
							</div>
							<div class="col-md-4">
								<input type="text" id="TX_Periodo" name="TX_Periodo" class="form-control" placeholder="Ej: 01 Marzo a 30 de Abril" required>
							</div>
							<div class="col-md-4">
								<select id="SL_Areas" name="SL_Areas" class="selectpicker form-control" multiple required title="Seleccione las Areas">
									<option value="1">DANZA</option>
									<option value="2">MÚSICA</option>
									<option value="3">ARTES PLÁSTICAS</option>
									<option value="4">LITERATURA</option>
									<option value="5">TEATRO</option>
									<option value="6">AUDIOVISUALES</option>
								</select>
							</div>
						</div>
						<div class="col-md-12" style="text-align: left; border-style: ridge; padding-top: 10px; padding-bottom: 10px;">
							<div class="col-md-4">
								<label id="LB_Numero_Grupos">Número de Grupos Atendidos:</label>
							</div>
							<div class="col-md-4">
								<input type="number" id="TX_Numero_Grupos" name="TX_Numero_Grupos" class="form-control" required>
							</div>
						</div>
						<div class="col-md-12" style=" border-style: outset;">
							<p><label>OBJETIVO GENERAL</label></p>
							<p style="text-align: justify;">Debe ingresar el OBJETIVO GENERAL que envió en la PROPUESTA de su Organización</p>
							<div class="col-md-12">
								<textarea id="TXTA_OBJETIVO_GRAL" name="TXTA_OBJETIVO_GRAL" class="form-control" rows="3" placeholder="Aquí el Objetivo General" required></textarea>
								<br>
							</div>
						</div>
						<div class="col-md-12" style=" border-style: outset;">
							<p><label>OBJETIVOS ESPECÍFICOS</label>
							</p>
							<p>Relacionados en la propuesta aprobada (ingrese tantas filas como sea necesario para cada objetivo específico con el botón AZUL)</p>
							<table class="table col-md-12">
								<thead>
									<th width="5px">No.</th>
									<th>Objetivo Específico</th>
									<th>Actividad(es)</th>
									<th>Meta(s)</th>
									<th>Indicador(es)</th>
								</thead>
								<tbody id="contenedor_objetivos">
									<tr id="tr_objetivo_1">
										<td style="padding:0px; background-color:rgba(0,166,0,0.3); text-align:center; vertical-align: middle;"><label id="nombre_1">1</label></td>
										<td style="padding: 0px;"><textarea id="objetivo_1" name="objetivo_1" class="form-control" rows="6" placeholder="Relacionados en la propuesta aprobada (ingrese tantas filas como sea necesario para cada objetivo específico)" required></textarea></td>
										<td style="padding: 0px;"><textarea id="actividad_obj_1" name="actividad_obj_1" class="form-control" rows="6" placeholder="Relacionadas en la propuesta con relación al objetivo general" required></textarea></td>
										<td style="padding: 0px;"><textarea id="metas_obj_1" name="metas_obj_1" class="form-control" rows="6" placeholder="Relacionadas en la propuesta con relación al objetivo general" required></textarea></td>
										<td style="padding: 0px;"><textarea id="indicador_obj_1" name="indicador_obj_1" class="form-control" rows="6" placeholder="* Nombre&#10;* Fórmula&#10;* Estado Inicial&#10;* Valor esperado" required></textarea>
										</td>
									</tr>
								</tbody>
							</table>
							<div style="text-align: right;" id="div_agregar_eliminar" hidden>
								<a name="eliminar_fila_objetivo" class="btn btn-danger" title="Eliminar fila" id="eliminar_fila_objetivo"><i class="fa fa-minus"></i></a>
								<a name="crear_fila_objetivo" class="btn btn-primary" title="Agregar fila" id="crear_fila_objetivo"><i class="fa fa-plus"></i></a>
							</div>
						</div>
						<div class="col-md-12" style=" border-style: outset;">
							<p><label>DESCRIPCIÓN DE CUMPLIMIENTO DE CADA OBJETIVO ESPECÍFICO</label>
							</p>
							<table class="table col-md-12">
								<thead>
									<th width="5px">No. Objetivo</th>
									<th>% Indicador</th>
									<th>Descripción de Cumplimiento</th>
								</thead>
								<tbody id="contenedor_cumplimiento">
									<tr id="tr_cumplimiento_1">
										<td style="padding:0px; background-color:rgba(0,166,0,0.3); text-align:center; vertical-align: middle;"><label id="nombreobj_1">1</label></td>
										<td style="padding: 0px;"><textarea id="porcentaje_1" name="porcentaje_1" class="form-control" rows="4" placeholder="* Fórmula&#10;* Estado Actual" required></textarea></td>
										<td style="padding: 0px;"><textarea id="cumplimiento_1" name="cumplimiento_1" class="form-control" rows="4" placeholder="Describa de manera detallada y precisa las actividades realizadas para el desarrollo del objetivo de acuerdo al porcentaje de cumplimiento indicado (dónde, cómo, cuándo)" required></textarea></td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="col-md-6" style=" border-style: outset;">
							<p><label>PERSPECTIVAS PEDAGÓGICAS</label></p>
							<p style="text-align: justify;"><strong>PROPUESTA PEDAGÓGICA</strong><br> Debe ingresar la propuesta pedagógica en el siguiente espacio</p>
							<div class="col-md-12">
								<textarea id="TXTA_PROPUESTA_PEDAGOGICA" name="TXTA_PROPUESTA_PEDAGOGICA" class="form-control" rows="3" placeholder="Aquí la Propuesta Pedagógica" required></textarea>
								<br>
							</div>
							<p style="text-align: justify;"><strong>HALLAZGOS Formación, Creación, Circulación</strong></p>
							<div class="col-md-12">
								<textarea id="TXTA_HALLAZGOS_PEDAGOGICOS" name="TXTA_HALLAZGOS_PEDAGOGICOS" class="form-control" rows="3" placeholder="Aquí los Hallazgos Pedagógicos" required></textarea>
								<br>
							</div>
							<p style="text-align: justify;"><strong>TRANSFORMACIONES</strong></p>
							<div class="col-md-12">
								<textarea id="TXTA_TRANSFORMACIONES_PEDAGOGICAS" name="TXTA_TRANSFORMACIONES_PEDAGOGICAS" class="form-control" rows="3" placeholder="Aquí las Transformaciones Pedagógicas" required></textarea>
								<br>
							</div>
						</div>
						<div class="col-md-6" style=" border-style: outset;">
							<p><label>FUNDAMENTACIÓN METODOLÓGICA</label></p>
							<p style="text-align: justify;">Debe ingresar la fundamentación metodológica en el siguiente espacio</p>
							<div class="col-md-12">
								<textarea id="TXTA_PROPUESTA_METODOLOGICA" name="TXTA_PROPUESTA_METODOLOGICA" class="form-control" rows="3" placeholder="Aquí la Fundamentación Metodológica" required></textarea>
								<br>
							</div>
							<p style="text-align: justify;"><strong>HALLAZGOS Formación, Creación, Circulación</strong></p>
							<div class="col-md-12">
								<textarea id="TXTA_HALLAZGOS_METODOLOGICOS" name="TXTA_HALLAZGOS_METODOLOGICOS" class="form-control" rows="3" placeholder="Aquí los Hallazgos Metodológicos" required></textarea>
								<br>
							</div>
							<p style="text-align: justify;"><strong>TRANSFORMACIONES</strong></p>
							<div class="col-md-12">
								<textarea id="TXTA_TRANSFORMACIONES_METODOLOGICAS" name="TXTA_TRANSFORMACIONES_METODOLOGICAS" class="form-control" rows="3" placeholder="Aquí las Transformaciones Metodológicas" required></textarea>
								<br>
							</div>
						</div>
						<div class="col-md-12">
							<br>
							<div class="col-md-6 col-md-offset-3">
								<center>
									<input type="submit" id="GUARDAR_SEGUIMIENTO" name="GUARDAR_SEGUIMIENTO" class="btn btn-success" value="ENVIAR">
								</center>
							</div>	
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="tab-pane" id="realizar_seguimiento_v2" role="tabpanel">
			<div class="row">
				<div class="col-xs-12 col-md-12 text-center bg-success">
					<h4>Realizar Seguimiento <small><font style="color:#fff">Organizaciones</font></small></h4>
				</div>
			</div>
			<div id="DIV_FORM_SEGUIMIENTO_V2" class="col-md-12" style="padding-top: 10px">
				<form id="FORM_SEGUIMIENTO_V2">
					<div class="col-md-12">
						<div class="col-md-12" style="text-align: center; border-style: ridge; padding-top: 10px; background-color: #009f9969; color:#fff;">
							<p>INFORME ESTADÍSTICO Y METODOLÓGICO DE SEGUIMIENTO DE LA PROPUESTA PEDAGÓGICO</p>
						</div>
						<div class="col-md-12" style="text-align: left; border-style: ridge; padding-top: 10px; padding-bottom: 10px;">
							<div class="col-md-8">
								<label class="NOMBRE"></label>
							</div>
							<div class="col-md-1">
								<label id="LB_NIT_V2">NIT:</label>
							</div>
							<div class="col-md-3">
								<input type="text" id="TX_NIT_V2" name="TX_NIT_V2" class="form-control" placeholder="NIT organización" required>
							</div>
						</div>
						<div class="col-md-12" style="text-align: left; border-style: ridge; padding-top: 10px; padding-bottom: 10px;">
							<div class="col-md-1">
								<label id="LB_No_Convenio_V2">Convenio:</label>
							</div>
							<div class="col-md-3">
								<input type="text" id="TX_Numero_Convenio_V2" name="TX_Numero_Convenio_V2" class="form-control" placeholder="Número del Convenio" required>
							</div>
							<div class="col-md-1">
								<label id="LB_Fecha_Inicio_V2">Inicio:</label>
							</div>
							<div class="col-md-3">
								<input type="text" id="TX_Fecha_Inicio_V2" name="TX_Fecha_Inicio_V2" class="form-control" required readonly>
							</div>
							<div class="col-md-1">
								<label id="LB_Fecha_Final_V2">Fin:</label>
							</div>
							<div class="col-md-3">
								<input type="text" id="TX_Fecha_Fin_V2" name="TX_Fecha_Fin_V2" class="form-control" required readonly>
							</div>
						</div>
						<div class="col-md-12" style=" border-style: outset;">
							<p><label>OBJETIVO GENERAL</label></p>
							<p style="text-align: justify;">Debe ingresar el OBJETIVO GENERAL que envió en la PROPUESTA de su Organización</p>
							<div class="col-md-12">
								<textarea id="TXTA_OBJETIVO_GRAL_V2" name="TXTA_OBJETIVO_GRAL_V2" class="form-control" rows="3" placeholder="Aquí el Objetivo General" required></textarea>
								<br>
							</div>
						</div>
						<div class="col-md-12" style="text-align: left; border-style: ridge; padding-top: 10px; padding-bottom: 10px;">
							<div class="col-md-2">
								<label id="LB_Periodo_V2">Periodo Reportado:</label>
							</div>
							<div class="col-md-4">
								<input type="text" id="TX_Periodo_V2" name="TX_Periodo_V2" class="form-control" placeholder="Ej: 01 Marzo a 30 de Abril" required>
							</div>
							<div class="col-md-2">
								<label id="LB_Numero_Grupos_V2"># de Grupos Atendidos:</label>
							</div>
							<div class="col-md-4">
								<input type="number" id="TX_Numero_Grupos_V2" name="TX_Numero_Grupos_V2" class="form-control" required>
							</div>
						</div>
						<div class="col-md-12" style="text-align: left; border-style: ridge; padding-top: 10px; padding-bottom: 10px;">
							<div class="col-md-2">
								<label id="LB_Areas_Artisticas_V2">Areas Artísticas:</label>
							</div>
							<div class="col-md-4">
								<select id="SL_Areas_V2" name="SL_Areas_V2" class="selectpicker form-control" multiple required title="Seleccione las Areas">
									<option value="1">DANZA</option>
									<option value="2">MÚSICA</option>
									<option value="3">ARTES PLÁSTICAS</option>
									<option value="4">LITERATURA</option>
									<option value="5">TEATRO</option>
									<option value="6">AUDIOVISUALES</option>
								</select>
							</div>
						</div>
						<div class="col-md-12" style=" border-style: outset;">
							<p><label>OBJETIVOS ESPECÍFICOS</label>
							</p>
							<p>Relacionados en la propuesta aprobada (ingrese tantas filas como sea necesario para cada objetivo específico con el botón "+")</p>
							<table class="table col-md-12">
								<thead>
									<th width="5px">No.</th>
									<th>Objetivo Específico</th>
									<th>Actividad(es)</th>
								</thead>
								<tbody id="contenedor_objetivos_V2">
									<tr id="tr_objetivo_1_V2">
										<td style="padding:0px; background-color:#009f9969; text-align:center; vertical-align: middle;"><label id="nombre_1_V2">1</label></td>
										<td style="padding: 0px;"><textarea id="objetivo_1_V2" name="objetivo_1_V2" class="form-control" rows="6" placeholder="Relacionados en la propuesta aprobada (ingrese tantas filas como sea necesario para cada objetivo específico)" required></textarea></td>
										<td style="padding: 0px;"><textarea id="actividad_obj_1_V2" name="actividad_obj_1_V2" class="form-control" rows="6" placeholder="Relacionadas en la propuesta con relación al objetivo general" required></textarea></td>
									</tr>
								</tbody>
							</table>
							<div style="text-align: right;" id="div_agregar_eliminar_V2">
								<a name="eliminar_fila_objetivo_V2" class="btn btn-danger" title="Eliminar fila" id="eliminar_fila_objetivo_V2"><i class="fa fa-minus"></i></a>
								<a name="crear_fila_objetivo_V2" class="btn btn-success" title="Agregar fila" id="crear_fila_objetivo_V2"><i class="fa fa-plus"></i></a>
							</div>
						</div>
						<div class="col-md-12" style=" border-style: outset;">
							<br>
							<p style="text-align: justify;"><strong>PROPUESTA Y PERSPECTIVA PEDAGÓGICA</strong><br> Debe ingresar la propuesta formativa y la perspectiva pedagógica (enfoque) en el siguiente espacio</p>
							<div class="col-md-12">
								<textarea id="TXTA_PROPUESTA_PEDAGOGICA_V2" name="TXTA_PROPUESTA_PEDAGOGICA_V2" class="form-control" rows="3" placeholder="Aquí la Propuesta y Perspectiva Pedagógica" required></textarea>
								<br>
							</div>
							<p style="text-align: justify;"><strong>METODOLÓGIA</strong></p>
							<div class="col-md-12">
								<textarea id="TXTA_PROPUESTA_METODOLOGICA_V2" name="TXTA_PROPUESTA_METODOLOGICA_V2" class="form-control" rows="3" placeholder="Aquí la propuesta Metodológica" required></textarea>
								<br>
							</div>
						</div>
						<div class="col-md-12" style=" border-style: outset;">
							<div class="col-md-12">
								<br>
								<p><label>AVANCES EN EL DESARROLLO DE LA PROPUESTA PEDAGÓGICA</label></p>
							</div>
							<div class="col-md-6">
								<p style="text-align: justify;"><i>Avances en el desarrollo y relación con los indicadores referidos a las nociones de Cuerpo, Territorio, Juego y Creación</i></p>
							</div>
							<div class="col-md-6">
								<p style="text-align: justify;"><i>Formación (acciones que evidencian la implementación de la metodología propuesta por la organización)</i></p>
							</div>
							<div class="col-md-6">
								<textarea id="TXTA_AVANCES_V2" name="TXTA_AVANCES_V2" class="form-control" rows="3" placeholder="Aquí los avances" required></textarea>
								<br>
							</div>
							<div class="col-md-6">
								<textarea id="TXTA_FORMACION_V2" name="TXTA_FORMACION_V2" class="form-control" rows="3" placeholder="Aquí la formación" required></textarea>
							</div>
							<div class="col-md-12">
								<p><label>APORTES DE LA ORGANIZACIÓN</label></p>
							</div>
							<div class="col-md-6">
								<p style="text-align: justify;"><i>Aportes al Programa Crea en cuanto a la formación y otros aspectos</i></p>
							</div>
							<div class="col-md-6">
								<p style="text-align: justify;"><i>Articulación en territorio (GPT, Coordinación Crea, IED)</i></p>
							</div>
							<div class="col-md-6">
								<textarea id="TXTA_APORTES_V2" name="TXTA_APORTES_V2" class="form-control" rows="3" placeholder="Aquí los aportes al programa" required></textarea>
								<br>
							</div>
							<div class="col-md-6">
								<textarea id="TXTA_ARTICULACION_V2" name="TXTA_ARTICULACION_V2" class="form-control" rows="3" placeholder="Aquí la articulación en Territorio" required></textarea>
							</div>
						</div>
						<div class="col-md-12">
							<br>
							<div class="col-md-6 col-md-offset-3">
								<center>
									<input type="submit" id="GUARDAR_SEGUIMIENTO_V2" name="GUARDAR_SEGUIMIENTO_V2" class="btn btn-success" value="ENVIAR">
								</center>
							</div>	
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="tab-pane" id="realizar_seguimiento_v3" role="tabpanel">
			<div class="row">
				<div class="col-xs-12 col-md-12 text-center bg-success">
					<h4>Realizar Seguimiento <small><font style="color:#fff">Organizaciones</font></small></h4>
				</div>
			</div>
			<div id="DIV_FORM_SEGUIMIENTO_V3" class="col-md-12" style="padding-top: 10px">
				<form id="FORM_SEGUIMIENTO_V3">
					<div class="col-md-12">
						<div class="col-md-12" style="text-align: center; border-style: ridge; padding-top: 10px; background-color: #009f9969; color:#fff;">
							<p>INFORME ESTADÍSTICO Y METODOLÓGICO DE SEGUIMIENTO DE LA PROPUESTA PEDAGÓGICO</p>
						</div>
						<div class="col-md-12" style="text-align: left; border-style: ridge; padding-top: 10px; padding-bottom: 10px;">
							<div class="col-md-8">
								<label class="NOMBRE"></label>
							</div>
							<div class="col-md-1">
								<label id="LB_NIT_V3">NIT:</label>
							</div>
							<div class="col-md-3">
								<input type="text" id="TX_NIT_V3" name="TX_NIT_V3" class="form-control" placeholder="NIT organización" required>
							</div>
						</div>
						<div class="col-md-12" style="text-align: left; border-style: ridge; padding-top: 10px; padding-bottom: 10px;">
							<div class="col-md-1">
								<label id="LB_No_Convenio_V3">Convenio:</label>
							</div>
							<div class="col-md-3">
								<input type="text" id="TX_Numero_Convenio_V3" name="TX_Numero_Convenio_V3" class="form-control" placeholder="Número del Convenio" required>
							</div>
							<div class="col-md-1">
								<label id="LB_Fecha_Inicio_V3">Inicio:</label>
							</div>
							<div class="col-md-3">
								<input type="text" id="TX_Fecha_Inicio_V3" name="TX_Fecha_Inicio_V3" class="form-control" required readonly>
							</div>
							<div class="col-md-1">
								<label id="LB_Fecha_Final_V3">Fin:</label>
							</div>
							<div class="col-md-3">
								<input type="text" id="TX_Fecha_Fin_V3" name="TX_Fecha_Fin_V3" class="form-control" required readonly>
							</div>
						</div>
						<div class="col-md-12" style=" border-style: outset;">
							<p><label>OBJETIVO GENERAL</label></p>
							<p style="text-align: justify;">Debe ingresar el OBJETIVO GENERAL que envió en la PROPUESTA de su Organización</p>
							<div class="col-md-12">
								<textarea id="TXTA_OBJETIVO_GRAL_V3" name="TXTA_OBJETIVO_GRAL_V3" class="form-control" rows="3" placeholder="Aquí el Objetivo General" required></textarea>
								<br>
							</div>
						</div>
						<div class="col-md-12" style="text-align: left; border-style: ridge; padding-top: 10px; padding-bottom: 10px;">
							<div class="col-md-2">
								<label id="LB_Periodo_V3">Periodo Reportado:</label>
							</div>
							<div class="col-md-4">
								<input type="text" id="TX_Periodo_V3" name="TX_Periodo_V3" class="form-control" placeholder="Ej: 01 Marzo a 30 de Abril" required>
							</div>
							<div class="col-md-2">
								<label id="LB_Numero_Grupos_V3"># de Grupos Atendidos:</label>
							</div>
							<div class="col-md-4">
								<input type="number" id="TX_Numero_Grupos_V3" name="TX_Numero_Grupos_V3" class="form-control" required>
							</div>
						</div>
						<div class="col-md-12" style="text-align: left; border-style: ridge; padding-top: 10px; padding-bottom: 10px;">
							<div class="col-md-2">
								<label id="LB_Areas_Artisticas_V3">Areas Artísticas:</label>
							</div>
							<div class="col-md-4">
								<select id="SL_Areas_V3" name="SL_Areas_V3" class="selectpicker form-control" multiple required title="Seleccione las Areas">
									<option value="1">DANZA</option>
									<option value="2">MÚSICA</option>
									<option value="3">ARTES PLÁSTICAS</option>
									<option value="4">LITERATURA</option>
									<option value="5">TEATRO</option>
									<option value="6">AUDIOVISUALES</option>
								</select>
							</div>
						</div>
						<div class="col-md-12" style=" border-style: outset;">
							<p><label>OBJETIVOS ESPECÍFICOS</label>
							</p>
							<p>Relacionados en la propuesta aprobada (ingrese tantas filas como sea necesario para cada objetivo específico con el botón "+")</p>
							<table class="table col-md-12">
								<thead>
									<th width="5px">No.</th>
									<th>Objetivo Específico</th>
									<th>Actividad(es)</th>
								</thead>
								<tbody id="contenedor_objetivos_V3">
									<tr id="tr_objetivo_1_V3">
										<td style="padding:0px; background-color:#009f9969; text-align:center; vertical-align: middle;"><label id="nombre_1_V3">1</label></td>
										<td style="padding: 0px;"><textarea id="objetivo_1_V3" name="objetivo_1_V3" class="form-control" rows="6" placeholder="Relacionados en la propuesta aprobada (ingrese tantas filas como sea necesario para cada objetivo específico)" required></textarea></td>
										<td style="padding: 0px;"><textarea id="actividad_obj_1_V3" name="actividad_obj_1_V3" class="form-control" rows="6" placeholder="Relacionadas en la propuesta con relación al objetivo general" required></textarea></td>
									</tr>
								</tbody>
							</table>
							<div style="text-align: right;" id="div_agregar_eliminar_V3">
								<a name="eliminar_fila_objetivo_V3" class="btn btn-danger" title="Eliminar fila" id="eliminar_fila_objetivo_V3"><i class="fa fa-minus"></i></a>
								<a name="crear_fila_objetivo_V3" class="btn btn-success" title="Agregar fila" id="crear_fila_objetivo_V3"><i class="fa fa-plus"></i></a>
							</div>
						</div>
						<div class="col-md-12" style=" border-style: outset;">
							<p><label>INDICADORES Y DESCRIPCIÓN DE CUMPLIMIENTO</label>
							</p>
							<table class="table col-md-12">
								<thead>
									<th width="5px">No. Indicador</th>
									<th>Descripción de Indicador</th>
									<th>Formúla</th>
									<th>Descripción de Cumplimiento</th>
								</thead>
								<tbody id="contenedor_indicadores_V3">
									<tr id="tr_indicador_1">
										<td style="padding:0px; background-color:rgba(0,166,0,0.3); text-align:center; vertical-align: middle;"><label id="nombre_ind_1_V3">1</label></td>
										<td style="padding: 0px;"><textarea id="ind_1_V3" name="ind_1_V3" class="form-control" rows="4" placeholder="* Descripción textual del indicador" required></textarea></td>
										<td style="padding: 0px;"><textarea id="formula_ind_1_V3" name="formula_ind_1_V3" class="form-control" rows="4" placeholder="* Fórmula de medición o pregunta del indicador" required></textarea></td>
										<td style="padding: 0px;"><textarea id="cumplimiento_ind_1_V3" name="cumplimiento_ind_1_V3" class="form-control" rows="4" placeholder="Describa de manera detallada y precisa el estado actual de cumplimiento del indicador de acuerdo a la fórmula indicada." required></textarea></td>
									</tr>
								</tbody>
							</table>
							<div style="text-align: right;" id="div_agregar_eliminar_indicador_V3">
								<a name="eliminar_fila_indicador_V3" class="btn btn-danger" title="Eliminar fila" id="eliminar_fila_indicador_V3"><i class="fa fa-minus"></i></a>
								<a name="crear_fila_indicador_V3" class="btn btn-success" title="Agregar fila" id="crear_fila_indicador_V3"><i class="fa fa-plus"></i></a>
							</div>
						</div>
						<div class="col-md-12" style=" border-style: outset;">
							<br>
							<p style="text-align: justify;"><strong>PROPUESTA Y PERSPECTIVA PEDAGÓGICA</strong><br> Debe ingresar la propuesta formativa y la perspectiva pedagógica (enfoque) en el siguiente espacio</p>
							<div class="col-md-12">
								<textarea id="TXTA_PROPUESTA_PEDAGOGICA_V3" name="TXTA_PROPUESTA_PEDAGOGICA_V3" class="form-control" rows="3" placeholder="Aquí la Propuesta y Perspectiva Pedagógica" required></textarea>
								<br>
							</div>
							<p style="text-align: justify;"><strong>METODOLÓGIA</strong></p>
							<div class="col-md-12">
								<textarea id="TXTA_PROPUESTA_METODOLOGICA_V3" name="TXTA_PROPUESTA_METODOLOGICA_V3" class="form-control" rows="3" placeholder="Aquí la propuesta Metodológica" required></textarea>
								<br>
							</div>
						</div>
						<div class="col-md-12" style=" border-style: outset;">
							<div class="col-md-12">
								<br>
								<p><label>AVANCES EN EL DESARROLLO DE LA PROPUESTA PEDAGÓGICA</label></p>
							</div>
							<div class="col-md-6">
								<p style="text-align: justify;"><i>Avances en el desarrollo y relación con los indicadores referidos a las nociones de Cuerpo, Territorio, Juego y Creación</i></p>
							</div>
							<div class="col-md-6">
								<p style="text-align: justify;"><i>Formación (acciones que evidencian la implementación de la metodología propuesta por la organización)</i></p>
							</div>
							<div class="col-md-6">
								<textarea id="TXTA_AVANCES_V3" name="TXTA_AVANCES_V3" class="form-control" rows="3" placeholder="Aquí los avances" required></textarea>
								<br>
							</div>
							<div class="col-md-6">
								<textarea id="TXTA_FORMACION_V3" name="TXTA_FORMACION_V3" class="form-control" rows="3" placeholder="Aquí la formación" required></textarea>
							</div>
							<div class="col-md-12">
								<p><label>APORTES DE LA ORGANIZACIÓN</label></p>
							</div>
							<div class="col-md-6">
								<p style="text-align: justify;"><i>Aportes al Programa Crea en cuanto a la formación y otros aspectos</i></p>
							</div>
							<div class="col-md-6">
								<p style="text-align: justify;"><i>Articulación en territorio (GPT, Coordinación Crea, IED)</i></p>
							</div>
							<div class="col-md-6">
								<textarea id="TXTA_APORTES_V3" name="TXTA_APORTES_V3" class="form-control" rows="3" placeholder="Aquí los aportes al programa" required></textarea>
								<br>
							</div>
							<div class="col-md-6">
								<textarea id="TXTA_ARTICULACION_V3" name="TXTA_ARTICULACION_V3" class="form-control" rows="3" placeholder="Aquí la articulación en Territorio" required></textarea>
							</div>
						</div>
						<div class="col-md-12">
							<br>
							<div class="col-md-6 col-md-offset-3">
								<center>
									<input type="submit" id="GUARDAR_SEGUIMIENTO_V3" name="GUARDAR_SEGUIMIENTO_V3" class="btn btn-success" value="ENVIAR">
								</center>
							</div>	
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="tab-pane active" id="consultar_seguimientos" role="tabpanel">
			<div class="row">
				<div class="col-xs-12 col-md-12 text-center bg-primary">
					<h4>Consultar Seguimientos <small><font style="color:#fff">Organizaciones</font></small></h4>
				</div>
				<div class="col-xs-6 col-md-6">
					<select id="SL_Year" title="Seleccione el Año" class="form-control">
						<option>Seleccione el año del Convenio</option>
						<option value="2017">Convenios 2017</option>
						<option value="2018">Convenios 2018</option>
						<option value="2019">Convenios 2019</option>
					</select>
				</div>
				<div class="col-xs-6 col-md-6">
					<select id="SL_Organizacion" title="Seleccione la Organización" class="form-control selectpicker" data-live-search="true">
						<option value="">Seleccione la Organización</option>
					</select>
				</div>
				<div id="DIV_GENERAR_REPORTE" name="DIV_GENERAR_REPORTE">
					<form id="FM_REPORTE_CONSOLIDADO" name="FM_REPORTE_CONSOLIDADO">
						<div class="col-xs-6 col-md-6">
							<select id="SL_Convenios_Organizacion" class="form-control selectpicker" required>
								<option value="">Seleccione el Convenio</option>
							</select>
						</div>
						<div>
							<button id="BTN_GENERAR_REPORTE" class="btn btn-primary" type="submit">Descargar Reporte de Seguimientos</button>	
						</div>
					</form>
				</div>
				<div class="col-xs-12 col-md-12">
					<table id="tabla_seguimientos" class="table table-hover" style="text-align: center">
						<!-- <br><caption style="text-align: center; font-size: 20px;">Seguimientos</caption> -->
						<thead>
							<tr><th>Organización</th>
								<th>Periodo</th>
								<th>Subida</th>
								<th>Descargar</th>
								<th>Editar</th>
								<th>Revisión</th>
								<th>Observaciones</th>
							</tr>
						</thead>
						<tbody id="body_seguimientos">

						</tbody>
					</table>
				</div>	
			</div>
		</div>
	</div>
</body>
<div class="modal fade" id="MODAL_REVISION">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modal_titulo"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="text-align: justify;">
				<div class="row">
					<div class="col-md-12">
						<p>Ingrese alguna observación</p>		
						<textarea id="TXA_Observacion_Seguimiento" name="TXA_Observacion_Seguimiento" class="form-control" rows="5" placeholder="Alguna observación Aquí"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12" style="text-align: right;">
						<br>
						<p>Aprobación
							<input data-toggle="toggle" data-onstyle="success" id="IN_Aprobacion" name= "IN_Aprobacion" data-offstyle="danger" data-on="SI" data-off="NO" type="checkbox" class="estado_check"></p>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" id="BT_Guardar_Observacion">GUARDAR</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="MODAL_OBSERVACION">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modal_titulo_observacion"></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" style="text-align: justify;">
					<div class="row">
						<div class="col-md-12">
							<p id="P_Observacion"></p>
						</div>
					</div>
				</div>
				<div class="modal-footer">

					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modal_enviando" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<img src="../imagenes/enviando.gif" width="100%">      
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	</html>