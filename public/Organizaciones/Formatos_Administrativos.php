<?php
//header('charset=utf-8');
session_start();
if(!isset($_SESSION["session_username"])) {
	header("location:index.php");

} else {
$Id_Persona = $_SESSION["session_username"]; //
$Id_Rol =	$_SESSION['session_usertype'];
setlocale(LC_MONETARY,"de_DE");
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="../bootstrap/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/Siclan.css" rel="stylesheet">

	<link href="https://fonts.googleapis.com/css?family=Yatra One|BioRhyme|Righteous|Prompt" rel="stylesheet">
	<link href="../bower_components/fontawesome/web-fonts-with-css/css/fontawesome-all.min.css" rel="stylesheet" type="text/css">
	<script src="../LibreriasExternas/JQuery/jquery-3.1.1.min.js"></script>
	<link href="../LibreriasExternas/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">
	<script src="../LibreriasExternas/datatables/media/js/jquery.dataTables.min.js"></script>
	<script src="../LibreriasExternas/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
	<script src="../bootstrap/jquery/dist/jquery.min.js"></script>
	<script src="../bootstrap/bootstrap/dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../../public/bootstrap/bootstrap-filestyle/bootstrap-filestyle.js"> </script>
	<link rel="stylesheet" type="text/css" href="../bootstrap/bootstrap-select/bootstrap-select.css">
	<script type="text/javascript" src="../bootstrap/bootstrap-select/bootstrap-select.js"></script>
	<script type="text/javascript" src="../js/bootbox.js"></script>
	<link href="../LibreriasExternas/bootstrap-toggle/bootstrap-toggle.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../LibreriasExternas/datepicker/css/bootstrap-datepicker.css">
	<script type="text/javascript" src="../LibreriasExternas/datepicker/js/bootstrap-datepicker.js"></script>
	<script src="../LibreriasExternas/bootstrap-toggle/bootstrap-toggle.min.js"></script>
	<link href="../LibreriasExternas/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">
	<script src="../LibreriasExternas/datatables/media/js/jquery.dataTables.min.js"></script>
	<script src="../LibreriasExternas/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

	<script type="text/javascript" src="Js/Formatos_Administrativos.js?v=2021.04.24.1"></script>

	<script src='../LibreriasExternas/pdfmake/pdfmake.min.js'></script>
	<script src='../LibreriasExternas/pdfmake/vfs_fonts.js'></script>

	<script type="text/javascript" src="Js/FAS.js?v=2020.02.10.0"></script>

	<link href="../LibreriasExternas/summernote/summernote.css" rel="stylesheet">
	<script src="../LibreriasExternas/summernote/summernote.min.js"></script>
	<script src="../LibreriasExternas/summernote/lang/summernote-es-ES.js"></script>

	<script type="text/javascript" src="Js/Proyeccion_Gasto.js?v=2021.04.25.50"></script> 

	<link rel="stylesheet" type="text/css" href="../LibreriasExternas/alertifyjs/css/alertify.min.css">
	<script type="text/javascript" src="../LibreriasExternas/alertifyjs/alertify.min.js"></script>
</head>
<style type="text/css">
	.row-margin-none{
		margin-right: 0;
		margin-left: 0;
	}
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
	.border-form{
		padding-left: 0px;
		padding-right: 0px;
		border-style: ridge;
		padding-top: 10px;
		background-color: rgb(210,210,210);
	}
	.content-form-bordered{
		padding-left: 0px;
		padding-right: 0px;
		border-style: ridge;
		padding-top: 10px;
	}
	.table-proyeccion th{
		font-size: 12px;
	}
	.table-proyeccion td{
		font-size: 11px;
	}
	[readonly],
	fieldset[readonly] {
		background-color: #eee;
		border-width: 1px;
		border-style: groove;
		border-color: initial;
		border-image: initial;
	}
	/*.alertify .ajs-dialog {
    	top: 30%;
    	transform: translateY(-50%);
		margin: auto;
		}*/

		input[type='number'] {
			-moz-appearance:textfield;
		}

		input::-webkit-outer-spin-button,
		input::-webkit-inner-spin-button {
			-webkit-appearance: none;
		}
	</style>
	<body>
		<input type='hidden' id='id_usuario' value='<?php echo $Id_Persona; ?>'>
		<div class="container-fluid" style="padding-top: 30px">

			<ul class="nav nav-tabs">
				<li class="active nav-item"><a  data-toggle="tab" id="a-consultar-archivos" class="nav-link" href="#consulta-archivos">Consultar Archivos</a></li>
				<li class="nav-item"><a id="tab_consulta_formatos" class="nav-link" data-toggle="tab" href="#consulta_formatos">Consulta de Formatos</a></li>
				<li class="nav-item"><a id="tab_subir_archivos" name="tab_subir_archivos" class="nav-link" data-toggle="tab" href="#home" >Subir Archivos</a></li>
				<li class="nav-item"><a id="tab_informe_gestion" class="nav-link" data-toggle="tab" href="#informe_gestion">Informe de Gestión</a></li>
				<li class="nav-item"><a id="tab_proyeccion_gasto" class="nav-link" data-toggle="tab" href="#proyeccion_gasto" role="tab">Proyección del Gasto</a></li>
			</ul>
			<br>
			<div class="col-xs-8 col-md-8 col-md-offset-4">
				<div class="col-xs-1 col-md-1 text-right">
					<label>Convenio:</label>
				</div>
				<div class="col-xs-5 col-md-5">
					<select id="SL_Convenios_Organizacion" class="form-control selectpicker" required>
						<option value="">Seleccione el Convenio</option>
					</select>
				</div>
			</div>
			<br>
			<div class="tab-content">
				<div id="home" class="tab-pane fade in">
					<form id="Form_Archivos" name="Form_Archivos" enctype="multipart/form-data">
						<div class="form-group ">
							<div class="form-group " id="contenedor_anexos">
								<br>
								<div class="form-group row">
									<div  class="col-lg-1 col-md-1" style="text-align: right; margin-top: 5px;">
										<label for="SL_Anio" class="control-label">Año</label>
									</div>
									<div class="col-lg-3 col-md-3">
										<select required id="SL_Anio" name="SL_Anio" class="selectpicker form-control " title="Seleccione el Año">
										</select>
									</div>
									
								</div>
								<div class="form-group row">
									<div  class="col-lg-1 col-md-1" style="text-align: right; margin-top: 5px;">
										<label for="SL_Mes" class="control-label">Mes</label>
									</div>
									<div class="col-lg-3 col-md-3">
										<select required id="SL_Mes" name="SL_Mes" class="selectpicker form-control " title="Seleccione el Mes">
										</select>
									</div>
								</div>
								<div class="row form-group ">
									<div id="div_archivo_1" data-toggle="tooltip" title="Informe Financiero" data-placement="right" class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
										<input id="archivo_1" name="file[]" type="file" class="filestyle" data-buttonName="btn-primary" data-buttonBefore="true" runat="server" data-buttonText="&nbsp&nbsp&nbsp&nbsp&nbsp Informe Financiero">
									</div>
									<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
										XLS: <a href="../Organizaciones/templates/09._soporte_de_ejecucion_financiera_para_supervision_-_xlsx_v_3.1.xlsx" download><img src="../imagenes/xls.png" height="40"></a> ODS: <a href="../Organizaciones/templates/09._soporte_de_ejecucion_financiera_para_supervision_-_ods_v_3.1.ods" download><img src="../imagenes/ods.png" height="40"></a>
									</div>

								</div>
								<!-- <div class="row form-group ">
									<div id="div_archivo_2" data-toggle="tooltip" title="Proyeccion del Gasto" data-placement="right" class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
										<input id="archivo_2" name="file[]" type="file" class="filestyle" data-buttonName="btn-primary" data-buttonBefore="true" runat="server" data-buttonText="&nbsp Proyeccion del Gasto">
									</div>
								</div> -->
								<div class="row form-group ">
									<div id="div_archivo_3" data-toggle="tooltip" title="Reporte de Recursos con Cargo a la Entidad Asociada" data-placement="right" class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
										<input id="archivo_3" name="file[]" type="file" class="filestyle" data-buttonName="btn-primary" data-buttonBefore="true" runat="server" data-buttonText="&nbsp Reporte de Recursos">
									</div>
									<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
										Plantilla <a href="../Organizaciones/templates/60._reporte_de_gastos_-_recursos_propios_1ap-gju-f-60_v.2 (1).xls" download><img src="../imagenes/xls.png" height="40"></a>
									</div>
								</div>
								<div class="row form-group ">
									<div id="div_archivo_4" data-toggle="tooltip" title="Informe de Gestión" data-placement="right" class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
										<input id="archivo_4" name="file[]" type="file" class="filestyle" data-buttonName="btn-primary" data-buttonBefore="true" runat="server" data-buttonText="&nbsp&nbsp&nbsp&nbsp Informe de Gestión">
									</div>
								</div>
							</div>
						</div>
						<div class="text-center row col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<button type="submit" class="btn btn-success btn-lg" id="enviar_documentos">Enviar Documentos</button>
						</div>
					</form>
				</div>
				<div class="tab-pane fade in active" id="consulta-archivos">
					<div class="row">
						<div class="col-xs-12 col-md-12 text-center bg-primary">
							<h4>Consultar Archivos <small><font style="color:#fff">Administrativos</font></small></h4>
						</div>
						<div class="col-xs-6 col-md-6">
							<select id="SL_Year_Archivos_Organizacion" title="Seleccione el año del Convenio" class="form-control selectpicker">
								<option value="2017">Convenios 2017</option>
								<option value="2018">Convenios 2018</option>
								<option value="2019">Convenios 2019</option>
								<option value="2020">Convenios 2020</option>
								<option value="2021">Convenios 2021</option>
							</select>
						</div>
						<div class="col-xs-6 col-md-6">
							<select id="SL_Organizacion_Archivos" title="Seleccione la Organización" class="form-control selectpicker" data-live-search='true'>
								<option value="">Seleccione la Organización</option>
							</select>
						</div>
						<div class="col-xs-12 col-md-12">
							<br>
							<div class="col-md-7 col-md-offset-3" style="background-color: rgba(225,252,209,1); padding: 10px; border-radius: 20px;" id="DIV_DESCARGAR_TRAZABILIDAD" hidden>
								<FORM id="FORM_TRAZABILIDAD" name="FORM_TRAZABILIDAD">
									<div>
										<div class="col-md-3">
											<select id="SL_Year_Archivos" title="Seleccione el Año" class="form-control">
												<option>Año</option>
												<option value="2017">2017</option>
												<option value="2018">2018</option>
												<option value="2019">2019</option>
												<option value="2020">2020</option>
												<option value="2021">2021</option>
											</select>
										</div>
										<div class="col-md-3">
											<select id="SL_TRAZABILIDAD_MES" class="form-control" required>
												<option value="">Trazabilidad del Mes...</option>
												<option value="01">Enero</option>
												<option value="02">Febrero</option>
												<option value="03">Marzo</option>
												<option value="04">Abril</option>
												<option value="05">Mayo</option>
												<option value="06">Junio</option>
												<option value="07">Julio</option>
												<option value="08">Agosto</option>
												<option value="09">Septiembre</option>
												<option value="10">Octubre</option>
												<option value="11">Noviembre</option>
												<option value="12">Diciembre</option>
											</select>
										</div>
										<div class="col-md-5">
											<button id="BTN_TRAZABILIDAD" name="BTN_TRAZABILIDAD" type="submit" class="btn btn-success form-control">DESCARGAR TRAZABILIDAD</button>
										</div>
									</div>
								</FORM>
							</div>
							<div class="col-md-12" style="background-color: rgb(255, 253, 147); border-style: outset;">
								<p><label>NOTA IMPORTANTE:</label></p>
								<p style="text-align: justify;">• Utilice los botones de la última columna de la siguiente tabla para definir cuales son los archivos completados o finalizados, de modo que el equipo administrativo pueda identificarlos en medio de los borradores o erroneos, todos aquellos que queden en <strong>"SI"</strong> serán los que se revisarán.</p>
							</div>
							<table id="tabla_archivos" class="table table-hover" style="text-align: center">
								<br><caption style="text-align: center; font-size: 20px;">ARCHIVOS</caption>
								<thead>
									<th>Nombre Archivo</th>
									<th>Tipo</th>
									<th>Subida</th>
									<th>Mes/Año</th>
									<th>Descarga</th>
									<th>Anexos</th>
									<th>Revisión</th>
									<th>Observaciones</th>
									<th>Estado</th>
								</thead>
								<tbody id="body_archivos">

								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="tab-pane fade in" id="informe_gestion">
					<div class="row">
						<div class="col-xs-12 col-md-12 text-center bg-primary">
							<h4>Informe de Gestión <small><font style="color:#fff">Organizaciones</font></small></h4>
						</div>
					</div>
					<div id="DIV_FORM_GESTION" class="col-md-12" style="padding-top: 10px">
						<form id="FORM_INFORME_GESTION">
							<div class="col-md-12">
								<div class="col-md-12" style="text-align: center; border-style: ridge; padding-top: 10px; background-color: rgb(210,210,210);">
									<p>INFORME DE SEGUIMIENTO A LA GESTIÓN</p>
								</div>
								<div class="col-md-12" style="text-align: left; border-style: ridge; padding-top: 10px; padding-bottom: 10px;">
									<div class="col-md-3">
										<label id="LB_Nombre_Proyecto">Nombre del Proyecto:</label>
									</div>
									<div class="col-md-10 col-md-offset-1">
										<textarea id="TXTA_NOMBRE_PROYECTO" name="TXTA_NOMBRE_PROYECTO" class="form-control" required></textarea>
									</div>
								</div>
								<div class="col-md-12" style="text-align: left; border-style: ridge; padding-top: 10px; padding-bottom: 10px;">
									<div class="col-md-3">
										<label id="LB_Nombre_Representante">Representante Legal:</label>
									</div>
									<div class="col-md-4">
										<input type="text" id="TX_Nombre_Representante" name="TX_Nombre_Representante" class="form-control" placeholder="Nombre del Representante"  required>
									</div>
									<div class="col-md-1">
										<label id="LB_Numero_Informe">Informe:</label>
									</div>
									<div class="col-md-2">
										<select id="SL_Numero_Informe" name="SL_Numero_Informe" class="form-control" required>
											<option value="">...</option>
											<option value="1">1 de ...</option>
											<option value="2">2 de ...</option>
											<option value="3">3 de ...</option>
											<option value="4">4 de ...</option>
											<option value="5">5 de ...</option>
											<option value="6">6 de ...</option>
											<option value="7">7 de ...</option>
											<option value="8">8 de ...</option>
											<option value="9">9 de ...</option>
											<option value="10">10 de ...</option>
											<option value="11">11 de ...</option>
											<option value="12">12 de ...</option>
											<option value="13">13 de ...</option>
											<option value="14">14 de ...</option>
											<option value="15">15 de ...</option>
											<option value="16">16 de ...</option>
										</select>
									</div>
									<div class="col-md-2">
										<select id="SL_Total_Informes" name="SL_Total_Informes" class="form-control" required>
											<option value="">...</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
											<option value="6">6</option>
											<option value="7">7</option>
											<option value="8">8</option>
											<option value="9">9</option>
											<option value="10">10</option>
											<option value="11">11</option>
											<option value="12">12</option>
											<option value="13">13</option>
											<option value="14">14</option>
											<option value="15">15</option>
											<option value="16">16</option>											
										</select>
									</div>
								</div>
								<div class="col-md-12" style="text-align: left; border-style: ridge; padding-top: 10px; padding-bottom: 10px;">
									<div class="col-md-3">
										<label id="LB_Periodo">Periodo del Informe:</label>
									</div>
									<div class="col-md-4">
										<select id="SL_Periodo_Informe" name="SL_Periodo_Informe" class="selectpicker form-control" title="Seleccione un Periodo..." required>
										</select>
									</div>
									<div class="col-md-4">
										<select id="SL_Anio_Informe" name="SL_Anio_Informe" class="selectpicker form-control" title="Seleccione Año..." required>
										</select>
									</div>
								</div>
								<div class="col-md-12" style="background-color: rgb(255, 253, 147); border-style: outset;">
									<p><label>NOTA IMPORTANTE:</label> Los periodos no se pueden traslapar, entonces:</p>
									<p style="text-align: justify;">•	Informe 1 de X: Desde la fecha del acta de inicio hasta el día de entrega del informe<br>•	Informe 2 de X: Desde el otro día de la entrega anterior, hasta la fecha de entrega actual<br>•	Informe 3 de X: Desde el otro día de la entrega anterior, hasta la fecha de terminación del contrato<br>•	Incluir tantos como sea necesario según lo pactado en el contrato.</p>
								</div>
								<div class="col-md-12" style="text-align: left; border-style: ridge; padding-top: 10px; padding-bottom: 10px;">
									<div class="col-md-12">
										<div class="col-md-3">
											<label id="LB_Objeto">OBJETO DEL CONTRATO:</label>
										</div>
										<div class="col-md-8">
											<textarea rows="2" id="TXTA_OBJETO_CONTRATO" name="TXTA_OBJETO_CONTRATO" class="form-control" placeholder="Escribir  aquí el objeto de su contrato de apoyo"></textarea>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-md-3">
											<label id="LB_Email">Correo Responsable:</label>
										</div>
										<div class="col-md-8">
											<input type="text" id="TX_Correo" name="TX_Correo" class="form-control" placeholder="E-mail del responsable de este informe." required>
										</div>
									</div>
								</div>
								<div class="col-xs-12 col-md-12 text-center bg-primary">
									<h4><small><font style="color:#fff">1. CUMPLIMIENTO Y EVALUACIÓN DE ACTIVIDADES</font></small></h4>
								</div>
								<div class="col-md-12" style="background-color: #d6e9c6; border-style: outset;">
									<p><label>OBLIGACIONES ESPECÍFICAS</label>
									</p>
									<p>Relacionados en la propuesta aprobada (ingrese tantas filas como sea necesario para cada obligación específica con el botón AZUL)</p>
									<table class="table col-md-12">
										<thead>
											<th width="5px">No.</th>
											<th>Obligación Específica</th>
											<th>Actividad(es)</th>
										</thead>
										<tbody id="contenedor_obligaciones_especificas">
											<tr id="tr_objetivo_1">
												<td style="padding:0px; background-color:rgba(0,166,0,0.3); text-align:center; vertical-align: middle;"><label id="nombre_1">1</label>
												</td>
												<td style="padding: 0px;"><textarea id="obligacion_especifica_1" name="obligacion_especifica_1" class="form-control" rows="6" placeholder="Relacionados en el contrato del Convenio (ingrese tantas filas como sea necesario para cada obligación específica)" required></textarea>
												</td>
												<td style="padding: 0px;"><textarea id="actividad_obligacion_1" name="actividad_obligacion_1" class="form-control" rows="6" placeholder="Actividades que realizó para cumplir la obligación Específica."></textarea>
												</td>
											</tr>
										</tbody>
									</table>
									<div style="text-align: right;" id="div_agregar_eliminar">
										<a name="" class="btn btn-danger" title="Eliminar fila" id="eliminar_fila_obligacion"><i class="fa fa-minus"></i></a>
										<a name="" class="btn btn-primary" title="Agregar fila" id="crear_fila_obligacion"><i class="fa fa-plus"></i></a>
									</div>
								</div>
								<div class="col-md-12" style="background-color: #d6e9c6; border-style: outset;">
									<p><label>DESCRIPCIÓN DE ACTIVIDADES DE CADA OBLIGACIÓN ESPECÍFICA</label>
									</p>
									<div class="col-md-12" style="background-color: rgb(255, 253, 147); border-style: outset;">
										<p><label>Especificaciones:</label></p>
										<p style="text-align: justify;">•	<label>CÓMO</label> (Estrategia de convocatoria y selección (Participantes y públicos)- Estrategia de divulgación - Metodologías, temáticas, materiales, alimentación, transporte, entre otros)<br>•	<label>CUÁNDO</label> (cumplimiento de cronograma)<br>•	<label>DÓNDE</label> (Lugares donde se desarrollan las actividades, aclarando el proceso de gestión para conseguirlos)<br>•	<label>CON QUIÉN</label> Descripción de la población (participantes y públicos, Localidades beneficiadas) - (Diligenciar el formato de poblaciones) – Describir la metodología para el conteo de asistentes.</p>
									</div>
									<table class="table col-md-12">
										<input type="text" id="id_celda_sumatoria_conquien" hidden>
										<thead>
											<th width="100%">Detalle de Actividades</th>
										</thead>
										<tbody id="contenedor_detalle">
											<tr>
												<td style="padding:0px; background-color:rgba(0,166,0,0.3); text-align:center; vertical-align: middle;"><label id="nombreobj_1">Detalle de Actividades de Obligación Específica 1 <i class="fas fa-stream btn btn-success leer_obligacion" style="color:white" data-toggle="tooltip" title="Leer Obligación"></i></label>
												</td>
											</tr>
											<tr class="col-md-12">
												<td style="padding: 0px; float: inherit;"  class="col-md-4">
													<label>COMO?</label><textarea id="como_1" name="como_1" class="form-control campo" rows="3"></textarea>
												</td>
												<td style="padding: 0px; float: inherit;"  class="col-md-4">
													<label>CUANDO?</label><textarea id="cuando_1" name="cuando_1" class="form-control campo" rows="3"></textarea>
												</td>
												<td style="padding: 0px; float: inherit;" class="col-md-4">
													<label>DONDE?</label><textarea id="donde_1" name="donde_1" class="form-control campo" rows="3"></textarea>
												</td>
											</tr>
											<tr class="col-md-12">
												<td style="padding: 0px; float:inherit;" class="col-md-4">
															<!-- <label>Aplica la pregunta CON QUIEN para esta Obligación?  </label>
																<input data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="SI" data-off="NO" type="checkbox" class="estado_check" type="checkbox" id="check_conquien_1" name="check_conquien_1" data-id="1" placeholder="CON QUIEN?"> -->
																<div id="div_conquien_1">
																	<label>CON QUIEN?</label>
																<!-- <textarea class="form-control campo conquien readonly" id="conquien_1" name="conquien_1" placeholder="Con quien?"></textarea>
																	<input type="text" id="beneficiarios_1" name="beneficiarios_1" class="form-control campo hidden"> -->
																	<textarea id="descripcion_conquien_1" name="descripcion_conquien_1" class="form-control campo" rows="3" placeholder="Descripción de la población beneficiada - Describir la metodología para el conteo de asistentes."></textarea>
																</div>
															</td>
															<td style="padding: 0px; float:inherit;" class="col-md-4">
																<label>ANALISIS DE METAS</label><textarea id="analisis_metas_1" name="analisis_metas_1" class="form-control campo" rows="3"></textarea>
															</td>
															<td style="padding: 0px; float:inherit;" class="col-md-4">
																<label>ANALISIS DE INDICADORES</label><textarea id="analisis_indicadores_1" name="analisis_indicadores_1" class="form-control campo" rows="3"></textarea>
															</td>
														</tr>
														<tr class="col-md-12">
															<td style="padding: 0px; float:inherit;" class="col-md-4">
																<label>ANALISIS DE IMPACTO</label><textarea id="analisis_impacto_1" name="analisis_impacto_1" class="form-control campo" rows="3"></textarea>
															</td>
															<td style="padding: 0px; float:inherit;" class="col-md-4">
																<label>ASPECTOS A DESTACAR</label><textarea id="aspectos_1" name="aspectos_1" class="form-control campo" rows="3"></textarea>
															</td>
															<td style="padding: 0px; float:inherit;" class="col-md-4">
																<label>DIFICULTADES</label><textarea id="dificultades_1" name="dificultades_1" class="form-control campo" rows="3"></textarea>
															</td>
														</tr>
														<tr class="col-md-12">
															<td style="padding: 0px; float:inherit;" class="col-md-6">
																<label>OTROS</label><textarea id="otros_1" name="otros_1" class="form-control campo" rows="3"></textarea>
															</td>
															<td style="padding: 0px; float:inherit;" class="col-md-6">
																<label>ANEXOS DE ESTA OBLIGACIÓN</label><textarea id="anexos_1" name="anexos_1" class="form-control campo" rows="3"></textarea>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
											<div class="col-xs-12 col-md-12 text-center bg-primary">
												<h4><small><font style="color:#fff">2. REPORTE CONSOLIDADO DE DATOS Y CIFRAS</font></small></h4>
											</div>
											<div class="col-md-12" style="background-color: rgb(255, 253, 147); border-style: outset;">
												<p><label>NOTA IMPORTANTE:</label> Este numeral estará disponible para diligenciar en el último Informe del Convenio.</p>
											</div>
											<div id="div_numeral_dos" name="div_numeral_dos" hidden>
												<div class="col-md-12" style="text-align: left; border-style: ridge; padding-top: 10px; padding-bottom: 10px;">
													<div class="col-md-12">
														<div class="col-md-3">
															<label id="LB_Actividades_Realizadas">Actividades Realizadas:</label>
														</div>
														<div class="col-md-9">
															<textarea id="TXTA_Actividades_Realizadas" name="TXTA_Actividades_Realizadas" class="form-control required" rows="3" required></textarea>
														</div>
													</div>
													<div class="col-md-12">
														<div class="col-md-3">
															<label id="LB_Poblacion_Beneficiada">Población Beneficiada:</label>
														</div>
														<div class="col-md-9">
															<textarea id="TXTA_Poblacion_Beneficiada" name="TXTA_Poblacion_Beneficiada" class="form-control required" rows="3" required></textarea>
															<!-- <input type="text" id="beneficiarios_Poblacion" name="beneficiarios_Poblacion" class="form-control hidden"> -->
														</div>
													</div>
													<div class="col-md-12">
														<div class="col-md-3">
															<label id="LB_Artistas_Beneficiados">Artistas Beneficiados:</label>
														</div>
														<div class="col-md-2">
															<input type="number" min="0" id="TX_Artistas_Beneficiados" name="TX_Artistas_Beneficiados" class="form-control required" required>
														</div>
													</div>
													<div class="col-md-12">

														<label id="LB_Difusion">Paginas Web y/o Links en los que realizó difusión al proyecto:</label>
													</div>
													<div class="col-md-12">
														<input type="text" id="TX_Difusion" name="TX_Difusion" class="form-control required" rows="2" placeholder="www.paginawebA.com, www.paginaB.com, www.paginaC.com" maxlength="1000" required>
													</div>
												</div>
											</div>

											<div class="col-xs-12 col-md-12 text-center bg-primary">
												<h4><small><font style="color:#fff">3. OBLIGACIONES ESPECÍFICAS</font></small></h4>
											</div>
											<div class="col-md-12" style="background-color: rgb(255, 253, 147); border-style: outset;">
												<p><label>NOTA IMPORTANTE:</label> Este numeral estará disponible para diligenciar en el último Informe del Convenio.</p>
											</div>
											<div id="div_numeral_tres" name="div_numeral_tres" hidden>
												<div class="col-md-12" style="background-color: rgba(0,220,0,0.3); border-style: outset;">
													<h4>OBLIGACIONES CON CARGO A LOS RECURSOS DEL IDARTES</h4>
												</div>
												<div class="col-md-12" style="background-color: #d6e9c6; border-style: outset;">
													<table class="table col-md-12">
														<thead>
															<th width="10%">No.</th>
															<th width="20%">Recursos Idartes</th>
															<th width="20%">Recursos Propios</th>
															<th width="30%">Informe</th>
															<th width="10%">Folio</th>
														</thead>
														<tbody id="contenedor_obligaciones_idartes">
															<tr id="tr_obligaciones_recursos_idartes_1">
																<td style="padding:0px; background-color:rgba(0,166,0,0.3); text-align:center; vertical-align: middle;"><label id="nombre_1">1</label>
																</td>
																<td style="padding: 0px;"><input id="recursos_idartes_tb1_1" name="recursos_idartes_tb1_1" class="form-control required" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\.*)\./g, '$1');" placeholder="0" required>
																</td>
																<td style="padding: 0px;"><input placeholder="0" id="recursos_asociado_tb1_1" name="recursos_asociado_tb1_1" class="form-control required" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\.*)\./g, '$1');" required>
																</td>
																<td style="padding: 0px;">
																	<select id="SL_Informe_tb1_1" name="SL_Informe_tb1_1" class="form-control selectpicker required" title="Seleccione el Número del Informe..." multiple required>
																		<option value="1">Informe 1</option>
																		<option value="2">Informe 2</option>
																		<option value="3">Informe 3</option>
																		<option value="4">Informe 4</option>
																		<option value="5">Informe 5</option>
																		<option value="6">Informe 6</option>
																		<option value="7">Informe 7</option>
																		<option value="8">Informe 8</option>
																		<option value="9">Informe 9</option>
																		<option value="10">Informe 10</option>
																		<option value="11">Informe 11</option>
																		<option value="12">Informe 12</option>
																		<option value="13">Informe 13</option>
																		<option value="14">Informe 14</option>
																		<option value="15">Informe 15</option>
																		<option value="16">Informe 16</option>
																	</select>
																</td>
																<td style="padding: 0px;"><input type="text" id="folio_tb1_1" name="folio_tb1_1" class="form-control folios_tb1 required" required>
																	<input type="text" id="id_celda_folios" name="id_celda_folios" hidden>
																</td>
															</tr>
														</tbody>
													</table>
							<!-- <div style="text-align: right;" id="div_agregar_eliminar">
								<a name="eliminar_fila_recursos_idartes" class="btn btn-danger" title="Eliminar fila" id="eliminar_fila_recursos_idartes"><i class="fa fa-minus"></i></a>
								<a name="crear_fila_recursos_idartes" class="btn btn-primary" title="Agregar fila" id="crear_fila_recursos_idartes"><i class="fa fa-plus"></i></a>
							</div> -->
						</div>
						<div class="col-md-12" style="background-color: rgba(0,166,0,0.3); border-style: outset;">
							<h4>OBLIGACIONES CON CARGO A LOS RECURSOS DEL ASOCIADO</h4>
						</div>
						<div class="col-md-12" style="background-color: #d6e9c6; border-style: outset;">
							<table class="table col-md-12">
								<thead>
									<th width="50%">Descripción.</th>
									<th width="10%">Recursos Idartes</th>
									<th width="10%">Recursos Propios</th>
									<th width="10%">Informe</th>
									<th width="10%">Folio</th>
								</thead>
								<tbody id="contenedor_obligaciones_asociado">
									<tr id="tr_obligaciones_recursos_asociado_1">
										<td style="padding:0px;">
											<textarea id="descripcion_obligacion_asociado_1" name="descripcion_obligacion_asociado_1" class="form-control" rows="1"></textarea>
										</td>
										<td style="padding: 0px;"><input id="recursos_idartes_tb2_1" name="recursos_idartes_tb2_1" class="form-control required" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\.*)\./g, '$1');" placeholder="0" required>
										</td>
										<td style="padding: 0px;"><input placeholder="0" id="recursos_asociado_tb2_1" name="recursos_asociado_tb2_1" class="form-control required" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\.*)\./g, '$1');" required>
										</td>
										<td style="padding: 0px;">
											<select id="SL_Informe_tb2_1" name="SL_Informe_tb2_1" class="form-control selectpicker required" multiple required>
												<option value="1">Informe 1</option>
												<option value="2">Informe 2</option>
												<option value="3">Informe 3</option>
												<option value="4">Informe 4</option>
												<option value="5">Informe 5</option>
												<option value="6">Informe 6</option>
												<option value="7">Informe 7</option>
												<option value="8">Informe 8</option>
												<option value="9">Informe 9</option>
												<option value="10">Informe 10</option>
												<option value="11">Informe 11</option>
												<option value="12">Informe 12</option>
												<option value="13">Informe 13</option>
												<option value="14">Informe 14</option>
												<option value="15">Informe 15</option>
												<option value="16">Informe 16</option>
											</select>
										</td>
										<td style="padding: 0px;"><input type="text" id="folio_tb2_1" name="folio_tb2_1" class="form-control folios_tb2 required" required>
										</td>
									</tr>
								</tbody>
							</table>
							<div style="text-align: right;" id="div_agregar_eliminar">
								<a name="" class="btn btn-danger" title="Eliminar fila" id="eliminar_fila_recursos_asociado"><i class="fa fa-minus"></i></a>
								<a name="" class="btn btn-primary" title="Agregar fila" id="crear_fila_recursos_asociado"><i class="fa fa-plus"></i></a>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-md-12 text-center bg-primary">
						<h4><small><font style="color:#fff">4. ANEXOS</font></small></h4>
					</div>
					<div class="col-md-12" style="background-color: rgb(255, 253, 147); border-style: outset;">
						<p>
							Todos los anexos referenciados debe cargarlos en la carpeta de <strong>GOOGLE DRIVE</strong> que SIF le asignó y que está dispuesta para tal fin.
						</p>
					</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div id="div_archivo" class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="padding: 10px;">
								<input id="archivos_gestion" name="file[]" type="file" class="filestyle" data-buttonName="btn-primary" runat="server" multiple required>
							</div>
							<div id="archivos_adjuntos" class="col-xs-6 col-sm-6 col-md-6 col-lg-6 alert alert-danger" style="padding:5px; border-style: groove;">
							</div>
						</div>
					
					    <div class="col-md-12">
						<br>
						<div class="col-md-6 col-md-offset-3">
							<center>
								<input type="submit" id="GUARDAR_INFORME" name="GUARDAR_INFORME" class="btn btn-success" value="GUARDAR INFORME">
							</center>
						</div>
					</div> 
				</div>
			</form>
		</div>
	</div>
	<div class="tab-pane" id="proyeccion_gasto" role="tabpanel">
		<div class="row">
			<div class="col-xs-12 col-md-12 text-center bg-primary">
				<h4>Proyección del Gasto <small><font style="color:#fff">Organizaciones</font></small></h4>
			</div>
		</div>
		<div class="row">
			<form id="FORM_INFORME_PROYECCION">
				<div class="col-xs-12 col-md-12 text-center" style="padding: 0px;padding-top: 10px;">
					<div class="col-md-6 text-right border-form">
						<p style="padding-right: 10px">ORGANIZACIÓN</p>
					</div>
					<div class="col-md-6 text-left border-form">
						<p style="padding-left: 10px" id="p_organizacion"></p>
					</div>
					<div class="col-md-12 col-md-12 text-left content-form-bordered">
						<table class="table table-proyeccion table-bordered text-center" id="table_adiciones" width="25%" >
							<thead>
								<tr>
									<th class="text-center" style="width: 5%;"></th>
									<th class="text-center" style="width: 5%;">INICIAL Y ADICIONES</th>
									<th class="text-center" style="width: 5%;">IDARTES</th>
									<th class="text-center" style="width: 5%;">ASOCIADO</th>
									<th class="text-center" style="width: 5%;">TOTAL APORTES</th>
									<th class="text-center" style="width: 5%;">% APORTE ASOCIADO FRENTE AL APORTE DE IDARTES</th>
								</tr>
							</thead>
							<tbody>
							<!-- <tr>
								<td style="width: 5%">INICIAL</td>
								<td style="width: 5%">$0</td>
								<td style="width: 5%">$0</td>
								<td style="width: 5%">$0</td>
								<th class="text-center" style="width: 5%; border-top:transparent; border-bottom:transparent;"></th>
								<td style="width: 5%">0%</td>
							</tr>
							<tr>
								<td style="width: 5%">ADICIÓN 1</td>
								<td style="width: 5%">$0</td>
								<td style="width: 5%">$0</td>
								<td style="width: 5%">$0</td>
								<th class="text-center" style="width: 5%; border-top:transparent; border-bottom:transparent;"></th>
								<td style="width: 5%">0%</td>
							</tr>
							<tr>
								<td style="width: 5%">ADICIÓN 2</td>
								<td style="width: 5%">$0</td>
								<td style="width: 5%">$0</td>
								<td style="width: 5%">$0</td>
								<th class="text-center" style="width: 5%; border-top:transparent; border-bottom:transparent;"></th>
								<td style="width: 5%">0%</td>
							</tr>
							<tr>
								<td style="width: 5%">ADICIÓN 3</td>
								<td style="width: 5%">$0</td>
								<td style="width: 5%">$0</td>
								<td style="width: 5%">$0</td>
								<th class="text-center" style="width: 5%; border-top:transparent; border-bottom:transparent;"></th>
								<td style="width: 5%">0%</td>
							</tr>
							<tr>
								<td style="width: 5%">TOTAL</td>
								<td style="width: 5%">$0</td>
								<td style="width: 5%">$0</td>
								<td style="width: 5%">$0</td>
								<th class="text-center" style="width: 5%; border-top:transparent; border-bottom:transparent;"></th>
								<td style="width: 5%"></td>
							</tr> -->
							</tbody>
						</table>
						<div class="text-left" style="padding-left: 20px;padding-bottom: 10px">
							<a  href="#" id="a-add-item-0" class="btn btn-success " Title="Agregar Adición" data-toggle='tooltip'  data-placement="right"><i class="fa fa-plus"></i></a>
							<a  href="#" id="a-delete-item-0" class="btn btn-danger " Title="Quitar Adición" data-toggle='tooltip'  data-placement="right"><i class="fa fa-minus"></i></a>
						</div>

						<div class="col-md-12">
							<label id="LB_Nombre_Proyecto">APORTES DEL IDARTES</label>
						</div>

						<div class="col-md-1">
							<select id="SL_Proyecto" name="SL_Proyecto" class="col-md-6 form-control selectpicker" required title="Seleccione un proyecto">
							</select>
						</div>

						<div class="col-md-1">
							<select id="SL_Periodo_Proyeccion" name="SL_Periodo_Proyeccion" class="col-md-6 form-control selectpicker" multiple required title="Seleccione un Periodo">
							</select>
						</div>

						<div class="col-md-1">
							<select id="SL_Anio_Proyeccion" name="SL_Anio_Proyeccion" class="col-md-6 form-control selectpicker" required title="Seleccione un año">
							</select>
						</div>

						<table class="table table-proyeccion table-bordered text-center" id="table_desembolsos" width="50%" >
							<thead>
								<tr>
									<th class="text-center" style="width: 5%">DESEMBOLSO</th>
									<th class="text-center" style="width: 7%">DESEMBOLSOS ANTERIORES</th>
									<th class="text-center" style="width: 7%">ENERO</th>
									<th class="text-center" style="width: 7%">FEBRERO</th>
									<th class="text-center" style="width: 7%">MARZO</th>
									<th class="text-center" style="width: 7%">ABRIL</th>
									<th class="text-center" style="width: 7%">MAYO</th>
									<th class="text-center" style="width: 7%">JUNIO</th>
									<th class="text-center" style="width: 7%">JULIO</th>
									<th class="text-center" style="width: 7%">AGOSTO</th>
									<th class="text-center" style="width: 7%">SEPTIEMBRE</th>
									<th class="text-center" style="width: 7%">OCTUBRE</th>
									<th class="text-center" style="width: 7%">NOVIEMBRE</th>
									<th class="text-center" style="width: 7%">DICIEMBRE</th>
									<th class="text-center" style="width: 8%">VALOR</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>

						<div class="text-left" style="padding-left: 20px;padding-bottom: 10px">
							<a  href="#" id="a-add-des" class="btn btn-success " Title="Agregar Desembolso" data-toggle='tooltip'  data-placement="right"><i class="fa fa-plus"></i></a>
							<a  href="#" id="a-delete-des" class="btn btn-danger " Title="Quitar Último Desembolso" data-toggle='tooltip'  data-placement="right"><i class="fa fa-minus"></i></a>
						</div>
						<div class="col-md-12">
							<br>
							<label id="LB_Nombre_Proyecto">Rubros: </label>
						</div>
						<div class="col-md-1">
							<select id="SL_Rubro" name="SL_Rubro" class="col-md-6 form-control selectpicker" multiple required title="Seleccione los rubros"></select>
						</div>
						<div class="row col-md-12"><br></div>
					</div>
					<div class="col-md-12 col-md-12 text-left content-form-bordered" id="table_rubro_1">
						<div class="col-md-12">
							<label>Recurso Humano</label>
						</div>
						<table class="table table-proyeccion table-bordered text-center" id="table_items_proyeccion_1" width="100%" >
							<thead>
								<tr>
									<th class="text-center">N</th>
									<th class="text-center">ITEMS PRESUPUESTO ORGANIZACIÓN</th>
									<th class="text-center">ÍTEMS DEL INFORME FINANCIERO</th>
									<th class="text-center">CANTIDAD</th>
									<th class="text-center">UNIDAD DE MEDIDA</th>
									<th class="text-center">PRESUPUESTO INICIAL</th>
									<th class="text-center">ADICIONES</th>
									<th class="text-center">FECHA (dd/mm/aaaa)</th>
									<th class="text-center">TRASLADOS</th>
									<th class="text-center">FECHA (dd/mm/aaaa)</th>
									<th class="text-center" style="font-size: 10px">TOTAL PRESUPUESTO DESPUÉS DE ADICIONES Y/O TRASLADOS</th>
									<th class="text-center">ACUMULADO PERIODOS ANTERIORES</th>
									<th class="text-center">ENERO <br><br>
										<input title="N. Grupos Atendidos" data-toggle='tooltip'  data-placement="right" style="width:99%" id="TX_Grupos_Enero" name="TX_Grupos_Enero" type="number" maxlength="100">
									</th>
									<th class="text-center">FEBRERO <br><br>
										<input title="N. Grupos Atendidos" data-toggle='tooltip'  data-placement="right" style="width:99%" id="TX_Grupos_Febrero" name="TX_Grupos_Febrero" type="number" maxlength="100">
									</th>
									<th class="text-center">MARZO <br><br>
										<input title="N. Grupos Atendidos" data-toggle='tooltip'  data-placement="right" style="width:99%" id="TX_Grupos_Marzo" name="TX_Grupos_Marzo" type="number" maxlength="100">
									</th>
									<th class="text-center">ABRIL <br><br>
										<input title="N. Grupos Atendidos" data-toggle='tooltip'  data-placement="right" style="width:99%" id="TX_Grupos_Abril" name="TX_Grupos_Abril" type="number" maxlength="100">
									</th>
									<th class="text-center">MAYO <br><br>
										<input title="N. Grupos Atendidos" data-toggle='tooltip'  data-placement="right" style="width:99%" id="TX_Grupos_Mayo" name="TX_Grupos_Mayo" type="number" maxlength="100">
									</th>
									<th class="text-center">JUNIO <br><br>
										<input title="N. Grupos Atendidos" data-toggle='tooltip'  data-placement="right" style="width:99%" id="TX_Grupos_Junio" name="TX_Grupos_Junio" type="number" maxlength="100">
									</th>
									<th class="text-center">JULIO <br><br>
										<input title="N. Grupos Atendidos" data-toggle='tooltip'  data-placement="right" style="width:99%" id="TX_Grupos_Julio" name="TX_Grupos_Julio" type="number" maxlength="100">
									</th>
									<th class="text-center">AGOSTO <br><br>
										<input title="N. Grupos Atendidos" data-toggle='tooltip'  data-placement="right" style="width:99%" id="TX_Grupos_Agosto" name="TX_Grupos_Agosto" type="number" maxlength="100">
									</th>
									<th class="text-center">SEPTIEMBRE <br><br>
										<input title="N. Grupos Atendidos" data-toggle='tooltip'  data-placement="right" style="width:99%" id="TX_Grupos_Septiembre" name="TX_Grupos_Septiembre" type="number" maxlength="100">
									</th>
									<th class="text-center">OCTUBRE <br><br>
										<input title="N. Grupos Atendidos" data-toggle='tooltip'  data-placement="right" style="width:99%" id="TX_Grupos_Octubre" name="TX_Grupos_Octubre" type="number" maxlength="100">
									</th>
									<th class="text-center">NOVIEMBRE <br><br>
										<input title="N. Grupos Atendidos" data-toggle='tooltip'  data-placement="right" style="width:99%" id="TX_Grupos_Noviembre" name="TX_Grupos_Noviembre" type="number" maxlength="100">
									</th>
									<th class="text-center">DICIEMBRE <br><br>
										<input title="N. Grupos Atendidos" data-toggle='tooltip'  data-placement="right" style="width:99%" id="TX_Grupos_Diciembre" name="TX_Grupos_Diciembre" type="number" maxlength="100">
									</th>
									<th class="text-center">TOTAL ACUMULADO</th>
									<th class="text-center">SALDO FINAL DISPONIBLE</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>

						<div class="text-left" style="padding-left: 20px;padding-bottom: 10px">

							<a  href="#" id="a-add-item-1" class="btn btn-success " Title="Agregar Item" data-toggle='tooltip'  data-placement="right"><i class="fa fa-plus"></i></a>
							<a  href="#" id="a-delete-item-1" class="btn btn-danger " Title="Quitar Último Item" data-toggle='tooltip'  data-placement="right"><i class="fa fa-minus"></i></a>
						</div>
					</div>
					<div class="col-md-12 col-md-12 text-left content-form-bordered" id="table_rubro_2">
						<div class="col-md-12">
							<label>Formación</label>
						</div>
						<table class="table table-proyeccion table-bordered text-center" id="table_items_proyeccion_2" width="100%" >
							<thead>
								<tr>
									<th class="text-center">N</th>
									<th class="text-center">ITEMS PRESUPUESTO ORGANIZACIÓN</th>
									<th class="text-center">ÍTEMS DEL INFORME FINANCIERO</th>
									<th class="text-center">CANTIDAD</th>
									<th class="text-center">UNIDAD DE MEDIDA</th>
									<th class="text-center">PRESUPUESTO INICIAL</th>
									<th class="text-center">ADICIONES</th>
									<th class="text-center">FECHA (dd/mm/aaaa)</th>
									<th class="text-center">TRASLADOS</th>
									<th class="text-center">FECHA (dd/mm/aaaa)</th>
									<th class="text-center" style="font-size: 10px">TOTAL PRESUPUESTO DESPUÉS DE ADICIONES Y/O TRASLADOS</th>
									<th class="text-center">ACUMULADO PERIODOS ANTERIORES</th>
									<th class="text-center">ENERO</th>
									<th class="text-center">FEBRERO</th>
									<th class="text-center">MARZO</th>
									<th class="text-center">ABRIL</th>
									<th class="text-center">MAYO</th>
									<th class="text-center">JUNIO</th>
									<th class="text-center">JULIO</th>
									<th class="text-center">AGOSTO</th>
									<th class="text-center">SEPTIEMBRE</th>
									<th class="text-center">OCTUBRE</th>
									<th class="text-center">NOVIEMBRE</th>
									<th class="text-center">DICIEMBRE</th>
									<th class="text-center">TOTAL ACUMULADO</th>
									<th class="text-center">SALDO FINAL DISPONIBLE</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>

						<div class="text-left" style="padding-left: 20px;padding-bottom: 10px">
							<a  href="#" id="a-add-item-2" class="btn btn-success " Title="Agregar Item" data-toggle='tooltip'  data-placement="right"><i class="fa fa-plus"></i></a>
							<a  href="#" id="a-delete-item-2" class="btn btn-danger " Title="Quitar Último Item" data-toggle='tooltip'  data-placement="right"><i class="fa fa-minus"></i></a>
						</div>
					</div>
					<div class="col-md-12 col-md-12 text-left content-form-bordered" id="table_rubro_3">
						<div class="col-md-12">
							<label>Materiales</label>
						</div>
						<table class="table table-proyeccion table-bordered text-center" id="table_items_proyeccion_3" width="100%" >
							<thead>
								<tr>
									<th class="text-center">N</th>
									<th class="text-center">ITEMS PRESUPUESTO ORGANIZACIÓN</th>
									<th class="text-center">ÍTEMS DEL INFORME FINANCIERO</th>
									<th class="text-center">CANTIDAD</th>
									<th class="text-center">UNIDAD DE MEDIDA</th>
									<th class="text-center">PRESUPUESTO INICIAL</th>
									<th class="text-center">ADICIONES</th>
									<th class="text-center">FECHA (dd/mm/aaaa)</th>
									<th class="text-center">TRASLADOS</th>
									<th class="text-center">FECHA (dd/mm/aaaa)</th>
									<th class="text-center" style="font-size: 10px">TOTAL PRESUPUESTO DESPUÉS DE ADICIONES Y/O TRASLADOS</th>
									<th class="text-center">ACUMULADO PERIODOS ANTERIORES</th>
									<th class="text-center">ENERO</th>
									<th class="text-center">FEBRERO</th>
									<th class="text-center">MARZO</th>
									<th class="text-center">ABRIL</th>
									<th class="text-center">MAYO</th>
									<th class="text-center">JUNIO</th>
									<th class="text-center">JULIO</th>
									<th class="text-center">AGOSTO</th>
									<th class="text-center">SEPTIEMBRE</th>
									<th class="text-center">OCTUBRE</th>
									<th class="text-center">NOVIEMBRE</th>
									<th class="text-center">DICIEMBRE</th>
									<th class="text-center">TOTAL ACUMULADO</th>
									<th class="text-center">SALDO FINAL DISPONIBLE</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>

						<div class="text-left" style="padding-left: 20px;padding-bottom: 10px">
							<a  href="#" id="a-add-item-3" class="btn btn-success " Title="Agregar Item" data-toggle='tooltip'  data-placement="right"><i class="fa fa-plus"></i></a>
							<a  href="#" id="a-delete-item-3" class="btn btn-danger " Title="Quitar Último Item" data-toggle='tooltip'  data-placement="right"><i class="fa fa-minus"></i></a>
						</div>
					</div>
					<div class="col-md-12 col-md-12 text-left content-form-bordered" id="table_rubro_4">
						<div class="col-md-12">
							<label>Circulación y Divulgación</label>
						</div>
						<table class="table table-proyeccion table-bordered text-center" id="table_items_proyeccion_4" width="100%" >
							<thead>
								<tr>
									<th class="text-center">N</th>
									<th class="text-center">ITEMS PRESUPUESTO ORGANIZACIÓN</th>
									<th class="text-center">ÍTEMS DEL INFORME FINANCIERO</th>
									<th class="text-center">CANTIDAD</th>
									<th class="text-center">UNIDAD DE MEDIDA</th>
									<th class="text-center">PRESUPUESTO INICIAL</th>
									<th class="text-center">ADICIONES</th>
									<th class="text-center">FECHA (dd/mm/aaaa)</th>
									<th class="text-center">TRASLADOS</th>
									<th class="text-center">FECHA (dd/mm/aaaa)</th>
									<th class="text-center" style="font-size: 10px">TOTAL PRESUPUESTO DESPUÉS DE ADICIONES Y/O TRASLADOS</th>
									<th class="text-center">ACUMULADO PERIODOS ANTERIORES</th>
									<th class="text-center">ENERO</th>
									<th class="text-center">FEBRERO</th>
									<th class="text-center">MARZO</th>
									<th class="text-center">ABRIL</th>
									<th class="text-center">MAYO</th>
									<th class="text-center">JUNIO</th>
									<th class="text-center">JULIO</th>
									<th class="text-center">AGOSTO</th>
									<th class="text-center">SEPTIEMBRE</th>
									<th class="text-center">OCTUBRE</th>
									<th class="text-center">NOVIEMBRE</th>
									<th class="text-center">DICIEMBRE</th>
									<th class="text-center">TOTAL ACUMULADO</th>
									<th class="text-center">SALDO FINAL DISPONIBLE</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>

						<div class="text-left" style="padding-left: 20px;padding-bottom: 10px">
							<a  href="#" id="a-add-item-4" class="btn btn-success " Title="Agregar Item" data-toggle='tooltip'  data-placement="right"><i class="fa fa-plus"></i></a>
							<a  href="#" id="a-delete-item-4" class="btn btn-danger " Title="Quitar Último Item" data-toggle='tooltip'  data-placement="right"><i class="fa fa-minus"></i></a>
						</div>
					</div>
					<div class="col-md-12 col-md-12 text-left content-form-bordered" id="table_rubro_5">
						<div class="col-md-12">
							<label>Memorias</label>
						</div>
						<table class="table table-proyeccion table-bordered text-center" id="table_items_proyeccion_5" width="100%" >
							<thead>
								<tr>
									<th class="text-center">N</th>
									<th class="text-center">ITEMS PRESUPUESTO ORGANIZACIÓN</th>
									<th class="text-center">ÍTEMS DEL INFORME FINANCIERO</th>
									<th class="text-center">CANTIDAD</th>
									<th class="text-center">UNIDAD DE MEDIDA</th>
									<th class="text-center">PRESUPUESTO INICIAL</th>
									<th class="text-center">ADICIONES</th>
									<th class="text-center">FECHA (dd/mm/aaaa)</th>
									<th class="text-center">TRASLADOS</th>
									<th class="text-center">FECHA (dd/mm/aaaa)</th>
									<th class="text-center" style="font-size: 10px">TOTAL PRESUPUESTO DESPUÉS DE ADICIONES Y/O TRASLADOS</th>
									<th class="text-center">ACUMULADO PERIODOS ANTERIORES</th>
									<th class="text-center">ENERO</th>
									<th class="text-center">FEBRERO</th>
									<th class="text-center">MARZO</th>
									<th class="text-center">ABRIL</th>
									<th class="text-center">MAYO</th>
									<th class="text-center">JUNIO</th>
									<th class="text-center">JULIO</th>
									<th class="text-center">AGOSTO</th>
									<th class="text-center">SEPTIEMBRE</th>
									<th class="text-center">OCTUBRE</th>
									<th class="text-center">NOVIEMBRE</th>
									<th class="text-center">DICIEMBRE</th>
									<th class="text-center">TOTAL ACUMULADO</th>
									<th class="text-center">SALDO FINAL DISPONIBLE</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>

						<div class="text-left" style="padding-left: 20px;padding-bottom: 10px">
							<a  href="#" id="a-add-item-5" class="btn btn-success " Title="Agregar Item" data-toggle='tooltip'  data-placement="right"><i class="fa fa-plus"></i></a>
							<a  href="#" id="a-delete-item-5" class="btn btn-danger " Title="Quitar Último Item" data-toggle='tooltip'  data-placement="right"><i class="fa fa-minus"></i></a>
						</div>
					</div>
					<div class="col-md-12 col-md-12 text-left content-form-bordered" id="table_rubro_6">
						<div class="col-md-12">
							<label>Gastos Administrativos</label>
						</div>
						<table class="table table-proyeccion table-bordered text-center" id="table_items_proyeccion_6" width="100%" >
							<thead>
								<tr>
									<th class="text-center">N</th>
									<th class="text-center">ITEMS PRESUPUESTO ORGANIZACIÓN</th>
									<th class="text-center">ÍTEMS DEL INFORME FINANCIERO</th>
									<th class="text-center">CANTIDAD</th>
									<th class="text-center">UNIDAD DE MEDIDA</th>
									<th class="text-center">PRESUPUESTO INICIAL</th>
									<th class="text-center">ADICIONES</th>
									<th class="text-center">FECHA (dd/mm/aaaa)</th>
									<th class="text-center">TRASLADOS</th>
									<th class="text-center">FECHA (dd/mm/aaaa)</th>
									<th class="text-center" style="font-size: 10px">TOTAL PRESUPUESTO DESPUÉS DE ADICIONES Y/O TRASLADOS</th>
									<th class="text-center">ACUMULADO PERIODOS ANTERIORES</th>
									<th class="text-center">ENERO</th>
									<th class="text-center">FEBRERO</th>
									<th class="text-center">MARZO</th>
									<th class="text-center">ABRIL</th>
									<th class="text-center">MAYO</th>
									<th class="text-center">JUNIO</th>
									<th class="text-center">JULIO</th>
									<th class="text-center">AGOSTO</th>
									<th class="text-center">SEPTIEMBRE</th>
									<th class="text-center">OCTUBRE</th>
									<th class="text-center">NOVIEMBRE</th>
									<th class="text-center">DICIEMBRE</th>
									<th class="text-center">TOTAL ACUMULADO</th>
									<th class="text-center">SALDO FINAL DISPONIBLE</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>

						<div class="text-left" style="padding-left: 20px;padding-bottom: 10px">
							<a  href="#" id="a-add-item-6" class="btn btn-success " Title="Agregar Item" data-toggle='tooltip'  data-placement="right"><i class="fa fa-plus"></i></a>
							<a  href="#" id="a-delete-item-6" class="btn btn-danger " Title="Quitar Último Item" data-toggle='tooltip'  data-placement="right"><i class="fa fa-minus"></i></a>
						</div>
					</div>
					<div class="col-md-12 col-md-12 text-left content-form-bordered">
						<table class="table table-proyeccion table-bordered text-center" id="table_totales" width="100%" >
							<thead>
								<tr>
									<th class="text-center"></th>
									<th class="text-center"></th>
									<th class="text-center"></th>
									<th class="text-center"></th>
									<th class="text-center"></th>
									<th class="text-center">PRESUPUESTO INICIAL</th>
									<th class="text-center">ADICIONES</th>
									<th class="text-center"></th>
									<th class="text-center">TRASLADOS</th>
									<th class="text-center"></th>
									<th class="text-center" style="font-size: 10px">TOTAL PRESUPUESTO DESPUÉS DE ADICIONES Y/O TRASLADOS</th>
									<th class="text-center">ACUMULADO PERIODOS ANTERIORES</th>
									<th class="text-center">ENERO</th>
									<th class="text-center">FEBRERO</th>
									<th class="text-center">MARZO</th>
									<th class="text-center">ABRIL</th>
									<th class="text-center">MAYO</th>
									<th class="text-center">JUNIO</th>
									<th class="text-center">JULIO</th>
									<th class="text-center">AGOSTO</th>
									<th class="text-center">SEPTIEMBRE</th>
									<th class="text-center">OCTUBRE</th>
									<th class="text-center">NOVIEMBRE</th>
									<th class="text-center">DICIEMBRE</th>
									<th class="text-center">TOTAL ACUMULADO</th>
									<th class="text-center">SALDO FINAL DISPONIBLE</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
					<div class="col-md-12 col-md-12 text-left content-form-bordered">

						<div class="col-md-2">
							<label id="LB_Nombre_Proyecto">APORTE DEL ASOCIADO</label>
						</div>
						<table class="table table-proyeccion table-bordered text-center" id="table_items_asociado" width="100%" >
							<thead>
								<tr>
									<th class="text-center">N</th>
									<th class="text-center">ITEMS PRESUPUESTO ORGANIZACIÓN</th>
									<th class="text-center">ÍTEMS DEL INFORME FINANCIERO</th>
									<th class="text-center">CANTIDAD</th>
									<th class="text-center">UNIDAD DE MEDIDA</th>
									<th class="text-center">PRESUPUESTO INICIAL</th>
									<th class="text-center">ADICIONES</th>
									<th class="text-center">FECHA (dd/mm/aaaa)</th>
									<th class="text-center">TRASLADOS</th>
									<th class="text-center">FECHA (dd/mm/aaaa)</th>
									<th class="text-center" style="font-size: 10px">TOTAL PRESUPUESTO DESPUÉS DE ADICIONES Y/O TRASLADOS</th>
									<th class="text-center">ACUMULADO PERIODOS ANTERIORES</th>
									<th class="text-center">ENERO</th>
									<th class="text-center">FEBRERO</th>
									<th class="text-center">MARZO</th>
									<th class="text-center">ABRIL</th>
									<th class="text-center">MAYO</th>
									<th class="text-center">JUNIO</th>
									<th class="text-center">JULIO</th>
									<th class="text-center">AGOSTO</th>
									<th class="text-center">SEPTIEMBRE</th>
									<th class="text-center">OCTUBRE</th>
									<th class="text-center">NOVIEMBRE</th>
									<th class="text-center">DICIEMBRE</th>
									<th class="text-center">TOTAL ACUMULADO</th>
									<th class="text-center">SALDO FINAL DISPONIBLE</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>

						<div class="text-left" style="padding-left: 20px;padding-bottom: 10px">
							<a  href="#" id="a-add-asoc" class="btn btn-success " Title="Agregar Desembolso" data-toggle='tooltip'  data-placement="right"><i class="fa fa-plus"></i></a>
							<a  href="#" id="a-delete-asoc" class="btn btn-danger " Title="Quitar Último Desembolso" data-toggle='tooltip'  data-placement="right"><i class="fa fa-minus"></i></a>
						</div>
					</div>
					<div class="col-md-12 col-md-12 text-left content-form-bordered">
						<div class="text-left" style="padding-left: 20px;padding-bottom: 10px">
							<input type="button" id="a-save-informe-proyeccion" name="a-save-informe-proyeccion" class="btn btn-success" Title="Enviar Formato" value="Enviar Formato">
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="tab-pane fade in" id="consulta_formatos">
		<div class="row">
			<div class="col-xs-12 col-md-12 text-center bg-primary">
				<h4>Consulta de Formatos<small><font style="color:#fff"> Organizaciones</font></small></h4>
			</div>
			<div class="col-xs-6 col-md-6">
				<select id="SL_Year" title="Seleccione el año del Convenio" class="form-control selectpicker">
					<option value="2017">Convenios 2017</option>
					<option value="2018">Convenios 2018</option>
					<option value="2019">Convenios 2019</option>
					<option value="2020">Convenios 2020</option>
					<option value="2021">Convenios 2021</option>
				</select>
			</div>
			<div class="col-xs-6 col-md-6">
				<select id="SL_Organizacion" title="Seleccione la Organización" class="form-control selectpicker" data-live-search='true'>
					<option value="">Seleccione la Organización</option>
				</select>
			</div>
			<div class="col-xs-12 col-md-12">
				<br>
				<div class="col-md-12" style="background-color: rgb(255, 253, 147); border-style: outset;">
					<p><label>NOTA IMPORTANTE:</label></p>
					<p style="text-align: justify;">• Utilice los botones de la última columna de la siguiente tabla para definir cuales son los formatos completados o finalizados, de modo que el equipo administrativo pueda identificarlos en medio de los borradores o erroneos, todos aquellos que queden en <strong>"SI"</strong> serán los que se revisarán.</p>
				</div>
				<table id="tabla_fas" class="table table-hover" style="text-align: center">
					<br><caption style="text-align: center; font-size: 20px;">Formatos Administrativos</caption>
					<thead>
						<th>Mes/Año</th>
						<th>Subida</th>
						<th>Tipo</th>
						<th>Descarga</th>
						<th>Ver</th>
						<th>Revisión</th>
						<th>Observaciones</th>
						<th>Completado</th>
					</thead>
					<tbody id="body_formatos_administrativos">
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
</body>

<div class="modal fade" id="MODAL_REVISION_ARCHIVOS">
	<div class="modal-dialog modal-lg" role="document">
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
						<textarea id="TXA_Observacion_Archivo" name="TXA_Observacion_Archivo" class="form-control" rows="5" placeholder="Alguna observación Aquí"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12" style="text-align: right;">
						<br>
						<p>Aprobación							<input data-toggle="toggle" data-onstyle="success" id="IN_Aprobacion_Archivos" name= "IN_Aprobacion_Archivos" data-offstyle="danger" data-on="SI" data-off="NO" type="checkbox" class="estado_check"></p>
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

<div class="modal fade" id="MODAL_OBSERVACION_ARCHIVOS">
	<div class="modal-dialog modal-lg" role="document">
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
<div class="modal fade" id="MODAL_ANEXOS_ARCHIVOS">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modal_titulo_anexo"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="text-align: justify;">
				<div class="row">
					<div class="col-md-12">
						<table id="TABLA_ANEXOS" class="table table-hover">
							<thead>
								<th>Nombre Archivo</th>
								<th>Descargar</th>
							</thead>
							<tbody id="body_anexos">
							</tbody>
						</table>
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
		</div>
	</div>
</div>

<div class="modal fade" id="MODAL_REVISION_FAS">
	<div class="modal-dialog modal-lg" role="document">
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
						<div id="DIV_Observacion_FA" name="DIV_Observacion_FA" class="form-control"></div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12" style="text-align: right;">
						<br>
						<p>Aprobación
							<input data-toggle="toggle" data-onstyle="success" id="IN_Aprobacion_FA" name= "IN_Aprobacion_FA" data-offstyle="danger" data-on="SI" data-off="NO" type="checkbox" class="estado_check"></p>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" id="BT_Guardar_Observacion_FA">GUARDAR</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="MODAL_OBSERVACION_FAS">
		<div class="modal-dialog modal-lg" role="document">
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
							<p id="P_Observacion_FA"></p>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal_con_quien" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">Con quien se realizó la actividad(es)?</h4>
				</div>
				<div class="modal-body">

					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<p style="text-align:center"><strong>Beneficiarios segun sexo:</strong></p>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Mujeres:</p></div>
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Mujeres" type="number" class="form-control" min="0" value="0"></div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Hombres:</p></div>
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Hombres" type="number" class="form-control" min="0" value="0"></div>
					</div>

					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<p style="text-align:center"><strong>Beneficiarios según grupo poblacional por ciclo vital:</strong></p>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Primera infancia (0 – 5 años):</p></div>
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_P_Infancia" type="number" class="form-control" min="0" value="0"></div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Infancia (6 – 11 años):</p></div>
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Infancia" type="number" class="form-control" min="0" value="0"></div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Adolescencia (12 – 13 años):</p></div>
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Adolescencia" type="number" class="form-control" min="0" value="0"></div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Juventud (14 – 26 años):</p></div>
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Juventud" type="number" class="form-control" min="0" value="0"></div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Adulto (27 – 59 años):</p></div>
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Adulto" type="number" class="form-control" min="0" value="0"></div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Adulto Mayor (60 años y más):</p></div>
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Adulto_Mayor" type="number" class="form-control" min="0" value="0"></div>
					</div>

					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<p style="text-align:center"><strong>Beneficiarios según sector social:</strong></p>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Campesinos:</p></div>
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Campesinos" type="number" class="form-control" min="0" value="0"></div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Artesanos:</p></div>
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Artesanos" type="number" class="form-control" min="0" value="0"></div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Personas con discapacidad:</p></div>
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Discapacidad" type="number" class="form-control" min="0" value="0"></div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">LGBTI:</p></div>
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_LGBTI" type="number" class="form-control" min="0" value="0"></div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Reinsertados - reincorporados:</p></div>
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Reinsertados" type="number" class="form-control" min="0" value="0"></div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Víctimas:</p></div>
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Victimas" type="number" class="form-control" min="0" value="0"></div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Personas en condición de desplazamiento:</p></div>
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Dezplazamiento" type="number" class="form-control" min="0" value="0"></div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Habitantes de calle:</p></div>
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Habitantes_Calle" type="number" class="form-control" min="0" value="0"></div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Medios comunitarios:</p></div>
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Medios_Comunitarios" type="number" class="form-control" min="0" value="0"></div>
					</div>

					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<p style="text-align:center"><strong>Beneficiarios según la pertenencia étnica:</strong></p>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Pueblo Raizal:</p></div>
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Pueblo_Raizal" type="number" class="form-control" min="0" value="0"></div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Afrodescendientes, negritudes y palenque:</p></div>
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Afrodescendientes" type="number" class="form-control" min="0" value="0"></div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Pueblo Rrom - gitano:</p></div>
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Pueblo_Gitano" type="number" class="form-control" min="0" value="0"></div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Pueblos indígenas:</p></div>
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Indigenas" type="number" class="form-control" min="0" value="0"></div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Otras etnias:</p></div>
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Otras_Etnias" type="number" class="form-control" min="0" value="0"></div>
					</div>

					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<p style="text-align:center"><strong>Beneficiarios según estrato:</strong></p>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Estrato 1:</p></div>
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Estrato_Uno" type="number" class="form-control" min="0" value="0"></div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Estrato 2:</p></div>
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Estrato_Dos" type="number" class="form-control" min="0" value="0"></div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Estrato 3:</p></div>
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Estrato_Tres" type="number" class="form-control" min="0" value="0"></div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Estrato 4:</p></div>
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Estrato_Cuatro" type="number" class="form-control" min="0" value="0"></div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Estrato 5:</p></div>
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Estrato_Cinco" type="number" class="form-control" min="0" value="0"></div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><p style="text-align:right">Estrato 6:</p></div>
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><input id="BH_Estrato_Seis" type="number" class="form-control" min="0" value="0"></div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					<button type="button" class="btn btn-primary" id="capturar_beneficiarios">Guardar Beneficiarios</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<div class="modal fade" id="modal_folios" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">Indique los Folios correspondientes</h4>
				</div>
				<div id="modal_body" class="modal-body">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					<button type="button" class="btn btn-primary" id="capturar_folios">Guardar Folios</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<div class="modal fade" id="modal_guardado_informe_gestion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">Opción de Guardado</h4>
				</div>
				<div id="modal_body" class="modal-body">
					<h3>Ahora podrá ir guardando el informe de gestión progresivamente hasta terminarlo, cada uno de los borradores irán quedando en la pestaña CONSULTA DE FORMATOS, dentro de los cuales podrá indicar cual es el que está COMPLETADO con el botón de la útlima columna (SI/NO), esto con el fin de identificar cuales deben ser revisados por el componente administrativo.</h3>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	</html>
<?php }  ?>
