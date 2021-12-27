
<!DOCTYPE html>
<html lang="es">
<style type="text/css">
	.enlaces-index {
		background-color: #66429a;
		border: none;
		color: #ffffff !important;
		text-align: center;
		transition: 0.3s;
	}
	.enlaces-index:hover {
		opacity: 1;
		background-color: #ffffff !important;
		color: #66429a !important;
	}
	.centered {
		float: none !important;
		margin: 0 auto;
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
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Expires" content="0" />	
	<script src="LibreriasExternas/sweetalert2/sweetalert2.min.js"></script>
	<script>
		window.open = function() {};
		window.print = function() {};

		if (false) {
			window.ontouchstart = function() {};
		}
	</script>
	<script type="text/javascript">
		if(window.location.href!="https://sif.idartes.gov.co/sif/public/" &&
			window.location.href == "https://sif_dev.idartes.gov.co/sif/public/" &&
			!window.location.href.includes("localhost")){
			window.location.href = "https://sif.idartes.gov.co/sif/public/";
		}
	</script>
	<script src="bower_components/jquery/dist/jquery.min.js"></script>
	<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="bower_components/alertifyjs/build/alertify.min.js"></script>
	<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src='https://www.google.com/recaptcha/api.js?hl=es-419'></script>
	<script src="https://www.google.com/recaptcha/api.js?render=6Leao9gUAAAAAOgHuJ391BALdwcw20KNCSu750p7"></script>

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

	<script type="text/javascript" src="js/iniciarsesion.js?v=2020.06.11"></script>
	<script src="js/Siclan.js?v=695"></script>        
	<script src="js/slider.js?v=3" type="text/javascript"></script>
	<script src="js/GridColumnCarousel.js?v=2"></script>
	<script src="js/noticias.js?v=2020.02.07" type="text/javascript"></script>
	<script src="js/funcionesGenerales.js?v=2019.10.01.1" type="text/javascript"></script>
	<script src="js/bienvenida_version.js?v=2019.10.08.0"></script>
	<!-- <script type="text/javascript" src="js/jquery.snow.min.1.0.js"></script>

	<script type="text/javascript">
		function ConteoRegresivo()
{
	var fecha=new Date('2018','11','16','23','59','59');
	var hoy=new Date();
	var dias=0
	var horas=0
	var minutos=0
	var segundos=0
	if (fecha>hoy)
	{
		var diferencia=(fecha.getTime()-hoy.getTime())/1000
		dias=Math.floor(diferencia/86400)
		diferencia=diferencia-(86400*dias)
		horas=Math.floor(diferencia/3600)
		diferencia=diferencia-(3600*horas)
		minutos=Math.floor(diferencia/60)
		diferencia=diferencia-(60*minutos)
		segundos=Math.floor(diferencia)
		document.getElementById('contador').innerHTML = '<h2>Quedan <b>' + dias + '</b> días, <b>' + horas + '</b> horas, <b>' + minutos + '</b> minutos y <b>' + segundos + '</b> segundos para el cierre de SIF</h2>';
		if (dias>0 || horas>0 || minutos>0 || segundos>0)
		{
			setTimeout("ConteoRegresivo()",1000)
		}
	}
	else
	{
		document.getElementById('contador').innerHTML = '0 Días  ¡Sistema Cerrado por cierre de año!';
	}
} 
</script> -->
</head>
<body>
	<span id="inicio"></span>
	<header class="row" id="header-arriba">
		<div class="banner-arriba">
			<div class="row" style="margin-left: unset !important; padding-left: 10.8%; padding-top: 1%;">
				<div class="col-xs-12 col-sm-12 col-md-3">
					<a title="Bogotá"  class="enlaces-banner float-left" id="enlace-crea-header"><img alt="" src="imagenes/bogota.png" class="logos-header" style="width: 25vh !important"></a>
					<!-- <a href="http://nidos.gov.co/" target="_blank" title="Nidos" class="enlaces-banner" id="enlace-nidos-header"><img alt="" src="imagenes/logo-nidos-header.png"  class="logos-header"></a> -->
				</div>
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 texto-header">
					<h2>Sistema Integrado de Formación</h2>
				</div>
			</div>
		</div>
	</header>
	<div class="row contenedor-landing-page" style="height: 70% !important; padding: 3%;  padding-bottom: 75vh !important">
		<div class="col-lg-7 col-md-7 col-lg-offset-1 col-md-offset-1 col-sm-12 col-xs-12">
			<div id="mycarousel" class="carousel slide" data-ride="carousel" data-interval="1000">
				<!-- Indicators -->
				<ol class="carousel-indicators" style="z-index: 1">
					<li data-target="#mycarousel" data-slide-to="0" class="active"></li>
				</ol>

				<!-- Wrapper for slides -->
				<div class="carousel-inner" style="height: 60vh" role="listbox">
					<div class="item" style="max-height: 100% !important; max-width: 100% !important;">
						<img src="imagenes/slider/1.jpg?v=2020.02" data-color="lightblue">
					</div>
				</div>

				<!-- Controls -->
				<!-- <a class="left carousel-control" href="#mycarousel" onclick="javascript:return false;" role="button" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
					<span class="sr-only">Anterior</span>
				</a>
				<a class="right carousel-control" href="#mycarousel" onclick="javascript:return false;" role="button" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
					<span class="sr-only">Siguiente</span>
				</a> -->
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
			<form name="login" id="login" class="login" style="height: 60vh;">
				<center><p class="titulo-sif">SIF</p></center>
				<!-- <center><p class="label-sif usatucuenta">Usa tu cuenta de SIF</p></center> -->
				<center><a href="https://forms.gle/vRzm7MJ73cNaZ2438" target="_blank"><p class="titulo-sif" style="font-size: 14px !important">Solicitar un usuario</p></a></center>
				<center><p class="subtitulo-sif">Iniciar sesión</p></center>
				<div class="form-group col-xs-12 col-sm-8 col-sm-offset-2 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
					<p class="label-sif">Usuario</p>
					<input class="tecleable form-control mayuscula" tabindex="1" name="username" id="username" type="text" value="" required>
				</div>
				<div class="form-group col-xs-12 col-sm-8 col-sm-offset-2 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
					<p class="label-sif">Contraseña</p>
					<input class="tecleable form-control" tabindex="2" name="password" id="password" value="" type="password" required/>
				</div> 
				<div class="form-group col-xs-12 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
					<input type="submit" name="login" id="bt_login" class="btn form-control" value="Siguiente"  tabindex="4" />
				</div>
				<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center; padding-top: 5%">
					<a class="olvide-password text-center" style="padding-top: 10px" id="olvide-password" href="#" >¿Olvidaste tu nombre de usuario?</a>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
					<div class="alert alert-danger" id="div_alerta" name="div_alerta" hidden>
						<strong>Acceso Denegado.</strong><br><span id="span-error"></span>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
					<div class="alert alert-danger" id="div_alerta_recaptcha" name="div_alerta_recaptcha" hidden>
						<strong>Debe diligenciar el ReCaptcha para Acceder</strong>
					</div>
				</div>
			</form>
		</div>
		<div id="contador"></div>
	</div>
</div>		

<header class="row">
	<div class="banner-abajo" style="position: fixed; height: 11.5rem;">
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
						<li><a href="../framework/centro-de-monitoreo" style="padding-top: 1rem !important" class="subtitulo-sif enlaces-index">Centro de Monitoreo</a></li>	
						
						<li><a href="coberturas.php" style="padding-top: 1rem !important" class="subtitulo-sif enlaces-index">Coberturas</a>
						</li>
						<li><a href="https://docs.google.com/forms/d/e/1FAIpQLSesdl4RQyiD-_1ddkFdnPaSUwgZbjrrMrCIlXTJ8lXCg9-3KQ/viewform?usp=sf_link" target="_blank" style="padding-top: 1rem !important" class="subtitulo-sif enlaces-index">Proceso Virtualización</a></li>
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
<!-- <div class="row gris">
	<div class="container">
		<span id="georefenciacion"></span>
		<h2>Geo Referenciación <button class="btn" style="background-color: #0596b5; color: #ffffff" id="BT_CARGAR_ESTADISTICAS_LOCALIDADES">Click aquí para cargar mapa</button></h2>
		<div class="col-xs-12">
			<div id="mapdiv" hidden="hidden" style="width: 100%; background-color:#eeeeee; height: 500px;"></div>
		</div>
	</div>
</div> -->

<!-- <div class="row" style="background-color: #66429a !important; color: #ffffff !important; padding-bottom: 7vh !important;">
	<div class="container">
		<span id="coberturas"></span>
		<h2 class="text-center">Coberturas</h2>
		<div class="col-xs-12 col-sm-12 col-md-12">
			<div class="col-xs-12 col-sm-12 col-md-3 col-md-offset-3 col-lg-offset-3">
				<select id="SL_Linea" name="SL_Linea" class="form-control">  
				</select>
			</div> 
			<div class="col-xs-12 col-sm-12 col-md-2">
				<select id="SL_Ano_Crea_Linea" name="SL_Ano_Crea_Linea" class="form-control">
					<option value="2016">2016</option>
					<option value="2017">2017</option>
					<option value="2018">2018</option>
					<option value="2019">2019</option>
				</select>
			</div> 
			<div class="col-xs-12 col-sm-12 col-md-2">
				<button id="BT_CARGAR_GRAFICAS" class="btn form-control" style="background-color: #0596b5; color: #ffffff">GRÁFICAR</button>
			</div>
		</div>
		<div id="chartDivs" hidden>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"> 
				<div class="row">
					<h4 class="text-center">MENSUAL</h4>
					<div id="chartdiv"></div>
				</div>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<div class="row">
					<h4 class="text-center">POR CREA</h4>
					<div id="chartdivC"></div>
				</div>					
			</div>
		</div> -->
				<!-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<br>
					<h4 class="text-center">Por Áreas Artísticas</h4>
					<div class="col-xs-6 col-sm-6 col-md-8"> 
						<select id="SL_Linea_Areas" class="form-control selectpicker" data-actions-box="true" data-live-search="true">
							<option value="AE">Arte en la Escuela</option>
							<option value="EC">Impulso Colectivo</option>
							<option value="LC">Converge</option>   
						</select>
					</div> 
					<div class="col-xs-6 col-sm-6 col-md-4">
						<select id="SL_Ano_Areas" class="form-control selectpicker" data-actions-box="true" data-live-search="true">
							<option value="2016">2016</option>
							<option value="2017">2017</option>
							<option value="2018">2018</option>
						</select>
					</div> 
					<div class="row">
						<div id="chartdivArea"></div>
					</div>					
				</div> -->
				<!-- <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3 cifras-acumulado">
					<table class="table table-responsive" style="width: 100%;">
						<thead>
							<tr>
								<th>Programa</th>
								<th>Total Atendidos <span id="anioTotal"></span></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Arte en la escuela</td>
								<td class="resultadoTotal" id="totalAE"></td>
							</tr>
							<tr>
								<td>Impulso Colectivo</td>
								<td class="resultadoTotal" id="totalEC"></td>
							</tr>
							<tr>
								<td>Converge</td>
								<td class="resultadoTotal" id="totalLC"></td>
							</tr>														
						</tbody>
					</table>
				</div>
			</div>
		</div> -->
		<!-- <a class="ancla ancla_inicio btn btn-info" href="#inicio"><i class="fa fa-angle-double-up"></i></a> -->
		<!-- <footer style="margin:0px;">
			<div class="container-fluid" style="background-color: #4f3483; padding: 1%">
				<div class="col-xs-12">
					<img src="imagenes/crea-blanco.png">
					<img src="imagenes/nidos-blanco.png">
				</div>
				<div class="logo-footer">
					<img src="imagenes/bogota-blanco.png" width="65%">
				</div>
			</div>
		</footer> -->


		<script>
		  /*if (document.location.search.match(/type=embed/gi)) {
		    window.parent.postMessage('resize', "*");
		}*/
	</script>
</body>

<div class="modal fade" id="modal-password" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Recuperación de Contraseña</h4>
			</div>
			<div class="modal-body">
				<strong>1. Verifique su correo y haga clic en siguiente</strong>
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon"><span class="fa fa-envelope-square"></span></span>
						<div class="no-padding col-xs-12 col-sm-12 col-md-9 col-lg-9">
							<input class="form form-control" type="email" id="email" name="email" placeholder="Correo" disabled="disabled">
							<input  type="hidden" id="id" name="id">
						</div>
						<div class="no-padding col-xs-12 col-sm-12 col-md-3 col-lg-3">
							<button type="button" class="form-control btn btn-success" id="enviar-token">Siguiente</button>
						</div>
					</div>
				</div>
				<div class="form-group hidden" id="contenedor-token">
					<strong>2. Revise su bandeja de entrada y copie en el siguiente cuadro el token enviado</strong>
					<div class="input-group">
						<span class="input-group-addon"><span class="fa fa-unlock-alt"></span></span>
						<div class="no-padding col-xs-12 col-sm-12 col-md-9 col-lg-9">
							<input class="form form-control" type="text" id="token" name="token" placeholder="token" >
						</div>
						<div class="no-padding col-xs-12 col-sm-12 col-md-3 col-lg-3">
							<button type="button" class="form-control btn btn-success" id="verificar-token">Verificar</button>
						</div>
					</div>
				</div>
				<div class="form-group hidden" id="contenedor-password">
					<strong>3. Ingrese su nueva contraseña</strong>
					<div class="input-group">
						<span class="input-group-addon"><span class="fa fa-key"></span></span>
						<div class="no-padding col-xs-12">
							<input class="form form-control" type="password" id="password-cambiar" name="password-cambiar" placeholder="Ingrese la contraseña" >
						</div>
					</div>
					<div class="input-group">
						<span class="input-group-addon"><span class="fa fa-key"></span></span>
						<div class="no-padding col-xs-12">
							<input class="form form-control" type="password" id="password-confirmacion" name="password-confirmacion" placeholder="confirmar la contraseña" >
						</div>
					</div>
					<div class="no-padding col-xs-12">
						<button type="button" class="form-control btn btn-success" id="cambiar-password">Cambiar Contraseña</button>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
</html>
