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
    <script type="text/javascript" src="Js/Consultar_Asistencia_Colegio_Mes.js?v=2021.05.20.0"></script>
    
    <link href="../bootstrap/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">
	<script src="../bootstrap/datatables/media/js/jquery.dataTables.min.js"></script>
	<script src="../bootstrap/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

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
					<h1>Consultar Asistencia por colegio <small>(Arte en la escuela)</small></h1>
					<?php echo "<input type='hidden' id='id_usuario' value='".$Id_Persona."' >"; ?>
				</div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12 col-md-3">  
						<label for="SL_Ano">Seleccione el año:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<select id="SL_Ano" class="form-control selectpicker">
							<?php for($i=2017;$i<=date("Y");$i++): ?>
							<option value="<?= $i ?>" <?php if($i==date("Y")) echo ' selected'; ?>><?= $i ?></option>							
							<?php endfor; ?>
						</select>
					</div>
					<div class="col-xs-8 col-md-3">
						<label for="SL_clan">Seleccione el crea:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<select id="SL_clan" multiple="multiple" class="form-control selectpicker" data-actions-box="true" selectAllText="Seleccionar Todos" deselectAllText="Deselccionar Todos" data-live-search="true"></select>
					</div>								
					<div class="col-xs-12 col-md-3"> 
						<label for="SL_colegio">Seleccione el colegio:</label>
					</div>
					<div class="col-xs-12 col-md-9"> 
						<select id="SL_colegio" multiple="multiple" class="form-control selectpicker" data-actions-box="true" selectAllText="Seleccionar Todos" deselectAllText="Deselccionar Todos" data-live-search="true"></select>  
					</div>
										
				</div>
				<div class="row">
					<div class="col-xs-6 col-md-3">
						<label for="SL_mes">Mes Desde:</label>
					</div>
					<div class="col-xs-6 col-md-9">
						<select id="SL_mes" class="form-control"></select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-md-3">
						<label for="SL_mesh">Mes Hasta:</label>
					</div>
					<div class="col-xs-6 col-md-9">
						<select id="SL_mesh" class="form-control"></select>
					</div>
				</div>				
				<div class="row">
					<div class="col-xs-3 col-xs-offset-4 col-md-3 col-md-offset-4">
						<a href="#" id="BT_consultar_asistencias" class="form-control btn btn-info">Consultar</a>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-md-12 table-responsive">
						<div class="alert alert-warning">
							<h4 class="text-center">Datos de asistencia mensual</h4>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 alert alert-info">
							<label id="LB_Atendidos">Atendidos</label>
						</div>
						<label for=""></label>
			            <div id="div_table_asistencia"> 
			            </div>  
					</div>
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
</html>