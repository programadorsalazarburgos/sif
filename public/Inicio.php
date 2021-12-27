<?php
define('BASEPATH', str_replace('\\', '/', __DIR__));
date_default_timezone_set('America/Bogota');
$horaCierre=new DateTime('2018-09-20 14:00:00');
$horaApertura=new DateTime('2018-09-23 05:45:00');
//$horaActual=date("Y-m-d H:i:s");
$horaActual=new DateTime();
if($horaActual >= $horaCierre and $horaActual <= $horaApertura){
  //echo "hora de mantenimiento ".$horaCierre->format('Y-m-d H:i:s')." - ".$horaApertura->format('Y-m-d H:i:s');
 header("location:index_mantenimiento.php");
}
else{
  //echo "todavia no es hora de mantenimiento ".$horaActual->format('Y-m-d H:i:s')." : ".$horaCierre->format('Y-m-d H:i:s')." - ".$horaApertura->format('Y-m-d H:i:s');
}
//header('Content-type: charset=utf-8');
//unset($_COOKIE["PHPSESSID"]);
session_start();
//echo "<script>console.log('".json_encode(print_r($GLOBALS,true))."');</script>";
//echo "<script>console.log('session_id(): ".session_id()."');</script>";
//echo "<script>console.log('session_name(): ".session_name()."');</script>";

//echo "<script>console.log('".json_encode(print_r($GLOBALS,true))."');</script>";
if(!isset($_SESSION["session_username"])) {
 header("location:index.php");

} else {
  $id_persona= $_SESSION["session_username"];
  $id_Rol =   $_SESSION['session_usertype'];
}
include_once("../Controlador/Administracion/C_Cargar_Menu.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Sistema Integrado de Formación IDARTES">
  <meta name="Keywords" content="SIF, SIF.gov.co, si.clan, si.clan.gov.co, idartes">
  <meta name="author" content="SIF">
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Expires" content="0" />	  
  <link rel="shortcut icon" href="imagenes/faviconsif.png">
  <link href="bootstrap/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="bootstrap/metisMenu/dist/metisMenu.min.css" rel="stylesheet" type="text/css">
  <link href="css/Siclan.css?v=2020.03.20.0"   rel="stylesheet" type="text/css" media="all">
  <link href="css/header.css?v=2020.05.14.0"  rel="stylesheet" type="text/css" media="all">
  <link href="bootstrap/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

  <!-- jQuery --><script type="text/javascript"  src="bootstrap/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap Core JavaScript --><script type="text/javascript"  src="bootstrap/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- Metis Menu Plugin JavaScript --><script type="text/javascript"  src="bootstrap/metisMenu/dist/metisMenu.min.js"></script>
  
  <script  type="text/javascript" src="js/apariencia.js?v=2020.02.19.1"></script>  
  <script type="text/javascript" src="js/header.js?v=2021.08.19.10"></script>  
  
  <!-- Custom Theme JavaScript --><script type="text/javascript"  src="js/Siclan.js?v=1.0"></script>
  <script type="text/javascript" src="js/jquery-scrolltofixed-min.js?v=13"></script>
  <script type="text/javascript" src="Administracion/Js/Cargar_Menu.js?v=2020.02.19.0"></script>

  <link rel="stylesheet" type="text/css" href="LibreriasExternas/alertifyjs/css/alertify.min.css">
  <link rel="stylesheet" href="LibreriasExternas/sweetalert2/sweetalert2.min.css">
  <script type="text/javascript" src="LibreriasExternas/alertifyjs/alertify.min.js"></script>
  <script src="LibreriasExternas/sweetalert2/sweetalert2.min.js"></script>

<!--   <link rel="stylesheet" type="text/css" href="LibreriasExternas/loadingAjax/jquery.loading.css">
  <script type="text/javascript" src="LibreriasExternas/loadingAjax/jquery.loading.js"></script> -->
  <script type="text/javascript" src="js/fechaHoraServidor.js?v=2020.02.18.0"></script>
  <script  type="text/javascript" src="js/funcionesGenerales.js?v=2021.07.13.9"></script>
  <script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
  <script type="text/javascript">
    if(window.location.href!="https://sif.idartes.gov.co/sif/public/Inicio.php" &&
      window.location.href!="https://sif_dev.idartes.gov.co/sif/public/Inicio.php" &&
      !window.location.href.includes("localhost")){
        window.location.href = "https://sif.idartes.gov.co/sif/public/"; 
      }
     $(document).ready(function(){ 
        //código para modal encuesta
     /*<?php 
        if($id_Rol==1){ 
         echo '$("#enlace-encuesta").attr("href","https://docs.google.com/forms/d/e/1FAIpQLSciNKg_T7f099Xd9387188drJtNEwL-4PPTiMoK1TVtQhrQEQ/viewform");
         $("#enlace-encuesta").html("Encuesta a Formadores(as) CREA");
         $("#modal-encuesta").modal("show");
         $("#enlace-encuesta").click(function(){ $("#modal-encuesta").modal("hide"); });';

       }elseif($id_Rol==4 or $id_Rol==5 or $id_Rol==15){
        echo '
        $("#enlace-encuesta").attr("href","https://docs.google.com/forms/d/e/1FAIpQLSfR7GCbugs9HpLTrZZY3jqYEnZBgurEVL_o3mNKB9X5KHJNYA/viewform?");
        $("#enlace-encuesta").html("Encuesta a Gestores(as) pedagógicos(as) territoriales - GPT");
        $("#modal-encuesta").modal("show");
        $("#enlace-encuesta").click(function(){ $("#modal-encuesta").modal("hide"); });';

      }
      ?>*/
    });
  </script>
</head>
<body>

  <?php //include 'Administracion/Cargar_Menu.php';
  echo "<input type='hidden' id='id_usuario' value='".$id_persona."' />";
  echo "<input type='hidden' id='id_rol' value='".$id_Rol."' />";
  ?>
  <input type="hidden" id="socket_io" value="">

  <div id="wrapper">
    <nav id="navbarra" class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0; background-color: #66429a !important; color: #ffffff">
      <div class="row">
        <div class="navbar-header col-xs-3 col-sm-3 col-md-3 col-lg-3">
          <a class="navbar-brand" href="Inicio.php" style="color: #ffffff">
            <i class="fas fa-home fa-2x"></i>
            <span style="font-size: 26px; color: #ffffff"> SIF</span>
            <i id="time" name="time"></i>              
          </a>
        </div>
        <div class="navbar-header col-xs-12 col-sm-12 col-md-6 col-lg-6 col-md-offset-3 col-md-offset-3">
          <div id="titulo-sistema-informacion">
            Sistema Integrado de Formación
            <a href="https://drive.google.com/drive/folders/12AIkSo2E7oUfKa06clWUDo97N0ss9bg0" target="_blank" type="button" class="btn btn-warning btn-sm" title="Guias Arte En La Escuela">
              <span class="glyphicon glyphicon-book"></span> Guias Arte En La Escuela
            </a>
          </div>
        </div>
        <div align="right">
          <ul class="nav navbar-top-links navbar-right">
            <li id="nombre_usuario" name="nombre_usuario" style="color: #e8c6e8"></li>
            <li>
              <a href="Administracion/Solicitud_Soporte2.php" target="ventana_iframe" title="Solucionar Soporte">
                <i class="fas fa-life-ring fa-2x blancoHeader"></i> 
              </a>
            </li>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" title="Notificaciones">
                <i class=" fas fa-envelope-open fa-2x blancoHeader" ></i>
                <span class="badge notification" id="SP_Notificaciones"></span>
              </a>
              <ul class="dropdown-menu notificacionMenu dropdown-user" id="UL_Notificaciones">
              </ul>
            </li>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" title="Acciones de Usuario">
                <i class=" fas fa-user-circle fa-2x blancoHeader"></i></i><i class="fa fa-caret-down blancoHeader"></i>
              </a>
              <ul class="dropdown-menu dropdown-user">
                <li><a><div id="imagenUsuario"></div></a></li>
                <li><a href="Administracion/Actualizar_Perfil_Usuario.php" target="ventana_iframe"><i class="fa fa-user fa-fw"></i> Perfil de Usuario</a></li>
                <!-- <li><a href="https://www.youtube.com/playlist?list=PLhqpiXvaCrQeti-K9SOshZPOIe0rfJ9uK" target="_blank"><i class="fab fa-youtube fa-fw"></i> Ayudas Audiovisuales</a></li> -->
                <li><a href="Administracion/Change_Password.php" target="ventana_iframe"><i class="fas fa-key fa-fw"></i> Cambiar Contraseña</a></li>
                <li class="divider"></li>
                <li><a href="CerrarSesion.php"><i class="fas fa-sign-out-alt fa-fw"></i> Cerrar Sesión</a></li>
              </ul>
              <div align="center">
                <div id="menu_responsive">
                  <button id="boton_menu">
                    <span class="linea"></span>
                    <span class="linea"></span>
                    <span class="linea"></span>
                  </button>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </div>

  <div> 
    <div id="div_menu" class="col-md-2 col-xs-2">
      <ul class="nav" id="side-menu">
      </ul>
    </div>
    <script type="text/javascript">
      var heightFrame = '0px';
      var load = 0;
      function resizeIframe(obj) {
        if (load == 0 )
          heightFrame = (window.document.body.scrollHeight) + 'px';
        console.log(heightFrame);
        load = 1; 
        obj.style.height = heightFrame; 
        obj.style.width = '100%'; 
      } 
    </script> 
    <div  class="row">
      <!-- <iframe src="Bienvenida_nvo.php" frameborder="0" name="ventana_iframe" id="ventana_iframe" onLoad="cuandoCargaIframe();" style="margin-bottom: 10rem !important;"></iframe></div>  -->
      <iframe src="Bienvenida_nvo.php" frameborder="0" name="ventana_iframe" id="ventana_iframe" onLoad="cuandoCargaIframe();"></iframe></div> 
    </div>
    <!-- <div class="banner-abajo container-fluid" style="position: fixed; height: 8rem;">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 logos-abajo" style="width: 100vw; margin-left: -30px;">
        <div class="container-fluid" style="background-color: #4f3483; padding: 0.5%; margin-bottom: 50px">
          <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <img src="imagenes/crea-blanco.png" style="width:10rem !important;">
            <img src="imagenes/nidos-blanco.png" style="width:10rem !important; margin-left: 2vh !important;">
          </div>
          <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <img src="imagenes/bogota-blanco.png" class="pull-right" style="width:12rem !important; margin-right: 3%">
          </div>
          <div class="logo-footer">
          </div>
        </div>
      </div>
    </div> -->

    <div class="modal fade" id="modal_aceptacion_uso_siclan" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="title_modal_aceptacion_uso_siclan">Aceptación condiciones de uso SIF</h4>
          </div>
          <div class="modal-body">
            <div class='row'>
              <div class='col-xs-12 col-md-12'>
                <article class="text-justify" style="max-height:350px;overflow-y:scroll; ">
                  Versión: 2020.07.30
                  Yo, <b id="nombre_funcionario">XXXXX XXXXXXX XXXXXXXX</b> identificado con cédula de ciudadanía <b id="cedula_funcionario">VVVVVVVVV</b>, como funcionario o contratista del Instituto Distrital de las Artes – IDARTES; me comprometo a cumplir con las siguientes medidas de seguridad:
                  <br><br>
                  <ul>
                    <li>Recomendaciones de usuarios y contraseñas: El usuario y contraseña son de uso personal e intransferible.</li>
                    <li>Aplicativo:
                      <ul>
                        <li>Manifiesto que conozco a cabalidad que el acceso al aplicativo estará activo durante la vigencia de la vinculación con la entidad, acorde a las actividades asignadas. </li>
                        <li>Acepto que IDARTES podrá realizar controles y monitoreo de las actividades realizadas dentro de la aplicación para garantizar el uso de la misma.</li>
                        <li>Acepto cualquier cambio de perfil de acceso cuando así lo disponga el supervisor del contrato o Jefe Inmediato por cambio de las actividades.</li>
                        <li>Acepto que el administrador del aplicativo bloqueará la cuenta cuando se evidencie el manejo indebido y el no uso dentro de los parámetros definidos por el área.</li>
                        <li>Acepto los tiempos establecidos para el ingreso de la información de acuerdo a lo informado por el IDARTES para el uso y funcionamiento del aplicativo.</li>
                      </ul>
                    </li>
                    <li>Control de datos y legislación: Cumplir con los requisitos legales y reglamentarios relacionados con las políticas de seguridad de la información y protección de datos.</li>
                    <li>Clasificación de la Información: Reconozco que soy responsable del manejo y uso de la información para el IDARTES existente en mi usuario.</li>
                    <li>Solicitud de Soporte Técnico: Con el fin de proporcionar un único punto de contacto para todos los usuarios, los soportes de SIF, serán recibidos únicamente a través del Link de la aplicación y correo electronico.</li>
                  </ul>
                </article>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="row">
              <div class="col-xs-12 col-md-12">
                <div class="checkbox">
                  <label><input type="checkbox" id="CH_acepto_terminos" value="1">He leido y acepto los terminos y condiciones del uso del aplicativo SIF.</label>
                </div>
              </div>
            </div>
            <button type="button" class="btn btn-primary" disabled="disabled" id="BT_aceptar_terminos">Aceptar</button>
          </div>
        </div>
      </div>
    </div>


    <script type="text/javascript">
      $(function(){
        if(!usuarioAceptoTerminos()){
          cargarNombreYCedula();
          $("#modal_aceptacion_uso_siclan").modal({backdrop: 'static', keyboard: false});

          $("#CH_acepto_terminos").change(function(){
            if($(this).is(":checked")){
              $("#BT_aceptar_terminos").removeAttr("disabled");
            }else{
              $("#BT_aceptar_terminos").attr("disabled","disabled");
            }
          });

          $("#BT_aceptar_terminos").click(aceptarTerminos);
        }

      });
      var hidden = false;
  /*$('#btn_menu_show').click(function(){

    if (!hidden || $(window).width() < 767) {
      $("#div_menu").hide();
      hidden = true;
      $("#div_menu").width('100%');
      $('#div_contenido').width('100%');
      $('#I_btn_menu').removeClass('fa fa-angle-double-left').addClass('fa fa-angle-double-right');
    }
    else
    {
      $("#div_menu").width('18.6%');
      $("#div_menu").show();
      hidden = false;
      $('#div_contenido').width('81.4%');
      $('#I_btn_menu').removeClass('fa fa-angle-double-right').addClass('fa fa-angle-double-left');
    }
  });*/

  /*if ($( window ).width() < 747) {
    $("#div_menu").show();
    $("#div_menu").width('100%');
    $('#div_contenido').width('100%');
    $('#btn_menu_show').hide();
  }
  else
  {
    $('#btn_menu_show').show();
    if (!hidden) {
      $('#div_contenido').width('81.4%');
      $("#div_menu").width('18.6%');
      $("#div_menu").show();
    }
    else
    {
      $('#div_menu').hide();
    }
  }*/

  /*$( window ).resize(function() {
    if ($( window ).width() < 747) {
      $("#div_menu").show();
      $("#div_menu").width('100%');
      $('#div_contenido').width('100%');
      $('#btn_menu_show').hide();
    }
    else
    {
      $('#btn_menu_show').show();
      if (!hidden) {
        $('#div_contenido').width('81.4%');
        $("#div_menu").width('18.6%');
        $("#div_menu").show();
      }
      else
      {
        $('#div_menu').hide();
      }
    }
  });*/ 

  $( window ).resize(function() {
    if ($( window ).width() < 747) {
      $("#div_menu").show();
      $("#div_menu").width('100%');
      $('#div_contenido').width('100%');
      $('#btn_menu_show').hide();
    }
    else
    {
      $('#btn_menu_show').show();
      if (!hidden) {
        $('#div_contenido').width('81.4%');
        $("#div_menu").width('18.6%');
        $("#div_menu").show();
      }
      else
      {
        $('#div_menu').hide();
      }
    }
  });

  function usuarioAceptoTerminos(){
    var acepto = false;
    var datos = {
      opcion: 'verificar_aceptacion_terminos',
      id_usuario: $("#id_usuario").val()
    }
    $.ajax({
      url: '../Controlador/Administracion/C_Administrar_Actividades.php',
      type: 'POST',
      data: datos,
      async: false
    }).done(function(data){
      if(data == 1){
        acepto = true;
      }else{
        acepto = false;
      }
    }).fail(function(data){
      console.log("Fallo" + data);
    });
    return acepto;
  }

  function cargarNombreYCedula(){
    var datos = {
      opcion: 'get_nombre_cedula_usuario',
      id_usuario: $("#id_usuario").val()
    }
    $.ajax({
      url: '../Controlador/Administracion/C_Administrar_Actividades.php',
      type: 'POST',
      data: datos
    }).done(function(data){
      try{
        var d = $.parseJSON(data);
        $("#nombre_funcionario").text(d.nombre);
        $("#cedula_funcionario").text(d.cedula);
      }catch(ex){
        console.log("Error"  + e);
      }
    }).fail(function(data){
      console.log("Fallo" + data);
    });
  }

  function aceptarTerminos(){
    var datos = {
      opcion: 'aceptar_terminos',
      id_usuario: $("#id_usuario").val()
    }
    $.ajax({
      url: '../Controlador/Administracion/C_Administrar_Actividades.php',
      type: 'POST',
      data: datos
    }).done(function(data){
      $("#modal_aceptacion_uso_siclan").modal('hide');
    }).fail(function(data){
      console.log("Fallo" + data);
    });
  }
</script>
</body>
<div class="modal fade" id="modal_enviando" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <img src="imagenes/enviando.gif" width="100%">
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modal-encuesta" tabindex="-1" role="dialog" aria-labelledby="modal_encuestas" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
     <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">Aviso de Diligenciamiento</h4>
    </div>      
    <div class="modal-body">
      <p>No olvide diligenciar la: <a id="enlace-encuesta" target="ventana_iframe" class="btn btn-danger" ></a></p>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    </div>      
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</html>
