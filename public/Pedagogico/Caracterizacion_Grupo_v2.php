<?php
session_start();
if(!isset($_SESSION["session_username"])) {
	header("location:index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<script src="../bower_components/fontawesome/svg-with-js/js/fontawesome-all.min.js" ></script>
	<link href="https://fonts.googleapis.com/css?family=Yatra One|BioRhyme|Righteous|Prompt" rel="stylesheet">
	<link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../css/material-desing.css">
	<script type="text/javascript" src="../bower_components/jquery/dist/jquery.min.js"></script>
	<script type="text/javascript" src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
	<script type="text/javascript" src="../js/bootbox.js"></script>
	<link href="../bower_components/summernote/dist/summernote.css" rel="stylesheet"> 
	<script src="../bower_components/summernote/dist/summernote.min.js"></script>          
	<script src="../bower_components/summernote/dist/lang/summernote-es-ES.js"></script>
	<script type="text/javascript" src="../js/funcionesGenerales.js?v=2019.05.27"></script>

	<script type="text/javascript" src="Js/Caracterizar_Grupo_v2.js?v=2019.11.13.0"></script>

	<link href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet"> 
	<link href="../bower_components/datatables.net-buttons-dt/css/buttons.dataTables.min.css" rel="stylesheet"> 
	<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script> 
	<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> 
	<script src="../bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script> 
	<script src="../bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
	<script src='../bower_components/pdfmake/build/pdfmake.js?v=2019.05.03.0'></script>
	<script src='../bower_components/pdfmake/build/vfs_fonts.js?v=2019.05.16.0'></script>
</head>
<style type="text/css">
	div{
		font-family: 'Prompt';
		font-size: 14px;
		font-weight: normal; 
	}
	textarea{
		resize: vertical;
	}
	@media only screen and (max-width: 767px) {

		label {
			font-size: 10px;
		}
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
	.modal-dialog {
		width: 90% !important;
	}
</style>
<body>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Caracterización de Grupos <small>Artista Formador</small></h1>
				</div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item " ><a class="nav-link" data-toggle="tab" href="#caracterizacion" role="tab" id="a_caracterizacion">Nueva Caracterización</a></li>
					<!-- <li class="nav-item active"><a class="nav-link" data-toggle="tab" href="#documento" role="tab">Informe Detallado</a></li> -->
					<li class="nav-item  active"><a class="nav-link" data-toggle="tab" href="#listado" id="a_listado" role="tab">Listado</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane" id="caracterizacion" role="tabpanel">
						<div class="panel-body panel-success">
							<div class="col-md-12" style="text-align: center; border-style: ridge; padding-top: 10px; background-color: rgb(210,210,210);">
								<p>
									<b>FICHA DE CARACTERIZACIÓN – PROCESO DE FORMACIÓN ARTÍSTICA</b>
								</p>
							</div><br><br><br>
							<div class="row">
								<div class="col-xs-2 col-md-2 col-md-offset-4" style="text-align: right;">
									<label for="SL_grupo">SELECCIONE EL GRUPO:</label>
								</div>
								<div class="col-xs-2 col-md-2">
									<select id="SL_grupo" class="form-control" required title="Seleccione un Grupo"></select>
								</div>
								<div class="col-xs-2 col-md-2" id="DIV_CARGAR_DATOS" hidden>
									<button id="BT_CARGAR_DATOS" class="btn btn-success"><i class="fas fa-download"></i> CARGAR DATOS ÚLTIMA CARACTERIZACIÓN APROBADA</button>
								</div>
							</div>
							<br>
							<div id="DIV_FORM_CARACTERIZACION">
								<form id="FORM_CARACTERIZACION">
									<div id="FORM_CARACTERIZACION_CONTAINER">
										<div class="col-md-12">
											<div class="col-md-12" style="text-align: left; border-style: ridge;">
												<div class="col-md-8">
													<label id="nombre_formador">Formador: Aquí irá el nombre del FORMADOR</label>
												</div>
												<div class="col-md-4">
													<label id="LB_Area_Artistica"></label>
												</div>
											</div>
											<div class="col-md-12" style="text-align: left; border-style: ridge;">
												<div class="col-md-8">
													<label id="LB_Linea_Atencion"></label>
												</div>
												<div class="col-md-4">
													<label id="LB_Clan"></label>
												</div>
											</div>
											<div class="col-md-12" style="text-align: left; border-style: ridge;">
												<div class="col-md-8">
													<label id="LB_Fecha_Inicio"></label>
												</div>
												<div class="col-md-4">
													<label id="id_del_grupo"></label>
												</div>
											</div>
											<div class="col-md-12" style="text-align: center; border-style: ridge;">
												<label id="LB_Lugar_Atencion"></label>
											</div>
											<div class="col-md-12" style="text-align: left; border-style: ridge;">
												<div class="col-md-6">
													<select id="SL_CICLO" name="SL_CICLO" class="form-control select" required title="Seleccionar CICLO...">
														<option value="0" data-subtext=" (Impulsa CREA/Converge CREA)">NO APLICA</option>
														<option value="1" data-subtext=" (Grados 1,2)">CICLO I (Grados 1,2)</option>
														<option value="2" data-subtext=" (Grados 3,4)">CICLO II (Grados 3,4)</option>
														<option value="3" data-subtext=" (Grados 5,6,7)">CICLO III (Grados 5,6,7)</option>
														<option value="4" data-subtext=" (Grados 8,9)">CICLO IV (Grados 8,9)</option>
													</select>	
												</div>
												<div class="col-md-6">
													<select id="SL_TIPO_CARACTERIZACION" name="SL_TIPO_CARACTERIZACION" class="form-control select" required campo title="Seleccionar Tipo de Caracterización...">
														<option value="INICIAL" >INICIAL</option>
														<option value="FINAL">FINAL</option>
													</select>
												</div>
											</div>
											<div class="col-md-12" style="text-align: left; border-style: ridge;">
												<div class="col-md-6">
													<label id="LB_Horario"></label>
												</div>
												<div class="col-md-6">
													<label id="LB_Promedio_Asistentes"></label>
												</div>
											</div>
											<div class="col-md-12" style="background-color: #eeeeee; border-style: ridge;">
												<p><label>1. ANÁLISIS DE CONTEXTO (PARTICULARIDADES)</label></p>
												<p style="text-align: justify;">(Descripción de condiciones, situaciones o experiencias de vida significativas de los participantes que pueden afectar los procesos, es decir, aquellas cosas que no podemos obviar. Es importante tener en cuenta tanto aspectos positivos como negativos).</p>
												<div class="col-md-12">
													<textarea id="TXTA_PARTICULARIDADES" name="TXTA_PARTICULARIDADES" class="form-control required campo" rows="7" placeholder="Aquí el análisis de contexto del grupo"></textarea>
													<br>
												</div>
											</div>
											<div class="col-md-12" style="background-color: #eeeeee; border-style: ridge;">
												<p><label>2. Caracterización</label>
												</p>
												<p style="text-align: justify;"><b>2.1 Descripción general del grupo:</b><br>
													Para La Línea de Arte en la Escuela:
													Breve reseña del grupo que contenga los siguientes datos: Edades de los participantes, Ciclo de formación al que pertenecen o si son multigrados, grupos de aceleración, enuncie los grados.   Gustos específicos, expectativas frente al centro de interés y los talleres según el área artística, que incluya territorio, nivel socioeconómico, colegio, experiencias previas de formación, o si no han tenido ninguna experiencia previa.<br>
													Para la Línea de Impulso Colectivo:
													Breve reseña del grupo que contenga los siguientes datos: Edades de los participantes y gustos específicos, expectativas frente al proyecto artístico, que incluya territorio, nivel socioeconómico, experiencias previas de formación, o si no han tenido ninguna experiencia previa.<br>
													Para la Línea de Converge:
												Breve reseña del grupo que contenga los siguientes datos: Edades de los participantes, comunidades, poblaciones específicas y gustos específicos, expectativas frente al proceso orientado por el área y/o la entidad. Territorio, nivel socioeconómico, condición social, experiencias con lo artístico, o si no han tenido ninguna experiencia previa.</p>
												<div class="col-md-12">
													<textarea id="TXTA_DESCRIPCION_GRUPO" name="TXTA_DESCRIPCION_GRUPO" class="form-control required campo" rows="3" placeholder="Aquí la descripción del 2.1"></textarea>
													<br>
												</div>
												<p style="text-align: justify;"><b>2.2 Identificación de intereses del grupo:</b><br>
													Para la Línea de Arte en la Escuela.
													Tiene como objetivo dar cuenta de manera descriptiva los intereses de los niños, niñas y adolescentes, relacionados con  “Explorar, ir más allá́, expandir posibilidades: se aprende a ser más exigente consigo mismo, a ser creativo, a intentar otras formas de trabajar y de pensar, de explorar y aprender de errores y accidentes.” (Idartes, 2016, 77)<br>
													Para la Línea de Impulso Colectivo.
													Identificación de un tema (s), pregunta (s) de los integrantes del grupo, para la construcción de un proyecto artístico.<br>
													Para la Línea de Converge.
												Identificación de un tema (s), pregunta (s) de los integrantes del grupo, para la construcción del proceso artístico con diversa naturaleza, disciplinar, interdisciplinar o transdisciplinar.</p>
												<div class="col-md-12">
													<textarea id="TXTA_INTERESES" name="TXTA_INTERESES" class="form-control required campo" rows="3" placeholder="Aquí la descripción de intereses del grupo."></textarea>
													<br>
												</div>
												<p style="text-align: justify;"><b>2.3 Descripción del espacio:</b><br>
												El espacio en el que se ofrece la formación cuenta con mesas para el desarrollo de las actividades, la luz es favorable, sin embargo en relación a la cantidad de participantes ameritaría pensar en otra ubicación. Tiene aislamiento acústico y ventilación adecuada.</p>
												<div class="col-md-12">
													<textarea id="TXTA_ESPACIO" name="TXTA_ESPACIO" class="form-control required campo" rows="3" placeholder="Aquí la descripción del lugar de trabajo del grupo."></textarea>
													<br>
												</div>	
											</div>
											<div class="col-md-12" style="background-color: #eeeeee; border-style: ridge;">
												<p><label>3. ASPECTOS DE CONVIVENCIA </label>
												</p>
												<p style="text-align: justify;">Identificar los aspectos de convivencia del grupo, dinámicas de relación, comunicación asertiva o no, concertaciones y acuerdos de aula.<br> 
													Para la Línea de Arte en la Escuela.
													Se refiere al componente socio-afectivo que corresponde a las orientaciones de la Secretaría de Educación. (Dimensión afectiva, corporal y relacional. Describir si es notoria o no la capacidad perceptiva, reflexiva, cooperativa, sentido de colectividad, integración).<br>
													Para la Línea de Emprende y Converge
												se refiere a la Dimensión afectiva, corporal y relacional. Describir si es notoria o no la capacidad perceptiva, reflexiva, cooperativa, sentido de colectividad, integración.</p>
												<div class="col-md-12">
													<br>
													<textarea id="TXTA_CONVIVENCIA" name="TXTA_CONVIVENCIA" class="form-control required campo" rows="3" placeholder="Aquí la descripción de convivencia del grupo."></textarea>
													<br>
												</div>			
											</div>
											<div class="col-md-12" style="background-color: #eeeeee; border-style: ridge;">
												<p><label>4. OBSERVACIONES/RECOMENDACIONES</label></p>
												<p style="text-align: justify;">Aquí puede ingresar cualquier información adicional que considere pertinente respecto al grupo.</p>
												<div class="col-md-12">
													<textarea id="TXTA_OBSERVACIONES" name="TXTA_OBSERVACIONES" class="form-control campo" placeholder="Aquí las observaciones adicionales, este campo es opcional." rows="3"></textarea>
													<br>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group text-center row">
										<div class="">
											<div class="col-lg-offset-4 col-lg-1 col-md-offset-4 col-md-1 col-sm-offset-4 col-sm-1 text-left">
											</div>
											<div class="col-lg-2 col-md-2 col-sm-2 text-left">
												<div style="margin-top: 8px; margin-left: 50px;" class="material-switch pull-left" data-toggle='tooltip' title="Finalizado / Sin Finalizar" data-placement="bottom" >
													<input  id="input-finalizado-1" name="input-finalizado-1"  class="checkState" type="checkbox"/>
													<label for="input-finalizado-1" class="label-success"></label>
												</div>
												<label style="margin-top: 8px" class="col-lg-6 text-left" id="label-state-finalizado-1">Sin Finalizar</label>
											</div>
											<div class="col-lg-5 col-md-5 col-sm-5 text-left">
												<button id="submit-caracterizacion" type="submit" class="btn btn-success  btn-lg">Guardar</button>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="tab-pane active" id="listado" role="tabpanel">
						<div class="alert alert-dismissible alert-info">
							A continuación se encuentran las caracterizaciónes realizadas para sus grupos.
						</div>
						<div class="col-lg-12 row" >
							<div class="table-responsive">
								<table id="table-listado-caracterizaciones" class="table table-hover " width="100%" style="width: 100%">
									<thead>
										<tr>
											<th>id</th>
											<th>Grupo</th>
											<th>Línea de Atención</th>
											<th>Tipo Caracterización</th>
											<th>Fecha de Registro/Edición</th>
											<th>Estado</th>
										</tr>
									</thead>
								</table>  
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</body>
<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Formato de Caracterización</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="div_correcciones" name="div_correcciones" hidden>
					<div class="col-sm-12 col-md-12 col-lg-12">
						<div class="col-sm-6 col-md-6 col-lg-6 col-md-offset-3">
							<label>CORRECIÓNES:</label>
						</div>
					</div>
					<div class="col-sm-12 col-md-12 col-lg-12">
						<div class="col-sm-6 col-md-6 col-lg-6 col-md-offset-3">
							<textarea id="TXTA_REVISION" name="TXTA_REVISION" rows="5">

							</textarea>
						</div>
					</div>
				</div>
				<form id="FORM_CARACTERIZACION_EDITAR">
					
				</form>
			</div>
			<div class="modal-footer">
				<div class="modal-footer">
				</div>
			</div>
		</div>
	</div>
</div>
</html>