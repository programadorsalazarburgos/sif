<?php
session_start();
if(!isset($_SESSION["session_username"])) {
	header("location:index.php");
} else {  ?> 
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"> 
	<link href="../bootstrap/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/Siclan.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script type="text/javascript" src="Js/ActualizarPassword.js?v=2020.03.05.10"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../js/bootbox.js"></script>
	<script type="text/javascript" src="../LibreriasExternas/jquery.validate.min.js"></script>
	<style type="text/css">
</style>
</head>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="page-header" align="center">
					<h1>Cambio de Contraseña<small> SIF</small></h1>
				</div>
			</div>
			<div class="panel-body">
				<div class="signup-form-container">
					<div class="signup-form-container">
						<form role="form" id="change-password-form" name="change-password-form" autocomplete="off">
							<div class="form-body">
								<div class="col-md-6 col-md-offset-3">
									<!-- <h3 class="form-title"><i class="glyphicon glyphicon-lock"></i> Actualización de Contraseña</h3> -->
									<i class="pull-right">
										<h4 class="form-title">En este espacio podrás modificar tu contraseña. <i class="glyphicon glyphicon-lock"></i></h4>
									</i>
								</div>
								<div class="col-md-6 col-md-offset-3">
									<hr>
									<center>
										<i>
											<h5 class="form-title"><span class="glyphicon glyphicon-pushpin"></span> CONDICIONES DE SU NUEVA CONTRASEÑA:</h5>
											<h5 class="form-title"><span class="glyphicon glyphicon-menu-right"></span> Mínimo 8 caracteres.</h5>
											<h5 class="form-title"><span class="glyphicon glyphicon-menu-right"></span> Al menos una letra. (Aa-Zz)</h5>
											<h5 class="form-title"><span class="glyphicon glyphicon-menu-right"></span> Al menos 1 número. (0-9)</h5>
										</i>
									</center>
								</div>
								<div class="col-md-6 col-md-offset-4">
									<div class="col-md-8">
										<div class="form-group">
											<div class="input-group">
												<div class="input-group-addon"><span><b>Actual</b></span></div>
												<input id="TB_Old_Password" name="TB_Old_Password" type="password" class="form-control" placeholder="Contraseña actual" data-toggle="tooltip" data-placement="top"><div class="input-group-addon" title="Mostrar"><span class="glyphicon glyphicon-eye-open mostrar-pass" data-input-id="TB_Old_Password"></span></div>
											</div>
											<span class="help-block" id="error"></span>
										</div>
									</div>									
								</div>
								<div class="col-md-6 col-md-offset-4" hidden>
									<div class="col-md-8">
										<input id="TB_Pass_Actual_Hidden" name="TB_Pass_Actual_Hidden" type="text" class="form-control" placeholder="Validación" data-toggle="tooltip" data-placement="top" readonly>
									</div>									
								</div>
								<div class="col-md-6 col-md-offset-4">
									<div class="col-md-8">
										<div class="form-group">
											<div class="input-group">
												<div class="input-group-addon"><span><b>Nueva</b></span></div>
												<input id="TB_New_Password" name="TB_New_Password" type="password" class="form-control mayuscula" placeholder="Nueva contraseña" data-toggle="tooltip" data-placement="top" title="Nueva Contraseña"><div class="input-group-addon" title="Mostrar"><span class="glyphicon glyphicon-eye-open mostrar-pass" data-input-id="TB_New_Password"></span></div>
											</div>
											<span class="help-block" id="error"></span>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-md-offset-4">
									<div class="col-md-8">
										<div class="form-group">
											<div class="input-group">
												<div class="input-group-addon"><span><b>Nueva</b></span></div>
												<input id="TB_Retype_Password" name="TB_Retype_Password" type="password" class="form-control mayuscula" placeholder="Confirme la Nueva contraseña" data-toggle="tooltip" data-placement="top" title="Nueva Contraseña"><div class="input-group-addon" title="Mostrar"><span class="glyphicon glyphicon-eye-open mostrar-pass" data-input-id="TB_Retype_Password"></span></div>
											</div>
											<span class="help-block" id="error"></span>
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<center>
										<button id="BTN_SUBMIT" name="BTN_SUBMIT" type="submit" class="btn btn-success">Modificar Contraseña</button>
									</center>
								</div>
							</div>
						</form>
					</div>
				</div>
			</body>

			</html>
			<?php }  ?>