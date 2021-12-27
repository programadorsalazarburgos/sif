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
	<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script> 
	<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> 
	<script src="../bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script> 
	<script src="../bower_components/datatables.net-responsive-bs/js/responsive.bootstrap.min.js"></script>  	

	<script src="../bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"  type="text/javascript" ></script>
	<script src="../bower_components/jszip/dist/jszip.min.js"  type="text/javascript" ></script>
	<script src="../bower_components/datatables.net-buttons/js/buttons.html5.min.js" type="text/javascript" ></script>
	
	<link href="../bower_components/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" >  
	<script src="../bower_components/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript" ></script> 

    <script type="text/javascript" src="Js/Consultar_Asignaciones.js?v=2021.03.05"></script>
</head>
<body style="font-family:-webkit-pictograph !important">
	<?php include('../LibreriasExternas/Analytics/analyticstracking.php'); ?>
	<div class="container-fluid">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="page-header">
					<h1>Consultar Histórico de Asignaciones de Organizaciones y Artistas Formadores Crea</h1>
					<?php echo "<input type='hidden' id='id_usuario' value='".$Id_Persona."' >"; ?>
				</div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-8 col-md-3">
						<label for="SL_clan">Seleccione la linea:</label>
					</div> 
					<div class="col-xs-12 col-md-9">
						<select id="SL_linea" class="form-control selectpicker" data-actions-box="true" selectAllText="Seleccionar Todos" deselectAllText="Deselccionar Todos" data-live-search="true">
							<option value="AE">Arte en la Escuela</option>
							<option value="IC">Impulso Colectivo</option>
							<option value="CV">Converge</option>
						</select> 
					</div>																		
					<div class="col-xs-8 col-md-3">
						<label for="SL_Ano">Seleccione el año:</label>
					</div>
					<div class="col-xs-12 col-md-9">
						<select id="SL_Ano" class="form-control selectpicker">
							<?php for($i=2017;$i<=date("Y");$i++): ?>
							<option value="<?= $i ?>" <?php if($i==date("Y")) echo ' selected'; ?>><?= $i ?></option>							
							<?php endfor; ?>
						</select>
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
				<br>
					<div class="col-xs-12 col-md-12 alert alert-info">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
	  							<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
  								<path d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg>
							Esta consulta presenta el HISTÓRICO de asignaciones, por lo tanto, un grupo puede aparecer múltiples veces según las asignaciones de Formador y Organización que haya tenido.
							<br>Para conocer únicamente el estado de la asignación actual de los grupos, puede dirigirse a <a href="/sif/public/ConsultasReportes/Consultar_Grupos.php">ASIGNACIÓN ACTUAL</a>.
					</div>
				</div>			
				<div class="row">
					<div class="col-xs-3 col-xs-offset-4 col-md-3 col-md-offset-4">
						<a href="#" id="BT_consultar_asignaciones" class="form-control btn btn-info">Consultar</a>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-md-12 table-responsive">
						<label for=""></label>
			            <div id="div_table_asignaciones"> 
			            </div>  
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>