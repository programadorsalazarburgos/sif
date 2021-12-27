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
	<title>Asignar Artista Formador a Organización</title>
	<link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../bower_components/jquery/dist/jquery.min.js"></script> 
	<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!--
	<link href="../bootstrap/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="../bootstrap/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
-->
	<link href="../bower_components/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"  rel="stylesheet" type="text/css" > 
	<link href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.css" rel="stylesheet"> 
	<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script> 
	<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> 
	<script src="../bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script> 
	<script src="../bower_components/datatables.net-responsive-bs/js/responsive.bootstrap.min.js"></script>  

	
	<script type="text/javascript" src="../js/bootbox.js"></script>
    <link href="../bootstrap/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

	<script type="text/javascript" src="Js/Asignacion_Artista_Organizacion.js?v=2018.09.03"></script> 
</head>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	
	<div class="container-fluid">
		<div class="panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Asignación Artista Formador a Organización</h1>
				</div>
				<input type='hidden' id='id_usuario' value='<?php echo $Id_Persona; ?>'> 
			</div>
			<div class="panel-body">
				<div class="row"> 
					<div class="col-xs-8 col-md-3">
						<label for="SL_organizacion">Seleccione la Organización:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<select id="SL_organizacion" class="form-control selectpicker" data-actions-box="true" data-live-search="true" title="Eliga una Organización"></select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-8 col-md-3">
						<label for="SL_organizacion">Seleccione el Artista Formador:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<select id="SL_artista" class="form-control selectpicker" data-actions-box="true" title="Seleccione una Organización" data-live-search="true"  title="Eliga un AF"></select>
					</div>
				</div>				
				<div class="row">
					<div class="col-xs-6 col-xs-offset-3 col-md-6 col-md-offset-3">
						<a href="#" id="BT_cargar_datos" class="form-control btn btn-primary">Asignar Organización</a>
					</div>
				</div>		
			</div>
		</div>
	</div>	
</body>
</html>
