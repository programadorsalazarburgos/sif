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
					<h1>Caracterizaci??n de Grupos <small>Artista Formador</small></h1>
				</div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item " ><a class="nav-link" data-toggle="tab" href="#caracterizacion" role="tab" id="a_caracterizacion">Nueva Caracterizaci??n</a></li>
					<!-- <li class="nav-item active"><a class="nav-link" data-toggle="tab" href="#documento" role="tab">Informe Detallado</a></li> -->
					<li class="nav-item  active"><a class="nav-link" data-toggle="tab" href="#listado" id="a_listado" role="tab">Listado</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane" id="caracterizacion" role="tabpanel">
						<div class="panel-body panel-success">
							<div class="col-md-12" style="text-align: center; border-style: ridge; padding-top: 10px; background-color: rgb(210,210,210);">
								<p>
									<b>FICHA DE CARACTERIZACI??N ??? PROCESO DE FORMACI??N ART??STICA</b>
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
									<button id="BT_CARGAR_DATOS" class="btn btn-success"><i class="fas fa-download"></i> CARGAR DATOS ??LTIMA CARACTERIZACI??N APROBADA</button>
								</div>
							</div>
							<br>
							<div id="DIV_FORM_CARACTERIZACION">
								<form id="FORM_CARACTERIZACION">
									<div id="FORM_CARACTERIZACION_CONTAINER">
										<div class="col-md-12">
											<div class="col-md-12" style="text-align: left; border-style: ridge;">
												<div class="col-md-8">
													<label id="nombre_formador">Formador: Aqu?? ir?? el nombre del FORMADOR</label>
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
													<select id="SL_TIPO_CARACTERIZACION" name="SL_TIPO_CARACTERIZACION" class="form-control select" required campo title="Seleccionar Tipo de Caracterizaci??n...">
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
												<p><label>1. AN??LISIS DE CONTEXTO (PARTICULARIDADES)</label></p>
												<p style="text-align: justify;">(Descripci??n de condiciones, situaciones o experiencias de vida significativas de los participantes que pueden afectar los procesos, es decir, aquellas cosas que no podemos obviar. Es importante tener en cuenta tanto aspectos positivos como negativos).</p>
												<div class="col-md-12">
													<textarea id="TXTA_PARTICULARIDADES" name="TXTA_PARTICULARIDADES" class="form-control required campo" rows="7" placeholder="Aqu?? el an??lisis de contexto del grupo"></textarea>
													<br>
												</div>
											</div>
											<div class="col-md-12" style="background-color: #eeeeee; border-style: ridge;">
												<p><label>2. Caracterizaci??n</label>
												</p>
												<p style="text-align: justify;"><b>2.1 Descripci??n general del grupo:</b><br>
													Para La L??nea de Arte en la Escuela:
													Breve rese??a del grupo que contenga los siguientes datos: Edades de los participantes, Ciclo de formaci??n al que pertenecen o si son multigrados, grupos de aceleraci??n, enuncie los grados.   Gustos espec??ficos, expectativas frente al centro de inter??s y los talleres seg??n el ??rea art??stica, que incluya territorio, nivel socioecon??mico, colegio, experiencias previas de formaci??n, o si no han tenido ninguna experiencia previa.<br>
													Para la L??nea de Impulso Colectivo:
													Breve rese??a del grupo que contenga los siguientes datos: Edades de los participantes y gustos espec??ficos, expectativas frente al proyecto art??stico, que incluya territorio, nivel socioecon??mico, experiencias previas de formaci??n, o si no han tenido ninguna experiencia previa.<br>
													Para la L??nea de Converge:
												Breve rese??a del grupo que contenga los siguientes datos: Edades de los participantes, comunidades, poblaciones espec??ficas y gustos espec??ficos, expectativas frente al proceso orientado por el ??rea y/o la entidad. Territorio, nivel socioecon??mico, condici??n social, experiencias con lo art??stico, o si no han tenido ninguna experiencia previa.</p>
												<div class="col-md-12">
													<textarea id="TXTA_DESCRIPCION_GRUPO" name="TXTA_DESCRIPCION_GRUPO" class="form-control required campo" rows="3" placeholder="Aqu?? la descripci??n del 2.1"></textarea>
													<br>
												</div>
												<p style="text-align: justify;"><b>2.2 Identificaci??n de intereses del grupo:</b><br>
													Para la L??nea de Arte en la Escuela.
													Tiene como objetivo dar cuenta de manera descriptiva los intereses de los ni??os, ni??as y adolescentes, relacionados con  ???Explorar, ir m??s all????, expandir posibilidades: se aprende a ser m??s exigente consigo mismo, a ser creativo, a intentar otras formas de trabajar y de pensar, de explorar y aprender de errores y accidentes.??? (Idartes, 2016, 77)<br>
													Para la L??nea de Impulso Colectivo.
													Identificaci??n de un tema (s), pregunta (s) de los integrantes del grupo, para la construcci??n de un proyecto art??stico.<br>
													Para la L??nea de Converge.
												Identificaci??n de un tema (s), pregunta (s) de los integrantes del grupo, para la construcci??n del proceso art??stico con diversa naturaleza, disciplinar, interdisciplinar o transdisciplinar.</p>
												<div class="col-md-12">
													<textarea id="TXTA_INTERESES" name="TXTA_INTERESES" class="form-control required campo" rows="3" placeholder="Aqu?? la descripci??n de intereses del grupo."></textarea>
													<br>
												</div>
												<p style="text-align: justify;"><b>2.3 Descripci??n del espacio:</b><br>
												El espacio en el que se ofrece la formaci??n cuenta con mesas para el desarrollo de las actividades, la luz es favorable, sin embargo en relaci??n a la cantidad de participantes ameritar??a pensar en otra ubicaci??n. Tiene aislamiento ac??stico y ventilaci??n adecuada.</p>
												<div class="col-md-12">
													<textarea id="TXTA_ESPACIO" name="TXTA_ESPACIO" class="form-control required campo" rows="3" placeholder="Aqu?? la descripci??n del lugar de trabajo del grupo."></textarea>
													<br>
												</div>	
											</div>
											<div class="col-md-12" style="background-color: #eeeeee; border-style: ridge;">
												<p><label>3. ASPECTOS DE CONVIVENCIA </label>
												</p>
												<p style="text-align: justify;">Identificar los aspectos de convivencia del grupo, din??micas de relaci??n, comunicaci??n asertiva o no, concertaciones y acuerdos de aula.<br> 
													Para la L??nea de Arte en la Escuela.
													Se refiere al componente socio-afectivo que corresponde a las orientaciones de la Secretar??a de Educaci??n. (Dimensi??n afectiva, corporal y relacional. Describir si es notoria o no la capacidad perceptiva, reflexiva, cooperativa, sentido de colectividad, integraci??n).<br>
													Para la L??nea de Emprende y Converge
												se refiere a la Dimensi??n afectiva, corporal y relacional. Describir si es notoria o no la capacidad perceptiva, reflexiva, cooperativa, sentido de colectividad, integraci??n.</p>
												<div class="col-md-12">
													<br>
													<textarea id="TXTA_CONVIVENCIA" name="TXTA_CONVIVENCIA" class="form-control required campo" rows="3" placeholder="Aqu?? la descripci??n de convivencia del grupo."></textarea>
													<br>
												</div>			
											</div>
											<div class="col-md-12" style="background-color: #eeeeee; border-style: ridge;">
												<p><label>4. OBSERVACIONES/RECOMENDACIONES</label></p>
												<p style="text-align: justify;">Aqu?? puede ingresar cualquier informaci??n adicional que considere pertinente respecto al grupo.</p>
												<div class="col-md-12">
													<textarea id="TXTA_OBSERVACIONES" name="TXTA_OBSERVACIONES" class="form-control campo" placeholder="Aqu?? las observaciones adicionales, este campo es opcional." rows="3"></textarea>
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
							A continuaci??n se encuentran las caracterizaci??nes realizadas para sus grupos.
						</div>
						<div class="col-lg-12 row" >
							<div class="table-responsive">
								<table id="table-listado-caracterizaciones" class="table table-hover " width="100%" style="width: 100%">
									<thead>
										<tr>
											<th>id</th>
											<th>Grupo</th>
											<th>L??nea de Atenci??n</th>
											<th>Tipo Caracterizaci??n</th>
											<th>Fecha de Registro/Edici??n</th>
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
				<h5 class="modal-title" id="exampleModalLongTitle">Formato de Caracterizaci??n</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="div_correcciones" name="div_correcciones" hidden>
					<div class="col-sm-12 col-md-12 col-lg-12">
						<div class="col-sm-6 col-md-6 col-lg-6 col-md-offset-3">
							<label>CORRECI??NES:</label>
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