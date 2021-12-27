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
	<script type="text/javascript" src="../js/funcionesGenerales.js?v=2019.05.21.0"></script>

	<link href="../bower_components/summernote/dist/summernote.css" rel="stylesheet"> 
	<script src="../bower_components/summernote/dist/summernote.min.js"></script>          
	<script src="../bower_components/summernote/dist/lang/summernote-es-ES.js"></script>

	<script type="text/javascript" src="Js/Revision_Formatos_Pedagogicos.js?v=2020.02.10.0"></script>

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
	.cell-input{
		border-left: none !important;
		height: 10px !important;
		padding: 0px !important;
	}
</style>
<body>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Revisión Formatos Pedagógicos <small>Caracterización/Planeación/Valoración</small></h1>
				</div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item  active"><a class="nav-link" data-toggle="tab" href="#listado" id="a_listado" role="tab">Consulta Formatos</a></li>
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
							</div>
							<br>

							<div id="DIV_FORM_PLANEACION_AE">
								<form id="FORM_PLANEACION_AE" hidden>
									<div id="FORM_PLANEACION_AE_CONTAINER">
										<div class="col-md-12">
											<table class="table table-bordered" style="border-color: black;margin-bottom: 0px !important;">
												<tbody>										
													<tr>
														<td colspan="8" class="text-center contenedor"><b>FORMATO DE PLANEACIÓN “ARTE EN LA ESCUELA Y LA CIUDAD”</b></td>
													</tr>
													<tr>
														<td width="20%" colspan="2" class="contenedor"><b>Línea de Atención</b></td>
														<td width="30%" colspan="3"><span id="LB_Linea_Atencion"></span></td>
														<td width="20%"	class="contenedor"><b>Lugar de Atención</b></td>
														<td width="30%" colspan="2"><span id="LB_Lugar_Atencion"></span></td>
													</tr>
													<tr>
														<td width="20%" colspan="2"class="contenedor"><b>Artista formador(a)</b></td>
														<td width="20%" colspan="2"><span id="LB_Formador"></span></td>
														<td width="10%" class="contenedor"><b>Área artística</b></td>
														<td width="20%"	><span id="LB_Area_Artistica"></span></td>
														<td width="10%"	class="contenedor"><b>Crea al que pertenece</b></td>
														<td width="20%" ><span id="LB_Clan"></span></td>
													</tr>
													<tr>
														<td width="10%" class="contenedor"><b>IDARTES</b></td>
														<td width="10%" ><span id="LB_Idartes"></span></td>
														<td width="10%" class="contenedor"><b>Organización</b></td>
														<td width="10%" ><span id="LB_Organizacion"></span></td>
														<td width="10%" class="contenedor"><b>Horario de grupo</b></td>
														<td width="20%"	><span id="LB_Horario"></span></td>
														<td width="10%"	class="contenedor"><b>Código del grupo</b></td>
														<td width="20%" ><span id="id_del_grupo"></span></td>
													</tr>
													<tr>
														<td width="20%" colspan="2"><b>Ciclo/ Momento/ Multigrado/ Aceleración</b></td>
														<td width="10%" >
															<select id="SL_CICLO" name="SL_CICLO" class="form-control required campo"  title="Seleccione">
																<option value="0" >NO APLICA
																</option>
																<option value="1" data-subtext=" (Grados 1,2)">CICLO I
																</option>
																<option value="2" data-subtext=" (Grados 3,4)">CICLO II
																</option>
																<option value="3" data-subtext=" (Grados 5,6,7)">CICLO III
																</option>
																<option value="4" data-subtext=" Grados (8,9)">CICLO IV
																</option>
															</select>
														</td>
														<td width="20%" colspan="2" class="contenedor"><b>Nombre de la IED</b></td>
														<td width="50%" colspan="3"><span id="LB_Colegio"></span></td>
													</tr>
													<tr>
														<td width="20%" colspan="2"	class="contenedor"><b>Fecha de elaboración</b></td>
														<td width="80%" colspan="6"><span id="LB_Fecha_Elaboracion"></span></td>
													</tr>
												</tbody>
											</table>
											<div class="col-md-12 contenedor-form">
												<br>
												<label class="control-label">OBJETIVO DE FORMACIÓN/ PROYECTO/ PROCESO</label>
												<div class="col-md-12">
													<textarea id="TX_OBJETO" name="TX_OBJETO" class="form-control required campo" rows="7" placeholder="Objetivo de la formación"></textarea>
													<br>
												</div>
											</div>											
											<div class="col-md-12 contenedor-form">
												<br>
												<label>PREGUNTA ORIENTADORA</label>
												<div class="col-md-12">
													<textarea id="TX_PREGUNTA_ORIENTADORA" name="TX_PREGUNTA_ORIENTADORA" class="form-control required campo" rows="3" placeholder="Pregunta Orientadora"></textarea>
													<br>
												</div>
											</div>
											<div class="col-md-12 contenedor-form">
												<br>
												<label>BREVE DESCRIPCIÓN DEL PROYECTO/ PROCESO ARTÍSTICO</label>
												<br>
												<div class="col-md-12">
													<button id="BTN_EJEMPLO_1" type="button" class="btn btn-sm btn-danger" title="Ver Ejemplo" data-toggle="modal" data-target="#EJEMPLO_1"><span href="#" style="font-family: 'Prompt';">Ver Ejemplo</span></button>
												</div>
												<div class="col-md-12">
													<br>
													<textarea id="TX_DESCRIPCION" name="TX_DESCRIPCION" class="form-control required campo" rows="3" placeholder="DESCRIPCIÓN DEL PROYECTO/ PROCESO ARTÍSTICO"></textarea>
													<br>
												</div>
											</div>
											<div class="col-md-12 contenedor-form">
												<br>
												<label>METODOLOGÍA</label>
												<div class="col-md-12" style="min-height: 50px;">
													<select id="SL_METODOLOGIA" name="SL_METODOLOGIA" class="form-control required campo"  title="Seleccione">
													</select>
												</div>
											</div>
											<div class="col-md-12 contenedor-form">
												<br>
												<label>TEMAS PROPUESTOS</label>
												<br>
												<div class="col-md-12">
													<button type="button" class="btn btn-sm btn-danger" title="Ver Ejemplo" data-toggle="modal" data-target="#EJEMPLO_2"><span href="#" style="font-family: 'Prompt';">Ver Ejemplo</span></button>
												</div>
												<div class="col-md-12">
													<br>
													<textarea id="TX_TEMAS_PROPUESTOS" name="TX_TEMAS_PROPUESTOS" class="form-control required campo" rows="3" placeholder="TEMAS PROPUESTOS"></textarea>
													<br>
												</div>
											</div>
											<div class="col-md-12 contenedor-form" >
												<br>
												<p>
													<label>
														RECURSOS FUNGIBLES Y TECNOLÓGICOS
													</label>
												</p>
												<div class="col-md-12">
													<div class="row col-md-2">
														<label>Recursos:
														</label>
													</div>
													<div class="col-md-4">
														<select data-live-search="true" id="SL_RECURSOS" name="SL_RECURSOS" class="form-control required campo" title="Seleccione los Recursos" multiple >
														</select>
														<br>
													</div>
												</div>

												<div class="col-md-12">
													<div class="row col-md-2">
														<label>Otros (Opcional):
														</label>
													</div>
													<div class="col-md-5">
														<input id="TX_OTROS_RECURSOS" name="TX_OTROS_RECURSOS" class="form-control required campo" type="text" placeholder="Otros" maxlength="100">
													</div>
												</div>
												<div class="col-md-12"><br></div>
												<br>
											</div>
											<div class="col-md-12 contenedor-form" >
												<br>
												<p>
													<label>
														REFERENTES
													</label>

												</p>
												<div class="col-md-12">
													<button type="button" class="btn btn-sm btn-danger " title="Ver Ejemplo" data-toggle="modal" data-target="#EJEMPLO_3">
														<span href="#" style="font-family:'Prompt';">Ver Ejemplo
														</span>
													</button>
													<br>
												</div>
												<div class="col-md-12">
													<br>
													Incluir referentes con citación de referencias APA
												</div>

												<div class="col-md-12">
													<br>
													<div id="div-preguntas">
													</div>
													<div class="text-left">
														<a  href="#" id="a-add" class="btn btn-primary " Title="Agregar Referente" data-toggle='tooltip'  data-placement="right"><i class="fa fa-plus"></i></a>                                
													</div>
												</div>
												<div class="col-md-12"><br></div>
												<br>
											</div>
											<div class="col-md-12 contenedor-form" >
												<br>
												<p>
													<label>PROPUESTA DE CIRCULACIÓN (MUESTRAS LOCALES Y FINALES)
													</label>
												</p>
												<div class="col-md-12">
													<textarea class="form-control required campo" rows="7"  type="" id="TXT_Circulacion" name="TXT_Circulacion" placeholder="Aquí la propuesta de circulación." ></textarea>

													<br>
												</div>
											</div>
											<div class="col-md-12 contenedor-form" >
												<br>
												<p>
													<label>ACCIONES EN EL AULA
													</label>
												</p>
												<div class="col-md-12">
													<div class="panel-group" id="accordion">
														<div class="panel panel-default">
															<div class="panel-heading">
																<h4 class="panel-title">
																	<a class="mes" href="#mes1"><b>Mes 1</b>
																	</a>
																</h4>
															</div>
															<div id=" mes1">
																<br>
																<div class="form-group row" >
																	<label  for="TXT_acciones_mes_1"  class="col-lg-2 col-md-2 control-label text-right">Acciones
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_acciones_mes_1" name="TXT_acciones_mes_1" placeholder="Acciones Generales del Mes" type="text" rows="2"></textarea>
																	</div>  
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_1"  class="col-lg-2 col-md-2 control-label text-right">Semana 1
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_1" name="TXT_semana_1" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>  
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_2"  class="col-lg-2 col-md-2 control-label text-right">Semana 2
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_2" name="TXT_semana_2" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_3"  class="col-lg-2 col-md-2 control-label text-right">Semana 3
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_3" name="TXT_semana_3" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_4"  class="col-lg-2 col-md-2 control-label text-right">Semana 4
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_4" name="TXT_semana_4" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
															</div>
														</div>
														<div class="panel panel-default">
															<div class="panel-heading">
																<h4 class="panel-title">
																	<a data-toggle="collapse" data-parent="#accordion" class="mes" href="#mes2"><b>Mes 2</b>
																	</a>
																</h4>
															</div>
															<div id="mes2" class="panel-collapse mescollapse collapse">
																<br>

																<div class="form-group row" >
																	<label  for="TXT_acciones_mes_2"  class="col-lg-2 col-md-2 control-label text-right">Acciones
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_acciones_mes_2" name="TXT_acciones_mes_2" placeholder="Acciones Generales del Mes" type="text" rows="2"></textarea>
																	</div>  
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_5"  class="col-lg-2 col-md-2 control-label text-right"> Semana 1 
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_5" name="TXT_semana_5" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_6"  class="col-lg-2 col-md-2 control-label text-right"> Semana 2 
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_6" name="TXT_semana_6" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_7"  class="col-lg-2 col-md-2 control-label text-right"> Semana 3 
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_7" name="TXT_semana_7" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_8"  class="col-lg-2 col-md-2 control-label text-right"> Semana 4 
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_8" name="TXT_semana_8" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
															</div>
														</div>
														<div class="panel panel-default">
															<div class="panel-heading">
																<h4 class="panel-title">
																	<a data-toggle="collapse" data-parent="#accordion" class="mes" href="#mes3"><b>Mes 3</b>
																	</a>
																</h4>
															</div>
															<div id="mes3" class="panel-collapse mescollapse collapse">
																<br>

																<div class="form-group row" >
																	<label  for="TXT_acciones_mes_3"  class="col-lg-2 col-md-2 control-label text-right">Acciones
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_acciones_mes_3" name="TXT_acciones_mes_3" placeholder="Acciones Generales del Mes" type="text" rows="2"></textarea>
																	</div>  
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_9"  class="col-lg-2 col-md-2 control-label text-right"> Semana 1
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_9" name="TXT_semana_9" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_10"  class="col-lg-2 col-md-2 control-label text-right">Semana 2
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_10" name="TXT_semana_10" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_11"  class="col-lg-2 col-md-2 control-label text-right">Semana 3
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_11" name="TXT_semana_11" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_12"  class="col-lg-2 col-md-2 control-label text-right">Semana 4
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_12" name="TXT_semana_12" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
															</div>
														</div>
														<div class="panel panel-default">
															<div class="panel-heading">
																<h4 class="panel-title">
																	<a data-toggle="collapse" data-parent="#accordion" class="mes" href="#mes4"><b>Mes 4</b>
																	</a>
																</h4>
															</div>
															<div id="mes4" class="panel-collapse mescollapse collapse">
																<br>

																<div class="form-group row" >
																	<label  for="TXT_acciones_mes_4"  class="col-lg-2 col-md-2 control-label text-right">Acciones
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_acciones_mes_4" name="TXT_acciones_mes_4" placeholder="Acciones Generales del Mes" type="text" rows="2"></textarea>
																	</div>  
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_13"  class="col-lg-2 col-md-2 control-label text-right"> Semana 1
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_13" name="TXT_semana_13" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_14"  class="col-lg-2 col-md-2 control-label text-right">Semana 2
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_14" name="TXT_semana_14" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_15"  class="col-lg-2 col-md-2 control-label text-right">Semana 3
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_15" name="TXT_semana_15" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_16"  class="col-lg-2 col-md-2 control-label text-right">Semana 4
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_16" name="TXT_semana_16" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
															</div>
														</div>
														<div class="panel panel-default">
															<div class="panel-heading">
																<h4 class="panel-title">
																	<a data-toggle="collapse" data-parent="#accordion" class="mes" href="#mes5"><b>Mes 5</b>
																	</a>
																</h4>
															</div>
															<div id="mes5" class="panel-collapse mescollapse collapse">
																<br>

																<div class="form-group row" >
																	<label  for="TXT_acciones_mes_5"  class="col-lg-2 col-md-2 control-label text-right">Acciones
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_acciones_mes_5" name="TXT_acciones_mes_5" placeholder="Acciones Generales del Mes" type="text" rows="2"></textarea>
																	</div>  
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_17"  class="col-lg-2 col-md-2 control-label text-right"> Semana 1
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_17" name="TXT_semana_17" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_18"  class="col-lg-2 col-md-2 control-label text-right">Semana 2
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_18" name="TXT_semana_18" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_19"  class="col-lg-2 col-md-2 control-label text-right">Semana 3
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_19" name="TXT_semana_19" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_20"  class="col-lg-2 col-md-2 control-label text-right">Semana 4
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_20" name="TXT_semana_20" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
															</div>
														</div>
														<div class="panel panel-default">
															<div class="panel-heading">
																<h4 class="panel-title">
																	<a data-toggle="collapse" data-parent="#accordion" class="mes" href="#mes6"><b>Mes 6</b>
																	</a>
																</h4>
															</div>
															<div id="mes6" class="panel-collapse mescollapse collapse">
																<br>

																<div class="form-group row" >
																	<label  for="TXT_acciones_mes_6"  class="col-lg-2 col-md-2 control-label text-right">Acciones
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_acciones_mes_6" name="TXT_acciones_mes_6" placeholder="Acciones Generales del Mes" type="text" rows="2"></textarea>
																	</div>  
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_21"  class="col-lg-2 col-md-2 control-label text-right"> Semana 1
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_21" name="TXT_semana_21" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_22"  class="col-lg-2 col-md-2 control-label text-right">Semana 2
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_22" name="TXT_semana_22" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_23"  class="col-lg-2 col-md-2 control-label text-right">Semana 3
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_23" name="TXT_semana_23" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_24"  class="col-lg-2 col-md-2 control-label text-right">Semana 4
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_24" name="TXT_semana_24" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
															</div>
														</div>
														<div class="panel panel-default">
															<div class="panel-heading">
																<h4 class="panel-title">
																	<a data-toggle="collapse" data-parent="#accordion" class="mes" href="#mes7"><b>Mes 7</b>
																	</a>
																</h4>
															</div>
															<div id="mes7" class="panel-collapse mescollapse collapse">
																<br>

																<div class="form-group row" >
																	<label  for="TXT_acciones_mes_7"  class="col-lg-2 col-md-2 control-label text-right">Acciones
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_acciones_mes_7" name="TXT_acciones_mes_7" placeholder="Acciones Generales del Mes" type="text" rows="2"></textarea>
																	</div>  
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_25"  class="col-lg-2 col-md-2 control-label text-right"> Semana 1
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_25" name="TXT_semana_25" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_26"  class="col-lg-2 col-md-2 control-label text-right">Semana 2
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_26" name="TXT_semana_26" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_27"  class="col-lg-2 col-md-2 control-label text-right">Semana 3
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_27" name="TXT_semana_27" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_28"  class="col-lg-2 col-md-2 control-label text-right">Semana 4
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_28" name="TXT_semana_28" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
															</div>
														</div>
														<div class="panel panel-default">
															<div class="panel-heading">
																<h4 class="panel-title">
																	<a data-toggle="collapse" data-parent="#accordion" class="mes" href="#mes8"><b>Mes 8</b>
																	</a>
																</h4>
															</div>
															<div id="mes8" class="panel-collapse mescollapse collapse">
																<br>

																<div class="form-group row" >
																	<label  for="TXT_acciones_mes_8"  class="col-lg-2 col-md-2 control-label text-right">Acciones
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_acciones_mes_8" name="TXT_acciones_mes_8" placeholder="Acciones Generales del Mes" type="text" rows="2"></textarea>
																	</div>  
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_29"  class="col-lg-2 col-md-2 control-label text-right"> Semana 1
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_29" name="TXT_semana_29" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_30"  class="col-lg-2 col-md-2 control-label text-right">Semana 2
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_30" name="TXT_semana_30" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_31"  class="col-lg-2 col-md-2 control-label text-right">Semana 3
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_31" name="TXT_semana_31" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_32"  class="col-lg-2 col-md-2 control-label text-right">Semana 4
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_32" name="TXT_semana_32" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
															</div>
														</div>
														<div class="panel panel-default">
															<div class="panel-heading">
																<h4 class="panel-title">
																	<a data-toggle="collapse" data-parent="#accordion" class="mes" href="#mes9"><b>Mes 9</b>
																	</a>
																</h4>
															</div>
															<div id="mes9" class="panel-collapse mescollapse collapse">
																<br>

																<div class="form-group row" >
																	<label  for="TXT_acciones_mes_9"  class="col-lg-2 col-md-2 control-label text-right">Acciones
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_acciones_mes_9" name="TXT_acciones_mes_9" placeholder="Acciones Generales del Mes" type="text" rows="2"></textarea>
																	</div>  
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_33"  class="col-lg-2 col-md-2 control-label text-right"> Semana 1
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_33" name="TXT_semana_33" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_34"  class="col-lg-2 col-md-2 control-label text-right">Semana 2
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_34" name="TXT_semana_34" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_35"  class="col-lg-2 col-md-2 control-label text-right">Semana 3
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_35" name="TXT_semana_35" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_36"  class="col-lg-2 col-md-2 control-label text-right">Semana 4
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_36" name="TXT_semana_36" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
															</div>
														</div>
														<div class="panel panel-default">
															<div class="panel-heading">
																<h4 class="panel-title">
																	<a data-toggle="collapse" data-parent="#accordion" class="mes" href="#mes10"><b>Mes 10</b>
																	</a>
																</h4>
															</div>
															<div id="mes10" class="panel-collapse mescollapse collapse">
																<br>

																<div class="form-group row" >
																	<label  for="TXT_acciones_mes_10"  class="col-lg-2 col-md-2 control-label text-right">Acciones
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_acciones_mes_10" name="TXT_acciones_mes_10" placeholder="Acciones Generales del Mes" type="text" rows="2"></textarea>
																	</div>  
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_37"  class="col-lg-2 col-md-2 control-label text-right"> Semana 1
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_37" name="TXT_semana_37" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_38"  class="col-lg-2 col-md-2 control-label text-right">Semana 2
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_38" name="TXT_semana_38" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_39"  class="col-lg-2 col-md-2 control-label text-right">Semana 3
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_39" name="TXT_semana_39" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_40"  class="col-lg-2 col-md-2 control-label text-right">Semana 4
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_40" name="TXT_semana_40" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
															</div>
														</div>
														<div class="panel panel-default">
															<div class="panel-heading">
																<h4 class="panel-title">
																	<a data-toggle="collapse" data-parent="#accordion" class="mes" href="#mes11"><b>Mes 11</b>
																	</a>
																</h4>
															</div>
															<div id="mes11" class="panel-collapse mescollapse collapse">
																<br>

																<div class="form-group row" >
																	<label  for="TXT_acciones_mes_11"  class="col-lg-2 col-md-2 control-label text-right">Acciones
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_acciones_mes_11" name="TXT_acciones_mes_11" placeholder="Acciones Generales del Mes" type="text" rows="2"></textarea>
																	</div>  
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_41"  class="col-lg-2 col-md-2 control-label text-right"> Semana 1
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_41" name="TXT_semana_41" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_42"  class="col-lg-2 col-md-2 control-label text-right">Semana 2
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_42" name="TXT_semana_42" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_43"  class="col-lg-2 col-md-2 control-label text-right">Semana 3
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_43" name="TXT_semana_43" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_44"  class="col-lg-2 col-md-2 control-label text-right">Semana 4
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_44" name="TXT_semana_44" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
															</div>
														</div>
													</div> 
												</div>
											</div>
											<div class="col-md-12 contenedor-form" >
												<br>
												<p>
													<label>ARTICULACIÓN CON EL PROYECTO EDUCATIVO INSTITUCIONAL (PEI) Línea Arte en la Escuela
													</label>
												</p>

												<div class="col-md-12">
													<h6>(Para diligenciar este required campo debe solicitar información a su respectivo GPT/AF por IED)</h6>
												</div>
												<div class="col-md-12">
													<textarea class="form-control required campo" rows="7"  type="" id="TXT_Articulacion" name="TXT_Articulacion" placeholder="Aquí la propuesta de circulación."></textarea>

													<br>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group text-center row">
										<div class="">
											<div class="col-lg-offset-4 col-lg-1 col-md-offset-4 col-md-1 col-sm-offset-4 col-sm-1 text-left">
											</div>
											<div class="col-lg-2 col-md-2 col-sm-2 text-left" style="margin-top: 15px">
												<div style="margin-top: 15px; margin-left: 50px;" class="material-switch pull-left" data-toggle='tooltip' title="Finalizado / Sin Finalizar" data-placement="bottom" >
													<input  id="input-finalizado-1" name="input-finalizado-1"  class="checkState" type="checkbox"/>
													<label for="input-finalizado-1" class="label-success"></label>
												</div>
												<label style="margin-top: 15px" class="col-lg-6 text-left" id="label-state-finalizado-1">Sin Finalizar</label>
											</div>
											<div class="col-lg-5 col-md-5 col-sm-5 text-left" style="margin-top: 15px">
												<button id="submit-planeacion" type="submit" class="btn btn-success  btn-lg">Guardar</button>
											</div>
										</div>
									</div>
								</form>
								<form id="FORM_PLANEACION_EC_LC" hidden>
									<div id="FORM_PLANEACION_EC_LC_CONTAINER">
										<div class="col-md-12">
											<table class="table table-bordered" style="border-color: black;margin-bottom: 0px !important;">
												<tbody>										
													<tr>
														<td colspan="8" class="text-center contenedor"><b>FORMATO DE PROYECTO O PROCESO DE EMPRENDE Y CONVERGE PROPUESTA DE PRESENTACIÓN DE PROYECTO ARTÍSTICO-FORMATIVO</b></td>
													</tr>
													<tr>
														<td width="20%" class="contenedor"><b>Línea de Atención</b></td>
														<td width="30%" colspan="3"><span id="LB_Linea_Atencion"></span></td>
														<td width="20%"	class="contenedor"><b>Lugar de Atención</b></td>
														<td width="30%" colspan="2"><span id="LB_Lugar_Atencion"></span></td>
													</tr>
													<tr>
														<td width="10%" class="contenedor"><b>Artista formador(a)</b></td>
														<td width="10%" ><span id="LB_Formador"></span></td>
														<td width="10%" class="contenedor"><b>Área artística</b></td>
														<td width="10%" colspan="2"><span id="LB_Area_Artistica"></span></td>
														<td width="10%" class="contenedor"><b>Crea al que pertenece</b></td>
														<td width="10%" ><span id="LB_Clan"></span></td>
													</tr>
													<tr>
														<td width="10%" class="contenedor"><b>Horario de grupo</b></td>
														<td width="10%" colspan="4"><span id="LB_Horario"></span></td>
														<td width="10%" class="contenedor"><b>Código del grupo</b></td>
														<td width="10%" ><span id="id_del_grupo"></span></td>
													</tr>
													<tr>
														<td width="10%" colspan="7" class="contenedor"><center><b>Información para la Línea de Impulso Colectivo</b></center></td>
													</tr>
													<tr>
														<td width="10%" colspan="2" class="contenedor"><b>Nombre del proyecto artístico</b></td>
														<td width="10%" colspan="3" class="cell-input"><input style="width: 100%; height: 100%;" type="text" class="required campo" name="TX_NOMBRE_PROYECTO" id="TX_NOMBRE_PROYECTO" placeholder="Nombre del proyecto artístico"></td>
														<td width="10%" class="contenedor"><b>Manos a obra/ Súbete a la escena/ Grupo Metropolitano</b></td>
														<td width="10%"  class="cell-input"><input style="width: 100%; height: 100%;" type="text" class="required campo" name="TX_MANOS" id="TX_MANOS" placeholder="Manos a obra/ Súbete a la escena.."></td>
													</tr>
													<tr>
														<td width="10%" colspan="7" class="contenedor"><b><center>Información para la Línea de Impulso Colectivo</center></b></td>
													</tr>
													<tr>
														<td width="10%" colspan="7" class="contenedor"><b><center>Información para la Línea de Impulso Colectivo</center></b></td>
													</tr>
													<tr>
														<td width="10%" colspan="2" class="contenedor"><b>Tipo de población</b></td>
														<td width="10%" colspan="2" class="cell-input"><input style="width: 100%; height: 100%;" type="text" class="required campo" name="TX_TIPO_POBLACION" id="TX_TIPO_POBLACION" placeholder="Tipo de población"></td>
														<td width="10%" class="contenedor"><b>Entidad aliada</b></td>
														<td width="10%" colspan="2" class="cell-input"><input style="width: 100%; height: 100%;" type="text" class="required campo" name="TX_ENTIDAD_ALIADA" id="TX_ENTIDAD_ALIADA" placeholder="Entidad aliada"></td>
													</tr>
													<tr>
														<td width="10%" colspan="7" class="contenedor"><b><center>ESTRUCTURA DEL PROYECTO O PROCESO ARTÍSTICO</center></b></td>
													</tr>
												</tbody>
											</table>
											<div class="col-md-12 contenedor-form">
												<br>
												<label class="control-label">Propósito de la Entidad Aliada (Sólo para Converge):</label>
												<small><i>(Mencione de manera concreta cuál es el objetivo que tiene la entidad aliada para el desarrollo del proceso o proyecto. Esto lo debe brindar el orientador de Línea o GPT).</i></small><br>
												<div class="col-md-12">
													<textarea id="TX_PROPOSITO" name="TX_PROPOSITO" class="form-control required campo" rows="7" placeholder="Propósito de la Entidad Aliada (Sólo para Converge)"></textarea>
													<br>
												</div>
											</div>											
											<div class="col-md-12 contenedor-form">
												<br>
												<label class="control-label">Tipo de proyecto:</label>
												<small><i>(Emprende: proyecto de co-creación con la comunidad, proyecto de impacto en la comunidad, proyecto de producción de piezas simbólicas, Proyectos de investigación, Laboratorio: …).</i></small><br>
												<div class="col-md-12">
													<textarea id="TX_TIPO_PROYECTO" name="TX_TIPO_PROYECTO" class="form-control required campo" rows="3" placeholder="Tipo de proyecto"></textarea>
													<br>
												</div>
											</div>
											<div class="col-md-12 contenedor-form">
												<br>
												<label class="control-label">Justificación:</label>
												<small><i>(Debe tener correspondencia con la información de la caracterización. Es el por qué es importante el proyecto o proceso planteado).</i></small><br>
												<div class="col-md-12">
													<br>
													<textarea id="TX_JUSTIFICACION" name="TX_JUSTIFICACION" class="form-control required campo" rows="3" placeholder="Justificación"></textarea>
													<br>
												</div>
											</div>
											<div class="col-md-12 contenedor-form">
												<br>
												<label class="control-label">Descripción general del proyecto:</label>
												<small><i>(pensar un proyecto para desarrollar hasta 15 de nov. La descripción debe concreta, usar máximo 150 palabras).</i></small><br>
												<div class="col-md-12">
													<br>
													<textarea id="TX_DESCRIPCION" name="TX_DESCRIPCION" class="form-control required campo" rows="3" placeholder="Descripción general del proyecto"></textarea>
													<br>
												</div>
											</div>
											<div class="col-md-12 contenedor-form">
												<br>
												<label class="control-label">Objetivo general:</label>
												<small><i>(debe iniciar por un verbo en infinitivo, debe ser claro, concreto y coherente con el tiempo de desarrollo).</i></small><br>
												<div class="col-md-12">
													<br>
													<textarea id="TX_OBJETIVO_GENERAL" name="TX_OBJETIVO_GENERAL" class="form-control required campo" rows="3" placeholder="Objetivo general"></textarea>
													<br>
												</div>
											</div>
											<div class="col-md-12 contenedor-form">
												<br>
												<label class="control-label">Objetivos específicos:</label>
												<small><i>(Estos son acciones esenciales para alcanzar el objetivo general. Plantear mínimo tres o cuatro).</i></small><br>
												<div class="col-md-12">
													<br>
													<textarea id="TX_OBJETIVOS_ESPECIFICOS" name="TX_OBJETIVOS_ESPECIFICOS" class="form-control required campo" rows="3" placeholder="Objetivos específicos"></textarea>
													<br>
												</div>
											</div>
											<div class="col-md-12 contenedor-form">
												<br>
												<label class="control-label">Metodología:</label>
												<small><i>(Estos son acciones esenciales para alcanzar el objetivo general. Plantear mínimo tres o cuatro).</i></small><br>
												<div class="col-md-12">
													<br>
													<textarea id="TX_METODOLOGIA" name="TX_METODOLOGIA" class="form-control required campo" rows="3" placeholder="Metodología"></textarea>
													<br>
												</div>
											</div>
											<div class="col-md-12 contenedor-form">
												<br>
												<label class="control-label">Referentes conceptuales/teóricos/ visuales/ audiovisuales:</label>
												<small><i>(Explicar qué referentes fundamentales, importantes va usar para el desarrollo del proyecto. Organizarlos por: referentes conceptuales o teóricos. Referentes para la creación, referentes de otras áreas artísticas).</i></small><br>
												<div class="col-md-12">
													<br>
													<textarea id="TX_REFERENTES" name="TX_REFERENTES" class="form-control required campo" rows="3" placeholder="Referentes"></textarea>
													<br>
												</div>
											</div>
											<div class="col-md-12 contenedor-form">
												<br>
												<label class="control-label">Resultados esperados:</label>
												<small><i>(Enunciar de manera concreta qué espera del proceso y desarrollo del proyecto).</i></small><br>
												<div class="col-md-12">
													<br>
													<textarea id="TX_RESULTADOS" name="TX_RESULTADOS" class="form-control required campo" rows="3" placeholder="Resultados esperados"></textarea>
													<br>
												</div>
											</div>
											<div class="col-md-12 contenedor-form">
												<br>
												<label class="control-label">Criterios cualitativos de evaluación del proyecto:</label>
												<small><i>(criterios para Emprende Personal, disciplinar, colectivo y la relación con el sector. Y para la Línea de Laboratorio los criterios son: Percepción de sí mismo y de los otros, construcción d sentidos de vida en común, percepción del otro en la relación con la acciones o condiciones de vida propias [justicia social]).</i></small><br>
												<div class="col-md-12">
													<br>
													<textarea id="TX_CRITERIOS" name="TX_CRITERIOS" class="form-control required campo" rows="3" placeholder="Criterios cualitativos de evaluación del proyecto"></textarea>
													<br>
												</div>
											</div>
											<div class="col-md-12 contenedor-form">
												<br>
												<label class="control-label">Materiales / recursos:</label>
												<small><i>(Enunciar que materiales y recursos se van a gestionar para el desarrollo del proyecto).</i></small><br>
												<div class="col-md-12">
													<div class="col-md-4">
														<select data-live-search="true" id="SL_RECURSOS" name="SL_RECURSOS" class="form-control campo required" title="Seleccione los Recursos" multiple >
														</select>
														<br>
													</div>
												</div>

												<div class="col-md-12">
													<div class="row col-md-2">
														<label>Otros (Opcional):
														</label>
													</div>
													<div class="col-md-5">
														<input id="TX_OTROS_RECURSOS" name="TX_OTROS_RECURSOS" class="form-control" type="text" placeholder="Otros" maxlength="100">
													</div>
												</div>
												<div class="col-md-12"><br></div>
											</div>
											<div class="col-md-12 contenedor-form">
												<br>
												<label class="control-label">Planeador:</label>
												<small><i>(Indique el tipo de actividad macro, actividad micro y semanas de desarrollo).</i></small><br>
												<div class="col-md-12">
													<br>
													<textarea id="TX_PLANEADOR" name="TX_PLANEADOR" class="form-control required  campo" rows="3" placeholder="Planeador"></textarea>
													<br>
												</div>
											</div>
											<div class="col-md-12 contenedor-form" >
												<br>
												<div class="col-md-12">
													<div class="panel-group" id="accordion">
														<div class="panel panel-default">
															<div class="panel-heading">
																<h4 class="panel-title">
																	<a class="mes" href="#mes_1"><b>Mes 1</b>
																	</a>
																</h4>
															</div>
															<div id="mes_1">
																<br>
																<div class="form-group row" >
																	<label  for="TXT_acciones_mes_1"  class="col-lg-2 col-md-2 control-label text-right">(Enunciar las fases o momentos)
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_acciones_mes_1" name="TXT_acciones_mes_1" placeholder="Fases o momentos" type="text" rows="2"></textarea>
																	</div>  
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_1"  class="col-lg-2 col-md-2 control-label text-right">Semana 1
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_1" name="TXT_semana_1" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>  
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_2"  class="col-lg-2 col-md-2 control-label text-right">Semana 2
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_2" name="TXT_semana_2" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_3"  class="col-lg-2 col-md-2 control-label text-right">Semana 3
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_3" name="TXT_semana_3" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_4"  class="col-lg-2 col-md-2 control-label text-right">Semana 4
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_4" name="TXT_semana_4" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
															</div>
														</div>
														<div class="panel panel-default">
															<div class="panel-heading">
																<h4 class="panel-title">
																	<a data-toggle="collapse" data-parent="#accordion" class="mes" href="#mes_2"><b>Mes 2</b>
																	</a>
																</h4>
															</div>
															<div id="mes_2" class="panel-collapse mescollapse collapse">
																<br>

																<div class="form-group row" >
																	<label  for="TXT_acciones_mes_2"  class="col-lg-2 col-md-2 control-label text-right">(Enunciar las fases o momentos)
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_acciones_mes_2" name="TXT_acciones_mes_2" placeholder="Fases o momentos" type="text" rows="2"></textarea>
																	</div>  
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_5"  class="col-lg-2 col-md-2 control-label text-right"> Semana 1 
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_5" name="TXT_semana_5" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_6"  class="col-lg-2 col-md-2 control-label text-right"> Semana 2 
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_6" name="TXT_semana_6" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_7"  class="col-lg-2 col-md-2 control-label text-right"> Semana 3 
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_7" name="TXT_semana_7" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_8"  class="col-lg-2 col-md-2 control-label text-right"> Semana 4 
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_8" name="TXT_semana_8" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
															</div>
														</div>
														<div class="panel panel-default">
															<div class="panel-heading">
																<h4 class="panel-title">
																	<a data-toggle="collapse" data-parent="#accordion" class="mes" href="#mes_3"><b>Mes 3</b>
																	</a>
																</h4>
															</div>
															<div id="mes_3" class="panel-collapse mescollapse collapse">
																<br>

																<div class="form-group row" >
																	<label  for="TXT_acciones_mes_3"  class="col-lg-2 col-md-2 control-label text-right">(Enunciar las fases o momentos)
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_acciones_mes_3" name="TXT_acciones_mes_3" placeholder="Fases o momentos" type="text" rows="2"></textarea>
																	</div>  
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_9"  class="col-lg-2 col-md-2 control-label text-right"> Semana 1
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_9" name="TXT_semana_9" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_10"  class="col-lg-2 col-md-2 control-label text-right">Semana 2
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_10" name="TXT_semana_10" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_11"  class="col-lg-2 col-md-2 control-label text-right">Semana 3
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_11" name="TXT_semana_11" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_12"  class="col-lg-2 col-md-2 control-label text-right">Semana 4
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_12" name="TXT_semana_12" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
															</div>
														</div>
														<div class="panel panel-default">
															<div class="panel-heading">
																<h4 class="panel-title">
																	<a data-toggle="collapse" data-parent="#accordion" class="mes" href="#mes_4"><b>Mes 4</b>
																	</a>
																</h4>
															</div>
															<div id="mes_4" class="panel-collapse mescollapse collapse">
																<br>

																<div class="form-group row" >
																	<label  for="TXT_acciones_mes_4"  class="col-lg-2 col-md-2 control-label text-right">(Enunciar las fases o momentos)
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_acciones_mes_4" name="TXT_acciones_mes_4" placeholder="Fases o momentos" type="text" rows="2"></textarea>
																	</div>  
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_13"  class="col-lg-2 col-md-2 control-label text-right"> Semana 1
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_13" name="TXT_semana_13" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_14"  class="col-lg-2 col-md-2 control-label text-right">Semana 2
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_14" name="TXT_semana_14" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_15"  class="col-lg-2 col-md-2 control-label text-right">Semana 3
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_15" name="TXT_semana_15" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_16"  class="col-lg-2 col-md-2 control-label text-right">Semana 4
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_16" name="TXT_semana_16" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
															</div>
														</div>
														<div class="panel panel-default">
															<div class="panel-heading">
																<h4 class="panel-title">
																	<a data-toggle="collapse" data-parent="#accordion" class="mes" href="#mes_5"><b>Mes 5</b>
																	</a>
																</h4>
															</div>
															<div id="mes_5" class="panel-collapse mescollapse collapse">
																<br>

																<div class="form-group row" >
																	<label  for="TXT_acciones_mes_5"  class="col-lg-2 col-md-2 control-label text-right">(Enunciar las fases o momentos)
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_acciones_mes_5" name="TXT_acciones_mes_5" placeholder="Fases o momentos" type="text" rows="2"></textarea>
																	</div>  
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_17"  class="col-lg-2 col-md-2 control-label text-right"> Semana 1
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_17" name="TXT_semana_17" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_18"  class="col-lg-2 col-md-2 control-label text-right">Semana 2
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_18" name="TXT_semana_18" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_19"  class="col-lg-2 col-md-2 control-label text-right">Semana 3
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_19" name="TXT_semana_19" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_20"  class="col-lg-2 col-md-2 control-label text-right">Semana 4
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_20" name="TXT_semana_20" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
															</div>
														</div>
														<div class="panel panel-default">
															<div class="panel-heading">
																<h4 class="panel-title">
																	<a data-toggle="collapse" data-parent="#accordion" class="mes" href="#mes_6"><b>Mes 6</b>
																	</a>
																</h4>
															</div>
															<div id="mes_6" class="panel-collapse mescollapse collapse">
																<br>

																<div class="form-group row" >
																	<label  for="TXT_acciones_mes_6"  class="col-lg-2 col-md-2 control-label text-right">(Enunciar las fases o momentos)
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_acciones_mes_6" name="TXT_acciones_mes_6" placeholder="Fases o momentos" type="text" rows="2"></textarea>
																	</div>  
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_21"  class="col-lg-2 col-md-2 control-label text-right"> Semana 1
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_21" name="TXT_semana_21" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_22"  class="col-lg-2 col-md-2 control-label text-right">Semana 2
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_22" name="TXT_semana_22" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_23"  class="col-lg-2 col-md-2 control-label text-right">Semana 3
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_23" name="TXT_semana_23" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_24"  class="col-lg-2 col-md-2 control-label text-right">Semana 4
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_24" name="TXT_semana_24" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
															</div>
														</div>
														<div class="panel panel-default">
															<div class="panel-heading">
																<h4 class="panel-title">
																	<a data-toggle="collapse" data-parent="#accordion" class="mes" href="#mes_7"><b>Mes 7</b>
																	</a>
																</h4>
															</div>
															<div id="mes_7" class="panel-collapse mescollapse collapse">
																<br>

																<div class="form-group row" >
																	<label  for="TXT_acciones_mes_7"  class="col-lg-2 col-md-2 control-label text-right">(Enunciar las fases o momentos)
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_acciones_mes_7" name="TXT_acciones_mes_7" placeholder="Fases o momentos" type="text" rows="2"></textarea>
																	</div>  
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_25"  class="col-lg-2 col-md-2 control-label text-right"> Semana 1
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_25" name="TXT_semana_25" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_26"  class="col-lg-2 col-md-2 control-label text-right">Semana 2
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_26" name="TXT_semana_26" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_27"  class="col-lg-2 col-md-2 control-label text-right">Semana 3
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_27" name="TXT_semana_27" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_28"  class="col-lg-2 col-md-2 control-label text-right">Semana 4
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_28" name="TXT_semana_28" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
															</div>
														</div>
														<div class="panel panel-default">
															<div class="panel-heading">
																<h4 class="panel-title">
																	<a data-toggle="collapse" data-parent="#accordion" class="mes" href="#mes_8"><b>Mes 8</b>
																	</a>
																</h4>
															</div>
															<div id="mes_8" class="panel-collapse mescollapse collapse">
																<br>

																<div class="form-group row" >
																	<label  for="TXT_acciones_mes_8"  class="col-lg-2 col-md-2 control-label text-right">(Enunciar las fases o momentos)
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_acciones_mes_8" name="TXT_acciones_mes_8" placeholder="Fases o momentos" type="text" rows="2"></textarea>
																	</div>  
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_29"  class="col-lg-2 col-md-2 control-label text-right"> Semana 1
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_29" name="TXT_semana_29" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_30"  class="col-lg-2 col-md-2 control-label text-right">Semana 2
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_30" name="TXT_semana_30" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_31"  class="col-lg-2 col-md-2 control-label text-right">Semana 3
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_31" name="TXT_semana_31" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_32"  class="col-lg-2 col-md-2 control-label text-right">Semana 4
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_32" name="TXT_semana_32" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
															</div>
														</div>
														<div class="panel panel-default">
															<div class="panel-heading">
																<h4 class="panel-title">
																	<a data-toggle="collapse" data-parent="#accordion" class="mes" href="#mes_9"><b>Mes 9</b>
																	</a>
																</h4>
															</div>
															<div id="mes_9" class="panel-collapse mescollapse collapse">
																<br>

																<div class="form-group row" >
																	<label  for="TXT_acciones_mes_9"  class="col-lg-2 col-md-2 control-label text-right">(Enunciar las fases o momentos)
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_acciones_mes_9" name="TXT_acciones_mes_9" placeholder="Fases o momentos" type="text" rows="2"></textarea>
																	</div>  
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_33"  class="col-lg-2 col-md-2 control-label text-right"> Semana 1
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_33" name="TXT_semana_33" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_34"  class="col-lg-2 col-md-2 control-label text-right">Semana 2
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_34" name="TXT_semana_34" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_35"  class="col-lg-2 col-md-2 control-label text-right">Semana 3
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_35" name="TXT_semana_35" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_36"  class="col-lg-2 col-md-2 control-label text-right">Semana 4
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_36" name="TXT_semana_36" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
															</div>
														</div>
														<div class="panel panel-default">
															<div class="panel-heading">
																<h4 class="panel-title">
																	<a data-toggle="collapse" data-parent="#accordion" class="mes" href="#mes_10"><b>Mes 10</b>
																	</a>
																</h4>
															</div>
															<div id="mes_10" class="panel-collapse mescollapse collapse">
																<br>

																<div class="form-group row" >
																	<label  for="TXT_acciones_mes_10"  class="col-lg-2 col-md-2 control-label text-right">(Enunciar las fases o momentos)
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_acciones_mes_10" name="TXT_acciones_mes_10" placeholder="Fases o momentos" type="text" rows="2"></textarea>
																	</div>  
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_37"  class="col-lg-2 col-md-2 control-label text-right"> Semana 1
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_37" name="TXT_semana_37" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_38"  class="col-lg-2 col-md-2 control-label text-right">Semana 2
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_38" name="TXT_semana_38" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_39"  class="col-lg-2 col-md-2 control-label text-right">Semana 3
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_39" name="TXT_semana_39" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_40"  class="col-lg-2 col-md-2 control-label text-right">Semana 4
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_40" name="TXT_semana_40" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
															</div>
														</div>
														<div class="panel panel-default">
															<div class="panel-heading">
																<h4 class="panel-title">
																	<a data-toggle="collapse" data-parent="#accordion" class="mes" href="#mes_11"><b>Mes 11</b>
																	</a>
																</h4>
															</div>
															<div id="mes_11" class="panel-collapse mescollapse collapse">
																<br>

																<div class="form-group row" >
																	<label  for="TXT_acciones_mes_11"  class="col-lg-2 col-md-2 control-label text-right">(Enunciar las fases o momentos)
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_acciones_mes_11" name="TXT_acciones_mes_11" placeholder="Fases o momentos" type="text" rows="2"></textarea>
																	</div>  
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_41"  class="col-lg-2 col-md-2 control-label text-right"> Semana 1
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_41" name="TXT_semana_41" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_42"  class="col-lg-2 col-md-2 control-label text-right">Semana 2
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_42" name="TXT_semana_42" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_43"  class="col-lg-2 col-md-2 control-label text-right">Semana 3
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_43" name="TXT_semana_43" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
																<div class="form-group row" >
																	<label  for="TXT_semana_44"  class="col-lg-2 col-md-2 control-label text-right">Semana 4
																	</label>
																	<div class="col-lg-9 col-md-9"  >
																		<textarea class="form-control campo" id="TXT_semana_44" name="TXT_semana_44" placeholder="Acciones" type="text" rows="2"></textarea>
																	</div>
																</div>
															</div>
														</div>
													</div> 
												</div>
											</div>
										</div>
									</div>
									<div class="form-group text-center row">
										<div class="">
											<div class="col-lg-offset-4 col-lg-1 col-md-offset-4 col-md-1 col-sm-offset-4 col-sm-1 text-left">
											</div>
											<div class="col-lg-2 col-md-2 col-sm-2 text-left" style="margin-top: 15px">
												<div style="margin-top: 15px; margin-left: 50px;" class="material-switch pull-left" data-toggle='tooltip' title="Finalizado / Sin Finalizar" data-placement="bottom" >
													<input  id="input-finalizado-3" name="input-finalizado-3"  class="checkState" type="checkbox"/>
													<label for="input-finalizado-3" class="label-success"></label>
												</div>
												<label style="margin-top: 15px" class="col-lg-6 text-left" id="label-state-finalizado-3">Sin Finalizar</label>
											</div>
											<div class="col-lg-5 col-md-5 col-sm-5 text-left" style="margin-top: 15px">
												<button id="submit-planeacion-ec" type="submit" class="btn btn-success  btn-lg">Guardar</button>
											</div>
										</div>
									</div>
								</form>
							</div>
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
														<option value="1" data-subtext=" (Grados 1,2)">CICLO I</option>
														<option value="2" data-subtext=" (Grados 3,4)">CICLO II</option>
														<option value="3" data-subtext=" (Grados 5,6,7)">CICLO III</option>
														<option value="4" data-subtext=" (Grados 8,9)">CICLO IV</option>
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
							A continuación podrá consultar los formatos pedagógicos de los grupos que desee.
						</div>
						<div class="col-sm-12 col-md-12 col-lg-12" style="padding-top: 1%">
							<div class="col-sm-2 col-md-2 col-lg-2">
								<label>AÑO</label>
							</div>
							<div class="col-sm-4 col-md-4 col-lg-4">
								<select class="form-control selectpicker" data-live-search="true" id="SL_ANIO" name="SL_ANIO"></select>
							</div>
						</div>
						<div class="col-sm-12 col-md-12 col-lg-12" style="padding-top: 1%">
							<div class="col-sm-2 col-md-2 col-lg-2">
								<label>LÍNEA DE ATENCIÓN</label>
							</div>
							<div class="col-sm-4 col-md-4 col-lg-4">
								<select class="form-control selectpicker" data-live-search="true" id="SL_LINEA_ATENCION" name="SL_LINEA_ATENCION"></select>
							</div>
						</div>
						<div class="col-sm-12 col-md-12 col-lg-12" style="padding-top: 1%">
							<div class="col-sm-2 col-md-2 col-lg-2">
								<label>FORMATO PEDAGÓGICO</label>
							</div>
							<div class="col-sm-4 col-md-4 col-lg-4">
								<select class="form-control selectpicker" data-live-search="true" id="SL_FORMATO_PEDAGÓGICO" name="SL_FORMATO_PEDAGÓGICO"></select>
							</div>
						</div>
						<div class="col-sm-12 col-md-12 col-lg-12" style="padding-top: 1%">
							<div class="col-sm-4 col-md-4 col-lg-4">
								<button class="btn btn-success pull-right" id="BT_Consultar_Formatos" name="BT_Consultar_Formatos">CONSULTAR</button>
							</div>
						</div>
						<div class="col-lg-12 row" >
							<div class="table-responsive">
								<table id="table-listado-formatos-pedagogicos" class="table table-hover " width="100%" style="width: 100%">
									<thead>
										<tr>
											<th>id</th>
											<th>Grupo</th>
											<th>Área Artística</th>
											<th>Formador</th>
											<th>Tipo</th>
											<th>Fecha de Registro/Edición</th>
											<th>Estado</th>
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