<?php
session_start();
if(!empty($_SESSION['id_usuario']) AND !empty($_SESSION['nombre_usuario']) ){

}else{
	header("location:index.php");
}
?>
<!DOCTYPE html>
<html>
<title>Convocatoria Organizaciones</title>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7; IE=EmulateIE9"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
<meta charset="utf-8"/> 
<link rel="shortcut icon" href="../public/imagenes/favicon.png">
<link href="../public/css/Siclan.css" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css?family=Yatra One|BioRhyme|Righteous|Prompt" rel="stylesheet"/>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />
<link href="https://fonts.googleapis.com/css?family=Play:400,700" rel="stylesheet">
<link href="assets/css/MenuOrganizacion.css" rel="stylesheet"/>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>                    
<script src="assets/js/menu_organizacion.js?v=2020.09.30.0"></script>
<script src="bootbox.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/md5.js"></script>
<script type="text/javascript" src="bootstrap-filestyle.js"> </script>
<style type="text/css">

</style>
</head>
<body>
	<div id="div_body">
		<div class="panel panel-info col-md-12 col-lg-12">
			<center>
				<img src="assets/images/LogoCrea.jpg" width="960" height="156">
				
			</center>

			<nav class="navbar navbar-default">
				<div class="container-fluid">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						
						<h3>Bienvenido <?php echo $_SESSION['nombre_usuario']?></h3>
					</div>

					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">						
						<ul class="nav navbar-nav navbar-right">
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-menu-hamburger"></span> Opciones</a>
								<ul class="dropdown-menu">
									<li><a id="cambiar_password" name="cambiar_password" href="#">Cambiar Contraseña</a></li>
									<li role="separator" class="divider"></li>
									<li><a id="cerrar_sesion" href="#">Cerrar Sesión</a></li>
								</ul>
							</li>
						</ul>
					</div><!-- /.navbar-collapse -->
				</div><!-- /.container-fluid -->
			</nav>

			<div class="panel-body"> 
				<center>
					<div class="container">
						<div class="row">
							<div class="page-header" id="title_convocatoria" name="title_convocatoria">
								<h1>Paso a Paso Convocatoria 2018</h1>
								<center>
									<p>Debe cambiar la contraseña que le fue asignada para poder acceder a las opciones dispuestas para la presentación de la propuesta.</p>
								</center>
							</div>
							<div class="col-md-11 ">
								<div class="progress">
									<div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
										0% Completado
									</div>
								</div>	
							</div>
							<div id="timeline" name="timeline">
								<ul class="timeline timeline-horizontal">
									<li class="timeline-item">
										<div class="timeline-badge primary"><i class="glyphicon glyphicon-time"></i></div>
										<div class="timeline-panel">
											<div class="timeline-heading">
												<div id="div_password" name="div_password" hidden>
													<button id="password" name="password" type="submit" class="form-control" data-toggle="tooltip" data-placement="top" title="CAMBIAR CONTRASEÑA" style="font-size: 11px;"><b>1. CAMBIAR CONTRASEÑA</b>
													</button><br><br>
												</div>
											</div>
										</div>
									</li>
									<li class="timeline-item">
										<div class="timeline-badge primary"><i class="glyphicon glyphicon-time"></i></div>
										<div class="timeline-panel">
											<div class="timeline-heading">
												<div id="habilitantes" hidden>
													<div id="div_subir_habilitantes" name="div_subir_habilitantes">
														<button id="subir_habilitantes" name="subir_habilitantes" type="submit" class="form-control" style="font-size: 11px;"><b>2. SUBIR DOCUMENTOS DE IDONEIDAD</b></button>
														<button id="reporte_habilitantes" name="reporte_habilitantes" type="submit" class="form-control" data-toggle="tooltip" data-placement="top" title="DESCARGAR REPORTE" style="font-size: 11px;">REPORTE DOCUMENTOS IDONEIDAD
															<i class="glyphicon glyphicon-download-alt"></i>
														</button><br><br>
													</div>
												</div>
											</div>
										</div>
									</li>
									<li class="timeline-item">
										<div class="timeline-badge primary"><i class="glyphicon glyphicon-time"></i></div>
										<div class="timeline-panel">
											<div class="timeline-heading">
												<div id="div_de_propuesta"  hidden>
													<div id="div_propuesta" name="div_propuesta">
														<button id="propuesta" name="propuesta" type="submit" class="form-control" style="font-size: 11px;"><b>3. DILIGENCIAR LA PROPUESTA</b></button>
														<button id="reporte_propuesta" name="reporte_propuesta" type="submit" class="form-control" data-toggle="tooltip" data-placement="top" title="DESCARGAR REPORTE" style="font-size: 11px;">REPORTE PROPUESTA
															<i class="glyphicon glyphicon-download-alt"></i>
														</button><br><br><br>
													</div>
												</div>
											</div>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>

				</div>


				
					<div id="div_consulta" name="div_consulta" class="col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-lg-offset-2">
						<button id="consultar_propuestas" name="consultar_propuestas" type="submit" class="form-control">CONSULTAR PROPUESTAS</button><br><br>
					</div>
					<br>
					<div id="div_invitacion" name="div_invitacion" class="col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-lg-offset-2" hidden>
						<button id="invitacion" name="invitacion" type="submit" class="form-control" data-toggle="tooltip" data-placement="top" title="INVITACIÓN CONVOCATORIA"><b>VER INVITACIÓN</b></button><br><br>
					</div>

					<!-- <div id="subsanaciones">
						<div id="div_subir_subsanaciones" name="div_subir_subsanaciones" class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xs-offset-1 col-sm-offset-1 col-md-offset-1 col-lg-offset-1">
							<button id="subir_subsanaciones" name="subir_subsanaciones" type="submit" class="btn btn-md btn-primary">SUBIR SUBSANACIONES</button>
							<button id="reporte_subsanaciones" name="reporte_subsanaciones" type="submit" class="btn btn-md btn-danger">REPORTE SUBSANACIONES
								<i class="glyphicon glyphicon-download-alt"></i>
							</button><br><br>
						</div>
					</div> -->

					<!-- <div id="subsanaciones2">
						<div id="div_subir_subsanaciones2" name="div_subir_subsanaciones2" class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-xs-offset-1 col-sm-offset-1 col-md-offset-1 col-lg-offset-1">
							<button id="subir_subsanaciones2" name="subir_subsanaciones2" type="submit" class="btn btn-md btn-primary">SUBIR SEGUNDAS SUBSANACIONES</button>
							<button id="reporte_subsanaciones2" name="reporte_subsanaciones2" type="submit" class="btn btn-md btn-danger">REPORTE
								<i class="glyphicon glyphicon-download-alt"></i>
							</button><br><br>
						</div>
					</div> -->
				
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xs-offset-3 col-sm-offset-3 col-md-offset-3 col-lg-offset-3">
					<div class="alert alert-danger" id="div_alerta" name="div_alerta" hidden>
						<strong>Acceso Denegado!</strong> Usuario o contraseña Incorrecta.
					</div>
				</div>
			</div>
			<div class="modal fade" id="modal_cambiar_password" name="modal_cambiar_password" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-md" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h4 class="modal-title">Cambiar Contraseña</h4>
						</div>
						<div class="modal-body">
							<form id="FORM_CAMBIAR_PASSWORD" name="FORM_CAMBIAR_PASSWORD" enctype="multipart/form-data">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="background-color: #eaeaea; padding:5px; border-style: groove;"><br>
									<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xs-offset-1 col-sm-offset-1 col-md-offset-1 col-lg-offset-1" style="text-align: right">
										<label>Contraseña Actual*: </label>
									</div>
									<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
										<input id="password_anterior" name="password_anterior" type="password" class="form-control" maxlength="100" required>
									</div>	
									<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xs-offset-1 col-sm-offset-1 col-md-offset-1 col-lg-offset-1" style="text-align: right">
										<label>Nueva Contraseña*: </label>
									</div>
									<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
										<input id="password_nueva" name="password_nueva" type="password" class="form-control" minlength="8" maxlength="100" required><br>
									</div>
									<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xs-offset-4 col-sm-offset-4 col-md-offset-4 col-lg-offset-4">
										<input id="confirmar_cambiar" name="confirmar:cambiar" type="submit" class="form-control btn btn-info" value="CONFIRMAR">
									</div>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<br>
									<div class="alert alert-danger" id="div_modal_alerta" name="div_modal_alerta" hidden>
										<strong>La contraseña actual no es correcta!</strong>
									</div>
								</div>   
							</form>
						</div>
						<div class="modal-footer">

						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->
			<div class="modal fade" id="modal_subir_habilitantes" name="modal_subir_habilitantes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h4 class="modal-title">Subir Documentos de Idoneidad</h4>
						</div>
						<div class="modal-body">
							<form id="FORM_HABILITANTES" name="FORM_HABILITANTES" enctype="multipart/form-data">
								<p style="font-size: 16px">Organicé los documentos en una misma carpeta antes de adjuntarlos, y arrastrando el MOUSE o haciendo uso de la tecla CTRL seleccionelos todos.</p>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="contenedor_anexos">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-3 col-sm-offset-3 col-md-offset-3 col-lg-offset-3">
											<div id="div_archivo" class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
												<input id="archivo" name="file[]" type="file" class="filestyle" data-buttonName="btn-primary" runat="server" multiple required>
											</div>
											<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
												<button type="submit" class="btn btn-success" id="enviar_habilitantes">Enviar Documentos</button>
											</div>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<br>
										</div>
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="background-color: #eaeaea; padding:5px; border-style: groove;"><br>
									<p style="font-size: 16px">Porfavor adjunte los siguientes <strong>19</strong> documentos:</p>
									<p><strong>Maxima cantidad de archivos permitidos 20</strong></p>
									<p>Se recomienda comprimir algunos archivos para no sobrepasar dicho limite, Ejemplo: Certificaciones.rar, Estatutos.rar</p>
									<p style="font-size: 12px; margin:0cm 0cm 0cm;"><strong>1)</strong> Formato Único de Hoja de Vida de Persona Jurídica</p>
									<p style="font-size: 12px; margin:0cm 0cm 0cm;"><strong>2)</strong> Certificado de Existencia y Representación Legal</p>	
									<p style="font-size: 12px; margin:0cm 0cm 0cm;"><strong>3)</strong> Autorización del órgano competente para el representante legal del Asociado para suscribir convenios</p>
									<p style="font-size: 12px; margin:0cm 0cm 0cm;"><strong>4)</strong> Copia legible de los estatutos de la entidad</p>
									<p style="font-size: 12px; margin:0cm 0cm 0cm;"><strong>5)</strong> Fotocopia de la cédula de ciudadanía del Representante Legal</p>
									<p style="font-size: 12px; margin:0cm 0cm 0cm;"><strong>6)</strong> Balance General con corte a 31 de diciembre de 2015</p>
									<p style="font-size: 12px; margin:0cm 0cm 0cm;"><strong>7)</strong> Estado de pérdidas y ganancias con corte a 31 de Diciembre de 2015</p>
									<p style="font-size: 12px; margin:0cm 0cm 0cm;"><strong>8)</strong> Notas a los Estados Financieros con corte a 31 de Diciembre de 2015</p>
									<p style="font-size: 12px; margin:0cm 0cm 0cm;"><strong>9)</strong> Declaración de Renta de los últimos tres años, con sello de presentación legible</p>
									<p style="font-size: 12px; margin:0cm 0cm 0cm;"><strong>10)</strong> Certificaciones de experiencia de la entidad sin ánimo de lucro (mínimo 2 años de experiencia en procesos de formación con niños, niñas y adolescentes)</p>
									<p style="font-size: 12px; margin:0cm 0cm 0cm;"><strong>11)</strong> Certificación expedida por Superpersonas Jurídicas (Vigente)</p>
									<p style="font-size: 12px; margin:0cm 0cm 0cm;"><strong>12)</strong> Fotocopia del RUT</p>
									<p style="font-size: 12px; margin:0cm 0cm 0cm;"><strong>13)</strong> Fotocopia del RIT (SI APLICA)</p>
									<p style="font-size: 12px; margin:0cm 0cm 0cm;"><strong>14)</strong> Certificación de cumplimiento de las obligaciones con la Seguridad Social y Parafiscales</p>
									<p style="font-size: 12px; margin:0cm 0cm 0cm;"><strong>15)</strong> Certificación Revisor Fiscal sobre costos de las actividades del proyecto <strong>(No obligatorio)</strong></p>
									<p style="font-size: 12px; margin:0cm 0cm 0cm;"><strong>16)</strong> Certificación de Antecedentes Contraloría</p>
									<p style="font-size: 12px; margin:0cm 0cm 0cm;"><strong>17)</strong> Certificación de Antecedentes Personería</p>
									<p style="font-size: 12px; margin:0cm 0cm 0cm;"><strong>18)</strong> Certificación de Antecedentes Procuraduría</p>
									<p style="font-size: 12px; margin:0cm 0cm 0cm;"><strong>19)</strong> Certificación de Antecedentes Judiciales Policía Nacional</p>
								</div>
								<div id="archivos_adjuntos_habilitantes" class="col-xs-6 col-sm-6 col-md-6 col-lg-6 alert alert-danger" style="padding:5px; border-style: groove;">
								</div>   
							</form>
						</div>
						<div class="modal-footer">

						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->

			<div class="modal fade" id="modal_subir_subsanaciones" name="modal_subir_subsanaciones" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h4 class="modal-title">Subir Documentos de Subsanación</h4>
						</div>
						<div class="modal-body">
							<form id="FORM_SUBSANACIONES" name="FORM_SUBSANACIONES" enctype="multipart/form-data">
								<p style="font-size: 16px">Organicé los documentos en una misma carpeta antes de adjuntarlos, y arrastrando el MOUSE o haciendo uso de la tecla CTRL seleccionelos todos.</p>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="contenedor_anexos">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-3 col-sm-offset-3 col-md-offset-3 col-lg-offset-3">
											<div id="div_archivo" class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
												<input id="archivo_subsanacion" name="file[]" type="file" class="filestyle" data-buttonName="btn-primary" runat="server" multiple required>
											</div>
											<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
												<button type="submit" class="btn btn-success" id="enviar_subsanaciones">Enviar Subsanaciones</button>
											</div>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<br>
										</div>
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="background-color: #eaeaea; padding:5px; border-style: groove;"><br>
									<p style="font-size: 16px">Porfavor adjunte los documentos que dan respuesta a las observaciones que le fueron realizadas, ya sea solo uno o varios.:</p>
									<p><strong><i>Maxima cantidad de archivos permitidos 20</i></strong></p>
									<p>En caso de ser muchos documentos se recomienda comprimir algunos de ellos para no sobrepasar dicho limite.</p>
								</div>
								<div id="archivos_adjuntos_subsanaciones" class="col-xs-6 col-sm-6 col-md-6 col-lg-6 alert alert-danger" style="padding:5px; border-style: groove;">
								</div>   
							</form>
						</div>
						<div class="modal-footer">

						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->

			<div class="modal fade" id="modal_subir_subsanaciones2" name="modal_subir_subsanaciones2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h4 class="modal-title">Subir Documentos de Segunda Subsanación</h4>
						</div>
						<div class="modal-body">
							<form id="FORM_SUBSANACIONES2" name="FORM_SUBSANACIONES2" enctype="multipart/form-data">
								<p style="font-size: 16px">Organicé los documentos en una misma carpeta antes de adjuntarlos, y arrastrando el MOUSE o haciendo uso de la tecla CTRL seleccionelos todos.</p>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="contenedor_anexos">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-3 col-sm-offset-3 col-md-offset-3 col-lg-offset-3">
											<div id="div_archivo" class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
												<input id="archivo_subsanacion2" name="file[]" type="file" class="filestyle" data-buttonName="btn-primary" runat="server" multiple required>
											</div>
											<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
												<button type="submit" class="btn btn-success" id="enviar_subsanaciones2">Enviar Segundas Subsanaciones</button>
											</div>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<br>
										</div>
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="background-color: #eaeaea; padding:5px; border-style: groove;"><br>
									<p style="font-size: 16px">Porfavor adjunte los documentos que dan respuesta a las observaciones que le fueron realizadas, ya sea solo uno o varios.:</p>
									<p><strong><i>Maxima cantidad de archivos permitidos 20</i></strong></p>
									<p>En caso de ser muchos documentos se recomienda comprimir algunos de ellos para no sobrepasar dicho limite.</p>
								</div>
								<div id="archivos_adjuntos_subsanaciones2" class="col-xs-6 col-sm-6 col-md-6 col-lg-6 alert alert-danger" style="padding:5px; border-style: groove;">
								</div>   
							</form>
						</div>
						<div class="modal-footer">

						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->

			<div class="modal fade" id="modal_enviando" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-md" role="document">
					<div class="modal-content">
						<div class="modal-body">
							<img src="assets/images/enviando.gif" width="600" height="250">      
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->
		</body>

		</html>