<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Encuesta Formadores</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/js/bootstrap-select.min.js"></script>

    <link rel="stylesheet" type="text/css" href="../LibreriasExternas/alertifyjs/css/alertify.min.css">
	<script type="text/javascript" src="../LibreriasExternas/alertifyjs/alertify.min.js"></script>

    <script  type="text/javascript" src="../js/funcionesGenerales.js"></script>

    <script type="text/javascript" src="Js/Encuesta_Estudiantes_Percepcion_Formadores.js?v=2018.10.16"></script>
    <script type="text/javascript" src="Js/bootstrap-slider/bootstrap-slider.js"></script>
    <link rel="stylesheet" type="text/css" href="Js/bootstrap-slider/css/bootstrap-slider.css">
</head>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="page-header">
				<h1>Encuesta a estudiantes <small>Percepción formadores</small></h1>
			</div>
		</div>
		<div class="panel-body">
			<form class="form" id="Form_encuesta_estudiantes_perecepcion_formadores">
				<div class="row">
					<div class="col-xs-10 col-md-6 col-md-3">
						<label for="TB_nombre_estudiante">Nombre del estudiante:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<input class="form-control" type="text" required="required" name="TB_nombre_estudiante" id="TB_nombre_estudiante" placeholder="Nombre del estudiante">
					</div>
				</div>
				<div class="row">
					<div class="col-xs-10 col-md-6 col-md-3">
						<label for="SL_area_artistica">Área del taller al que asiste:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<select class="selectpicker form-control" id="SL_area_artistica" name="SL_area_artistica"></select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-10 col-md-6 col-md-3">
						<label for="SL_artista_formador">Nombre del Artista Formador:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<select class="selectpicker form-control" id="SL_artista_formador" name="SL_artista_formador" data-live-search="true"></select>
						<input type="hidden" name="opcion" value="guardar_encuesta">
					</div>
				</div>
				<fieldset>
				<legend>Preguntas:</legend>
				<strong>
					<div class="row">
						<div class="col-xs-12 col-md-4">Pregunta</div>
						<div class="col-xs-10 col-md-6"><center>Repuesta</center></div>
					</div>
				</strong>
				<div class="row">
					<div class="col-xs-12 col-md-4">¿Le gusta la manera en que el formador hace el taller?</div>
					<div class="col-xs-10 col-md-6"><input id="slider_1" name="slider_1" /><hr /></div>
					<div class="col-xs-1 col-md-2"><div id="emoji_respuesta_1"><center><img alt="carita de respuesta" src="src_emoji/3.png" height="40"></center></div></div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-md-4">¿Considera que ha aprendido desde el área?</div>
					<div class="col-xs-10 col-md-6"><input id="slider_2" name="slider_2" /><hr /></div>
					<div class="col-xs-1 col-md-2"><div id="emoji_respuesta_2"><center><img alt="carita de respuesta" src="src_emoji/3.png" height="40"></center></div></div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-md-4">¿Dentro del taller se logran vincular sus intereses?</div>
					<div class="col-xs-10 col-md-6"><input id="slider_3" name="slider_3" /><hr /></div>
					<div class="col-xs-1 col-md-2"><div id="emoji_respuesta_3"><center><img alt="carita de respuesta" src="src_emoji/3.png" height="40"></center></div></div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-md-4">¿El artista formador incentiva el trabajo en grupo?</div>
					<div class="col-xs-10 col-md-6"><input id="slider_4" name="slider_4" /><hr /></div>
					<div class="col-xs-1 col-md-2"><div id="emoji_respuesta_4"><center><img alt="carita de respuesta" src="src_emoji/3.png" height="40"></center></div></div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-md-4">¿Hacen socializaciones entre el grupo sobre lo trabajado?</div>
					<div class="col-xs-10 col-md-6"><input id="slider_5" name="slider_5" /><hr /></div>
					<div class="col-xs-1 col-md-2"><div id="emoji_respuesta_5"><center><img alt="carita de respuesta" src="src_emoji/3.png" height="40"></center></div></div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-md-4">¿El formador reconoce sus avances en el área?</div>
					<div class="col-xs-10 col-md-6"><input id="slider_6" name="slider_6" /><hr /></div>
					<div class="col-xs-1 col-md-2"><div id="emoji_respuesta_6"><center><img alt="carita de respuesta" src="src_emoji/3.png" height="40"></center></div></div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-md-4">¿Hay espacios de dialogo en el taller?</div>
					<div class="col-xs-10 col-md-6"><input id="slider_7" name="slider_7" /><hr /></div>
					<div class="col-xs-1 col-md-2"><div id="emoji_respuesta_7"><center><img alt="carita de respuesta" src="src_emoji/3.png" height="40"></center></div></div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-md-3">
						<label for="TB_observaciones">Observaciones:</label>
					</div>
					<div class="col-xs-12 col-md-9"><textarea class="form-control" rows="3" id="TB_observaciones" name="TB_observaciones" placeholder="observaciones"></textarea></div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-md-4 col-md-offset-4 "><input type="submit" class="form-control btn btn-success" value="Guardar"></div>
				</div>
				</fieldset>
			</form>
		</div>
	</div>
	</div>
</body>
<div class="modal fade" id="modal_encuesta_finalizada" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class='alert alert-success fade-in'>
        	<h3>
        		<p>
        			<img src="src_emoji/mano_arriba.png" height="40">
        			La encuesta del estudiante:
        			<label id="LB_nombre_estudiante"></label>
        			 ha sido almacenada satisfactoriamente.
        		</p>
        	</h3>
        </div>
        <div class="alert alert-warning fade-in">
        	<a id="BT_realizar_de_nuevo" class="btn btn-info form-control">Realizar De Nuevo.</a>
        </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</html>
