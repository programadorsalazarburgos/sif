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

	<script type="text/javascript" src="Js/Sistematizacion_artistas.js?v=2019.05.27"></script>
	<script type="text/javascript" src="Js/Consulta_sistematizacion.js?v=2019.05.27"></script>

	<link href="../../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">
	<script src="../../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript"></script>

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

	<script src="../../bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"  type="text/javascript" ></script>
	<script src="../../bower_components/jszip/dist/jszip.min.js" type="text/javascript" ></script>
	<script src="../../bower_components/datatables.net-buttons/js/buttons.html5.min.js" type="text/javascript" ></script>

	<script src="../../bower_components/pdfmake/build/pdfmake.js" type="text/javascript" ></script>
	<script src="../../LibreriasExternas/pdfmake/build/vfs_fonts_nidos.js" type="text/javascript"></script>

	<script src="../../bower_components/jquery-validation/dist/jquery.validate.min.js"></script>

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
			margin-left: -1000px;
			position: absolute;
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
					<h1>Consulta sistematización</h1>
				</div>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item active"><a class="nav-link" data-toggle="tab" href="#div-consulta-sistematizacion" role="tab">Consulta sistematización</a></li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#div-descarga-sistematizacion" role="tab">Descarga sistematización</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="div-consulta-sistematizacion" role="tabpanel">
						<br>
						<div class="row">
							<div class="col-lg-offset-1 col-lg-10 text-center bg-info"><h4>Filtros para consultar y descargar información</h4>
							</div>
						</div>
						<br>
						<div class="row">
							<form>
								<div class="col-lg-offset-2 col-lg-4">
									<label for="SL_Territorio">Territorio:</label>
									<div class="form-group">
										<select class="form-control selectpicker" multiple data-actions-box="true" data-deselect-all-text="Ninguno" data-select-all-text="Todos" data-live-search="true" name="SL_Territorio" id="SL_Territorio" title="Seleccione un territorio"></select>
									</div>
								</div>
								<div class="col-lg-4">
									<label for="SL_Dupla">Dupla:</label>
									<div class="form-group">
										<select class="form-control selectpicker" multiple data-actions-box="true" data-deselect-all-text="Ninguno" data-select-all-text="Todos" data-live-search="true" name="SL_Dupla" id="SL_Dupla" title="Seleccione una dupla"></select>
									</div>
								</div>
								<div class="col-lg-offset-2 col-lg-4">
									<label for="SL_Mes">Mes:</label>
									<div class="form-group">
										<select class="form-control selectpicker" multiple data-actions-box="true" data-deselect-all-text="Ninguno" data-select-all-text="Todos" data-live-search="true" name="SL_Mes" id="SL_Mes" title="Seleccione un mes"></select>
									</div>
								</div>
								<div class="col-lg-4">
									<label for="SL_Campo">Campo:</label>
									<div class="form-group">
										<select class="form-control selectpicker" multiple data-actions-box="true" data-deselect-all-text="Ninguno" data-select-all-text="Todos" data-live-search="true" name="SL_Campo" id="SL_Campo" title="Seleccione un Campo"></select>
									</div>
								</div>
								<div class="col-lg-offset-4 col-lg-4">
									<div class="form-group">
										<button class="btn btn-primary btn-block" type="button" id="BTN_Consultar_Info">Consultar información</button>
									</div>
								</div>
							</form>
						</div>
						<div class="col-lg-offset-1 col-lg-10 table-responsive" id="div-info-sistematizacion">
						</div>
					</div>
					<div class="tab-pane" id="div-descarga-sistematizacion" role="tabpanel">
						<br>
						<div class="row">
							<div class="col-lg-offset-1 col-lg-10 text-center bg-info"><h4>Filtros para descarga de sistematizaciones</h4>
							</div>
						</div>
						<br>
						<form>
							<div class="col-lg-offset-3 col-lg-3">
								<label for="SL_Territorio">Territorio:</label>
								<div class="form-group">
									<select class="form-control selectpicker" multiple data-actions-box="true" data-deselect-all-text="Ninguno" data-select-all-text="Todos" data-live-search="true" name="SL_Territorio" id="SL_Territorio_Des" title="Seleccione un territorio"></select>
								</div>
							</div>
							<div class="col-lg-3">
								<label for="SL_Dupla">Mes:</label>
								<div class="form-group">
									<select class="form-control selectpicker" multiple data-actions-box="true" data-deselect-all-text="Ninguno" data-select-all-text="Todos" data-live-search="true" name="SL_Dupla_Des" id="SL_Mes_Des" title="Seleccione un mes"></select>
								</div>
							</div>
							<div class="col-lg-offset-3 col-lg-6">
								<label for="SL_Dupla">Dupla:</label>
								<div class="form-group">
									<select class="form-control selectpicker" multiple data-actions-box="true" data-deselect-all-text="Ninguno" data-select-all-text="Todos" data-live-search="true" name="SL_Dupla_Des" id="SL_Dupla_Des" title="Seleccione una dupla"></select>
								</div>
							</div>
							<div class="col-lg-offset-4 col-lg-4">
								<div class="form-group">
									<button class="btn btn-primary btn-block" type="button" id="BTN_Consultar_Sis">Consultar sistematizaciones</button>
								</div>
							</div>
							<div class="col-lg-offset-1 col-lg-10" id="div-info-descarga">
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
						<h4 class="modal-title"></h4>
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