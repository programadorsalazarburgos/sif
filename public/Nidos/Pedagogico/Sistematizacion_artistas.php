<?php
session_start();
if(!isset($_SESSION["session_username"])) {
	header("location:../index.php");
} else {
	$Id_Persona = $_SESSION["session_username"];
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Formato de sistematización</title>

	<link href="../../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

	<script type="text/javascript" src="Js/Sistematizacion_artistas.js?v=1.7.2.4"></script>

	<link href="../../bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"  rel="stylesheet" type="text/css" >
	<link href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet">
	<link href="../../bower_components/datatables.net-buttons-dt/css/buttons.dataTables.min.css" rel="stylesheet" >
	<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src="../../bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="../../bower_components/datatables.net-responsive-bs/js/responsive.bootstrap.min.js"></script>

	<link href="../../bower_components/summernote/dist/summernote.css" rel="stylesheet"> 
	<script src="../../bower_components/summernote/dist/summernote.min.js"></script>          
	<script src="../../bower_components/summernote/dist/lang/summernote-es-ES.js"></script>  

	<link href="../../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">
	<script src="../../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript"></script>

	<link href="../../bower_components/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet" type="text/css">
	<script src="../../bower_components/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>

	<script src="../../bower_components/pdfmake/build/pdfmake.js" type="text/javascript" ></script>
	<script src="../../LibreriasExternas/pdfmake/build/vfs_fonts_nidos.js" type="text/javascript"></script>

	<script src="../../node_modules/bootstrap-fileinput/js/fileinput.min.js" type="text/javascript"></script>
	<script src="../../node_modules/bootstrap-fileinput/js/plugins/piexif.min.js"></script>
	<script src="../../node_modules/bootstrap-fileinput/js/plugins/sortable.min.js"></script>
	<script src="../../node_modules/bootstrap-fileinput/js/plugins/purify.min.js"></script> 

	<link href="../../node_modules/bootstrap-fileinput/css/fileinput.min.css" rel="stylesheet" type="text/css">

	<script src="../../node_modules/bootstrap-fileinput/js/locales/es.js" type="text/javascript"></script>


	<script src="../../node_modules/html2canvas/dist/html2canvas.js"></script>

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

	<style type="text/css">
		.img-artista{
			margin: 10px auto 30px;
			border-radius: 100%;
			border: 2px solid #aaa;
			background-size: cover;
			background-repeat: no-repeat;
			background-position: center;
			width: 200px;
			height: 200px;
			background-image: url();
		}

		.popover{
			width: 600px !important;
			max-width: none !important;
		}

		.big-size-textarea{
			min-width: 100%;
			max-width: 100%;
			min-height: 450px;
			max-height: 450px;
		}

		.small-size-textarea{
			min-width: 100%;
			max-width: 100%;
			min-height: 200px;
			max-height: 200px;
		}
		a, a:hover, a:focus{
			text-decoration: none;
		}
		.row{
			margin-bottom: 15px;
		}
		.carousel-caption{
			background: rgba(0, 0, 0, 0.28);
			max-width: 100%;
			left: 0;
			right: 0;
			bottom: 0;
		}
		.carousel-indicators{
			bottom: 0;
		}
		.carousel-inner > .item {
			height: 55vh;
		}
		.carousel-inner > .item > img {
			position: absolute;
			top: 50%;
			left: 50%;
			-webkit-transform: translate(-50%, -50%);
			-ms-transform: translate(-50%, -50%);
			transform: translate(-50%, -50%);
			max-height: 900px;
			width: auto;
		}
	</style>

</head>
<body>
	<?php include('../../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Formato de sistematización</h1>
				</div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item" id="li-registrar-sistematizacion" style="display: none;"><a class="nav-link" data-toggle="tab" href="#registrar-sistematizacion" role="tab">Registrar sistematización</a></li>
					<li class="nav-item" id="li-editar-sistematizacion" style="display: none;"><a class="nav-link" data-toggle="tab" href="#editar-sistematizacion" role="tab">Edición y descarga sistematización</a></li>
					<li class="nav-item" id="li-revision-sistematizacion" style="display: none;"><a class="nav-link" data-toggle="tab" href="#revision-sistematizacion" role="tab">Revisión sistematización</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane" id="registrar-sistematizacion" role="tabpanel">
						<form id="form-guardar-sistematizacion">
							<br>
							<div id="form-guardar-sistematizacion-contenedor">
								<br>
								<div class="row">
									<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
										<a href="#" class="regresar" style="color: #333; text-decoration: none; display: none;">
											<i class="fas fa-arrow-left fa-2x"><p style="font-size: 12px;">Regresar</p></i>
										</a>
										<br>
									</div>
								</div>
								<div class="col-lg-12" id="div-planeacion-sistematizacion">
									<legend class="text-center">Artistas Dupla - <span id="n-dupla"></span></legend>
									<div id="div-artistas">
									</div>
									<legend class="text-center">Experiencia artística</legend>
									<div class="col-lg-offset-5 col-lg-2 col-md-offset-4 col-md-4 col-sm-offset-4 col-sm-4 col-xs-offset-2 col-xs-8">
										<div class="form-group">
											<button class="btn btn-block btn-danger btn-lg" id="btn-copiar-sistematizacion" type="button">Copiar planeación</button>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6 col-md-6 col-sm-12">
											<div class="form-group">
												<label for="TX_Nombre_Exp">Nombre de la experiencia artística</label>
												<a href="#" title="Ayuda" data-toggle="popover" data-placement="top" data-trigger="hover" data-content="Escriba el nombre de la experiencia artística." class="fa fa-info-circle fa-lg"></a>
												<label class="label-button"></label>
												<input type="text" class="form-control" id="TX_Nombre_Exp" name="TX_Nombre_Exp" maxlength="100" placeholder="Máximo 100 caracteres">
												<span class="help-block" id="error"></span>
											</div>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-12">
											<div class="form-group">
												<label for="SL_Mes_Exp">Mes de la experiencia artística</label>
												<select class="form-control selectpicker" data-live-search="true" id="SL_Mes_Exp" name="SL_Mes_Exp" title="Seleccione el mes"></select>
												<span class="help-block" id="error"></span>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6 col-md-6">
											<label for="TX_Tema">Tema</label>
											<a href="#" id="popover-tema" data-toggle="popover" title="Ayuda" data-placement="top" data-trigger="hover" data-content="En una breve frase defina la idea principal de la experiencia y que está relacionada con la narrativa poética de la misma." class="fa fa-info-circle fa-lg"></a>
											<label class="label-button"></label>
											<input type="text" class="form-control" id="TX_Tema" name="TX_Tema" maxlength="100" placeholder="Máximo 100 caracteres">
										</div>
										<div class="col-lg-6 col-md-6">
											<label for="TX_Nombre_Exp">Materias</label>
											<a href="#" id="popover-materias" data-toggle="popover" title="Ayuda" data-placement="top" data-trigger="hover" data-content="Enuncie las materias intangibles y tangibles (incluidos materiales), que componen la experiencia." class="fa fa-info-circle fa-lg"></a>
											<label class="label-button"></label>
											<textarea class="form-control small-size-textarea" id="TX_Materias" name="TX_Materias" maxlength="500" placeholder="Máximo 500 caracteres"></textarea>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12 col-md-12">
											<label for="TX_Intencion_Artistica">Intención artística</label>
											<a href="#" id="popover-intencion" data-toggle="popover" title="Ayuda" data-placement="top" data-trigger="hover" data-content="Plantee de manera clara y sintética cuál es su motivación como artista al crear esta experiencia y qué busca al ponerla en relación con los niños. Dentro de este planteamiento mencione para qué quiere hacerlo a la luz del objetivo general del proyecto Nidos. Las siguientes preguntas pueden ayudarle a orientar su intención: ¿Qué desea provocar la dupla? ¿Cuál es su interés con la experiencia? ¿Cómo espera que los niños, niñas y familiares se involucren? ¿Qué intencionalidad pedagógica persigue?" class="fa fa-info-circle fa-lg"></a>
											<label class="label-button"></label>
											<textarea class="form-control small-size-textarea" id="TX_Intencion_Artistica" name="TX_Intencion_Artistica" maxlength="300" placeholder="Máximo 300 caracteres"></textarea>
										</div>
									</div>
									<div id="div-referentes" class="row">
										<div id="referente_1">
											<div class="col-lg-6 col-md-6">
												<label for="TX_Referente_1">Referente 1</label>
												<a href="#" id="popover-referente" data-toggle="popover" title="Ayuda" data-placement="top" data-trigger="hover" data-content="Links, enlaces,  documentos o archivos relacionados." class="fa fa-info-circle fa-lg"></a>
												<label class="label-button"></label>
												<textarea class="form-control small-size-textarea referente" id="TX_Referente_1" name="TX_Referente_1" maxlength="500" placeholder="Máximo 500 caracteres"></textarea>
											</div>
											<div class="col-lg-6 col-md-6">
												<label for="TX_Aplicabilidad_Referente_1">Aplicabilidad Referente 1</label>
												<a href="#" id="popover-aplicabilidad" data-toggle="popover" title="Ayuda" data-placement="top" data-trigger="hover" data-content="Describa cómo se relacionan los referentes con la experiencia artística, es decir, de qué manera están presentes en la propuesta. Cómo modifica, adecua o transforma el referente para la experiencia y la población objetivo." class="fa fa-info-circle fa-lg"></a>
												<label class="label-button"></label>
												<textarea class="form-control small-size-textarea aplicabilidad" id="TX_Aplicabilidad_Referente_1" name="TX_Aplicabilidad_Referente_1" maxlength="500" placeholder="Máximo 500 caracteres"></textarea>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12 col-md-12 text-right">
											<button class="btn btn-info btns-referentes" id="btn-agregar-ref" type="button">+</button>
											<button class="btn btn-danger btns-referentes" id="btn-quitar-ref" type="button">-</button>
										</div>
									</div>
									<legend class="text-center">Descripción de la experiencia artística</legend>
									<div class="row" id="div-descripcion-experiencia">
										<div class="col-lg-12 col-md-12">
											<label for="TX_Ambientacion">Ambientación</label>
											<a href="#" id="popover-ambientación" data-toggle="popover" title="Ayuda" data-placement="top" data-trigger="hover" data-content="Describa las transformaciones y adecuaciones que se planean introducir en el espacio (luz, sonido, disposición de elementos, microclimas, entre otros) y el propósito de dichas transformaciones o adecuaciones a la luz de la intención artística. Hay materias y materiales que hacen parte de la ambientación, téngalas en cuenta en esta descripción. En este apartado puede incluir dibujos o imágenes construidas que le permitan ilustrar el tema. (Cada imagen debe tener una altura mínima de 500 pixeles antes de ser insertada en el campo)." class="fa fa-info-circle fa-lg"></a>
											<label class="label-button"></label>
											<div class="summernote" id="TX_Ambientacion"></div>
										</div>
										<div class="col-lg-12 col-md-12">
											<label for="TX_Dispositivos">Dispositivos</label>
											<a href="#" id="popover-dispositivos" data-toggle="popover" title="Ayuda" data-placement="top" data-trigger="hover" data-content="Describa los dispositivos (incluidos personajes o cuerpos como dispositivos) que harán parte de la   experiencia, teniendo en cuenta sus materiales y proceso de elaboración.  (Añada registro fotográfico de los dispositivos, preferiblemente una fotografía a modo de collage con todos los dispositivos. Cada fotografía anexada debe tener una altura mínima de 500 pixeles antes de ser insertada en el campo)." class="fa fa-info-circle fa-lg"></a>
											<label class="label-button"></label>
											<div class="summernote" id="TX_Dispositivos"></div>
										</div>
										<div class="col-lg-12 col-md-12">
											<label for="TX_Momentos">Momentos</label>
											<a href="#" id="popover-momentos" data-toggle="popover" title="Ayuda" data-placement="top" data-trigger="hover" data-content="Describa los distintos momentos que tendrá la experiencia incluyendo inicio, desarrollo y cierre, así como los procesos, etapas o acciones que espera que se desencadenen en la implementación de la misma. Es importante señalar la entrada de dispositivos, materias, materiales y personajes, y las intervenciones o acciones provocadoras que desarrollan los artistas durante estos momentos." class="fa fa-info-circle fa-lg"></a>
											<label class="label-button"></label>
											<div class="summernote" id="TX_Momentos"></div>	
										</div>
									</div>
								</div>
								<div class="col-lg-12" id="div-desarrollo-sistematizacion" style="display: none;">
									<div class="row">
										<legend class="text-center">Hallazgos</legend>
										<div class="row">
											<div class="col-lg-12 col-md-12"><legend>Entorno institucional</legend></div>
										</div>
										<div class="row">
											<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
												<label for="TX_Ninos_Ins">Niños/Niñas</label>
												<a href="#" id="popover-ninos-ins" data-toggle="popover" title="Ayuda" data-placement="top" data-trigger="hover" data-content="Respuestas, interacciones y posibles transformaciones que surgieron desde los participantes con relación a la experiencia artística." class="fa fa-info-circle fa-lg"></a>
												<label class="label-button"></label>
												<textarea class="form-control big-size-textarea" id="TX_Ninos_Ins" name="TX_Ninos_Ins" maxlength="10000" placeholder="Máximo 10000 caracteres"></textarea>
											</div>
											<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
												<label for="TX_Agentes_Ins">Agentes educativos</label>
												<a href="#" id="popover-agentes-ins" data-toggle="popover" title="Ayuda" data-placement="top" data-trigger="hover" data-content="Respuestas, interacciones y posibles transformaciones que surgieron desde los participantes con relación a la experiencia artística." class="fa fa-info-circle fa-lg"></a>
												<label class="label-button"></label>
												<textarea class="form-control big-size-textarea" id="TX_Agentes_Ins" name="TX_Agentes_Ins" maxlength="10000" placeholder="Máximo 10000 caracteres"></textarea>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-12 col-md-12"><legend>Entorno familiar</legend></div>
										</div>
										<div class="row">
											<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
												<label for="TX_Ninos_Fam">Niños/Niñas</label>
												<a href="#" id="popover-ninos-fam" data-toggle="popover" title="Ayuda" data-placement="top" data-trigger="hover" data-content="Respuestas, interacciones y posibles transformaciones que surgieron desde los participantes con relación a la experiencia artística." class="fa fa-info-circle fa-lg"></a>
												<label class="label-button"></label>
												<textarea class="form-control big-size-textarea" id="TX_Ninos_Fam" name="TX_Ninos_Fam" maxlength="10000" placeholder="Máximo 10000 caracteres"></textarea>
											</div>
											<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
												<label for="TX_Agentes_Fam">Agentes educativos</label>
												<a href="#" id="popover-agentes-fam" data-toggle="popover" title="Ayuda" data-placement="top" data-trigger="hover" data-content="Respuestas, interacciones y posibles transformaciones que surgieron desde los participantes con relación a la experiencia artística." class="fa fa-info-circle fa-lg"></a>
												<label class="label-button"></label>
												<textarea class="form-control big-size-textarea" id="TX_Agentes_Fam" name="TX_Agentes_Fam" maxlength="10000" placeholder="Máximo 10000 caracteres"></textarea>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
												<label for="TX_Familias_Fam">Familias</label>
												<a href="#" id="popover-familias-fam" data-toggle="popover" title="Ayuda" data-placement="top" data-trigger="hover" data-content="Respuestas, interacciones y posibles transformaciones que surgieron desde los participantes con relación a la experiencia artística." class="fa fa-info-circle fa-lg"></a>
												<label class="label-button"></label>
												<textarea class="form-control big-size-textarea" id="TX_Familias_Fam" name="TX_Familias_Fam" maxlength="10000" placeholder="Máximo 10000 caracteres"></textarea>
											</div>
											<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">	
												<label for="TX_Mujeres_Fam">Mujeres gestantes</label>
												<a href="#" id="popover-mujeres-fam" data-toggle="popover" title="Ayuda" data-placement="top" data-trigger="hover" data-content="Respuestas, interacciones y posibles transformaciones que surgieron desde los participantes con relación a la experiencia artística." class="fa fa-info-circle fa-lg"></a>
												<label class="label-button"></label>
												<textarea class="form-control big-size-textarea" id="TX_Mujeres_Fam" name="TX_Mujeres_Fam" maxlength="10000" placeholder="Máximo 10000 caracteres"></textarea>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-12 col-md-12"><legend>Comunidad</legend></div>
										</div>
										<div class="row">
											<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
												<label for="TX_Ninos_Com">Niños/Niñas</label>
												<a href="#" id="popover-ninos-com" data-toggle="popover" title="Ayuda" data-placement="top" data-trigger="hover" data-content="Respuestas, interacciones y posibles transformaciones que surgieron desde los participantes con relación a la experiencia artística." class="fa fa-info-circle fa-lg"></a>
												<label class="label-button"></label>
												<textarea class="form-control big-size-textarea" id="TX_Ninos_Com" name="TX_Ninos_Com" maxlength="10000" placeholder="Máximo 10000 caracteres"></textarea>
											</div>
											<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
												<label for="TX_Familias_Com">Familias</label>
												<a href="#" id="popover-familias-com" data-toggle="popover" title="Ayuda" data-placement="top" data-trigger="hover" data-content="Respuestas, interacciones y posibles transformaciones que surgieron desde los participantes con relación a la experiencia artística." class="fa fa-info-circle fa-lg"></a>
												<label class="label-button"></label>
												<textarea class="form-control big-size-textarea" id="TX_Familias_Com" name="TX_Familias_Com" maxlength="10000" placeholder="Máximo 10000 caracteres"></textarea>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-12 col-md-12"><legend>Reflexiones de los artistas</legend></div>
										</div>
										<div class="row">
											<div class="col-lg-6 col-md-6">
												<label for="TX_Aprendizajes_Creacion">Desde la creación</label>
												<a href="#" id="popover-aprendizajes-creacion" data-toggle="popover" title="Ayuda" data-placement="top" data-trigger="hover" data-content="Reflexiones, observaciones, intereses y hallazgos personales que surgen en el artista durante la creación e implementación de la experiencia y con relación a su práctica. Se espera que la dupla de artistas reflexione sobre al menos una de las líneas propuestas en cada sistematización (Desde la creación, Aprendizajes personales, Otros aspectos significativos)." class="fa fa-info-circle fa-lg"></a>
												<label class="label-button"></label>
												<textarea class="form-control big-size-textarea" id="TX_Aprendizajes_Creacion" name="TX_Aprendizajes_Creacion" maxlength="3000" placeholder="Máximo 3000 caracteres"></textarea>
											</div>
											<div class="col-lg-6 col-md-6">
												<label for="TX_Aprendizajes_Personales">Aprendizajes personales</label>
												<a href="#" id="popover-aprendizajes-personales" data-toggle="popover" title="Ayuda" data-placement="top" data-trigger="hover" data-content="Reflexiones, observaciones, intereses y hallazgos personales que surgen en el artista durante la creación e implementación de la experiencia y con relación a su práctica. Se espera que la dupla de artistas reflexione sobre al menos una de las líneas propuestas en cada sistematización (Desde la creación, Aprendizajes personales, Otros aspectos significativos)." class="fa fa-info-circle fa-lg"></a>
												<label class="label-button"></label>
												<textarea class="form-control big-size-textarea" id="TX_Aprendizajes_Personales" name="TX_Aprendizajes_Personales" maxlength="3000" placeholder="Máximo 3000 caracteres"></textarea>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-12 col-md-12">
												<label for="TX_Otros_Aspectos">Otros aspectos significativos</label>
												<a href="#" id="popover-otros-aspectos" data-toggle="popover" title="Ayuda" data-placement="top" data-trigger="hover" data-content="Reflexiones, observaciones, intereses y hallazgos personales que surgen en el artista durante la creación e implementación de la experiencia y con relación a su práctica. Se espera que la dupla de artistas reflexione sobre al menos una de las líneas propuestas en cada sistematización (Desde la creación, Aprendizajes personales, Otros aspectos significativos)." class="fa fa-info-circle fa-lg"></a>
												<label class="label-button"></label>
												<textarea class="form-control big-size-textarea" id="TX_Otros_Aspectos" name="TX_Otros_Aspectos" maxlength="3000" placeholder="Máximo 3000 caracteres"></textarea>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-12 col-md-12" id="div-banco-imagenes">
												<label for="TX_Banco_Imagenes">Banco de imágenes</label>
												<label class="label-button"></label>
												<a href="#" id="popover-imagenes" data-toggle="popover" title="Ayuda" data-placement="top" data-trigger="hover" data-content="En este espacio puede subir hasta 10 imágenes de 5MB cada una." class="fa fa-info-circle fa-lg"></a>
												<div id="TX_Banco_Imagenes"></div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-6 col-xs-offset-3 col-md-6 col-md-offset-3">
										<button class="btn btn-block btn-primary" id="BTN_Guardar_Sistematizacion" type="submit">Guardar Sistematización</button>
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="tab-pane" id="editar-sistematizacion" role="tabpanel">
						<form id="form-modificar-sistematizacion">
							<br>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="div-tabla-sistematizaciones">
								<table id="tabla_sistematizaciones_dupla" class="table table-striped table-bordered table-hover" width="100%">
									<thead>
										<tr>
											<th>Nombre de la experiencia</th>
											<th>Periodo</th>
											<th>Planeación</th>
											<th>Sistematización</th>
											<th>Banco de imágenes</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
							</div>
							<div id="div-info-detallada-sistematizacion" style="display: none;">
								<div id="form-modificar-sistematizacion-contenedor">
								</div>
								<div class="row">
									<div class="col-xs-6 col-xs-offset-3 col-md-6 col-md-offset-3">
										<button class="btn btn-block btn-primary" id="BTN_modificar_Sistematizacion" data-modificar="planeacion" type="submit">Modificar Sistematización</button>
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="tab-pane" id="revision-sistematizacion" role="tabpanel">
						<div id="div-sl-dupla" class="col-lg-offset-2 col-lg-8 col-md-offset-2 col-md-8">
							<div class="form-group">
								<select class="form-control selectpicker" title="Seleccione una dupla" data-live-search="true" name="SL_Dupla" id="SL_Dupla"></select>
							</div>
						</div>
						<div class="row"></div>
						<form id="form-revisar-sistematizacion">
							<br>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="div-tabla-sistematizaciones-eaat" style="display: none;">
								<table id="tabla_sistematizaciones_dupla_eaat" class="table table-striped table-bordered table-hover" width="100%">
									<thead>
										<tr>
											<th>Nombre de la experiencia</th>
											<th>Periodo</th>
											<th>Planeación</th>
											<th>Sistematización</th>
											<th>Banco de imágenes</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
							</div>
							<div id="div-info-detallada-sistematizacion-eaat" style="display: none;">
								<div id="form-revisar-sistematizacion-contenedor">
								</div>
								<div class="row">
									<div class="col-lg-12 col-md-12">
										<div class="col-lg-offset-3 col-lg-3 col-md-offset-2 col-md-4">
											<button class="btn btn-block btn-warning btn-revision" data-tipo="planeacion" id="BTN_Guardar_revision" type="button">Revisar</button>
										</div>
										<div class="col-lg-3 col-md-4">
											<button class="btn btn-block btn-success btn-revision" id="BTN_Aprobar_planeacion" data-tipo="planeacion" type="button">Aprobar</button>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="modal-imagenes" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Banco de imágenes</h4>
					</div>
					<div class="modal-body">
						<div id="div-carousel"></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>