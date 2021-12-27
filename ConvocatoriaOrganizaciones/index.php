<?php
session_start();
if(!empty($_SESSION['id_usuario']) AND !empty($_SESSION['nombre_usuario']) ){
	header("location:menuorganizacion.php");
}else{
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
<link href="assets/css/Index.css" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css?family=Yatra One|BioRhyme|Righteous|Prompt" rel="stylesheet"/>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>                    
<link href="https://fonts.googleapis.com/css?family=Play:400,700" rel="stylesheet">
<script src="InicioSesion.js?v=1.2"></script>
</head>
<body>
	<div id="precarga" style="padding-top:100px">
		<center><img src="assets/images/cargando-formulario.gif"></center>
	</div>
	<div id="div_body" class="" hidden>
		<div class="panel panel-info col-md-4 col-lg-4 col-md-offset-4 col-lg-offset-4">
			<img src="assets/images/LogoCrea.jpg" width="960" height="110" alt="">
			<div class="panel-heading row-centered">
				<h3>CONVOCATORIA ORGANIZACIONES 2018</h3>
			</div>
			<div class="panel-body"> 
				<form id="FORM_LOGIN" name="FORM_LOGIN" enctype="multipart/form-data">
					<center><b>1.</b> Utilice el Usuario y Contraseña asignado, el cual le fue enviado mediante correo electrónico.
						<br><strong><b>2.</b> Una vez ingrese es OBLIGATORIO que CAMBIE SU CONTRASEÑA para que pueda acceder a todas las opciones.</strong></center>
						<br>			
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 row-centered"><p>INICIO DE SESIÓN</p></div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><br>
							<div class="col-md-3 col-lg-3 col-md-offset-2 col-lg-offset-2" style="text-align: right">
								<label>USUARIO: </label>
							</div>
							<div class="col-md-6 col-lg-6">
								<input id="usuario" name="usuario" type="text" class="form-control" maxlength="100" required>
							</div>	
							<div class="col-md-3 col-lg-3 col-md-offset-2 col-lg-offset-2" style="text-align: right">
								<label>CONTRASEÑA: </label>
							</div>
							<div class="col-md-6 col-lg-6">
								<input id="password" name="password" type="password" class="form-control" maxlength="100" required><br>
							</div>
							<div class="col-md-4 col-lg-4 col-md-offset-4 col-lg-offset-4">
								<input id="iniciar_sesion" name="iniciar_sesion" type="submit" class="form-control btn btn-info" value="INICIAR SESIÓN">
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<br>
							<div class="alert alert-danger row-centered" id="div_alerta" name="div_alerta" hidden>
								<strong>Acceso Denegado!</strong> Usuario o contraseña Incorrecta.
							</div>
						</div>   
					</form>
				</div>
			</div>
		</div>
	</body>

	</html>