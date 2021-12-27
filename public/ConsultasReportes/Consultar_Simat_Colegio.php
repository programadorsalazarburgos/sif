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
	<link href="../bootstrap/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script type="text/javascript" src="../bootstrap/bootstrap/dist/js/bootstrap.js"></script>
	<link href="../css/pace.css" rel="stylesheet">
	<script type="text/javascript" src="Js/Consultar_Simat_Colegio.js?v=2020.09.30.0"></script> 

	<link href="../bootstrap/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">
	<script src="../bootstrap/datatables/media/js/jquery.dataTables.min.js"></script>
	<script src="../bootstrap/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.dataTables.min.css">
	<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js"></script>

	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
	<script src="../js/pace.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/js/bootstrap-select.min.js"></script>
</head>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading"> 
				<div class="page-header">
					<h1>Consultar Estudiantes Simat  <small>(por Colegio)</small></h1>
					<?php echo "<input type='hidden' id='id_usuario' value='".$Id_Persona."' >"; ?>
				</div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-8 col-md-3">
						<label for="SL_clan">Seleccione el crea:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<select id="SL_clan" class="form-control selectpicker" data-actions-box="true"  data-live-search="true"></select>
					</div>								
					<div class="col-xs-12 col-md-3">  
						<label for="SL_colegio">Seleccione el colegio:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<select id="SL_colegio" class="form-control selectpicker" data-actions-box="true" data-live-search="true"></select>  
					</div>					
				</div>			
				<div class="row">
					<div class="col-xs-3 col-xs-offset-4 col-md-3 col-md-offset-4">
						<a href="#" id="BT_consultar_simat" class="form-control btn btn-info">Consultar</a>
					</div>
				</div>
				<div class="row">
					<div id="div_table_simat" class="col-xs-12 col-md-12 table-responsive">  
					</div>
				</div>
			</div>
		</div>
	</body>
	<script>
		window.Pace.options = {
			restartOnRequestBefore: true
		}
	</script>
	<div class="modal fade" id="modal_enviando" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<img src="../imagenes/enviando.gif" width="100%">      
				</div>
			</div>
		</div>
	</div>
	</html>