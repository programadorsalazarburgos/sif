<?php
session_start();
if(!isset($_SESSION["session_username"])) {
	header("location:index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<script src="../bower_components/fontawesome/svg-with-js/js/fontawesome-all.min.js" ></script>
	<link href="https://fonts.googleapis.com/css?family=Yatra One|BioRhyme|Righteous|Prompt" rel="stylesheet">
	<link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../css/material-desing.css">
	<link href='../bower_components/fullcalendar/dist/core/main.css' rel='stylesheet'/>
	<link href='../bower_components/fullcalendar/dist/daygrid/main.css' rel='stylesheet' />
	<!-- <link href="Css/calendar.css" rel="stylesheet"> -->
	<script type="text/javascript" src="../bower_components/jquery/dist/jquery.min.js"></script>
	<script type="text/javascript" src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
	<script type="text/javascript" src="../js/bootbox.js"></script>
	<script type="text/javascript" src="../js/funcionesGenerales.js?v=2019.06.11.2"></script>

	<link href="../bower_components/summernote/dist/summernote.css" rel="stylesheet"> 
	<script src="../bower_components/summernote/dist/summernote.min.js"></script>          
	<script src="../bower_components/summernote/dist/lang/summernote-es-ES.js"></script>

	<link href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet"> 
	<link href="../bower_components/datatables.net-buttons-dt/css/buttons.dataTables.min.css" rel="stylesheet"> 
	<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script> 
	<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> 
	<script src="../bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script> 
	<script src="../bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src='../bower_components/pdfmake/build/pdfmake.js?v=2019.05.03.0'></script>
	<script src='../bower_components/pdfmake/build/vfs_fonts.js?v=2019.05.16.0'></script>


	<script src='../bower_components/fullcalendar/dist/core/main.js?v=2019.06.10.7'></script>
	<script src='../bower_components/fullcalendar/dist/interaction/main.js?v=2019.06.10.7'></script>
	<script src='../bower_components/fullcalendar/dist/daygrid/main.js'></script>
	<script src='../bower_components/fullcalendar/dist/core/locales/es.js'></script>
	<script type="text/javascript" src="Js/Monitoreo_Registro_Asistencia.js?v=2021.09.22.20"></script>
</head>
<style type="text/css">
	.modal-dialog {
		/*height: 80% !important;*/
		padding-top:5%;
	}

	.modal-content {
		/*height: 100% !important;*/
		overflow:visible;
	}

	.modal-body {
		/*height: 80%;*/
		overflow: auto;
	}
	div{
		font-family: 'Prompt';
		font-size: 14px;
		font-weight: normal; 
	}
	textarea{
		resize: vertical;
	}
	@media only screen and (max-width: 767px) {

		label {
			font-size: 10px;
		}
	}
	.modal-dialog {
		width: 90% !important;
	}
	.cell-input{
		border-left: none !important;
		height: 10px !important;
		padding: 0px !important;
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
		width: 700px;
		background-color: #FFFFFF;
		border-radius: 6px;
		box-shadow: 0 1px 2px #C3C3C3;
		-webkit-box-shadow: 0px 0px 21px 2px rgba(0,0,0,0.18);
		-moz-box-shadow: 0px 0px 21px 2px rgba(0,0,0,0.18);
		box-shadow: 0px 0px 21px 2px rgba(0,0,0,0.18);
	}
	.fc-day:hover{
		background:lightblue;
	}

	/*Allow pointer-events through*/
	.fc-slats, /*horizontals*/
	.fc-content-skeleton, /*day numbers*/
	.fc-bgevent-skeleton /*events container*/{
		pointer-events:none
	}

	/*Turn pointer events back on*/
	.fc-bgevent,
	.fc-event-container{
		pointer-events:auto; /*events*/
	}
	.fc-today{
		background-color: #009f99!important;
		color: #ffffff!important;
	}

</style>
<body>
	<div class="panel panel-success">
		<div class="panel-heading">
			<div class="page-header">
				<h1>Monitoreo Registro de Asistencia <small>Arte en la Escuela/Impulsa CREA/Converge CREA</small></h1>
			</div>
		</div>
		<br>
		<div class="row text-center">
			<div class="form-group col-lg-12">
				<label for="select" class="col-lg-1 col-lg-offset-3">Linea de Atención</label>
				<div class="col-lg-5">
					<select class="form-control selectpicker" data-live-search="true" id="SL_LINEA_ATENCION" name="SL_LINEA_ATENCION">
					</select>
				</div>
			</div>
		</div>
		<div class="row text-center">
			<div class="form-group col-lg-12">
				<label for="select" class="col-lg-1 col-lg-offset-3">Organización</label>
				<div class="col-lg-5">
					<select class="form-control selectpicker" data-live-search="true" id="SL_ORGANIZACION" name="SL_ORGANIZACION">
					</select>
				</div>
			</div>
		</div>
		<div class="row text-center">
			<div class="form-group col-lg-12">
				<label for="select" class="col-lg-1 col-lg-offset-3">CREA</label>
				<div class="col-lg-5">
					<select class="form-control selectpicker" multiple data-live-search="true" id="SL_CREA" name="SL_CREA">
					</select>
				</div>
			</div>
		</div>
	</div>
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
						<center><h4 class="modal-title" id="modal-title">Registro de Asistencia</h4></center>
					</div>
					<div class="modal-body">
						<div class="col-lg-12 row" >
							<div class="table-responsive">
								<table id="table-listado-asistencia" class="table table-hover " width="100%" style="width: 100%">
									<thead>
										<tr>
											<th>Grupo</th>
											<th>Organizacion</th>
											<th>Formador</th>
											<th>Fecha Sesión</th>
											<th>Asistencia</th>
											<th>Fecha de Registro</th>
											<th>Novedad</th>
										</tr>
									</thead>
								</table>  
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
<!-- Modal -->
</html>