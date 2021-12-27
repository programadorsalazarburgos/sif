<?php
//header('Content-type: text/html; charset=utf-8');
if(!isset($_SESSION["session_username"])) {
  header("location:index.php");
} else {
  $id_persona= $_SESSION["session_username"];  
  $id_Rol =   $_SESSION['session_usertype'];
}
include_once("../Controlador/Administracion/C_Cargar_Menu.php");
echo "<input type='hidden' id='id_usuario' value='".$id_persona."' />";
echo "<input type='hidden' id='id_rol' value='".$id_Rol."' />";
?>

<meta charset="utf-8">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<!-- <script type="text/javascript" src="js/jquery-scrolltofixed-min.js"></script> -->
<script type="text/javascript" src="Administracion/Js/Cargar_Menu.js?v=2.3.0"></script>
<link href="https://fonts.googleapis.com/css?family=Yatra One|BioRhyme|Righteous|Prompt" rel="stylesheet">
<!-- <script src="https://sif.idartes.gov.co:55000/socket.io/socket.io.js"></script> -->
<!-- <script src="http://localhost:5000/socket.io/socket.io.js"></script> -->
<script type="text/javascript" src="js/fechaHoraServidor.js?v=1.0"></script>   




<style type="text/css">
    div{
        font-family: 'Prompt';
        font-size: 14px; 
    }
    .notification{
        padding: 4px 7px;
        margin-left: -21px;
        margin-top: -25px;
        background-color: #d23535;
    }
    .notificacionMenu {
        float: none;
        min-width: 1300%;
    }
    
    @media screen and (max-width: 850px) and (min-width: 600px) {
        .notificacionMenu {            
            min-width: 900%;
        }
    }
    @media screen and (max-width: 600px) and (min-width: 430px) {
        .notificacionMenu {            
            min-width: 560%;
        }
    }
    @media screen and (max-width: 430px)  {
        .notificacionMenu {            
            min-width: 420%;
        }
    }
}

</style>
<?php echo '<input type="hidden" id="id_usuario" value="'.$id_persona.'" />'; ?>
<div id="wrapper">
	<!-- Navigation -->
    <nav id="navbarra" class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0;">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="Inicio.php">SICREA</a> 
        </div>
        <!-- /.navbar-header -->
        <div align="right"> 
            <ul class="nav navbar-top-links navbar-right">
                <i id="time" name="time" style="color:#23527c"></i>
                <i class="fa fa-dot-circle-o" style="color:rgb(0,230,0);"></i> <span id="nombre_usuario" name="nombre_usuario" style="color:#23527c"></span>
                <a href="Bienvenida.php#navs" target="ventana_iframe"><img src="imagenes/iconos/Recurso 15.png?v=1"  title="Gráficas de Atención" /></a>
                <a href="Administracion/Solicitud_Soporte2.php" target="ventana_iframe"><img src="imagenes/iconos/Recurso 14.png?v=1" ></a>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" style=" padding: 5px 5px;"><img src="imagenes/iconos/Recurso 13.png?v=1" /> <span class="badge notification" id="SP_Notificaciones"></span></a>
                    <ul class="dropdown-menu notificacionMenu dropdown-user" id="UL_Notificaciones">
                    </ul>
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-user fa-fw"></i><i class="fa fa-caret-down"></i></a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="ActualizarDatos_Usuarios.php" target="ventana_iframe"><i class="fa fa-user fa-fw"></i> Perfil de Usuario</a></li>
                        <li><a href="videotutoriales.html" target="ventana_iframe"><i class="fa fa-gear fa-fw"></i> Ayudas Audiovisuales</a></li>
                        <li><a href="Cambiar_Contrasenia.php" target="ventana_iframe"><i class="fa fa-gear fa-fw"></i> Cambiar Contraseña</a></li>
                        <li class="divider"></li>
                        <li><a href="CerrarSesion.php"><i class="fa fa-sign-out fa-fw"></i> Cerrar Sesión</a></li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
        </div>
        
    </nav>
</div> 
