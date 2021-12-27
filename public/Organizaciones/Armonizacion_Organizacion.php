<?php
//header('charset=utf-8');
session_start();
if(!isset($_SESSION["session_username"])) {
	header("location:index.php");

} else { 
$Id_Persona = $_SESSION["session_username"]; //
$Id_Rol =	$_SESSION['session_usertype'];
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="../bootstrap/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/Siclan.css" rel="stylesheet">

	<link href="https://fonts.googleapis.com/css?family=Yatra One|BioRhyme|Righteous|Prompt" rel="stylesheet">
	<link href="../bootstrap/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
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
	<script src="../LibreriasExternas/bootstrap-toggle/bootstrap-toggle.min.js"></script>
	<link href="../LibreriasExternas/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">
	<script src="../LibreriasExternas/datatables/media/js/jquery.dataTables.min.js"></script>
	<script src="../LibreriasExternas/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
	<script src='../LibreriasExternas/pdfmake/pdfmake.min.js'></script>
	<script src='../LibreriasExternas/pdfmake/vfs_fonts.js'></script>

	<script type="text/javascript" src="Js/Armonizacion_Organizacion.js?v=2020.09.30.0"></script>

	<link href="../LibreriasExternas/summernote/summernote.css" rel="stylesheet">
	<script src="../LibreriasExternas/summernote/summernote.min.js"></script>
	<script src="../LibreriasExternas/summernote/lang/summernote-es-ES.js"></script>
</head>
<style type="text/css">
.row-margin-none{
	margin-right: 0;
	margin-left: 0;
}
</style>
<body>
	<div class="container-fluid" style="padding-top: 30px">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-header">
					<h1 style="font-size: 45px;">Armonización<small  style="font-size: 20px;">.</small></h1>
					<input type='hidden' id='id_usuario' value='<?php echo $Id_Persona; ?>'> 
					<input type='hidden' id='id_rol' value='<?php echo $Id_Rol; ?>'> 
				</div>
			</div>
			<div class="panel-body">
				<div class="container">
					<ul class="nav nav-tabs">
						<!-- <li class="active"><a data-toggle="tab" href="#form">Formulario</a></li> -->
						<li><a data-toggle="tab" href="#consulta" id="enlace-consulta">Armonizaciones Formulario</a></li>
						<li class="active"><a data-toggle="tab" href="#armonizacion" id="enlace-consulta-archivos">Armonizaciones Archivos</a></li>
					</ul>
					<div class="col-xs-12 col-md-12">
						<div class="col-xs-6 col-md-6">
							<select id="SL_Convenios_Organizacion" class="form-control selectpicker" required>
								<option value="">Seleccione el Convenio</option>
							</select>
						</div>
					</div>
					<div class="tab-content">
						<div id="form" class="tab-pane fade in">
							<form id="FORM_Preguntas" name="FORM_Preguntas" enctype="multipart/form-data">
								<div class="form-group ">
									<div class="form-group " id="contenedor_anexos">
										<br>
										<div class="row form-group col-md-offset-1 col-md-10 ">
											<div class="col-md-12">
												<br>
												<label>
													A partir de la relación con el equipo de gestión territorial, ¿cómo se ha fortalecido la armonización con las IEDS que tiene a su cargo?
												</label>
												<br>
												<small>
													<ul>
														<li>Señale logros en la armonización:</li>
														<li>Señale problemáticas de la armonización</li>
														<li>Señale posibles soluciones:</li>
													</ul>
												</small>
											</div>
											<div class="col-md-12">
												<br>
												<textarea class="form-control" rows="3"  type="" id="TX_pregunta_1" name="TX_pregunta_1" placeholder="" required></textarea>

												<br>
											</div>
										</div>
										<div class="row form-group col-md-offset-1 col-md-10 ">
											<div class="col-md-12">
												<label>
													Describa los aportes que considera se construyeron en los seminarios AFA, para el fortalecimiento de su propuesta pedagógica y del trabajo adelantado en armonización.
												</label>
											</div>
											<div class="col-md-12">
												<br>
												<textarea class="form-control" rows="3"  type="" id="TX_pregunta_2" name="TX_pregunta_2" placeholder="" required></textarea>

												<br>
											</div>
										</div>
										<div class="row form-group col-md-offset-1 col-md-10 ">
											<div class="col-md-12">
												<label>
													¿Cómo se visibilizan estos aportes en su trabajo con cada una de las IEDS a su cargo?
												</label>
											</div>
											<div class="col-md-12">
												<br>
												<textarea class="form-control" rows="3"  type="" id="TX_pregunta_3" name="TX_pregunta_3" placeholder="" required></textarea>

												<br>
											</div>
										</div>
										<div class="row form-group col-md-offset-1 col-md-10 ">
											<div class="col-md-12">
												<label>
													¿Qué aciertos y desaciertos han surgido a partir de la articulación de los PEI de las IEDS y los lineamientos pedagógicos y metodológicos del programa CREA?
												</label>
												<br>
												<small></small>
											</div>
											<div class="col-md-12">
												<br>
												<textarea class="form-control" rows="3"  type="" id="TX_pregunta_4" name="TX_pregunta_4" placeholder="" required></textarea>

												<br>
											</div>
										</div>
										<div class="row form-group col-md-offset-1 col-md-10 ">
											<div class="col-md-12">
												<label>
													¿De qué manera sus contenidos disciplinares le están aportando a las niñas, niños y jóvenes en la construcción del ser?
												</label>
												<br>
												<small></small>
											</div>
											<div class="col-md-12">
												<br>
												<textarea class="form-control" rows="3"  type="" id="TX_pregunta_5" name="TX_pregunta_5" placeholder="" required></textarea>

												<br>
											</div>
										</div>
										<div class="row form-group col-md-offset-1 col-md-10 ">
											<div class="col-md-12">
												<label>
													Describa algunas experiencias significativas que considere relevantes para el Programa, en perspectiva de armonización o articulación.
												</label>
												<br>
												<small></small>
											</div>
											<div class="col-md-12">
												<br>
												<textarea class="form-control" rows="3"  type="" id="TX_pregunta_6" name="TX_pregunta_6" placeholder="" required></textarea>

												<br>
											</div>
										</div>																														
									</div>
								</div>
								<div class="text-center row col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<button type="submit" class="btn btn-success btn-lg" id="enviar_formulario">Enviar</button>
								</div>
							</form>
						</div>
						<div id="consulta" class="tab-pane fade in">
							<div class="row">
								<div class="col-xs-12 col-md-12 text-center bg-primary">
									<h4>CONSULTAR ARMONIZACIONES<small><font style="color:#fff"></font></small></h4>
								</div>
								<div class="col-xs-6 col-md-6">
									<select id="SL_Year" title="Seleccione el Año" class="form-control">
										<option>Seleccione el año</option>
										<option value="2017">Año 2017</option>
										<option value="2018">Año 2018</option>
									</select>
								</div>
								<div class="col-xs-6 col-md-6">
									<select id="SL_Organizacion" title="Seleccione la Organización" class="form-control">
										<option value="">Seleccione la Organización</option>
									</select>
								</div>
								<div class="col-xs-12 col-md-12">
									<br>
									<table id="tabla_armonizaciones" class="table table-hover" style="text-align: center">
										<br><caption style="text-align: center; font-size: 20px;">ARMONIZACIONES</caption>
										<thead>
											<th>Fecha de Envío</th>
											<th>DESCARGA DEL PDF</th>
											<th>Observar</th>
											<th>Estado</th>										
										</thead>
										<tbody id="body_armonizaciones">

										</tbody>
									</table>
								</div>	
							</div>
						</div>
						<div id="armonizacion" class="tab-pane fade in active">
							<div class="row"><br>
								<div class="col-xs-12 col-md-12">
									Descargar plantilla <span class="fa fa-arrow-right"></span> <a href="../Organizaciones/templates/BALANCE DE ARTICULACIÓN ORGANIZACIONES 2018- V1 PLANTILLA.docx" id="DOWNLOAD_PLANTILLA" download><img src="../imagenes/wordicon.png" height="70"></a>
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
														<input id="archivo_1" name="file[]" type="file" class="filestyle" data-buttonName="btn-primary" data-buttonBefore="true" runat="server" data-buttonText="&nbsp Armonización" required>
													</div>
													<button type="submit" class="btn btn-success btn-md" id="enviar_documentos">Enviar</button>
													<div class="alert alert-danger hidden">
														<strong><span class="fa fa-exclamation-triangle"></span></strong> Para enviar nuevas armonizaciones es necesario que diligencie el SEGUIMIENTO A LA PROPUESTA primeramente.<br>
													</div>
												</div>
											</div>
										</div>
									</form>
								</div>
								<div class="col-xs-12 col-md-12 text-center bg-primary">
									<h4>CONSULTAR ARMONIZACIONES<small><font style="color:#fff"></font></small></h4>
								</div>
								<div class="col-xs-6 col-md-6">
									<select id="SL_Year_Archivos" title="Seleccione el Año" class="form-control">
										<option>Seleccione el año del convenio</option>
										<option value="2017">Convenios 2017</option>
										<option value="2018">Convenios 2018</option>
										<option value="2019">Convenios 2019</option>
									</select>
								</div>
								<div class="col-xs-6 col-md-6">
									<select id="SL_Organizacion_Archivos" name="SL_Organizacion_Archivos" title="Seleccione la Organización" class="form-control">
										<option value="">Seleccione la Organización</option>
									</select>
								</div>
								<div class="col-xs-12 col-md-12">
									<br>
									<table id="tabla_archivos_armonizaciones" class="table table-hover" style="text-align: center">
										<br><caption style="text-align: center; font-size: 20px;">ARMONIZACIONES</caption>
										<thead>
											<th>NOMBRE</th>
											<th>TIPO ARCHIVO</th>
											<th>FECHA DE SUBIDA</th>
											<th>MES/AÑO</th>
											<th>DESCARGA</th>
											<th>REVISIÓN</th>
											<th>OBSERVACIONES</th>
											<th>FINAL</th>
										</thead>
										<tbody id="body_archivos">

										</tbody>
									</table>
								</div>	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

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
						<textarea id="TXA_Observacion_Armonizacion" name="TXA_Observacion_Armonizacion" class="form-control" rows="5" placeholder="Alguna observación Aquí"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12" style="text-align: right;">
						<br>
						<p>Aprobación							<input data-toggle="toggle" data-onstyle="success" id="IN_Aprobacion" name= "IN_Aprobacion" data-offstyle="danger" data-on="SI" data-off="NO" type="checkbox" class="estado_check"></p>
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
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modal_titulo_observacion_archivo"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="text-align: justify;">
				<div class="row">
					<div class="col-md-12">
						<p id="P_Observacion_archivo"></p>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="MODAL_REVISION_ARCHIVOS">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modal_titulo_archivos"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="text-align: justify;">
				<div class="row">
					<div class="col-md-12">
						<p>Ingrese alguna observación</p>		
						<textarea id="TXA_Observacion_Archivo_Armonizacion" name="TXA_Observacion_Archivo_Armonizacion" class="form-control" rows="5" placeholder="Alguna observación Aquí"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12" style="text-align: right;">
						<br>
						<p>Aprobación							<input data-toggle="toggle" data-onstyle="success" id="IN_Aprobacion_Archivo" name= "IN_Aprobacion_Archivo" data-offstyle="danger" data-on="SI" data-off="NO" type="checkbox" class="estado_check"></p>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="BT_Guardar_Observacion_Archivo">GUARDAR</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
</html>
<?php }  ?>