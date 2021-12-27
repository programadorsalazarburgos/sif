<?php
	session_start();
	if(!isset($_SESSION["session_username"])) {
		header("location:../index.php");
	} else {
		$Id_Persona= $_SESSION["session_username"];
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Evaluación Artistas Formadores</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/js/bootstrap-select.min.js"></script>


    <script type="text/javascript" src="Js/bootstrap-slider/bootstrap-slider.js"></script>
    <link rel="stylesheet" type="text/css" href="Js/bootstrap-slider/css/bootstrap-slider.css">
    <script type="text/javascript" src="Js/Evaluacion_Artista_Formador_Y_Organizacion.js?v=2018.10.16"></script>
</head>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
	<div class="panel panel-success">
		<div class="panel-heading">
			<div class="page-header">
				<h1>Evaluación a artista formador <small>Módulo Pedagógico</small></h1>
			</div>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-xs-12 col-md-12">
					<button class="form-control btn btn-info" data-toggle='modal' data-target='#modal-evaluacion-artista-formador'>Realizar nueva evaluación a un <b>Artista Formador</b></button>
				</div>
			<!--
				<div class="col-xs-12 col-md-12">
					<button class="form-control btn btn-warning" data-toggle="modal" data-target="#modal-evaluacion-organizacion">Realizar nueva evaluación a una <b>Organización</b></button>
				</div>
			-->
			</div>
		</div>
		<div class="panel-footer">

		</div>
		<div class="modal fade" role="dialog" id="modal-evaluacion-artista-formador">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type='button' class='close' data-dismiss='modal'>&times;</button>
						<h4 class='modal-title'>Evaluación <b>Artista Formador</b></h4>
					</div>
					<div class="modal-body">
						<form id="form_evaluacion_artista_formador">
							<fieldset>
								<legend>Datos de la evaluación a <b>Artista Formador</b>:</legend>
								<input required="required" type="hidden" name="opcion" value="registrar_evaluacion_artista_formador">
								<?php echo "<input type='hidden' name='id_usuario' value='".$Id_Persona."'>"; ?>
								<div class="row">
									<div class="col-xs-6 col-md-4">
										<label for="SL_area_artistica">Area Artistica:</label>
									</div>
									<div class="col-xs-12 col-md-8">
										<select required="required" class="selectpicker form-control" id="SL_area_artistica" name="SL_area_artistica"></select>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-6 col-md-4">
										<label for="SL_artista_formador">Artista formador:</label>
									</div>
									<div class="col-xs-12 col-md-8">
										<select required="required" class="selectpicker form-control" id="SL_artista_formador" name="SL_artista_formador" data-live-search="true" data-style="btn-info"></select>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-xs-6 col-md-6">
										<label for="slider_artista_formador_1">Cumplimiento en la entrega de tareas según contrato:</label>
									</div>
									<div class="col-xs-12 col-md-6">
										<input required="required" name="slider_artista_formador_1" id="slider_artista_formador_1" data-slider-max="20">
									</div>
									<div class="col-xs-12 col-md-12">
										<textarea required="required" class="form-control" name="justificacion_1" id="justificacion_1" rows="2" placeholder="Justificación de califiación 'cumplimiento en la entrega de tareas según contrato'"></textarea>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-6 col-md-6">
										<label for="slider_artista_formador_2">Disposición y colaboración en el trabajo en equipo:</label>
									</div>
									<div class="col-xs-12 col-md-6">
										<input required="required" name="slider_artista_formador_2" id="slider_artista_formador_2" data-slider-max="10">
									</div>
									<div class="col-xs-12 col-md-12">
										<textarea required="required" class="form-control" name="justificacion_2" id="justificacion_2" rows="2" placeholder="Justificación de califiación 'disposición y colaboración en el trabajo en equipo'"></textarea>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-6 col-md-6">
										<label for="slider_artista_formador_3" data-slider-max="20">Aportes significativos al área artística en el que se desempeña:</label>
									</div>
									<div class="col-xs-12 col-md-6">
										<input required="required" name="slider_artista_formador_3" id="slider_artista_formador_3" data-slider-max="20">
									</div>
									<div class="col-xs-12 col-md-12">
										<textarea required="required" class="form-control" name="justificacion_3" id="justificacion_3" rows="2" placeholder="Justificación de califiación 'aportes significativos al área artística en el que se desempeña'"></textarea>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-6 col-md-6">
										<label for="slider_artista_formador_4">Evidencias de calidad en los procesos formativos:</label>
									</div>
									<div class="col-xs-12 col-md-6">
										<input required="required" name="slider_artista_formador_4" id="slider_artista_formador_4" data-slider-max="25">
									</div>
									<div class="col-xs-12 col-md-12">
										<textarea required="required" class="form-control" name="justificacion_4" id="justificacion_4" rows="2" placeholder="Justificación de califiación 'evidencias de calidad en los procesos formativos'"></textarea>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-6 col-md-6">
										<label for="slider_artista_formador_5">Evidencias los resultados en el desempeño artístico:</label>
									</div>
									<div class="col-xs-12 col-md-6">
										<input required="required" name="slider_artista_formador_5" id="slider_artista_formador_5" data-slider-max="25">
									</div>
									<div class="col-xs-12 col-md-12">
										<textarea required="required" class="form-control" name="justificacion_5" id="justificacion_5" rows="2" placeholder="Justificación de califiación 'evidencias los resultados en el desempeño artístico'"></textarea>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12 col-md-12">
										<div class="progress">
											<div id="progresbar_total_puntaje_artista_formador" class="progress-bar progress-bar-danger" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
												<span>Puntaje:
												20</span>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-4 col-xs-offset-4 col-md-4 col-md-offset-4">
										<input type="submit" class="form-control btn btn-success" value="Guardar Evaluación">
									</div>
								</div>
							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" role="dialog" id="modal-evaluacion-organizacion">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type='button' class='close' data-dismiss='modal'>&times;</button>
						<h4 class='modal-title'>Evaluación <b>Organización</b></h4>
					</div>
					<div class="modal-body">
						<form id="form_evaluacion_organizacion">
							<fieldset>
								<legend>Datos de la evaluación <b>Organización</b></legend>
								<input required="required" type="hidden" name="opcion" value="registrar_evaluacion_organizacion">
								<?php echo "<input type='hidden' name='id_usuario' value='".$Id_Persona."'>"; ?>
								<div class="row">
									<div class="col-xs-6 col-md-4">
										<label for="SL_organizacion">Seleccione la organización:</label>
									</div>
									<div class="col-xs-12 col-md-8">
										<div class="form-group">
											<select required="required" class="selectpicker form-control" id="SL_organizacion_ev" name="SL_organizacion_ev" data-live-search="true"></select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12 col-md-12">
										<label for="slider_organizacion_1">Coherencia entre la propuesta y el desarrollo del proyecto de la organización (relación de la propuesta presentada con el desarrollo de la misma en cada área artística):</label>
									</div>
									<div class="col-xs-12 col-md-6 col-md-offset-3">
										<input required="required" name="slider_organizacion_1" id="slider_organizacion_1" data-slider-max="20">
									</div>
									<div class="col-xs-12 col-md-12">
										<textarea required="required" class="form-control" name="justificacion_org_1" id="justificacion_org_1" rows="2" placeholder="Justificación de califiación 'Coherencia entre la propuesta y el desarrollo del proyecto de la organización (relación de la propuesta presentada con el desarrollo de la misma en cada área artística)'"></textarea>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12 col-md-12">
										<label for="slider_organizacion_2">Apropiación de la orientación pedagógica del CLAN (Obra focal, Taller, Gestos de Valoración; Diligenciamiento de formatos, relación con los colegios ):</label>
									</div>
									<div class="col-xs-12 col-md-6 col-md-offset-3">
										<input required="required" name="slider_organizacion_2" id="slider_organizacion_2" data-slider-max="20">
									</div>
									<div class="col-xs-12 col-md-12">
										<textarea required="required" class="form-control" name="justificacion_org_2" id="justificacion_org_2" rows="2" placeholder="Justificación de califiación 'Apropiación de la orientación pedagógica del CLAN (Obra focal, Taller, Gestos de Valoración; Diligenciamiento de formatos, relación con los colegios )'"></textarea>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12 col-md-12">
										<label for="slider_organizacion_3">Materiales aportados para el desarrollo de las clases (calidad, cantidad, pertinencia):</label>
									</div>
									<div class="col-xs-12 col-md-6 col-md-offset-3">
										<input required="required" name="slider_organizacion_3" id="slider_organizacion_3" data-slider-max="10">
									</div>
									<div class="col-xs-12 col-md-12">
										<textarea required="required" class="form-control" name="justificacion_org_3" id="justificacion_org_3" rows="2" placeholder="Justificación de califiación 'Materiales aportados para el desarrollo de las clases (calidad, cantidad, pertinencia)'"></textarea>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12 col-md-12">
										<label for="slider_organizacion_4">Desempeño de la organización (Entrega oportuna de formatos, materiales, Asistencia a las reuniones, solución oportuna de dificultades):</label>
									</div>
									<div class="col-xs-12 col-md-6 col-md-offset-3">
										<input required="required" name="slider_organizacion_4" id="slider_organizacion_4" data-slider-max="20">
									</div>
									<div class="col-xs-12 col-md-12">
										<textarea required="required" class="form-control" name="justificacion_org_4" id="justificacion_org_4" rows="2" placeholder="Justificación de califiación 'Desempeño de la organización (Entrega oportuna de formatos, materiales, Asistencia a las reuniones, solución oportuna de dificultades)'"></textarea>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12 col-md-12">
										<label for="slider_organizacion_5">Evidencias de valoración del proceso formativo por parte de las comunidades beneficiarias (niños, docentes, familias, institucionalidad educativa, otros):</label>
									</div>
									<div class="col-xs-12 col-md-6 col-md-offset-3">
										<input required="required" name="slider_organizacion_5" id="slider_organizacion_5" data-slider-max="10">
									</div>
									<div class="col-xs-12 col-md-12">
										<textarea required="required" class="form-control" name="justificacion_org_5" id="justificacion_org_5" rows="2" placeholder="Justificación de califiación 'Evidencias de valoración del proceso formativo por parte de las comunidades beneficiarias (niños, docentes, familias, institucionalidad educativa, otros)'"></textarea>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12 col-md-12">
										<label for="slider_organizacion_6">Evidencias de acompañamiento y fortalecimiento pedagógico y artístico a artistas formadores:</label>
									</div>
									<div class="col-xs-12 col-md-6 col-md-offset-3">
										<input required="required" name="slider_organizacion_6" id="slider_organizacion_6" data-slider-max="10">
									</div>
									<div class="col-xs-12 col-md-12">
										<textarea required="required" class="form-control" name="justificacion_org_6" id="justificacion_org_6" rows="2" placeholder="Justificación de califiación 'Evidencias de acompañamiento y fortalecimiento pedagógico y artístico a artistas formadores'"></textarea>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12 col-md-12">
										<label for="slider_organizacion_7">Aportes de la organización en cada una de las áreas artísticas en las que adelanta proceso formativo (innovación pedagógica y/o artística):</label>
									</div>
									<div class="col-xs-12 col-md-6 col-md-offset-3">
										<input required="required" name="slider_organizacion_7" id="slider_organizacion_7" data-slider-max="10">
									</div>
									<div class="col-xs-12 col-md-12">
										<textarea required="required" class="form-control" name="justificacion_org_7" id="justificacion_org_7" rows="2" placeholder="Justificación de califiación 'Aportes de la organización en cada una de las áreas artísticas en las que adelanta proceso formativo (innovación pedagógica y/o artística)'"></textarea>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12 col-md-12">
										<div class="progress">
											<div id="progresbar_total_puntaje_organizacion" class="progress-bar progress-bar-danger" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
												<span>Puntaje:
												20</span>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-4 col-xs-offset-4 col-md-4 col-md-offset-4">
										<input type="submit" class="form-control btn btn-success" value="Guardar Evaluación">
									</div>
								</div>
							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
</body>
