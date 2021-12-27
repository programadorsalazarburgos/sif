<?php
session_start();
if(!isset($_SESSION["session_username"])) {
	header("location:index.php");
} else {
	$Id_Persona= $_SESSION["session_username"];
	?> 
	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Registrar Inventario</title>
		<link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
		<link href="../css/Siclan.css" rel="stylesheet">
		<link href="Css/infraestructura.css" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Yatra One|BioRhyme|Righteous|Prompt" rel="stylesheet">
		<link href="../bower_components/jquery-ui/themes/base/jquery-ui.css" rel="Stylesheet"></link>
		<link href="../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" rel="stylesheet">
		<script src="../bower_components/jquery/dist/jquery.min.js"></script>
		<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<script src="../bower_components/bootbox.js/bootbox.js"></script>
		<script src="../bower_components/jquery-ui/jquery-ui.js"></script>
		<script src="../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
		<script src="../bower_components/fontawesome/svg-with-js/js/fontawesome-all.min.js" ></script>
		<script src="../bower_components/bootstrap-filestyle/src/bootstrap-filestyle.js?v=2020.05.21.0"> </script>
		<script src="Js/RegistrarInventario.js?v=2020.01.09.5"></script>
	</head>
	<body>
		<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
		<div class="panel panel-primary">
			<FORM id="fm_registrar_inventario" name="fm_registrar_inventario" enctype="multipart/form-data">
				<div class="panel-heading panel-heading-custom">
					<div class="col-xs-12 col-md-12 col-lg-12 col-centered">
						<div class="col-xs-4">
							<strong><p style="font-size:20px; color: white !important" class="col-centered">REGISTRO DE INVENTARIO EN</p></strong>
						</div>
						<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
							<select id="SL_PROYECTO" name="SL_PROYECTO" class="form-control required" required title="Seleccione Proyecto">
							</select>
						</div>
						<div class="col-xs-3">
							<select id="SL_LUGAR" name="SL_LUGAR" class="selectpicker form-control required" data-live-search="true" title="Seleccione el Lugar" required>
							</select>
						</div>
					</div>
				</div>
				<div class="alert alert-success" id="Notificacion_Success" hidden><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>
				<div class="alert alert-danger" id="Notificacion_Wrong" hidden><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>El elemento no pudo ser registrado...</div>
				<div class="panel-body" style="padding: 0px;">
					<center>
						<div class="row row-centered">
							<div id="div_registro_inventario" hidden>
								<div class="col-xs-6 col-md-6 col-lg-6 custom-border">
									<div class="col-xs-12 col-md-12 col-lg-12" style="padding-top:1%">
										<div id="div_tipo_bien" name="div_tipo_bien">
											<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="text-align:right;">
												<label><p>Tipo Bien*:</p></label>
											</div>
											<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
												<select id="SL_TIPO_BIEN" name="SL_TIPO_BIEN" class="form-control required" required title="Seleccione Tipo Bien">
												</select>
											</div>
										</div>
									</div>
									<div class="col-xs-12 col-md-12 col-lg-12" style="padding-top:1%">
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="text-align:right;">
											<label><p>Cantidad*:</p></label>
										</div>
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
											<input id="TXT_CANTIDAD" name="TXT_CANTIDAD" class="form-control required" type="number" min="0" required>
										</div>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-top:1%">
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="text-align:right;">
											<label><p>Elemento*:</p></label>
										</div>
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
											<select id="SL_ELEMENTO" name="SL_ELEMENTO" class="form-control required" required title="Seleccione Elemento">
											</select>
										</div>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-top:1%; padding-bottom:1%; background-color:rgba(0,0,0,0.1)" id="div_donante" name="div_donante" hidden>
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="text-align:right;">
											<label><p>Donante*:</p></label>
										</div>
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
											<input id="TXT_DONANTE" name="TXT_DONANTE" class="form-control" placeholder="" type="text" list="donantes">
											<datalist id="donantes">
											</datalist>
										</div>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-top:1%;">
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="text-align:right;">
											<label><p>Estado*:</p></label>
										</div>
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
											<select id="SL_ESTADO_BIEN" name="SL_ESTADO_BIEN" class="form-control required" required title="Seleccione Estado">
											</select>
										</div>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-top:1%">
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="text-align:right;">
											<label><p># Traslado*:</p></label>
										</div>
										<div class="input-group col-xs-6 col-sm-6 col-md-6 col-lg-6">
											<input id="TXT_NUMERO_TRASLADO" name="TXT_NUMERO_TRASLADO" class="form-control required" type="text" onkeyup="this.value=this.value.replace(/[^\d]+/,'')" maxlength="10" required>
											<span class="input-group-btn"><input id="BT_SIN_NUMERO_TRASLADO" type="button" value="X" class="btn btn-success form-control"></span>
										</div>
									</div>
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 custom-border">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-top:1%">
										<label><p>Descripcion*:</p></label>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<textarea id="TXT_DESCRIPCION" name="TXT_DESCRIPCION" class="form-control required" type="text" rows="3" maxlength="500" required></textarea>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-top:1%">
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="text-align:right;">
											<label><p>Valor Unitario Inicial:</p></label>
										</div>
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
											<input id="TXT_VALOR_INICIAL" name="TXT_VALOR_INICIAL" value="0" class="form-control change-event" type="text">
										</div>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-top:1%">
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="text-align:right;">
											<label><p>Placa*:</p></label>
										</div>
										<div class="input-group col-xs-6 col-sm-6 col-md-6 col-lg-6">
											<input id="TXT_PLACA_1" name="TXT_PLACA_1" class="TXT_PLACA form-control required" type="text" onkeyup="this.value=this.value.replace(/[^\d]+/,'')" maxlength="10" required>
											<span class="input-group-btn"><input type="button" value="S/P" class="BT_SIN_PLACA btn btn-success form-control" data-id-input="1"></span>
											<input type="file" multiple class="btn btn-success filestyle" id="REGISTRO_FOTOGRAFICO_1" name="REGISTRO_FOTOGRAFICO_1[]" data-btnClass='btn-success' runat='server' data-text='Fotografía(s)'>
										</div>
									</div>
									<div id="div_placas_multiples">
										
									</div>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 botom-border">
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-xs-offset-4 col-md-offset-4 col-lg-offset-4" style="padding:1%">
										<input id="BT_LIMPIAR" name="BT_LIMPIAR" class="btn btn-warning form-control" type="reset" value="Limpiar">
									</div>
									<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style="padding:1%">
										<input class="btn btn-primary form-control" id="BT_REGISTRAR" name="BT_REGISTRAR" type="submit" value="REGISTRAR">
									</div>
								</div>
								<div id="div_archivos_adjuntos" name="div_archivos_adjuntos" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<h4>Se subirán los siguientes archivos:</h4>
								</div>
							</div>
						</div>

					</center>				
				</div>  
			</FORM>
		</div>
	</body> 
	</html>

	<?php }  ?>