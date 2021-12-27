<?php 
session_start();
if(!isset($_SESSION["session_username"])) {
	header("location:index.php");
} else {  ?> 
	<!DOCTYPE html>
	<html lang="es">
	<head>
		<meta charset="utf-8"> 
		<link href="../css/Siclan.css" rel="stylesheet">
		<link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
		<script src="../bower_components/jquery/dist/jquery.min.js"></script> 
		<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script> 

		<link href="../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet"> 
		<script src="../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>   

		<script src="../bower_components/fontawesome/svg-with-js/js/fontawesome-all.min.js" ></script>

		<link href="../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">  
		<script src="../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript" ></script>

		<script src="../bower_components/bootstrap-filestyle/src/bootstrap-filestyle.min.js" type="text/javascript"></script>

		<script src="../bower_components/jquery-validation/dist/jquery.validate.min.js"></script> 

		<script src="https://cdn.jsdelivr.net/gh/jamesssooi/Croppr.js@2.3.0/dist/croppr.min.js"></script>
        <link href="https://cdn.jsdelivr.net/gh/jamesssooi/Croppr.js@2.3.0/dist/croppr.min.css" rel="stylesheet"/>

		<script type="text/javascript" src="Js/ActualizarPerfilUsuario.js?v2020.04.07.27"></script>
		<style type="text/css">
	</style>
</head>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="page-header" align="center">
					<h1>Perfil de Usuario<small> SIF</small></h1>
				</div>
			</div>
			<div class="panel-body">

				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item active" ><a class="nav-link eventoClic mi_firma_tab" data-toggle="tab" href="#mi_firma" id="mi_firma_tab" role="tab">Subir Firma Escaneada</a></li>
					
					<li class="nav-item"><a class="nav-link eventoClic modificar_datos_tab" data-toggle="tab" href="#modificar_datos" id="modificar_datos_tab" role="tab">Datos Personales</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane" id="modificar_datos" role="tabpanel">
						<div class="row">
							<div class="signup-form-container">
								<div class="signup-form-container">
									<form role="form" id="update-form" name="update-form" autocomplete="off">
										<div class="form-body">
											<div class="col-md-10 col-md-offset-1">
												<h3 class="form-title"><i class="fa fa-user"></i> Datos Personales</h3>
												<i class="pull-right">
													<h4 class="form-title">Aquí usted como usuario del SIF podrá mantener actualizada su información personal, lo anterior para contar siempre con datos verídicos de nuestros usuarios. <span class="glyphicon glyphicon-pencil"></span></h4>
												</i>
											</div>
											<div class="col-md-10 col-md-offset-1">
												<hr>
											</div>
											<div class="col-md-8 col-md-offset-3">
												<div class="col-md-4">
													<div class="form-group">
														<div class="input-group">
															<div class="input-group-addon"><span class="fa fa-hashtag"></span></div>
															<input id="TB_NIdentificacion" name="TB_NIdentificacion" type="text" class="form-control" placeholder="Número de Identificación" data-toggle="tooltip" data-placement="top" title="Número de Identificación" readonly>
														</div>
														<span class="help-block" id="error"></span>
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<div class="input-group">
															<div class="input-group-addon"><span class="fa fa-id-card"></span></div>
															<select id="SL_TIPO_IDENTIFICACION" name="SL_TIPO_IDENTIFICACION" class="form-control selectpicker" data-live-search="true" data-toggle="tooltip" data-placement="top">
															</select>
														</div>
														<span class="help-block" id="error"></span>
													</div>
												</div>
											</div>
											<div class="col-md-8 col-md-offset-3">
												<div class="col-md-4">
													<div class="form-group">
														<div class="input-group">
															<div class="input-group-addon"><span><b>PN</b></span></div>
															<input id="TB_PNombre" name="TB_PNombre" type="text" class="form-control mayuscula" placeholder="Primer Nombre" data-toggle="tooltip" data-placement="top" title="Primer Nombre">
														</div>
														<span class="help-block" id="error"></span>
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<div class="input-group">
															<div class="input-group-addon"><span><b>SN</b></span></div>
															<input id="TB_SNombre" name="TB_SNombre" type="text" class="form-control mayuscula" placeholder="Segundo Nombre" data-toggle="tooltip" data-placement="top" title="Segundo Nombre">
														</div>
														<span class="help-block" id="error"></span>
													</div>
												</div>
											</div>
											<div class="col-md-8 col-md-offset-3">
												<div class="col-md-4">
													<div class="form-group">
														<div class="input-group">
															<div class="input-group-addon"><span><b>PA</b></span></div>
															<input id="TB_PApellido" name="TB_PApellido" type="text" class="form-control mayuscula" placeholder="Primer Apellido" data-toggle="tooltip" data-placement="top" title="Primer Apellido">
														</div>
														<span class="help-block" id="error"></span>
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<div class="input-group">
															<div class="input-group-addon"><span><b>SA</b></span></div>
															<input id="TB_SApellido" name="TB_SApellido" type="text" class="form-control mayuscula" placeholder="Segundo Apellido" data-toggle="tooltip" data-placement="top" title="Segundo Apellido">
														</div>
														<span class="help-block" id="error"></span>
													</div>
												</div>
											</div>
											<div class="col-md-8 col-md-offset-3">
												<div class="col-md-4">
													<div class="form-group">
														<div class="input-group">
															<div class="input-group-addon"><span class="fa fa-calendar"></span></div>
															<input id="TB_FNacimiento" name="TB_FNacimiento" type="text" class="form-control" placeholder="Fecha de Nacimiento" data-toggle="tooltip" data-placement="top" title="Fecha de Nacimiento">
														</div>
														<span class="help-block" id="error"></span>
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<div class="input-group">
															<div class="input-group-addon"><span class="fa fa-venus-mars"></span></div>
															<select id="SL_SEXO" name="SL_SEXO" class="form-control selectpicker" data-toggle="tooltip" data-placement="top" title="Genero"></select>
														</div>
														<span class="help-block" id="error"></span>
													</div>
												</div>
											</div>
											<div class="col-md-8 col-md-offset-3">
												<div class="form-group col-md-4">
													<div class="input-group">
														<div class="input-group-addon"><span class="fa fa-phone"></span></div>
														<input name="TB_Celular" id="TB_Celular" type="text" class="form-control" placeholder="Celular" data-toggle="tooltip" data-placement="top" title="Celular">
													</div>  
													<span class="help-block" id="error"></span>                    
												</div>
												<div class="form-group col-md-4">
													<div class="input-group">
														<div class="input-group-addon"><span class="fa fa-envelope"></span></div>
														<input id="TB_Correo" name="TB_Correo" class="form-control" placeholder="Email" data-toggle="tooltip" data-placement="top" title="Email">
													</div>  
													<span class="help-block" id="error"></span>                    
												</div>
											</div>
											<div class="col-md-8 col-md-offset-3">
												<div class="form-group col-md-8">
														<label for="TX_Foto_Perfil">Foto de perfil</label>
														<input id="TX_Foto_Perfil" name="TX_Foto_Perfil" type="file" runat="server">
														<p>Peso máximo: 5MB</p>
													<span class="help-block" id="error"></span>                    
												</div>
											</div>
											<div class="col-md-12">
												<center>
													<button id="BTN_SUBMIT" name="BTN_SUBMIT" type="submit" class="btn btn-success">Actualizar</button>
												</center>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					
					<div class="tab-pane active" id="mi_firma" role="tabpanel">
					  <form id="form_subir_firma">
						<div class="row">
						<div class="row">
						<div class="col-xs-12 col-md-12 text-center bg-info" id="top">
							<h4> Proceso para cargar firma</h4>
						</div>
					</div>
						<div class="row">
						<div class="col-xs-12 col-md-12">						
								<h3 class="form-title"><b>Recuerde que: </b></h3>
								<div class="col-xs-12 col-md-12 bg-info">	
								<ul>
									<br>
									<li>Cargue una foto de su firma lo mas clara posible.</li>
									<li>El fondo de la firma tiene que ser <b>totalmente blanco.</b></li>
									<li>La imagen de su firma debe estar en sentido horizontal.</li>
									<li>Si la firma en el informe no se ve correctamente puede volverla a subir.</li>
								</ul>
								</div>					
						</div>
						<div class="col-xs-12 col-md-12">						
								<div class="col-xs-12 col-md-12 bg-warning">	
								<ul id="mensaje_firma_actual">
								</ul>
								<center><img id="img_firma_actual" name="img_firma_actual" style="max-width: 200px !important; box-shadow: 2px 2px 12px 0px"></center>
								<br>
								</div>												
						</div>

					</div>
						<div class="row">
							<div class="col-md-8 col-md-offset-2">
								<h4>1. Seleccione la imagen de su firma</h4>
								<input type="file" id="TX_Firma_Usuario">
							</div>
						</div>
						<div class="row">	
							<div class="col-md-6 col-md-offset-2">
								<h4>2. Recorte la firma lo más ajustado posible</h4>
								<div id="editor_foto_firma"></div>
							</div>
						</div>
						<div class="row">	
							<div class="col-md-8 col-xs-12 col-md-offset-2">
								<h4>3. Visualice como se verá su firma </h4>								
									<canvas id="preview_foto_firma" style="max-width: 80% !important"></canvas>
							</div>
						</div>
						<div class="row">	
							<div class="col-md-8 col-md-offset-2" id="div_bt_guardar_firma">
								<input type="firma" name="firma" id="firma" hidden="hidden">
								<h4>4. Guarda tu firma</h4>
								<br>
								<input class="form-control btn btn-block btn-success" id="BT_reservar" type="submit" value="GUARDAR FIRMA">
							</div>
						</div>	
						</div>
					   </form>						
					</div>
				
				</div>
			</body>

			</html>
			<?php }  ?>