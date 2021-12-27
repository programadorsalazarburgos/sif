<?php
date_default_timezone_set('America/Bogota'); 
$horaCierre=new DateTime('2018-09-20 14:00:00');
$horaApertura=new DateTime('2018-09-23 05:45:00');
//$horaActual=date("Y-m-d H:i:s"); 
$horaActual=new DateTime();
if($horaActual >= $horaApertura){
//echo "hora de mantenimiento ".$horaCierre->format('Y-m-d H:i:s')." - ".$horaApertura->format('Y-m-d H:i:s');
  header("location:index.php"); 
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Sistema Integrado de Formación">
  <meta name="Keywords" content="siclan, siclan.gov.co, si.clan, si.clan.gov.co, idartes">
  <meta name="author" content="SICLAN">
  <title>SIF - MANTENIMIENTO</title>
  <link rel="shortcut icon" href="imagenes/favicon.png">
  <link href="bootstrap/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="bootstrap/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
  <link href="css/Siclan.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Yatra One|BioRhyme|Righteous|Prompt|Exo" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Wendy+One" rel="stylesheet" type="text/css">

  <link href="bootstrap/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <style type="text/css">
  body {
    background-image: url(imagenes/mantenimiento.jpg);
    background-position: center center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: cover;
    background-color:#464646;
    font-family: 'Exo';
    font-size: 14px; 
  }
</style>
</head>
<script>
  window.open = function() {};
  window.print = function() {};
// Support hover state for mobile.
if (false) {
  window.ontouchstart = function() {};
}
</script>
<script type="text/javascript" src="chrome-extension://bfbmjmiodbnnpllbbbfblcplfjjepjdn/js/injected.js"></script>
<meta content="clickberry-extension-here">
<meta content="clickberry-extension-here">
<style type="text/css"></style>
<style type="text/css"></style>
<style type="text/css"></style><style type="text/css"></style><script type="text/javascript" src="chrome-extension://bfbmjmiodbnnpllbbbfblcplfjjepjdn/js/injected.js"></script><meta content="clickberry-extension-here">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="js/iniciarsesion.js?v=1.5"></script>
<body>
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-green" style="background-color: transparent; border-color: transparent; ">
          <div class="panel-heading" style="padding: 0px; background-color: rgba(0,0,0,0.6); border-color: rgba(255,255,255,1); border-radius: 10%">
            <br>
            <!-- <center><img src="imagenes/siclan-blanco.png" width="100%"></center> -->
            <center><h1>Estamos en proceso de migración.<br></h1>
              <h2>El sistema estará disponible nuevamente a las 06:00 del día Lunes 23 de Septiembre.</h2><br>
              <h3>La hora es: <?php echo $horaActual->format('Y-m-d H:i:s');?></h3></center>
              <br>
            </div>
            <br>
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
  <script>
    if (document.location.search.match(/type=embed/gi)) {
      window.parent.postMessage('resize', "*");
    }
  </script> 
</body>
</html>