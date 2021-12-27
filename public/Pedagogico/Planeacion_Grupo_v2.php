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
	<link href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet"> 
	<link href="../bower_components/datatables.net-buttons-dt/css/buttons.dataTables.min.css" rel="stylesheet"> 
	<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script> 
	<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> 
	<script src="../bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script> 
	<script src="../bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
	<script src='../bower_components/pdfmake/build/pdfmake.js?v=2019.05.03.0'></script>
	<script src='../bower_components/pdfmake/build/vfs_fonts.js?v=2019.05.03.0'></script>
	<script type="text/javascript" src="Js/Planeacion_Grupo_v2.js?v=2020.02.07.0"></script>
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
	.contenedor-form{
		background-color: #eeeeee; 
		border: 1px solid #a7a7a7;
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
	.modal-md {
		width: 60% !important;
	}
	.modal-lg {
		width: 90% !important;
	}
	@media only screen and (max-width: 767px) {
		label {
			font-size: 10px;
		}
	}
	.center-modal{
		top: 0%;
		margin-top: 15%;
	}
	.table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
		border: 1px solid #bdbdbd;
	}
	.contenedor{
		background-color: #eeeeee;
		border: 1px solid white;
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
					<h1>Planeación de Grupos <small>Artista Formador</small></h1>
				</div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item active" ><a class="nav-link" data-toggle="tab" href="#caracterizacion" role="tab" id="a_caracterizacion">Nueva Planeación</a></li>
					<!-- <li class="nav-item active"><a class="nav-link" data-toggle="tab" href="#documento" role="tab">Informe Detallado</a></li> -->
					<li class="nav-item  "><a class="nav-link" data-toggle="tab" href="#listado" id="a_listado" role="tab">Listado</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="caracterizacion" role="tabpanel">
						<div class="panel-body panel-success">
							<br><br><br>
							<div class="row">
								<div class="col-xs-2 col-md-2 col-md-offset-4" style="text-align: right;margin-top: 8px">
									<label for="SL_GRUPO" class="control-label">SELECCIONE EL GRUPO:</label>
								</div>
								<div class="col-xs-2 col-md-2">
									<select id="SL_GRUPO" class="form-control"  title="Seleccione un Grupo"></select>
								</div>
								<div class="col-xs-2 col-md-2" id="DIV_CARGAR_DATOS" hidden>
									<button id="BT_CARGAR_DATOS" class="btn btn-success"><i class="fas fa-download"></i> CARGAR DATOS ÚLTIMA PLANEACIÓN APROBADA</button>
								</div>
							</div>
							<br>
							<div id="DIV_FORM_PLANEACION_AE">
								<form id="FORM_PLANEACION_AE" hidden>
									<div id="FORM_PLANEACION_AE_CONTAINER" name="FORM_PLANEACION_AE_CONTAINER">
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
															<select id="SL_CICLO" name="SL_CICLO" class="form-control campo"  title="Seleccione">
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
													<textarea id="TX_OBJETO" name="TX_OBJETO" class="form-control campo" rows="7" placeholder="Objetivo de la formación"></textarea>
													<br>
												</div>
											</div>											
											<div class="col-md-12 contenedor-form">
												<br>
												<label>PREGUNTA ORIENTADORA</label>
												<div class="col-md-12">
													<textarea id="TX_PREGUNTA_ORIENTADORA" name="TX_PREGUNTA_ORIENTADORA" class="form-control campo" rows="3" placeholder="Pregunta Orientadora"></textarea>
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
													<textarea id="TX_DESCRIPCION" name="TX_DESCRIPCION" class="form-control campo" rows="3" placeholder="DESCRIPCIÓN DEL PROYECTO/ PROCESO ARTÍSTICO"></textarea>
													<br>
												</div>
											</div>
											<div class="col-md-12 contenedor-form">
												<br>
												<label>METODOLOGÍA</label>
												<div class="col-md-12" style="min-height: 50px;">
													<select id="SL_METODOLOGIA" name="SL_METODOLOGIA" class="form-control campo"  title="Seleccione">
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
													<textarea id="TX_TEMAS_PROPUESTOS" name="TX_TEMAS_PROPUESTOS" class="form-control campo" rows="3" placeholder="TEMAS PROPUESTOS"></textarea>
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
														<select data-live-search="true" id="SL_RECURSOS" name="SL_RECURSOS" class="form-control campo" title="Seleccione los Recursos" multiple >
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
														<input id="TX_OTROS_RECURSOS" name="TX_OTROS_RECURSOS" class="form-control campo" type="text" placeholder="Otros" maxlength="100">
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
													<textarea class="form-control campo" rows="7"  type="" id="TXT_Circulacion" name="TXT_Circulacion" placeholder="Aquí la propuesta de circulación." ></textarea>

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
													<h6>(Para diligenciar este campo debe solicitar información a su respectivo GPT/AF por IED)</h6>
												</div>
												<div class="col-md-12">
													<textarea class="form-control campo" rows="7"  type="" id="TXT_Articulacion" name="TXT_Articulacion" placeholder="Aquí la propuesta de circulación."></textarea>

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
									<div id="FORM_PLANEACION_EC_LC_CONTAINER" name="FORM_PLANEACION_EC_LC_CONTAINER">
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
														<td width="10%" colspan="3" class="cell-input"><input style="width: 100%; height: 100%;" type="text" class= campo" name="TX_NOMBRE_PROYECTO" id="TX_NOMBRE_PROYECTO" placeholder="Nombre del proyecto artístico"></td>
														<td width="10%" class="contenedor"><b>Manos a obra/ Súbete a la escena/ Grupo Metropolitano</b></td>
														<td width="10%"  class="cell-input"><input style="width: 100%; height: 100%;" type="text" class= campo" name="TX_MANOS" id="TX_MANOS" placeholder="Manos a obra/ Súbete a la escena.."></td>
													</tr>
													<tr>
														<td width="10%" colspan="7" class="contenedor"><b><center>Información para la Línea de Impulso Colectivo</center></b></td>
													</tr>
													<tr>
														<td width="10%" colspan="2" class="contenedor"><b>Tipo de población</b></td>
														<td width="10%" colspan="2" class="cell-input"><input style="width: 100%; height: 100%;" type="text" class= campo" name="TX_TIPO_POBLACION" id="TX_TIPO_POBLACION" placeholder="Tipo de población"></td>
														<td width="10%" class="contenedor"><b>Entidad aliada</b></td>
														<td width="10%" colspan="2" class="cell-input"><input style="width: 100%; height: 100%;" type="text" class= campo" name="TX_ENTIDAD_ALIADA" id="TX_ENTIDAD_ALIADA" placeholder="Entidad aliada"></td>
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
													<textarea id="TX_PROPOSITO" name="TX_PROPOSITO" class="form-control campo" rows="7" placeholder="Propósito de la Entidad Aliada (Sólo para Converge)"></textarea>
													<br>
												</div>
											</div>											
											<div class="col-md-12 contenedor-form">
												<br>
												<label class="control-label">Tipo de proyecto:</label>
												<small><i>(Emprende: proyecto de co-creación con la comunidad, proyecto de impacto en la comunidad, proyecto de producción de piezas simbólicas, Proyectos de investigación, Laboratorio: …).</i></small><br>
												<div class="col-md-12">
													<textarea id="TX_TIPO_PROYECTO" name="TX_TIPO_PROYECTO" class="form-control campo" rows="3" placeholder="Tipo de proyecto"></textarea>
													<br>
												</div>
											</div>
											<div class="col-md-12 contenedor-form">
												<br>
												<label class="control-label">Justificación:</label>
												<small><i>(Debe tener correspondencia con la información de la caracterización. Es el por qué es importante el proyecto o proceso planteado).</i></small><br>
												<div class="col-md-12">
													<br>
													<textarea id="TX_JUSTIFICACION" name="TX_JUSTIFICACION" class="form-control campo" rows="3" placeholder="Justificación"></textarea>
													<br>
												</div>
											</div>
											<div class="col-md-12 contenedor-form">
												<br>
												<label class="control-label">Descripción general del proyecto:</label>
												<small><i>(pensar un proyecto para desarrollar hasta 15 de nov. La descripción debe concreta, usar máximo 150 palabras).</i></small><br>
												<div class="col-md-12">
													<br>
													<textarea id="TX_DESCRIPCION" name="TX_DESCRIPCION" class="form-control campo" rows="3" placeholder="Descripción general del proyecto"></textarea>
													<br>
												</div>
											</div>
											<div class="col-md-12 contenedor-form">
												<br>
												<label class="control-label">Objetivo general:</label>
												<small><i>(debe iniciar por un verbo en infinitivo, debe ser claro, concreto y coherente con el tiempo de desarrollo).</i></small><br>
												<div class="col-md-12">
													<br>
													<textarea id="TX_OBJETIVO_GENERAL" name="TX_OBJETIVO_GENERAL" class="form-control campo" rows="3" placeholder="Objetivo general"></textarea>
													<br>
												</div>
											</div>
											<div class="col-md-12 contenedor-form">
												<br>
												<label class="control-label">Objetivos específicos:</label>
												<small><i>(Estos son acciones esenciales para alcanzar el objetivo general. Plantear mínimo tres o cuatro).</i></small><br>
												<div class="col-md-12">
													<br>
													<textarea id="TX_OBJETIVOS_ESPECIFICOS" name="TX_OBJETIVOS_ESPECIFICOS" class="form-control campo" rows="3" placeholder="Objetivos específicos"></textarea>
													<br>
												</div>
											</div>
											<div class="col-md-12 contenedor-form">
												<br>
												<label class="control-label">Metodología:</label>
												<small><i>(Estos son acciones esenciales para alcanzar el objetivo general. Plantear mínimo tres o cuatro).</i></small><br>
												<div class="col-md-12">
													<br>
													<textarea id="TX_METODOLOGIA" name="TX_METODOLOGIA" class="form-control campo" rows="3" placeholder="Metodología"></textarea>
													<br>
												</div>
											</div>
											<div class="col-md-12 contenedor-form">
												<br>
												<label class="control-label">Referentes conceptuales/teóricos/ visuales/ audiovisuales:</label>
												<small><i>(Explicar qué referentes fundamentales, importantes va usar para el desarrollo del proyecto. Organizarlos por: referentes conceptuales o teóricos. Referentes para la creación, referentes de otras áreas artísticas).</i></small><br>
												<div class="col-md-12">
													<br>
													<textarea id="TX_REFERENTES" name="TX_REFERENTES" class="form-control campo" rows="3" placeholder="Referentes"></textarea>
													<br>
												</div>
											</div>
											<div class="col-md-12 contenedor-form">
												<br>
												<label class="control-label">Resultados esperados:</label>
												<small><i>(Enunciar de manera concreta qué espera del proceso y desarrollo del proyecto).</i></small><br>
												<div class="col-md-12">
													<br>
													<textarea id="TX_RESULTADOS" name="TX_RESULTADOS" class="form-control campo" rows="3" placeholder="Resultados esperados"></textarea>
													<br>
												</div>
											</div>
											<div class="col-md-12 contenedor-form">
												<br>
												<label class="control-label">Criterios cualitativos de evaluación del proyecto:</label>
												<small><i>(criterios para Emprende Personal, disciplinar, colectivo y la relación con el sector. Y para la Línea de Laboratorio los criterios son: Percepción de sí mismo y de los otros, construcción d sentidos de vida en común, percepción del otro en la relación con la acciones o condiciones de vida propias [justicia social]).</i></small><br>
												<div class="col-md-12">
													<br>
													<textarea id="TX_CRITERIOS" name="TX_CRITERIOS" class="form-control campo" rows="3" placeholder="Criterios cualitativos de evaluación del proyecto"></textarea>
													<br>
												</div>
											</div>
											<div class="col-md-12 contenedor-form">
												<br>
												<label class="control-label">Materiales / recursos:</label>
												<small><i>(Enunciar que materiales y recursos se van a gestionar para el desarrollo del proyecto).</i></small><br>
												<div class="col-md-12">
													<div class="row col-md-2">
														<label>Recursos:
														</label>
													</div>
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
						</div>
					</div>
					<div class="tab-pane" id="listado" role="tabpanel">
						<div class="alert alert-dismissible alert-info">
							A continuación se encuentran las planeaciones realizadas para sus grupos.
						</div>
						<div class="col-lg-12 row" >
							<div class="table-responsive">
								<table id="table-listado-planeaciones" class="table table-hover " width="100%" style="width: 100%">
									<thead>
										<tr>
											<th>id</th>
											<th>Grupo</th>
											<th>Línea de Atención</th>
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
				<h5 class="modal-title" id="exampleModalLongTitle">Formato de planeación</h5>
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
				<form id="FORM_PLANEACION_EDITAR" name="FORM_PLANEACION_EDITAR">
					
				</form>
			</div>
			<div class="modal-footer">
				<div class="modal-footer">
				</div>
			</div>
		</div>
	</div>
</div>
<div id="EJEMPLO_1" class="modal fade" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h5 class="modal-title">BREVE DESCRIPCIÓN DEL PROYECTO/ PROCESO ARTÍSTICO</h5>
			</div>
			<div class="modal-body" style="text-align: justify;">
				<b>Ejemplo</b> <br>
				<p class="col-md-offset-1">
					Elaboración de Bestiarios y Diccionarios de Animales Inexistentes.<br>
					Crónicas Barriales.<br>
					Periódico Mural.<br>
					Libro Álbum.<br>
					Libros Artesanales.<br>
					Cortometrajes literarios.<br>
					Feria de personajes épicos.<br>
				</p>
				<br>
				<b>Ejemplos danza:</b><br>
				<p class="col-md-offset-1">
					Apuesta de creación desde la temática focal - carnaval- hacia los<br>
					procesos de formación artística con los grupos. Los procesos se<br>
					pueden enfocar en distintas dimensiones como por ejemplo:<br>
					comparsa, carnaval, coreografía, intervención, etc.<br>
					<br>
				</p>
				<b>Ejemplos Audiovisuales:</b><br>
				<p class="col-md-offset-1">
					Procesos de exploración del lenguaje y los medios audiovisuales a<br>
					través del uso de dispositivos y juguetes ópticos para la narración de<br>
					una historia y la comprensión de la imagen en movimiento.<br>
					Proyectos de creación audiovisual a partir del juego y de las<br>
					experiencias de los participantes a través de la apreciación y<br>
					exploración de diversas narrativas.<br>
					<br>
				</p>
				<b>Ejemplos Música:</b><br>
				<p class="col-md-offset-1">
					Coro, Ensamble vocal, Montaje Vocal/Instrumental, Stomp,<br>
					Percusión corporal...<br>
					Artes Plásticas<br>
					Proyecto colaborativo para intervenir un espacio en la IED<br>
					Proyecto de creación colectiva con base en una temática/obra focal<br>
					Proyecto interdisciplinar con otra área de conocimiento o centro de<br>
					interés.<br>
				</p>
				<br>
				<b>Arte Dramático:</b><br>
				<p class="col-md-offset-1">
					Procesos creativos desde abordaje de Temas<br>
					Procesos creativos desde Preguntas<br>
					Proyectos de investigación-creación.<br>
					Proyectos interdisciplinares a través de preguntas transversales.<br>
					Procesos colaborativos y comunitarios.<br>
					Procesos de intervención de espacios.<br>
					Montaje de obras a partir del texto dramático<br>
					Montaje de obras de tipo experimental.<br>
					Procesos que involucran técnicas particulares; teatro gestual, circo,<br>
					clown, etc.<br>
				</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<div id="EJEMPLO_2" class="modal fade" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h5 class="modal-title">BREVE DESCRIPCIÓN DEL PROYECTO/ PROCESO ARTÍSTICO</h5>
			</div>
			<div class="modal-body" style="text-align: justify;">
				<p>
					<b>Ejemplo:</b>
				</p>
				<p class="col-md-offset-1">
					La vida.
					<br>
					La muerte.
					<br>
					El miedo.
					<br>
					Crecer.
					<br>
					Los animales.
					<br>
					La música.
					<br>

				</p>
				<p>
					<b>Ejemplos Danza:</b>
				</p>
				<p class="col-md-offset-1">
					Temas que devienen de la propuesta de la temática focal.
					<br>
				</p>
				<p>
					<b>Ejemplos Música:</b>
				</p>
				<p class="col-md-offset-1">
					Región, estilo musical, época, género, compositores nacionales, compositores extranjeros... 
					<br>
				</p>
				<p>
					<b>Ejemplos Audiovisuales:</b>
				</p>
				<p class="col-md-offset-1">
					Temáticas identificadas con el grupo para el
					desarrollo del proyecto de creación a partir de conocimientos e
					intereses previos sobre lo audiovisual, de las vivencias, contextos,
					anécdotas o problemáticas relacionadas con los territorios o líneas
					temáticas propuestas desde el área artística.
					<br>
				</p>
				<p>
					<b>Artes Plásticas:</b>
				</p>
				<p class="col-md-offset-1">
					Cuerpo, territorio, narrativas, proyecto de vida
					<br>
				</p>
				<p>
					<b>Arte Dramático:</b>
				</p>
				<p class="col-md-offset-1">
					Uso del tema como motor para la experiencia de creación.
					<br>
					Los temas podrían surgir de literatura hasta temas de corte
					contextual y situado.
					<br>
					Temas que surjan de otras disciplinas y que pueden ser
					transversales tales como: la imagen, el lenguaje, lo poético, lo
					urbano.
					<br>
					Temas que surjan de la relación del estudiante con su cuerpo y
					contexto.
					<br>
				</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade center-modal" id="EJEMPLO_3" style="top: 15%;">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="col-md-11">
					<h4 class="modal-title"><b>Referentes</b></h4>
				</div>
				<div class="col-md-1">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			</div>
			<div class="modal-body" style="text-align: justify;">
				<p>
					<b>Ejemplo:</b>
				</p>
				<p class="col-md-offset-1">
					<ul>
						<li>Snunit, Mijal. El Pájaro del Alma. FCE, México, 1985.</li>
						<li>Pombo, Rafael. Fábulas de Siempre. Norma, Bogotá, 1988.</li>
						<li>ETC...</li>
					</ul>

				</p>
				<p>
					<b>Ejemplos Danza:</b>
				</p>
				<p class="col-md-offset-1">
					Obras, Videos, Artistas, Literatura, Teoría, etc.
					<br>
				</p>
				<p>
					<b>Ejemplos Música:</b>
				</p>
				<p class="col-md-offset-1">
					Métodos, Cartillas, Videos, Trabajos discográficos, Biografías, Arreglos...
					<br>
				</p>
				<p>
					<b>Ejemplos Audiovisuales:</b>
				</p>
				<p class="col-md-offset-1">
					Videos, peliculas, escenas, secuencias, audio, radio, medios de
					comunicación, fotografías.
					<br>
				</p>
				<p>
					<b>Artes Plásticas:</b>
				</p>
				<p class="col-md-offset-1">
					Textos, procesos, material audiovisual, etc.
					<br>
				</p>
				<p>
					<b>Arte Dramático:</b>
				</p>
				<p class="col-md-offset-1">
					Obras escritas, textos literarios- poesía-, revistas, referentes
					audiovisuales, plásticos, sonoros, referentes de vida (biografías o
					auto-biografías) textos inéditos.
					<br>
				</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar
				</button>
			</div>
		</div>
	</div>
</div>
</html>
