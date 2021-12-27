<?php
session_start();
if(!isset($_SESSION["session_username"])) {
    header("location:index.php");
}

?> 
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="bootstrap/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Yatra One|BioRhyme|Righteous|Prompt" rel="stylesheet">
    <link href="css/Siclan.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bienvenida_version.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="LibreriasExternas/amcharts/amcharts/amcharts.js"></script>
    <script src="LibreriasExternas/amcharts/amcharts/pie.js"></script>
    <script src="LibreriasExternas/amcharts/amcharts/serial.js"></script>
    <script src="LibreriasExternas/amcharts/amcharts/gauge.js"></script>
    <script src="LibreriasExternas/amcharts/amcharts/themes/light.js"></script>
    <script src="LibreriasExternas/amcharts/amcharts/themes/chalk.js"></script>
    <script src="LibreriasExternas/amcharts/amcharts/lang/es.js"></script>
    <script src="LibreriasExternas/amcharts/amcharts/plugins/export/export.min.js"></script>
    <script src="LibreriasExternas/amcharts/amcharts/plugins/dataloader/dataloader.min.js"></script>
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
</head>
<style type="text/css">
    .btn-sample { 
      color: #FFFFFF; 
      background-color: #23527C; 
      border-color: #0B8EBD; 
  } 

  .btn-sample:hover, 
  .btn-sample:focus, 
  .btn-sample:active, 
  .btn-sample.active, 
  .open .dropdown-toggle.btn-sample { 
      color: #FFFFFF; 
      background-color: #21a7a5; 
      border-color: #0B8EBD; 
  } 

  .btn-sample:active, 
  .btn-sample.active, 
  .open .dropdown-toggle.btn-sample { 
      background-image: none; 
  } 

  .btn-sample.disabled, 
  .btn-sample[disabled], 
  fieldset[disabled] .btn-sample, 
  .btn-sample.disabled:hover, 
  .btn-sample[disabled]:hover, 
  fieldset[disabled] .btn-sample:hover, 
  .btn-sample.disabled:focus, 
  .btn-sample[disabled]:focus, 
  fieldset[disabled] .btn-sample:focus, 
  .btn-sample.disabled:active, 
  .btn-sample[disabled]:active, 
  fieldset[disabled] .btn-sample:active, 
  .btn-sample.disabled.active, 
  .btn-sample[disabled].active, 
  fieldset[disabled] .btn-sample.active { 
      background-color: #23527C; 
      border-color: #0B8EBD; 
  } 

  .btn-sample .badge { 
      color: #23527C; 
      background-color: #FFFFFF; 
  }
  .contenedor-botones{
    padding: 10%;
    border-bottom: 6px solid #23527c;
    color: #23527c;
    background-color: lightgrey;
}
</style>
<body>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 contenedor-botones">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h3>SEGUIMIENTO A LAS ORGANIZACIONES</h3>
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            <a class="btn btn-sample form-control" href="https://goo.gl/forms/kmnx8MKSH4g7mZcN2">Componente Administrativo</a>
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            <a class="btn btn-sample form-control" href="https://goo.gl/forms/tUw0sgXy63rlo2m63">Componente Territorial</a>
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            <a class="btn btn-sample form-control" href="https://docs.google.com/forms/d/e/1FAIpQLSfdyuYEYdIeNe6XRB4fWd-IEa9HBGsZu58jBKQydfr4k6ZzBA/viewform?c=0&w=1">Componente Pedagógico</a>
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            <a class="btn btn-sample form-control" href="https://goo.gl/forms/FHicgBpl8SmIyLZJ3">Gestión de la Información</a>
        </div>
    </div>
</body> 
</html>