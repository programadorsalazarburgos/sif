<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Recuperar Contraseña</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
 
 <link rel="shortcut icon" href="imagenes/favicon.ico">
<link href="bootstrap/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="bootstrap/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
<link href="css/Siclan.css" rel="stylesheet">
<link href="bootstrap/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

	<style type="text/css">
	
body {
  background-image: url(imagenes/Fondo.jpg);
  background-position: center center;
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: cover;
  background-color:#464646;
}
</style>
<script type=" text / javascript ">
     function anular(e) {
          tecla = (document.all) ? e.keyCode : e.which;
          return (tecla != 13);
     }
</script>

</head>
<body>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
              <div class="login-panel panel panel-green">
                    <div class="panel-heading">
                       	<font color="#FFFFFF" size="4"> <center><strong>RECUPERACIÓN DE CONTRASEÑA</strong> </center> </font>
						
                    </div>
                <div class="panel-body">
                  <div class="jumbotrom">
                  	<h3>Porfavor escribanos al correo <a href="mailto:si.clan@idartes.gov.co?Subject=Olvide%20Contraseña"><font color="#27ba3d">si.crea@idartes.gov.co</font></a> indicando su nombre y número de cédula y le daremos respuesta por dicho medio.</h3>
                  	<center><a href="index.php" class="btn btn-warning">Volver a inicio</a><input type="button" name="ver-ejemplo" id="ver-ejemplo" value="Ver Ejemplo" data-toggle="modal" data-target="#modal-contrasenia" class="btn btn-primary"></center>
                  </div>
                </div>
                </div>
            </div>
	
        </div>
 </div>
	
 <script src="bootstrap/jquery/dist/jquery.min.js"></script>
 <script src="bootstrap/bootstrap/dist/js/bootstrap.min.js"></script>
 <script src="bootstrap/metisMenu/dist/metisMenu.min.js"></script>
 <script src="js/Siclan.js"></script>
 <script src='https://www.google.com/recaptcha/api.js?hl=es-419'></script>
</body>
<div id="modal-contrasenia" class="modal fade" style="font-size: 20px;"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title" id="h4-edit">Recuperacion de contraseña</h4>
        </div>
        <div class="modal-body">
        	<center><img src="imagenes/reestablecer_contrasenia.png"></center>
        </div>
		</div>       
        </div>
</div>

</html>


