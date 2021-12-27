<?php
session_start();
if(!isset($_SESSION["session_username"])) {
	header("location:index.php");
} else {
	$Id_Persona= $_SESSION["session_username"];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Asignación De Actividades</title>
  	<link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  
  	<script src="../bower_components/jquery/dist/jquery.min.js"></script> 
  	<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script> 


	<link href="../bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"  rel="stylesheet" type="text/css" > 
	<link href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet"> 	
	<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script> 
	<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> 
	<script src="../bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script> 
	<script src="../bower_components/datatables.net-responsive-bs/js/responsive.bootstrap.min.js"></script> 	


	<link href="../bower_components/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet"> 
	<script src="../bower_components/bootstrap-toggle/js/bootstrap-toggle.min.js"></script> 

	<link href="../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css?v=1.12.1" rel="stylesheet" type="text/css" >  
	<script src="../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript" ></script>

	<link rel="stylesheet" type="text/css" href="../css/material-desing.css">   

	<script type="text/javascript" src="Js/Asignacion_Actividades_Rol.js?v=2021.08.19.0"></script>

</head>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Asignación de actividades <small>Menú SIF</small></h1>
				</div>
			</div>
			<div class="panel-body">

				<form id="" class="form-horizontal">

					<fieldset>
						<br>
						<div class="row form-group">
							<label for="select-programa" class="control-label col-xs-6 col-md-2 text-right">Seleccione el Programa:</label>
							<div class="col-xs-12 col-md-4 col-lg-4">
								<select class="form-control selectpicker" title="Seleccione uno o varios programas" id="select-programa" multiple name="select-programa" data-live-search="true"></select>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-xs-6 col-md-2 text-right">
								<label for="select-rol" class="control-label">Seleccione el rol:</label>
							</div>
							<div class="col-xs-12 col-md-4 col-lg-4">
								<select class="form-control selectpicker" title="Seleccione" id="select-rol" data-live-search="true"></select>
							</div>
						</div>
						<div class="row form-group">
							<br>
							<div class="col-md-6 col-md-offset-2" >
								<table class="table table-hover text-center" id="table-actividades" hidden style="width: 100%">
									<thead hidden >
										<tr>
											<th class="text-center"></th>
											<th class="text-center"></th>
											<th class="text-center"></th>
											<th class="text-center"></th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</body>
