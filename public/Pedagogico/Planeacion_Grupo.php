
<?php
session_start();
if(!isset($_SESSION["session_username"])) {
	header("location:index.php");
} else {
	$Id_Persona= $_SESSION["session_username"];
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="../LibreriasExternas/bootstrap-3.3.7-dist/css/bootstrap.min.css">
	<script src="../LibreriasExternas/JQuery/jquery-3.1.1.min.js">
	</script>
	<script src="../LibreriasExternas/bootstrap-3.3.7-dist/js/bootstrap.min.js">
	</script>
	<link href="../bootstrap/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="Js/Planeacion_Grupo.js?v=2019.05.27"> 
	</script>
	<link href="https://fonts.googleapis.com/css?family=Yatra One|BioRhyme|Righteous|Prompt" rel="stylesheet">
	<link href="../LibreriasExternas/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../bootstrap/bootstrap-slider/bootstrap-slider.css">
	<link rel="stylesheet" type="text/css" href="../bootstrap/bootstrap-select/bootstrap-select.css">
	<script src="../LibreriasExternas/datatables/media/js/jquery.dataTables.min.js">
	</script>
	<script type="text/javascript" src="../bootstrap/bootstrap-slider/bootstrap-slider.js">
	</script>
	<script type="text/javascript" src="../bootstrap/bootstrap-select/bootstrap-select.js">
	</script>
	<script type="text/javascript" src="../js/bootbox.js">
	</script>
	<link rel="stylesheet" type="text/css" href="../Pedagogico/Js/bootstrap-slider/css/bootstrap-slider.css">
	<script src="../LibreriasExternas/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js">
	</script>
</head>
<style type="text/css">
div{
	font-family: 'Prompt';
	font-size: 14px;
	font-weight: normal; 
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
	background-color: #d6e9c6;
	border: 1px solid white;
}
</style>
<body>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Planeación de Grupos 
						<small>Artista Formador
						</small>
					</h1>
					<input type='hidden' id='id_usuario' value='<?php echo $Id_Persona; ?>'> 
				</div>
			</div>
			<div class="panel-body">
				<div id="div_seleccionar_grupo">
					<form id="FORM_Realizar_Planeacion">
						<div class="row">
							<div class="col-xs-6 col-md-3">
								<label for="SL_grupo">Seleccione el grupo:
								</label>
							</div>
							<div class="col-xs-6 col-md-9">
								<select id="SL_grupo" class="form-control selectpicker" title="Seleccione un Grupo" required>
								</select>
							</div>
						</div>
						<div class="row" id="DIV_Observacion" hidden>
							<br>
							<div class="col-md-12">
								<label>Observación
								</label>
							</div>
							<div class="col-md-10 col-md-offset-1">
								<h5 id="LB_Observacion">Observación
								</h5>
							</div>
							<br>
							<div class="col-md-12">
								<label>Estado
								</label>
							</div>
							<div class="col-md-10 col-md-offset-1">
								<h5 id="LB_Estado">
								</h5>
							</div>
							<br>
						</div>
						<div class="row">
							<div class="col-xs-4 col-xs-offset-4 col-md-4 col-md-offset-4">
								<br>
								<button id="BTN_Generar_Planeacion" class="btn btn-primary form-control" type="submit">Realizar Planeación
								</button>
							</div>
						</div>
					</form>
				</div>
				<div class="panel-body panel-success">
					<div id="div_form_planeacion_arte">
						<form id="form_planeacion_arte">
							<div class="col-md-12">
								<table class="table table-bordered" style="border-color: white">
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
											<td width="20%" colspan="2"class="contenedor"	><b>Artista formador(a)</b></td>
											<td width="20%" colspan="2"><span id="LB_Formador"></span></td>
											<td width="10%" class="contenedor"><b>Área artística</b></td>
											<td width="20%"	><span id="LB_Area_Artistica"></span></td>
											<td width="10%"	class="contenedor"><b>Crea al que pertenece</b></td>
											<td width="20%" ><span id="LB_Clan"></span></td>
										</tr>
										<tr>
											<td width="10%" class="contenedor"><b>IDARTES</b></td>
											<td width="10%" ></td>
											<td width="10%" class="contenedor"><b>Organización</b></td>
											<td width="10%" >
												<!-- <span id="LB_Entidad">
												</span> -->
											</td>
											<td width="10%" class="contenedor"><b>Horario de grupo</b></td>
											<td width="20%"	><span id="LB_Horario"></span></td>
											<td width="10%"	class="contenedor"><b>Código del grupo</b></td>
											<td width="20%" ><span id="id_del_grupo"></span></td>
										</tr>
										<tr>
											<td width="20%" colspan="2"><b>Ciclo/ Momento/ Multigrado/ Aceleración</b></td>
											<td width="10%" >
												<select id="SL_CICLO" name="SL_CICLO" class="selectpicker form-control" required title="Seleccione">
													<option value="0">NO APLICA
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
								<div class="col-md-12 contenedor" >
									<br>
									<p>
										<label>OBJETIVO DE LA FORMACIÓN
										</label>
									</p>
									<div class="col-md-12">
										<textarea class="form-control" rows="7"  type="" id="TXT_Objetivo_Formacion" name="TXT_Objetivo_Formacion" placeholder="Aquí el objetivo de la formación" required=""></textarea>

										<br>
									</div>
								</div>
								<div class="col-md-12 contenedor" >
									<br>
									<p>
										<label>PREGUNTA ORIENTADORA
										</label>
									</p>
									<div class="col-md-12">
										<textarea id="TXT_Pregunta" name="TXT_Pregunta" class="form-control" rows="7" placeholder="Aquí la pregunta orientadora." required></textarea>
										<br>
									</div>
								</div>
								<div class="col-md-12 contenedor" >
									<br>
									<p>
										<label>
											PERSPECTIVA PEDAGÓGICA
										</label>
									</p>
									<div class="col-md-12">
										<button type="button" class="btn btn-sm btn-danger " title="Ver Ejemplo" data-toggle="modal" data-target="#MODAL_EJEMPLO_UNO">
											<span href="#" style="font-family:'Prompt';">Ver Ejemplo
											</span>
										</button>
										<br>
									</div>

									<div class="col-md-12">
										<br>
										<textarea id="TXT_Descripcion_proyecto" name="TXT_Descripcion_proyecto" class="form-control" rows="7" placeholder="Perspectiva pedagógica" required></textarea>
										<br>
									</div>
								</div>
								<div class="col-md-12 contenedor"  >
									<br>
									<p>
										<label>
											ESTRATEGIAS METODOLÓGICAS
										</label>
									</p>
									<div class="col-md-12">
										<div class="row col-md-2">
										</div>
										<div class="col-md-5">
											<select id="SL_Metodologia" name="SL_Metodologia" class="selectpicker form-control" title="Seleccione las metodologías" multiple>
												<option value="1">Taller</option>
												<option value="2">Trabajo por proyectos artísticos</option>
												<option value="3">Comunidades de práctica</option>
											</select>
											<br>
										</div>
									</div>
									<div class="col-md-12"><br></div>
									<div class="col-md-12">
										<div class="row col-md-2">
											<label>Otras, ¿cuáles?
											</label>
										</div>
										<div class="col-md-5">
											<input id="TXT_Otras_Metodologias" name="TXT_Otras_Metodologias" class="form-control" type="text" placeholder="Otras" maxlength="100">
										</div>
									</div>
									<div class="col-md-12"><br></div>
									<br>
								</div>
								<div class="col-md-12 contenedor" >
									<br>
									<p>
										<label>
											RESULTADOS
										</label>
									</p>
									<div class="col-md-12">

										<button type="button" class="btn btn-sm btn-danger " title="Ver Ejemplo" data-toggle="modal" data-target="#MODAL_EJEMPLO_CUATRO">
											<span href="#" style="font-family:'Prompt';">Ver Ejemplo
											</span>
										</button>
										<br>
									</div>
									<div class="col-md-12">
										<br>
										<textarea id="TXT_Resultados" name="TXT_Resultados" class="form-control" rows="7" placeholder="Resultados" required></textarea>
										<br>
									</div>
								</div>
								<div class="col-md-12 contenedor" >
									<br>
									<p>
										<label>
											TEMAS PROPUESTOS
										</label>
									</p>
									<div class="col-md-12">

										<button type="button" class="btn btn-sm btn-danger " title="Ver Ejemplo" data-toggle="modal" data-target="#MODAL_EJEMPLO_DOS">
											<span href="#" style="font-family:'Prompt';">Ver Ejemplo
											</span>
										</button>
										<br>
									</div>
									<div class="col-md-12">
										<br>
										<textarea id="TXT_Temas" name="TXT_Temas" class="form-control" rows="7" placeholder="Aquí los temas propuestos." required></textarea>
										<br>
									</div>
								</div>
								<div class="col-md-12 contenedor"  >
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
											<select data-live-search="true" id="SL_Recursos" name="SL_Recursos" class="selectpicker form-control" title="Seleccione los Recursos" multiple required>
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
											<input id="TX_Otros_Recursos" name="TX_Otros_Recursos" class="form-control" type="text" placeholder="Otros" maxlength="100">
										</div>
									</div>
									<div class="col-md-12"><br></div>
									<br>
								</div>
								<div class="col-md-12 contenedor" >
									<br>
									<p>
										<label>
											REFERENTES
										</label>

									</p>
									<div class="col-md-12">
										<button type="button" class="btn btn-sm btn-danger " title="Ver Ejemplo" data-toggle="modal" data-target="#MODAL_EJEMPLO_TRES">
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
								<div class="col-md-12 contenedor" >
									<br>
									<p>
										<label>PROPUESTA DE CIRCULACIÓN (MUESTRAS LOCALES Y FINALES)
										</label>
									</p>
									<div class="col-md-12">
										<textarea class="form-control" rows="7"  type="" id="TXT_Circulacion" name="TXT_Circulacion" placeholder="Aquí la propuesta de circulación." required></textarea>

										<br>
									</div>
								</div>
								<div class="col-md-12 contenedor" >
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
														<a href="#mes1"><b>Mes 1</b>
														</a>
													</h4>
												</div>
												<div id="mes1" class="">
													<br>
													<div class="form-group row" >
														<label  for="TXT_semana_1"  class="col-lg-2 col-md-2 control-label text-right">Semana 1
														</label>
														<div class="col-lg-9 col-md-9"  >
															<textarea class="form-control" id="TXT_semana_1" name="TXT_semana_1" placeholder="Acciones" required type="text" rows="2"></textarea>
														</div>  
													</div>
													<div class="form-group row" >
														<label  for="TXT_semana_2"  class="col-lg-2 col-md-2 control-label text-right">Semana 2
														</label>
														<div class="col-lg-9 col-md-9"  >
															<textarea class="form-control" id="TXT_semana_2" name="TXT_semana_2" placeholder="Acciones" required type="text" rows="2"></textarea>
														</div>
													</div>
													<div class="form-group row" >
														<label  for="TXT_semana_3"  class="col-lg-2 col-md-2 control-label text-right">Semana 3
														</label>
														<div class="col-lg-9 col-md-9"  >
															<textarea class="form-control" id="TXT_semana_3" name="TXT_semana_3" placeholder="Acciones" type="text" rows="2"></textarea>
														</div>
													</div>
													<div class="form-group row" >
														<label  for="TXT_semana_4"  class="col-lg-2 col-md-2 control-label text-right">Semana 4
														</label>
														<div class="col-lg-9 col-md-9"  >
															<textarea class="form-control" id="TXT_semana_4" name="TXT_semana_4" placeholder="Acciones" type="text" rows="2"></textarea>
														</div>
													</div>
												</div>
											</div>
											<div class="panel panel-default">
												<div class="panel-heading">
													<h4 class="panel-title">
														<a data-toggle="collapse" data-parent="#accordion" href="#mes2"><b>Mes 2</b>
														</a>
													</h4>
												</div>
												<div id="mes2" class="panel-collapse collapse">
													<br>
													<div class="form-group row" >
														<label  for="TXT_semana_5"  class="col-lg-2 col-md-2 control-label text-right"> Semana 1 
														</label>
														<div class="col-lg-9 col-md-9"  >
															<textarea class="form-control" id="TXT_semana_5" name="TXT_semana_5" placeholder="Acciones" type="text" rows="2"></textarea>
														</div>
													</div>
													<div class="form-group row" >
														<label  for="TXT_semana_6"  class="col-lg-2 col-md-2 control-label text-right"> Semana 2 
														</label>
														<div class="col-lg-9 col-md-9"  >
															<textarea class="form-control" id="TXT_semana_6" name="TXT_semana_6" placeholder="Acciones" type="text" rows="2"></textarea>
														</div>
													</div>
													<div class="form-group row" >
														<label  for="TXT_semana_7"  class="col-lg-2 col-md-2 control-label text-right"> Semana 3 
														</label>
														<div class="col-lg-9 col-md-9"  >
															<textarea class="form-control" id="TXT_semana_7" name="TXT_semana_7" placeholder="Acciones" type="text" rows="2"></textarea>
														</div>
													</div>
													<div class="form-group row" >
														<label  for="TXT_semana_8"  class="col-lg-2 col-md-2 control-label text-right"> Semana 4 
														</label>
														<div class="col-lg-9 col-md-9"  >
															<textarea class="form-control" id="TXT_semana_8" name="TXT_semana_8" placeholder="Acciones" type="text" rows="2"></textarea>
														</div>
													</div>
												</div>
											</div>
											<div class="panel panel-default">
												<div class="panel-heading">
													<h4 class="panel-title">
														<a data-toggle="collapse" data-parent="#accordion" href="#mes3"><b>Mes 3</b>
														</a>
													</h4>
												</div>
												<div id="mes3" class="panel-collapse collapse">
													<br>
													<div class="form-group row" >
														<label  for="TXT_semana_9"  class="col-lg-2 col-md-2 control-label text-right">Semana 1
														</label>
														<div class="col-lg-9 col-md-9"  >
															<textarea class="form-control" id="TXT_semana_9" name="TXT_semana_9" placeholder="Acciones" type="text" rows="2"></textarea>
														</div>
													</div>
													<div class="form-group row" >
														<label  for="TXT_semana_10"  class="col-lg-2 col-md-2 control-label text-right">Semana 2
														</label>
														<div class="col-lg-9 col-md-9"  >
															<textarea class="form-control" id="TXT_semana_10" name="TXT_semana_10" placeholder="Acciones" type="text" rows="2"></textarea>
														</div>
													</div>
													<div class="form-group row" >
														<label  for="TXT_semana_11"  class="col-lg-2 col-md-2 control-label text-right">Semana 3
														</label>
														<div class="col-lg-9 col-md-9"  >
															<textarea class="form-control" id="TXT_semana_11" name="TXT_semana_11" placeholder="Acciones" type="text" rows="2"></textarea>
														</div>
													</div>
													<div class="form-group row" >
														<label  for="TXT_semana_12"  class="col-lg-2 col-md-2 control-label text-right">Semana 4
														</label>
														<div class="col-lg-9 col-md-9"  >
															<textarea class="form-control" id="TXT_semana_12" name="TXT_semana_12" placeholder="Acciones" type="text" rows="2"></textarea>
														</div>
													</div>
												</div>
											</div>
											<div class="panel panel-default">
												<div class="panel-heading">
													<h4 class="panel-title">
														<a data-toggle="collapse" data-parent="#accordion" href="#mes4"><b>Mes 4</b>
														</a>
													</h4>
												</div>
												<div id="mes4" class="panel-collapse collapse">
													<br>
													<div class="form-group row" >
														<label  for="TXT_semana_13"  class="col-lg-2 col-md-2 control-label text-right">Semana 1
														</label>
														<div class="col-lg-9 col-md-9"  >
															<textarea class="form-control" id="TXT_semana_13" name="TXT_semana_13" placeholder="Acciones" type="text" rows="2"></textarea>
														</div>
													</div>
													<div class="form-group row" >
														<label  for="TXT_semana_14"  class="col-lg-2 col-md-2 control-label text-right">Semana 2
														</label>
														<div class="col-lg-9 col-md-9"  >
															<textarea class="form-control" id="TXT_semana_14" name="TXT_semana_14" placeholder="Acciones" type="text" rows="2"></textarea>
														</div>
													</div>
													<div class="form-group row" >
														<label  for="TXT_semana_15"  class="col-lg-2 col-md-2 control-label text-right">Semana 3
														</label>
														<div class="col-lg-9 col-md-9"  >
															<textarea class="form-control" id="TXT_semana_15" name="TXT_semana_15" placeholder="Acciones" type="text" rows="2"></textarea>
														</div>
													</div>
													<div class="form-group row" >
														<label  for="TXT_semana_16"  class="col-lg-2 col-md-2 control-label text-right">Semana 4
														</label>
														<div class="col-lg-9 col-md-9"  >
															<textarea class="form-control" id="TXT_semana_16" name="TXT_semana_16" placeholder="Acciones" type="text" rows="2"></textarea>
														</div>
													</div>
												</div>
											</div>
											<div class="panel panel-default">
												<div class="panel-heading">
													<h4 class="panel-title">
														<a data-toggle="collapse" data-parent="#accordion" href="#mes5"><b>Mes 5</b>
														</a>
													</h4>
												</div>
												<div id="mes5" class="panel-collapse collapse">
													<br>
													<div class="form-group row" >
														<label  for="TXT_semana_17"  class="col-lg-2 col-md-2 control-label text-right">Semana 1
														</label>
														<div class="col-lg-9 col-md-9"  >
															<textarea class="form-control" id="TXT_semana_17" name="TXT_semana_17" placeholder="Acciones" type="text" rows="2"></textarea>
														</div>
													</div>
													<div class="form-group row" >
														<label  for="TXT_semana_18"  class="col-lg-2 col-md-2 control-label text-right">Semana 2
														</label>
														<div class="col-lg-9 col-md-9"  >
															<textarea class="form-control" id="TXT_semana_18" name="TXT_semana_18" placeholder="Acciones" type="text" rows="2"></textarea>
														</div>
													</div>
													<div class="form-group row" >
														<label  for="TXT_semana_19"  class="col-lg-2 col-md-2 control-label text-right">Semana 3
														</label>
														<div class="col-lg-9 col-md-9"  >
															<textarea class="form-control" id="TXT_semana_19" name="TXT_semana_19" placeholder="Acciones" type="text" rows="2"></textarea>
														</div>
													</div>
													<div class="form-group row" >
														<label  for="TXT_semana_20"  class="col-lg-2 col-md-2 control-label text-right">Semana 4
														</label>
														<div class="col-lg-9 col-md-9"  >
															<textarea class="form-control" id="TXT_semana_20" name="TXT_semana_20" placeholder="Acciones" type="text" rows="2"></textarea>
														</div>
													</div>
												</div>
											</div>
											<div class="panel panel-default">
												<div class="panel-heading">
													<h4 class="panel-title">
														<a data-toggle="collapse" data-parent="#accordion" href="#mes6"><b>Mes 6</b>
														</a>
													</h4>
												</div>
												<div id="mes6" class="panel-collapse collapse">
													<br>
													<div class="form-group row" >
														<label  for="TXT_semana_21"  class="col-lg-2 col-md-2 control-label text-right">Semana 1
														</label>
														<div class="col-lg-9 col-md-9"  >
															<textarea class="form-control" id="TXT_semana_21" name="TXT_semana_21" placeholder="Acciones" type="text" rows="2"></textarea>
														</div>
													</div>
													<div class="form-group row" >
														<label  for="TXT_semana_22"  class="col-lg-2 col-md-2 control-label text-right">Semana 2
														</label>
														<div class="col-lg-9 col-md-9"  >
															<textarea class="form-control" id="TXT_semana_22" name="TXT_semana_22" placeholder="Acciones" type="text" rows="2"></textarea>
														</div>
													</div>
													<div class="form-group row" >
														<label  for="TXT_semana_23"  class="col-lg-2 col-md-2 control-label text-right">Semana 3
														</label>
														<div class="col-lg-9 col-md-9"  >
															<textarea class="form-control" id="TXT_semana_23" name="TXT_semana_23" placeholder="Acciones" type="text" rows="2"></textarea>
														</div>
													</div>
													<div class="form-group row" >
														<label  for="TXT_semana_24"  class="col-lg-2 col-md-2 control-label text-right">Semana 4
														</label>
														<div class="col-lg-9 col-md-9"  >
															<textarea class="form-control" id="TXT_semana_24" name="TXT_semana_24" placeholder="Acciones" type="text" rows="2"></textarea>
														</div>
													</div>
												</div>
											</div>
											<div class="panel panel-default">
												<div class="panel-heading">
													<h4 class="panel-title">
														<a data-toggle="collapse" data-parent="#accordion" href="#mes7"><b>Mes 7</b>
														</a>
													</h4>
												</div>
												<div id="mes7" class="panel-collapse collapse">
													<br>
													<div class="form-group row" >
														<label  for="TXT_semana_25"  class="col-lg-2 col-md-2 control-label text-right">Semana 1
														</label>
														<div class="col-lg-9 col-md-9"  >
															<textarea class="form-control" id="TXT_semana_25" name="TXT_semana_25" placeholder="Acciones" type="text" rows="2"></textarea>
														</div>
													</div>
													<div class="form-group row" >
														<label  for="TXT_semana_26"  class="col-lg-2 col-md-2 control-label text-right">Semana 2
														</label>
														<div class="col-lg-9 col-md-9"  >
															<textarea class="form-control" id="TXT_semana_26" name="TXT_semana_26" placeholder="Acciones" type="text" rows="2"></textarea>
														</div>
													</div>
													<div class="form-group row" >
														<label  for="TXT_semana_27"  class="col-lg-2 col-md-2 control-label text-right">Semana 3
														</label>
														<div class="col-lg-9 col-md-9"  >
															<textarea class="form-control" id="TXT_semana_27" name="TXT_semana_27" placeholder="Acciones" type="text" rows="2"></textarea>
														</div>
													</div>
													<div class="form-group row" >
														<label  for="TXT_semana_28"  class="col-lg-2 col-md-2 control-label text-right">Semana 4
														</label>
														<div class="col-lg-9 col-md-9"  >
															<textarea class="form-control" id="TXT_semana_28" name="TXT_semana_28" placeholder="Acciones" type="text" rows="2"></textarea>
														</div>
													</div>
												</div>
											</div>
											<div class="panel panel-default">
												<div class="panel-heading">
													<h4 class="panel-title">
														<a data-toggle="collapse" data-parent="#accordion" href="#mes8"><b>Mes 8</b>
														</a>
													</h4>
												</div>
												<div id="mes8" class="panel-collapse collapse">
													<br>
													<div class="form-group row" >
														<label  for="TXT_semana_29"  class="col-lg-2 col-md-2 control-label text-right">Semana 1
														</label>
														<div class="col-lg-9 col-md-9"  >
															<textarea class="form-control" id="TXT_semana_29" name="TXT_semana_29" placeholder="Acciones" type="text" rows="2"></textarea>
														</div>
													</div>
													<div class="form-group row" >
														<label  for="TXT_semana_30"  class="col-lg-2 col-md-2 control-label text-right">Semana 2
														</label>
														<div class="col-lg-9 col-md-9"  >
															<textarea class="form-control" id="TXT_semana_30" name="TXT_semana_30" placeholder="Acciones" type="text" rows="2"></textarea>
														</div>
													</div>
													<div class="form-group row" >
														<label  for="TXT_semana_31"  class="col-lg-2 col-md-2 control-label text-right">Semana 3
														</label>
														<div class="col-lg-9 col-md-9"  >
															<textarea class="form-control" id="TXT_semana_31" name="TXT_semana_31" placeholder="Acciones" type="text" rows="2"></textarea>
														</div>
													</div>
													<div class="form-group row" >
														<label  for="TXT_semana_32"  class="col-lg-2 col-md-2 control-label text-right">Semana 4
														</label>
														<div class="col-lg-9 col-md-9"  >
															<textarea class="form-control" id="TXT_semana_32" name="TXT_semana_32" placeholder="Acciones" type="text" rows="2"></textarea>
														</div>
													</div>
												</div>
											</div>
											<div class="panel panel-default">
												<div class="panel-heading">
													<h4 class="panel-title">
														<a data-toggle="collapse" data-parent="#accordion" href="#mes9"><b>Mes 9</b>
														</a>
													</h4>
												</div>
												<div id="mes9" class="panel-collapse collapse">
													<br>
													<div class="form-group row" >
														<label  for="TXT_semana_33"  class="col-lg-2 col-md-2 control-label text-right">Semana 1
														</label>
														<div class="col-lg-9 col-md-9"  >
															<textarea class="form-control" id="TXT_semana_33" name="TXT_semana_33" placeholder="Acciones" type="text" rows="2"></textarea>
														</div>
													</div>
													<div class="form-group row" >
														<label  for="TXT_semana_34"  class="col-lg-2 col-md-2 control-label text-right">Semana 2
														</label>
														<div class="col-lg-9 col-md-9"  >
															<textarea class="form-control" id="TXT_semana_34" name="TXT_semana_34" placeholder="Acciones" type="text" rows="2"></textarea>
														</div>
													</div>
													<div class="form-group row" >
														<label  for="TXT_semana_35"  class="col-lg-2 col-md-2 control-label text-right">Semana 3
														</label>
														<div class="col-lg-9 col-md-9"  >
															<textarea class="form-control" id="TXT_semana_35" name="TXT_semana_35" placeholder="Acciones" type="text" rows="2"></textarea>
														</div>
													</div>
													<div class="form-group row" >
														<label  for="TXT_semana_36"  class="col-lg-2 col-md-2 control-label text-right">Semana 4
														</label>
														<div class="col-lg-9 col-md-9"  >
															<textarea class="form-control" id="TXT_semana_36" name="TXT_semana_36" placeholder="Acciones" type="text" rows="2"></textarea>
														</div>
													</div>
												</div>
											</div>
											<div class="panel panel-default">
												<div class="panel-heading">
													<h4 class="panel-title">
														<a data-toggle="collapse" data-parent="#accordion" href="#mes10"><b>Mes 10</b>
														</a>
													</h4>
												</div>
												<div id="mes10" class="panel-collapse collapse">
													<br>
													<div class="form-group row" >
														<label  for="TXT_semana_37"  class="col-lg-2 col-md-2 control-label text-right">Semana 1
														</label>
														<div class="col-lg-9 col-md-9"  >
															<textarea class="form-control" id="TXT_semana_37" name="TXT_semana_37" placeholder="Acciones" type="text" rows="2"></textarea>
														</div>
													</div>
													<div class="form-group row" >
														<label  for="TXT_semana_38"  class="col-lg-2 col-md-2 control-label text-right">Semana 2
														</label>
														<div class="col-lg-9 col-md-9"  >
															<textarea class="form-control" id="TXT_semana_38" name="TXT_semana_38" placeholder="Acciones" type="text" rows="2"></textarea>
														</div>
													</div>
													<div class="form-group row" >
														<label  for="TXT_semana_39"  class="col-lg-2 col-md-2 control-label text-right">Semana 3
														</label>
														<div class="col-lg-9 col-md-9"  >
															<textarea class="form-control" id="TXT_semana_39" name="TXT_semana_39" placeholder="Acciones" type="text" rows="2"></textarea>
														</div>
													</div>
													<div class="form-group row" >
														<label  for="TXT_semana_40"  class="col-lg-2 col-md-2 control-label text-right">Semana 4
														</label>
														<div class="col-lg-9 col-md-9"  >
															<textarea class="form-control" id="TXT_semana_40" name="TXT_semana_40" placeholder="Acciones" type="text" rows="2"></textarea>
														</div>
													</div>
												</div>
											</div>
											<div class="panel panel-default">
												<div class="panel-heading">
													<h4 class="panel-title">
														<a data-toggle="collapse" data-parent="#accordion" href="#mes11"><b>Mes 11</b>
														</a>
													</h4>
												</div>
												<div id="mes11" class="panel-collapse collapse">
													<br>
													<div class="form-group row" >
														<label  for="TXT_semana_41"  class="col-lg-2 col-md-2 control-label text-right">Semana 1
														</label>
														<div class="col-lg-9 col-md-9"  >
															<textarea class="form-control" id="TXT_semana_41" name="TXT_semana_41" placeholder="Acciones" type="text" rows="2"></textarea>
														</div>
													</div>
													<div class="form-group row" >
														<label  for="TXT_semana_42"  class="col-lg-2 col-md-2 control-label text-right">Semana 2
														</label>
														<div class="col-lg-9 col-md-9"  >
															<textarea class="form-control" id="TXT_semana_42" name="TXT_semana_42" placeholder="Acciones" type="text" rows="2"></textarea>
														</div>
													</div>
													<div class="form-group row" >
														<label  for="TXT_semana_43"  class="col-lg-2 col-md-2 control-label text-right">Semana 3
														</label>
														<div class="col-lg-9 col-md-9"  >
															<textarea class="form-control" id="TXT_semana_43" name="TXT_semana_43" placeholder="Acciones" type="text" rows="2"></textarea>
														</div>
													</div>
													<div class="form-group row" >
														<label  for="TXT_semana_44"  class="col-lg-2 col-md-2 control-label text-right">Semana 4
														</label>
														<div class="col-lg-9 col-md-9"  >
															<textarea class="form-control" id="TXT_semana_44" name="TXT_semana_44" placeholder="Acciones" type="text" rows="2"></textarea>
														</div>
													</div>
												</div>
											</div>
										</div> 


									</div>
								</div>
								<div class="col-md-12 contenedor" >
									<br>
									<p>
										<label>ARTICULACIÓN CON EL PROYECTO EDUCATIVO INSTITUCIONAL (PEI)
										</label>
									</p>

									<div class="col-md-12">
										<h6>(Para diligenciar este campo debe solicitar información a su respectivo AFA)</h6>
									</div>
									<div class="col-md-12">
										<textarea class="form-control" rows="7"  type="" id="TXT_Articulacion" name="TXT_Articulacion" placeholder="Aquí la propuesta de circulación." required></textarea>

										<br>
									</div>
								</div>
								<div id="DIV_Ciclo" class="col-md-12 contenedor" >
									<br>
									<p>
										<label id="LB_Ciclo">
										</label>
									</p>
									<div class="col-md-12">
										<button type="button" class="btn btn-sm btn-danger " title="Ver Ejemplo" data-toggle="modal" data-target="#MODAL_EJEMPLO_CINCO">
											<span href="#" style="font-family:'Prompt';">Ver Ejemplo
											</span>
										</button>
										<br>
										<br>
									</div>
									<div class="col-md-12">
										<textarea class="form-control" rows="7"  type="" id="TXT_Ciclo" name="TXT_Ciclo" placeholder="Descripción de la articulación." required> </textarea>

										<br>
									</div>
								</div>
								<div class="col-md-12">
									<br>
									<div class="col-md-6 col-md-offset-4">
										<input type="submit" id="BTN_Guardar_planeacion" name="BTN_Guardar_planeacion" class="btn btn-success" value="GUARDAR PLANEACIÓN">
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<div class="modal fade center-modal" id="MODAL_EJEMPLO_UNO">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="col-md-11">
					<h4 class="modal-title"><b>PERSPECTIVA PEDAGÓGICA</b></h4>
				</div>
				<div class="col-md-1">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			</div>
			<div class="modal-body" style="text-align: justify;">
				<p class="col-md-offset-1">
					- Obras, procesos, temas, problemas, experiencias ARTÍSTIC@S
					<br>
					- Perspectivas pedagógicas propias de las artes
					<br>
					- Modelos propios de la educación
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
<div class="modal fade center-modal" id="MODAL_EJEMPLO_DOS">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="col-md-11">
					<h4 class="modal-title"><b>TEMAS PROPUESTOS</b></h4>
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
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar
				</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade center-modal" id="MODAL_EJEMPLO_TRES" style="top: 15%;">
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
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar
				</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade center-modal" id="MODAL_EJEMPLO_CUATRO" style="top: -10%;">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="col-md-11">
					<h4 class="modal-title"><b>Resultados</b></h4>
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
					Elaboración de Bestiarios y Diccionarios de Animales Inexistentes.
					<br>
					Crónicas Barriales.
					<br>
					Periódico Mural.
					<br>
					Libro Álbum.
					<br>
					Libros Artesanales.
					<br>
					Cortometrajes literarios.
					<br>
					Feria de personajes épicos.
					<br>
				</p>
				<p>
					<b>Ejemplos Danza:</b>
				</p>
				<p class="col-md-offset-1">
					Apuesta de creación desde la temática focal - carnaval- hacia los procesos de formación artística con los grupos. Los procesos se pueden enfocar en distintas dimensiones como por ejemplo: comparsa, carnaval, coreografía, intervención, etc.
					<br>
				</p>
				<p>
					<b>Ejemplos Audiovisuales:</b>
				</p>
				<p class="col-md-offset-1">
					Proyectos de creación de cortometraje, video clip, serie fotográfica, creación sonora, video experimental, etc, a través de los géneros de animación, documental, argumental, ficción, experimental, interdisciplinario, etc, realizados en los espacios del CLAN, colegio y otros externos.
					<br>
				</p>
				<p>
					<b>Ejemplos Música:</b>
				</p>
				<p class="col-md-offset-1">
					Coro, Ensamble vocal, Montaje Vocal/Instrumental, Stomp, Percusión corporal...
					<br>
				</p>
				<p>
					<b>Artes Plásticas:</b>
					
				</p>
				<p class="col-md-offset-1">
					Proyecto colaborativo para intervenir un espacio en la IED
					<br>
					Proyecto de creación colectiva con base en una temática/obra focal
					<br>
					Proyecto interdisciplinar con otra área de conocimiento o centro de interés
					<br>
				</p>
				<p>
					<b>Arte Dramático:</b>
				</p>
				<p class="col-md-offset-1">
					Procesos creativos desde Preguntas
					<br>
					Procesos creativos desde abordaje de Temas
					<br>
					Proyectos de investigación-creación.
					<br>
					Proyectos interdisciplinares a través de preguntas transversales.
					<br>
					Procesos colaborativos y comunitarios.
					<br>
					Procesos de intervención de espacios.
					<br>
					Montaje de obras a partir del texto dramático
					<br>
					Montaje de obras de tipo experimental.
					<br>
					Procesos que involucran técnicas particulares; teatro gestual, circo, clown, etc.
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
<div class="modal fade center-modal" id="MODAL_EJEMPLO_CINCO" style="top: -5%;">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<div class="col-md-11">
					<h4 class="modal-title"><b>ARTICULACIÓN CON CICLOS DE EDUCACIÓN</b></h4>
				</div>
				<div class="col-md-1">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			</div>
			<div class="modal-body" style="text-align: justify;">
				<p>
					<b>CICLO I</b>
				</p>
				<p class="col-md-offset-1">
					<ul>
						<li>Ejes de desarrollo: Estimulación y Exploración</li>
						<li>Impronta del Ciclo: Infancias y Construcción de sujetos</li>	
					</ul>
					En este ciclo de desarrollo la intuición es la materia principal, a través de lo sensorial y motriz se explora y construye  mundo, como una manera de edificarse a sí mismo.
					<br>

				</p>
				<p>
					<b>CICLO II</b>
				</p>
				<p class="col-md-offset-1">
					<ul>
						<li>Ejes de desarrollo: Descubrimiento y Experiencia</li>
						<li>Impronta del Ciclo: Cuerpo, Creatividad y Cultura</li>
					</ul>
					Teniendo en cuenta que en este ciclo hay una mayor noción en lo conceptual, es importante orientar el trabajo a la exploración basada en la experiencia propia de mundo, es decir que el trabajo artístico detone preguntas sobre la historia de vida propia, familiar, etc.
					<br>
				</p>
				<p>
					<b>CICLO III</b>
				</p>
				<p class="col-md-offset-1">
					<ul>
						<li>Ejes de desarrollo: Indagación y Experimentación</li>
						<li>Impronta del Ciclo: Interacción Social y Construcción de  Mundos Posibles.</li>
					</ul>
					El A.F. busca desde su quehacer pedagógico que el niño, niña o joven logre estimular su visión de mundo a través de la retroalimentación constante tanto con sus   compañeros de proceso como con el A.F. El afianzamiento de en comunidad y la construcción de colectivos artísticos.
					<br>
				</p>
				<p>
					<b>CICLO IV</b>
				</p>
				<p class="col-md-offset-1">
					<ul>
						<li>Ejes de desarrollo: Vocación y Exploración Profesional</li>
						<li>Impronta del Ciclo: Proyecto de vida</li>
					</ul>
					El arte construye reflejos integrales que permite al joven artista a responder creativa, emocional y cognitivamente a procesos de vida, en este sentido el taller en este ciclo de vida, realiza el fortalecimiento de una práctica específica con miras a generar desde el arte opciones de vida.
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