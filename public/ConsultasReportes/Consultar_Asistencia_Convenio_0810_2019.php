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
	<title>Consulta Asistencias Convenio 0810-2019</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>	

	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.dataTables.min.css">
	<link href="../bootstrap/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

	<script src="../bootstrap/datatables/media/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js"></script>
	<script src="../bootstrap/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/js/bootstrap-select.min.js"></script>

	<link rel="stylesheet" type="text/css" href="../LibreriasExternas/alertifyjs/css/alertify.min.css">
	<script type="text/javascript" src="../LibreriasExternas/alertifyjs/alertify.min.js"></script>
	<script type="text/javascript" src="../js/bootbox.js"></script>
	<link href="../bootstrap/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="Js/Consultar_Asistencia_Convenio_0810_2019.js?v=2019.08.09.5"></script>
</head>
<body>
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Consulta de Asistencias Convenio 0810-2019<small> (Secretaría de Seguridad)</small></h1>
				</div>
				<input type='hidden' id='id_usuario' value='<?php echo $Id_Persona; ?>'> 
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<div class="col-xs-8 col-md-2 col-md-offset-3" style="text-align: right;">
							<label for="SL_Year">Seleccione el año:</label>
						</div>
						<div class="col-xs-12 col-md-2">
							<select id="SL_Year" class="form-control selectpicker">
							</select>
						</div>					
					</div>		
					<div class="col-md-12">
						<div class="col-xs-8 col-md-2 col-md-offset-3" style="text-align: right;">
							<label for="SL_Mes">Seleccione el mes:</label>
						</div>
						<div class="col-xs-12 col-md-2">
							<select id="SL_Mes" class="form-control selectpicker">
							</select>
						</div>
					</div>
					<div class="col-xs-12 col-md-3 col-md-offset-4">
						<br><a id="BT_CONSULTAR" name="BT_CONSULTAR" class="btn btn-success form-control">CONSULTAR</a>
					</div>
				</div>

				<div class="row">
					<div class="col-xs-12 col-md-12 alert alert-warning">
						<p>Aquí podrá consultar la asistencia diaria que ha tenido cada uno de los grupos de formación del convenio 0810-2019 del Convenio de Seguridad en el mes seleccionado.</p>
					</div>
				</div>
				<div class="tab-content">
					<div class="tab-pane active" id="grupos_laboratorio_clan" role="tabpanel">
						<div class="row">
							<div class="col-xs-12 col-md-12 text-center bg-info">
								<h4>CONVERGE (SECRETRARÍA DE SEGURIDAD)<small> Asistencia Diaria Grupos</small></h4>
							</div> 
						</div>
						<div class="row">
							<div class="col-xs-12 col-md-12">
								<div class="table-responsive">
									<div id="div_table_grupos_laboratorio_clan"></div> 
								</div>
							</div>
						</div>
					</div>					
				</div>
			</div>
		</div>
	</div>	
</body>
<div class="modal fade" id="modal_enviando" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<img src="../imagenes/enviando.gif" width="100%">      
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</html>