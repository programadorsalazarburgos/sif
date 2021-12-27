<?php
session_start();
if(!isset($_SESSION["session_username"])) {
	header("location:index.php");

} else {
	$Id_Persona = $_SESSION["session_username"];
	$Id_Rol =	$_SESSION['session_usertype'];
}
?>

<!DOCTYPE html>
<html>
<head>

	<link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">

	<link href="../bower_components/datatables.net-buttons-dt/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css"> 
	<link href="../bower_components/datatables.net-responsive/css/responsive.bootstrap.min.css" rel="stylesheet" type="text/css">

	<link href="../bootstrap/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet" type="text/css">
	<script src="../bower_components/jquery/dist/jquery.min.js"></script> 
	<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="../bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src="../bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
	<script src="../bower_components/datatables.net-buttons/js/buttons.flash.min.js"></script>
	<script src="../bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
	<script src="../bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
	<script src="../bower_components/datatables.net-buttons/js/buttons.colVis.min.js"></script>
	<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script> 
	<script src="../bower_components/fontawesome/svg-with-js/js/fontawesome-all.min.js" ></script>
	<script src="../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript" ></script>
	
	<script type="text/javascript" src="Js/Administracion_Estadisticas_Anuales.js?v=2020.07.23.53"></script>
	
	<style type="text/css">
	.row-margin-none{
		margin-right: 0;
		margin-left: 0;
	}
</style>
</head>
<body>
	<div class="container-fluid" style="padding-top: 30px">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-header">
					<h1 style="font-size: 45px;">Administración de Estadísticas Anuales <small  style="font-size: 20px;">Metas | Formadores | Coberturas</small></h1>
					<input type='hidden' id='id_usuario' value='<?php echo $Id_Persona; ?>'>
					<input type='hidden' id='id_rol' value='<?php echo $Id_Rol; ?>'>
				</div>
			</div>
			<div class="panel-body">
				<form id="FM_Send_Notification" class="form-horizontal col-md-8 col-lg-8 col-md-offset-2 col-lg-offset-2">
					<fieldset>
						<legend class="text-center">Meta de Cobertura Anual y Cantidad de Artistas Formadores</legend>
						<div class="row form-group">
							<label for="SL_ANIO" class="control-label col-xs-6 col-md-3 col-md-offset-2 text-right">AÑO:</label>
							<div class="col-xs-12 col-md-3 col-lg-3">
								<select class="form-control selectpicker" title="Seleccione el Año" id="SL_ANIO" name="SL_ANIO" data-live-search="true"></select>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-xs-6 col-md-3 col-md-offset-2 text-right">
								<label for="TX_META_COBERTURA" class="control-label">META DE COBERTURA:</label>
							</div>
							<div class="col-xs-12 col-md-3 col-lg-3">
								<input type="number" id="TX_META_COBERTURA" name="TX_META_COBERTURA" value="0" class="form-control">
							</div>
						</div>
						<div class="row form-group">
							<div class="col-xs-6 col-md-3 col-md-offset-2 text-right">
								<label for="TX_TOTAL_AF" class="control-label"># ARTISTAS FORMADORES:</label>
							</div>
							<div class="col-xs-12 col-md-3 col-lg-3">
								<input type="number" id="TX_TOTAL_AF" name="TX_TOTAL_AF" value="0" class="form-control">
							</div>
						</div>
						<div class="row form-group">
							<div class="col-md-6 col-lg-6 col-md-offset-3 col-lg-offset-3">
								<table id="tabla_areas_artisticas" name="tabla_areas_artisticas" class="table table-striped table-bordered table-hover display nowrap" style="width:100%">
									<thead>
										<th>Área Artística</th>
										<th>Cantidad de Artistas Formadores</th>
									</thead>
									<tbody id="t_body">
									</tbody>
								</table>
							</div>
							<br>
							<br>
						</div>
						<div class="form-group text-center">
							<div class="col-lg-10 col-lg-offset-2">
								<button type="reset" class="btn btn-default btn-md">Cancelar</button>
								<button type="submit" class="btn btn-success btn-md">Guardar</button>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</body>
</html>
