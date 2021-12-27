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
	<title>Administración de territorios</title>

	<link href="../../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

	<script type="text/javascript" src="Js/Asignar_Persona_Territorio.js?v=1.7.1.1"></script>

	<link href="../../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">
	<script src="../../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript" ></script>

	<link href="../../bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"  rel="stylesheet" type="text/css" >
	<link href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet">
	<link href="../../bower_components/datatables.net-buttons-dt/css/buttons.dataTables.min.css" rel="stylesheet" >
	<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src="../../bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="../../bower_components/datatables.net-responsive-bs/js/responsive.bootstrap.min.js"></script>

	<script src="../../bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"  type="text/javascript" ></script>
	<script src="../../bower_components/jszip/dist/jszip.min.js"  type="text/javascript" ></script>
	<script src="../../bower_components/datatables.net-buttons/js/buttons.html5.min.js" type="text/javascript" ></script>






   <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css">

	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/js/bootstrap-select.min.js"></script>
	<link rel="stylesheet" href="../../LibreriasExternas/sweetalert2/sweetalert2.min.css">
	<script src="../../LibreriasExternas/sweetalert2/sweetalert2.min.js"></script>
	<script src="../../bower_components/moment/moment.js" type="text/javascript"></script>





	<script src="Js/calendar.js"></script>
	<script src="Js/calendarJs.js"></script>
	<link href="Js/calendar.css" rel="stylesheet">


	<style>

	body {
		margin-bottom: 40px;
		margin-top: 40px;
		text-align: center;
		font-size: 14px;
		font-family: 'Roboto', sans-serif;
	}

	#wrap {
		width: 1200px;
		margin: 0 auto;
	}

	#external-events {
		float: left;
		width: 150px;
		padding: 0 10px;
		text-align: left;
	}

	#external-events h4 {
		font-size: 16px;
		margin-top: 0;
		padding-top: 1em;
	}

	.external-event { /* try to mimick the look of a real event */
		margin: 10px 0;
		padding: 2px 4px;
		background: #3366CC;
		color: #fff;
		font-size: .85em;
		cursor: pointer;
	}

	#external-events p {
		margin: 1.5em 0;
		font-size: 11px;
		color: #666;
	}

	#external-events p input {
		margin: 0;
		vertical-align: middle;
	}

	#calendar {
		/* 		float: right; */
		margin: 0 auto;
		width: 1200px;
		background-color: #FFFFFF;
		border-radius: 6px;
		box-shadow: 0 1px 2px #C3C3C3;
		-webkit-box-shadow: 0px 0px 21px 2px rgba(0,0,0,0.18);
		-moz-box-shadow: 0px 0px 21px 2px rgba(0,0,0,0.18);
		box-shadow: 0px 0px 21px 2px rgba(0,0,0,0.18);
	}

</style>
</head>
<body>
	<?php include('../../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
		<div class="panel-heading">
			<div class="page-header">
				<h1>Administración de territorios</h1>
			</div>
		</div>
		<div class="panel-body">
			<ul class="nav nav-tabs" role="tablist">
				<li class="nav-item active"><a class="nav-link" data-toggle="tab" href="#asignacion_territorio" role="tab">Asignación de territorio</a></li>
				<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#consulta_asignacion_territorios" role="tab">Consulta de asignación</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="asignacion_territorio" role="tabpanel">
						<div class="row">
						<div class="col-xs-12 col-md-12 text-center bg-info">
							<h4>programacion</h4>
						</div>
					</div>
							<br>


							<div id='wrap'>

								<div id='calendar'></div>

								<div style='clear:both'></div>
							</div>
							<div class="modal fade" id="info-event" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<form class="form-horizontal">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												<h4 class="modal-title" id="myModalLabel">Evento</h4>
											</div>
											<div class="modal-body">
												<div class="row text-center">
													<div class="form-group col-lg-12">
														<label for="select" class="col-lg-3 control-label">Hora Inicio</label>
														<div class="col-lg-9">
															<select class="form-control selectpicker" data-live-search="true" id="select-hora-inicio" name="select-hora-inicio">
															</select>
														</div>
													</div>
												</div>
												<div class="row text-center">
													<div class="form-group col-lg-12">
														<label for="select" class="col-lg-3 control-label">Hora Fin</label>
														<div class="col-lg-9">
															<select class="form-control selectpicker" data-live-search="true" id="select-hora-fin" name="select-hora-fin">
															</select>
														</div>
													</div>
												</div>
												<div class="row text-center">
													<div class="form-group col-lg-12">
														<label for="input-texto" class="col-lg-3 control-label">Texto</label>
														<div class="col-lg-9">
															<textarea type="text" class="form-control" id="input-texto" name="input-texto" rows='3' placeholder="Texto"></textarea>
														</div>
													</div>
												</div>
												<div class="row text-center">
													<div class="form-group col-lg-12">
														<label for="input-color" class="col-lg-3 control-label">Código de color</label>
														<div class="col-lg-9">
															<input type="text" class="form-control" id="input-color" name="input-color" rows='3' placeholder="Texto">
														</div>
													</div>
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
												<button type="button" class="btn btn-primary" id="guardar-cambios">Guardar Cambios</button>
											</div>
										</form>
									</div>
								</div>
							</div>














				</div>


										<div class="tab-pane" id="consulta_asignacion_territorios" role="tabpanel">
										</div>
			</div>
		</div>
	</div>
</div>

</body>
</html>
