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
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="bootbox.js"></script>
<script src="../public/bootstrap/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js"></script>
<script src="../public/bootstrap/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.colVis.min.js"></script>
<script src="ConsultarConvocatoria.js?v=2018.07.18.0"></script>
<style type="text/css">
body{
	overflow-x:hidden
}
img {max-width:100%;}
/* centered columns styles */
.row-centered {text-align:center;}
.col-centered {
	display:inline-block;
	float:none;
	/* reset the text-align */
	text-align:right;
	/* inline-block space fix */
	margin-right:-4px;
}
p{
	font-family: 'Prompt';
	font-size: 17px; 
}
label{text-align: right;}
#container {
	height: 400px; 
	min-width: 310px; 
	max-width: 800px;
	margin: 0 auto;
}
</style>       
</head>
<body>
	<div id="div_body">
		<center>
			<header>
				<img src="imagenes/Logo.jpg" width="960" height="156" alt="">
				<br>
			</header> 
		</center>
		<div class="panel panel-success">

			<div class="col-md-12 panel-heading">
				<div class="col-md-4 col-md-offset-4">
					<center>
						<strong><p style="font-size:25px">BIENVENIDO <?php echo $_SESSION['nombre_usuario']?></p></strong>
					</center>
				</div>
				<div class="col-md-2">
					<button id="cerrar_sesion" class="btn btn-sm btn-danger">Cerrar sesión</button>
				</div>
			</div>
			<div class="panel-body" style="background-color:rgb(240,243,245)"> 
				<center>
					<p>
						<strong>Aquí podrá consultar las propuestas que han sido registradas para determinada convocatoria</strong><br>Por favor seleccione la convocatoria:
					</p>
				</center>
				<center>
					<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xs-offset-4 col-sm-offset-4 col-md-offset-4 col-lg-offset-4">
						<select id="SL_CONVOCATORIA" class="form-control" title="Convocatoria">
							<option value="">Seleccione una convocatoria</option>
							<!-- <option value="2016-11">2016-11</option> -->
							<option value="2016-12">2016-12</option>
						</select>
						<button class="btn btn-success form-control" id="consultar_convocatoria">Consultar</button>
						<br>
					</div>

					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"><h3>ORGANIZACIONES</h3></div>
					<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-lg-offset-2"><br>
						<table id="tabla-convocatoria" class="table table-hover row-centered">
							<thead>
								<th>Id_Usuario</th>
								<th>Usuario</th>
								<th>Opciones</th>
							</thead>
						</table>
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
											<input id="confirmar_cambiar" name="confirmar:cambiar" type="submit" class="form-control btn btn-success" value="CONFIRMAR">
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
								<h4 class="modal-title">Subir Documentos Habilitantes</h4>
							</div>
							<div class="modal-body">
								<form id="FORM_HABILITANTES" name="FORM_HABILITANTES" enctype="multipart/form-data">
									<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="background-color: #eaeaea; padding:5px; border-style: groove;"><br>
										<p style="font-size: 16px">Porfavor adjunte los siguientes documentos:</p>
										<p style="font-size: 12px; margin:0cm 0cm 0cm;"><strong>1)</strong> Documento Uno.</p>
										<p style="font-size: 12px; margin:0cm 0cm 0cm;"><strong>2)</strong> Documento Dos.</p>	
										<p style="font-size: 12px; margin:0cm 0cm 0cm;"><strong>3)</strong> Documento Tres.</p>
										<p style="font-size: 12px; margin:0cm 0cm 0cm;"><strong>4)</strong> Documento Cuatro.</p>
										<p style="font-size: 12px; margin:0cm 0cm 0cm;"><strong>5)</strong> Documento Cinco.</p>
									</div>
									<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="background-color: #eaeaea; padding:5px; border-style: groove;"><br>
										<p style="font-size: 16px">Organicé los documentos en una misma carpeta antes de adjuntarlos, y haciendo uso de la tecla CTRL o arrastrando el MOUSE seleccione todos ellos.</p><br><br>	
									</div>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="contenedor_anexos">
											<br>
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xs-offset-3 col-sm-offset-3 col-md-offset-3 col-lg-offset-3">
												<div id="div_archivo" class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
													<input id="archivo" name="file[]" type="file" class="filestyle" data-buttonName="btn-primary" runat="server" multiple required>
												</div>
												<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
													<button type="submit" class="btn btn-primary" id="enviar_habilitantes">Enviar Documentos</button>
												</div>
											</div>	
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
												<br>
												<div class="alert alert-danger">
													<strong>Estos son todos los archivos que se van a enviar:</strong>
													<div id="archivos_adjuntos_habilitantes">

													</div>
												</div>
											</div>
										</div>
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
								<img src="imagenes/enviando.gif" width="600" height="250">      
							</div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
			</body>

			<div class="modal fade" id="modal_anexos_propuesta" name="modal_anexos_propuesta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h4 class="modal-title">Anexos Propuesta</h4>
						</div>
						<div class="modal-body">
							<table id="tabla-anexos" name="tabla-anexos" class="table-hover">
								<thead>
									<th>Nombre Anexo</th>
									<th>Link</th>
								</thead>
							</table>
						</div>
						<div class="modal-footer">
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->


			</html>