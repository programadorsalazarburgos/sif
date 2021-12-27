<?php
	session_start();
	if(!isset($_SESSION["session_username"])) {
		header("location:index.php");
	} else {
		$Id_Persona= $_SESSION["session_username"];
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../bower_components/jquery/dist/jquery.min.js"></script> 
	<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>	

	<link href="../bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"  rel="stylesheet" type="text/css" > 
	<link href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet"> 
	<link href="../bower_components/datatables.net-buttons-dt/css/buttons.dataTables.min.css" rel="stylesheet" >
	<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script> 
	<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> 
	<script src="../bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script> 
	<script src="../bower_components/datatables.net-responsive-bs/js/responsive.bootstrap.min.js"></script>

	<script src="../bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"  type="text/javascript" ></script>
	<script src="../bower_components/jszip/dist/jszip.min.js"  type="text/javascript" ></script>
	<script src="../bower_components/datatables.net-buttons/js/buttons.html5.min.js" type="text/javascript" ></script>

	<link href="../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" >  
    <script src="../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript" ></script>  
    
    <script type="text/javascript" src="Js/Consultar_Asistencia_Grupos_Sesion_Clase.js?v=2020.10.13"></script>
</head>
<body> 
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Consultar Asistencia <small>Grupo en un mes especifico</small></h1>
					<?php echo "<input type='hidden' id='id_usuario' value='".$Id_Persona."' >"; ?>
				</div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-6 col-md-3">
						<label for="SL_clan">Seleccione el CREA:</label>
					</div>
					<div class="col-xs-6 col-md-9">
						<select id="SL_clan" class="form-control selectpicker" data-live-search="true"></select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-md-3">
						<label for="SL_grupo">Seleccione el Grupo:</label>
					</div>
					<div class="col-xs-6 col-md-9">
						<select id="SL_grupo" class="form-control selectpicker" data-live-search="true"></select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-md-3">
						<label for="SL_mes_clase">Seleccione el Mes:</label>
					</div>
					<div class="col-xs-6 col-md-9">
						<select id="SL_mes_clase" class="form-control selectpicker" data-live-search="true"></select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-4 col-xs-offset-4 col-md-4 col-md-offset-4">
						<button class="btn btn-info form-control" id="BT_consultar_Asistencia">Consultar</button>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-md-12 table-responsive">
						<div class="alert alert-warning">
							<h3 class="text-left">Datos del grupo</h3>
							<h4>Recuerde que puede usar el botón <button class='btn btn-secondary'><span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span></button> para ver el documento anexo de cualquier sesión de clase</h4>
						</div>
						<label for=""></label>
<!-- 						<table class="table" id="table_asistencia">
							<thead></thead>
							<tbody></tbody>
						</table> -->
						<div id="div_table_asistencia"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>