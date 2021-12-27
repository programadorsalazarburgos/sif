<?php
date_default_timezone_set('America/Bogota');
$horaCierre=new DateTime('2018-05-23 18:00:00');
$horaApertura=new DateTime('2018-05-24 05:00:00');
//$horaActual=date("Y-m-d H:i:s");
$horaActual=new DateTime();
if($horaActual >= $horaCierre and $horaActual <= $horaApertura){
	//echo "hora de mantenimiento ".$horaCierre->format('Y-m-d H:i:s')." - ".$horaApertura->format('Y-m-d H:i:s');
	header("location:index_mantenimiento.php");
}
else{
	//echo "todavia no es hora de mantenimiento ".$horaActual->format('Y-m-d H:i:s')." : ".$horaCierre->format('Y-m-d H:i:s')." - ".$horaApertura->format('Y-m-d H:i:s');
	// prueba 1
}

?>
<!DOCTYPE html>
<html lang="es">
<style type="text/css">
	.centrodemonitoreo {
		background-color: #66429a;
		border: none;
		color: #ffffff !important;
		/*padding: 16px 32px;*/
		text-align: center;
		font-size: 16px;
		/*margin: 4px 2px;*/
		opacity: 0.8;
		transition: 0.3s;
	}

	.centrodemonitoreo:hover {
		opacity: 1;
		background-color: #ffffff !important;
		color: #66429a !important;
	}
</style>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="Sistema Integrado de formación, nidos y crea">
	<meta name="Keywords" content="SIF, sistema integrado de formación, sicrea, sicrea.gov.co, si.clan, si.clan.gov.co, idartes, nidos">
	<meta name="author" content="Componente de Información e innovación Digital">
	<link rel="shortcut icon" href="imagenes/faviconsif.png">
	<link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"  type="text/css">
	<link href="bower_components/fontawesome/web-fonts-with-css/css/fontawesome-all.min.css" rel="stylesheet"  type="text/css">
	<link href="bower_components/alertifyjs/build/css/alertify.min.css" rel="stylesheet"  type="text/css">
	<link href="css/Siclan.css?v=2020.02.12.1" rel="stylesheet">
	<link href="css/GridColumnCarousel.min.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="bower_components/amcharts/dist/amcharts/plugins/export/export.css" type="text/css" media="all" />
	<link rel="stylesheet" href="LibreriasExternas/sweetalert2/sweetalert2.min.css">
	<!-- <script type="text/javascript" src="LibreriasExternas/alertifyjs/alertify.min.js"></script> -->
	<script src="LibreriasExternas/sweetalert2/sweetalert2.min.js"></script>
	<script>
		window.open = function() {};
		window.print = function() {};

		if (false) {
			window.ontouchstart = function() {};
		}
	</script>
	<<!-- script type="text/javascript">
		if(window.location.href!="http://sif.idartes.gov.co/sif/public/" && !window.location.href.includes("localhost"))
			window.location.href = "http://sif.idartes.gov.co/sif/public/";
	</script> -->
	<script src="bower_components/jquery/dist/jquery.min.js"></script>
	<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="bower_components/alertifyjs/build/alertify.min.js"></script>
	<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src='https://www.google.com/recaptcha/api.js?hl=es-419'></script>


	<script src="bower_components/js-md5/build/md5.min.js"></script>
	<script src="bower_components/js-sha1/build/sha1.min.js"></script>
	<script src="bower_components/amcharts/dist/amcharts/amcharts.js"></script>
	<script src="bower_components/amcharts/dist/amcharts/pie.js"></script>
	<script src="bower_components/amcharts/dist/amcharts/serial.js"></script>
	<script src="bower_components/amcharts/dist/amcharts/gauge.js"></script>
	<script src="bower_components/amcharts/dist/amcharts/themes/light.js"></script>
	<script src="bower_components/amcharts/dist/amcharts/themes/chalk.js"></script>
	<script src="bower_components/amcharts/dist/amcharts/lang/es.js"></script>
	<script src="bower_components/amcharts/dist/amcharts/plugins/export/export.min.js"></script>
	<script src="bower_components/amcharts/dist/amcharts/plugins/dataloader/dataloader.min.js"></script>
	<script src="bower_components/ammap/dist/ammap/ammap.js"></script>
	<script src="bower_components/ammap/dist/ammap/themes/light.js"></script>	  
	<!-- <script src="bower_components/bootstrap-select/dist/js/bootstrap-select.min.js"></script> -->

	<script type="text/javascript" src="js/iniciarsesion.js?v=2018.10.05.001"></script>
	<script src="js/Siclan.js?v=695"></script>        
	<script src="js/slider.js?v=3" type="text/javascript"></script>
	<script src="js/GridColumnCarousel.js?v=2"></script>
	<script src="js/noticias.js?v=2020.02.07" type="text/javascript"></script>
	<script src="js/funcionesGenerales.js?v=2019.10.01.1" type="text/javascript"></script>
	<script src="js/bienvenida_version.js?v=2019.10.08.0"></script>
</head>
<body>
	<span id="inicio"></span>
	<header class="row" id="header-arriba">
		<div class="banner-arriba">
			<div class="row" style="margin-left: unset !important; padding-left: 12.33333333%; padding-top: 1%;">
				<div class="col-xs-12 col-sm-12 col-md-3">
					<a title="Bogotá"  class="enlaces-banner float-left" id="enlace-crea-header"><img alt="" src="imagenes/bogota.png" class="logos-header"></a>
					<!-- <a href="http://nidos.gov.co/" target="_blank" title="Nidos" class="enlaces-banner" id="enlace-nidos-header"><img alt="" src="imagenes/logo-nidos-header.png"  class="logos-header"></a> -->
				</div>
				<div class="col-xs-12 col-sm-12 col-md-9 col-lg-6 texto-header">
					<h2>Sistema Integrado de Formación</h2>
				</div>
			</div>
		</div>
	</header>
	<div class="row contenedor-landing-page" style="height: 70% !important; padding: 3%">
		<div class="col-lg-8 col-md-8 col-lg-offset-2 col-md-offset-2 col-sm-12 col-xs-12">
			<div class="row">
				<div class="container" style="margin-bottom: 50vh">
					<span id="georefenciacion"></span>
					<h2>Geo Referenciación <button class="btn" style="background-color: #0596b5; color: #ffffff" id="BT_CARGAR_ESTADISTICAS_LOCALIDADES">Click aquí para cargar mapa</button></h2>
					<div class="col-xs-12">
						<div id="mapdiv" hidden="hidden" style="width: 100%; background-color:#eeeeee; height: 500px;"></div>
					</div>
				</div>
			</div>
		</div>
	</div>		

<header class="row">
	<div class="banner-abajo container-fluid" style="position: fixed; height: 11.5rem;">
		<div class="col-xs-12 col-sm-12 col-md-12" style="height: 40px; margin-left: 33vw">
			<div id="menu_responsive_inicio">
				<button id="boton_menu_inicio" style="z-index: 100">
					<span class="linea_inicio"></span>
					<span class="linea_inicio"></span> 
					<span class="linea_inicio"></span>
				</button>
			</div>
			<div id="contenedorMenu" class="header-menu">
				<nav class="navbarra" role="navigation">
					<ul id="menu-top" class="nav navbar-nav">
						<li id="enlaceInicio"><a href="#inicio">Inicio de Sesión</a></li>
						<li><a href="CDM.php" style="padding-top: 1rem !important" class="subtitulo-sif enlaces-index">Centro de Monitoreo</a></li>
						<li><a href="georeferenciacion.php" style="padding-top: 1rem !important" class="subtitulo-sif enlaces-index">Georefenciación</a></li>
						<li><a href="coberturas.php" style="padding-top: 1rem !important" class="subtitulo-sif enlaces-index">Coberturas</a></li>
					</ul>
				</nav>
			</div>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 logos-abajo" style="width: 105%; margin-left: -30px;">
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
	</div>
</header>
</body>