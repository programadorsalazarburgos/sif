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
	<title>Administrar Colegios CREA</title>
	<link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../bower_components/jquery/dist/jquery.min.js"></script> 
	<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

	<link href="../bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"  rel="stylesheet" type="text/css" > 
	<link href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet"> 
	<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script> 
	<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> 
	<script src="../bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script> 
	<script src="../bower_components/datatables.net-responsive-bs/js/responsive.bootstrap.min.js"></script>  

	<link href="../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" >
	<script src="../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript" ></script>

    <link href="../bootstrap/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
	<script type="text/javascript" src="Js/Administrar_Colegios_CREA.js?v=2018.09.10.13"></script> 
</head>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	
	<div class="container-fluid">
		<div class="panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Administración de Colegios CREA</h1>
				</div>
				<input type='hidden' id='id_usuario' value='<?php echo $Id_Persona; ?>'> 
			</div>
			<div class="panel-body col-md-6 col-md-offset-3">
				<div class="row"> 
					<div class="col-xs-3 col-md-3">
						<label for="SL_CREA">Seleccione el CREA:</label>
					</div>
					<div class="col-xs-9 col-md-9">
						<select id="SL_CREA" class="form-control selectpicker" data-actions-box="true" data-live-search="true" title="Eliga un CREA"></select>
					</div>
				</div>
				<div class="row">
					<br>
					<div class="col-xs-3 col-md-3">
						<label for="SL_Colegios">Seleccione el (los) Colegio (s):</label>
					</div>
					<div class="col-xs-9 col-md-9">
						<select id="SL_Colegios" name="SL_Colegios" class="form-control selectpicker" multiple data-actions-box="true" title="Seleccione colegios" data-live-search="true"  title="Eliga colegios"></select>
					</div>
				</div>
				<div class="row">
					<br>
					<div class="col-xs-12 col-md-12">
						<div class="jumbotron">
							<strong>COLEGIOS ASOCIADOS AL CREA</strong>
							<hr>
							<div id='div_colegios_asociados' name='div_colegios_asociados'>
								<div>Ningún CREA seleccionado</div>
							</div>
						</div>
					</div>
				</div>			
				<div class="row">
					<hr>
					<div class="col-xs-6 col-xs-offset-3 col-md-6 col-md-offset-3">
						<a href="#" id="BT_Guardar" class="form-control btn btn-primary">Guardar</a>
					</div>
				</div>		
			</div>
		</div>
	</div>	
</body>
</html>
