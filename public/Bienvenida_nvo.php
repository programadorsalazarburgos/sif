<?php
session_start();
if(!isset($_SESSION["session_username"])) {
  header("location:index.php");
}
else { 
  $id_persona= $_SESSION["session_username"];  
  $id_Rol =   $_SESSION['session_usertype'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="bootstrap/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/Siclan.css?v=2020.02.18.0" rel="stylesheet" type="text/css" media="all"> 
  <link href="css/Bienvenida.css?v=9686" rel="stylesheet" type="text/css" media="all" >
  <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="js/dashboard.js?v=67890"></script>
  <script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
</head>
<body id="dashboard">
  <?php //include 'Administracion/Cargar_Menu.php';
  echo "<input type='hidden' id='id_usuario' value='".$id_persona."' />";
  echo "<input type='hidden' id='id_rol' value='".$id_Rol."' />";
  ?>      
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
      <a title="Bogotá"  class="enlaces-banner float-left" id="enlace-crea-header"><img alt="" src="imagenes/bogota.png" class="logos-header" style="width: 15vh !important; margin-top: 1vh"></a>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8" style="text-align: center;">
      <br> 
    <!-- Necesitas asistencia técnica, conectate a nuestra mesa de ayuda por Meet los días LUNES y JUEVES <br>en el horario de 9:00 AM a 12:00 M <a href="https://meet.google.com/xmh-vrpb-kyy" target="_blank">AQUÍ</a> -->
    </div>
    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2"><br></div>
  </div>
  <div class="container">
    <div id="contenedorIconos" class="col-xs-12"></div>
    <div style="opacity: 0.4" class="pull-right">Icons made by <a href="https://www.flaticon.com/authors/freepik" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a></div>
  </div>

</div>
<div class="modal fade" id="modal_actividades" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header" id="headerActividades">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="tituloModulo"></h4>
      </div>                
      <div class="modal-body">                            
        <div id='actividades'></div>                            
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</body>
</html>
